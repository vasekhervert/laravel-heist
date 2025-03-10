<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HeistChannel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Vlastní styly pro dark mode */
        body {
            background-color: #121212;
            color: #e2e8f0;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100">
    <nav class="bg-gray-800 shadow-lg p-4 border-b border-gray-700">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold text-white">HeistChannel</a>
            <div>
                @auth
                    <span class="mr-4 text-gray-300">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-400 hover:text-red-300">Odhlásit</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-8 px-4">
        @yield('content')
    </main>
</body>
</html>
