<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id()
        ]);

        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        return response()->json($post->load('user'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $post->update($request->all());

        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->delete();

        return response()->json(null, 204);
    }

    // Upravené metody pro webové rozhraní
    public function storeWeb(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $post = Post::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'title' => $request->input('title', 'Příspěvek'), // Přidáme výchozí hodnotu pro title
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Příspěvek byl úspěšně přidán');
    }

    public function updateWeb(Request $request, Post $post)
    {
        // Kontrola oprávnění
        if (auth()->id() !== $post->user_id) {
            return redirect()->route('dashboard')
                ->with('error', 'Nemáte oprávnění upravit tento příspěvek');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $post->update([
            'content' => $request->content,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Příspěvek byl úspěšně aktualizován');
    }

    public function destroyWeb(Post $post)
    {
        // Kontrola oprávnění
        if (auth()->id() !== $post->user_id) {
            return redirect()->route('dashboard')
                ->with('error', 'Nemáte oprávnění smazat tento příspěvek');
        }

        $post->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Příspěvek byl úspěšně smazán');
    }
}
