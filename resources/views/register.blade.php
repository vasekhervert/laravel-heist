@extends('layouts.app')

@section('content')
<div class="min-h-screen p-6">
    <div class="max-w-xl mx-auto bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-700">
        <h1 class="text-2xl font-bold mb-4 text-center text-white">Registrace</h1>
        
        @if ($errors->any())
            <div class="bg-red-900 border border-red-700 text-red-300 px-4 py-3 rounded-lg mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300">Jméno</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="mt-1 block w-full rounded-md bg-gray-800 border-gray-600 text-white shadow-sm p-2 border @error('name') border-red-500 @enderror">
            </div>
            
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
                <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Potvrzení hesla</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="mt-1 block w-full rounded-md bg-gray-800 border-gray-600 text-white shadow-sm p-2 border">
            </div>
            
            <div>
                <button type="submit" 
                        class="w-full bg-green-700 text-white py-2 px-4 rounded hover:bg-green-600">
                    Registrovat se
                </button>
            </div>
        </form>
        
        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-blue-400 hover:underline">Zpět na přihlášení</a>
        </div>
    </div>
</div>
@endsection
