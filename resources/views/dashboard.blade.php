@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-5xl mx-auto">
        <!-- Search Bar for User's Posts -->
        <div class="mb-6">
            <form method="GET" action="{{ route('dashboard') }}" class="flex gap-3">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search your posts..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('dashboard') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        @if(request('search'))
            <div class="max-w-5xl mx-auto mb-4 text-gray-600 text-sm">
                Showing results for: <strong>"{{ request('search') }}"</strong>
                <span class="ml-2">({{ $posts->total() }} results)</span>
            </div>
        @endif

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">My Dashboard</h1>
            <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded text-sm font-semibold hover:bg-blue-600">
                + Create Post
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-5 mb-8">
            <div class="bg-white border border-gray-200 rounded-lg p-5 text-center">
                <div class="text-3xl font-bold text-blue-500">{{ auth()->user()->posts->count() }}</div>
                <div class="text-sm text-gray-500">Total Posts</div>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-5 text-center">
                <div class="text-3xl font-bold text-green-500">{{ auth()->user()->posts->where('is_published', true)->count() }}</div>
                <div class="text-sm text-gray-500">Published</div>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-5 text-center">
                <div class="text-3xl font-bold text-yellow-500">{{ auth()->user()->posts->sum('view_count') }}</div>
                <div class="text-sm text-gray-500">Total Views</div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
            <div class="border-b border-gray-200 px-5 py-3">
                <h2 class="font-semibold text-gray-800">My Posts</h2>
            </div>

            @forelse($posts as $post)
                <div class="border-b border-gray-200 px-5 py-4 flex justify-between items-center">
                    <div class="flex-1">
                        <div class="font-semibold text-gray-800">{{ $post->title }}</div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ $post->created_at->format('M d, Y') }} • {{ $post->view_count }} views
                            <span class="ml-2 px-2 py-0.5 rounded text-xs {{ $post->is_published ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $post->is_published ? 'Published' : 'Draft' }}
                    </span>
                        </div>
                    </div>
                    <div class="flex gap-3 whitespace-nowrap">
                        <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-500 text-sm hover:text-blue-600 inline-block">View</a>

                        @if(auth()->user()->id === $post->user_id)
                            <a href="{{ route('posts.edit', $post) }}" class="text-yellow-500 text-sm hover:text-yellow-600 inline-block">Edit</a>
                        @endif

                        @if(auth()->user()->id === $post->user_id || auth()->user()->isAdmin())
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this post?')" class="text-red-500 text-sm hover:text-red-600 cursor-pointer">Delete</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-500">
                    No posts yet.
                    <a href="{{ route('posts.create') }}" class="text-blue-500 hover:text-blue-600">Create your first post</a>
                </div>
            @endforelse
        </div>

        <div class="mt-5">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
