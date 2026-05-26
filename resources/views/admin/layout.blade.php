<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Admin Navigation Bar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center gap-8">
                <a href="/admin/dashboard" class="font-bold text-xl text-gray-800 hover:text-blue-500 transition">
                     BlogSystem Admin
                </a>
                <div class="flex gap-4">
                    <a href="/admin/dashboard" class="text-gray-600 hover:text-blue-500 transition {{ request()->routeIs('admin.dashboard') ? 'text-blue-500 font-semibold' : '' }}">
                        Dashboard
                    </a>
                    <a href="/admin/users" class="text-gray-600 hover:text-blue-500 transition {{ request()->routeIs('admin.users') ? 'text-blue-500 font-semibold' : '' }}">
                        Users
                    </a>
                    <a href="/admin/posts" class="text-gray-600 hover:text-blue-500 transition {{ request()->routeIs('admin.posts') ? 'text-blue-500 font-semibold' : '' }}">
                        All Posts
                    </a>
                </div>
            </div>
            <div class="flex gap-4 items-center">
                <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs font-semibold">Admin</span>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-600 text-sm font-semibold">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 border border-green-200 rounded p-3 mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 border border-red-200 rounded p-3 mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
