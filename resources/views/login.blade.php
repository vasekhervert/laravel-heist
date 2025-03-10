@extends('layouts.app')

@section('content')
<div class="min-h-screen p-6">
    <div class="max-w-xl mx-auto bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-700">
        
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
    

        @if(!auth()->check())
            <div class="mb-6 p-4 bg-gray-700 border border-gray-600 rounded-lg">
                <h2 class="text-xl font-bold mb-4 text-center text-white">Přihlášení</h2>
                
                @if ($errors->any())
                    <div class="bg-red-900 border border-red-700 text-red-300 px-4 py-3 rounded-lg mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('login.email') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               class="mt-1 block w-full rounded-md bg-gray-800 border-gray-600 text-white shadow-sm p-2 border @error('email') border-red-500 @enderror">
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300">Heslo</label>
                        <input type="password" name="password" id="password" required
                               class="mt-1 block w-full rounded-md bg-gray-800 border-gray-600 text-white shadow-sm p-2 border @error('password') border-red-500 @enderror">
                    </div>
                    
                    <div>
                        <button type="submit" 
                                class="w-full bg-green-700 text-white py-2 px-4 rounded hover:bg-green-600">
                            Přihlásit se
                        </button>
                    </div>
                </form>
                
                <div class="text-center mt-2">
                    <p>Nemáte účet? <a href="{{ route('register.form') }}" class="text-blue-400 hover:underline">Registrujte se</a></p>
                </div>
            </div>
            
            <div class="text-center mb-4">
                <p class="text-gray-400">nebo</p>
            </div>
        @endif

        <div class="space-y-4">
            @if(auth()->check())
                <a href="{{ route('dashboard') }}" 
                   class="block w-full bg-blue-700 text-white text-center py-2 px-4 rounded hover:bg-blue-600">
                    Přejít na dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full bg-red-700 text-white py-2 px-4 rounded hover:bg-red-600">
                        Odhlásit se
                    </button>
                </form>
            @else
                <a href="{{ url('api/auth/google') }}" 
                   class="block w-full bg-red-700 text-white text-center py-2 px-4 rounded hover:bg-red-600">
                    Přihlásit přes Google
                </a>
                <a href="{{ url('api/auth/facebook') }}" 
                   class="block w-full bg-blue-700 text-white text-center py-2 px-4 rounded hover:bg-blue-600">
                    Přihlásit přes Facebook
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
