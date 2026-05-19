<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Blog' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
<nav class="bg-white shadow">
    @auth
        <span>Welcome, {{ auth()->user()->name }}</span>
    @endauth
</nav>

<main class="max-w-7xl mx-auto px-4 py-8">
    @yield('content')
</main>
</body>
</html>
