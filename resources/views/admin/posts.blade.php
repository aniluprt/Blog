<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manage Posts - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<nav class="bg-white shadow-md mb-6">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
        <div class="flex items-center gap-8">
            <span class="font-bold text-xl text-gray-800">📝 Admin Panel</span>
            <div class="flex gap-4">
                <a href="/admin/dashboard" class="text-gray-600 hover:text-blue-500">Dashboard</a>
                <a href="/admin/users" class="text-gray-600 hover:text-blue-500">Users</a>
                <a href="/admin/posts" class="text-blue-500 font-semibold">Posts</a>
            </div>
        </div>
        <div class="flex gap-4 items-center">
            <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-600 text-sm font-semibold">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manage All Posts</h1>
            <p class="text-gray-500 text-sm mt-1">View, edit, or delete any post on the platform</p>
        </div>
        <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded text-sm font-semibold hover:bg-blue-600 transition">
            + Create New Post
        </a>
    </div>

    <div class="mb-6">
        <form method="GET" action="{{ route('admin.posts') }}" class="flex gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search posts by title, content, or author..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.posts') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">
                    Clear
                </a>
            @endif
        </form>
    </div>

    @if(request('search'))
        <div class="mb-4 text-gray-600 text-sm">
            Showing results for: <strong>"{{ request('search') }}"</strong>
            <span class="ml-2">({{ $posts->total() }} posts found)</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Title</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Author</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Views</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            @forelse($posts as $post)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $post->id }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-800">{{ $post->title }}</div>
                        @if($post->categories->count())
                            <div class="flex gap-1 mt-1">
                                @foreach($post->categories->take(2) as $category)
                                    <span class="text-xs text-gray-400">#{{ $category->name }}</span>
                                @endforeach
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-gray-400 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                {{ substr($post->user->name, 0, 1) }}
                            </div>
                            <span class="text-sm text-gray-600">{{ $post->user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $post->is_published ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $post->is_published ? 'Published' : 'Draft' }}
                            </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $post->view_count }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $post->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-3 whitespace-nowrap">
                            <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-500 hover:text-blue-600 text-sm inline-block">View</a>

                            @if(auth()->user()->id === $post->user_id)
                                <a href="{{ route('posts.edit', $post) }}" class="text-yellow-500 hover:text-yellow-600 text-sm inline-block">Edit</a>
                            @else
                                <span class="text-gray-400 text-sm">Edit</span>
                            @endif

                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-600 text-sm cursor-pointer" onclick="return confirm('Delete this post?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        No posts found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
</div>
</body>
</html>
