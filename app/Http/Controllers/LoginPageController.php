<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LoginPageController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function dashboard()
    {
        $posts = Post::with('user')->latest()->get();
        return view('dashboard', compact('posts'));
    }
}
