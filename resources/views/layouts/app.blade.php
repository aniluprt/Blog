<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BlogSystem')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        blue: { 500: '#0095f6' }
                    }
                }
            }
        }
    </script>

    <style>
        {
            white-space: nowrap;
        }

        .inline-block {
            display: inline-block;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800">

<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-5xl mx-auto px-4 py-3 flex justify-between items-center">
        <a href="{{ route('welcome') }}" class="text-xl font-bold text-gray-800 hover:text-blue-500">
             BlogSystem
        </a>
        <div class="flex gap-5 items-center">
            <a href="{{ route('posts.index') }}" class="text-sm text-gray-600 hover:text-blue-500">Blog</a>

            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 hover:text-blue-500">Admin Panel</a>
                @else
                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-blue-500">Dashboard</a>
                    <a href="{{ route('posts.create') }}" class="text-sm text-gray-600 hover:text-blue-500">Create Post</a>
                @endif
                <span class="text-sm text-gray-500">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-red-500 hover:text-red-600">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-blue-500">Login</a>
                <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-blue-500">Register</a>
            @endauth
        </div>
    </div>
</nav>


<main class="max-w-5xl mx-auto px-4 py-8 min-h-[calc(100vh-130px)]">
    @if(session('success'))
        <div class="bg-green-100 text-green-700 border border-green-200 rounded p-3 mb-5 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 border border-red-200 rounded p-3 mb-5 text-sm">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</main>

<footer class="text-center py-5 text-gray-400 text-xs border-t border-gray-200 bg-white">
    <p>&copy; {{ date('Y') }} BlogSystem.</p>
</footer>
</body>
</html>
