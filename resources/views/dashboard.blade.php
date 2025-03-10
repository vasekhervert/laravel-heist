@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">

    @if(session('success'))
        <div class="bg-green-900 border border-green-700 text-green-300 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-900 border border-red-700 text-red-300 px-4 py-3 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Formulář pro nový příspěvek -->
    <form action="{{ route('posts.store') }}" method="POST" class="mb-8 bg-gray-800 p-4 rounded shadow border border-gray-700">
        @csrf
        <textarea name="content" 
                  class="w-full p-2 border rounded mb-2 bg-gray-700 border-gray-600 text-white" 
                  placeholder="Piš tajný věci..."></textarea>
        <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-600">
            Odeslat tajnou zprávu
        </button>
    </form>

    <!-- Seznam příspěvků -->
    <div class="space-y-4">
        @foreach($posts as $post)
        <div class="bg-gray-800 p-4 rounded shadow border border-gray-700">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <span class="font-bold text-white">{{ $post->user->name }}</span>
                    <span class="text-gray-400 text-sm">
                        {{ $post->created_at->format('d.m.Y H:i') }}
                    </span>
                </div>
                @if($post->user_id === auth()->id())
                <div class="flex space-x-2">
                    <button onclick="editPost({{ $post->id }}, '{{ addslashes($post->content) }}')" 
                            class="text-blue-400 hover:underline">Upravit</button>
                    <form method="POST" 
                          action="{{ route('posts.destroy', $post->id) }}" 
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:underline">Smazat</button>
                    </form>
                </div>
                @endif
            </div>
            <p class="text-gray-300">{{ $post->content }}</p>
        </div>
        @endforeach
    </div>
</div>

<script>
function editPost(postId, content) {
    const newContent = prompt('Upravit příspěvek:', content);
    if (newContent) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/posts/${postId}`;
        form.style.display = 'none';
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        
        const contentInput = document.createElement('input');
        contentInput.type = 'hidden';
        contentInput.name = 'content';
        contentInput.value = newContent;
        
        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        form.appendChild(contentInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
