@extends('admin.layout')

@section('title', 'Manage Posts')

@section('content')
    <div>
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manage All Posts</h1>
            </div>
            <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded text-sm font-semibold hover:bg-blue-600 transition">
                + Create New Post
            </a>
        </div>

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
                            <div class="flex gap-2">
                                <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-500 hover:text-blue-600 text-sm">View</a>
                                <a href="{{ route('posts.edit', $post) }}" class="text-yellow-500 hover:text-yellow-600 text-sm">Edit</a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 text-sm" onclick="return confirm('Delete this post?')">Delete</button>
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
@endsection
