@extends('layouts.app')

@section('title', 'Blog')

@section('content')
    <div class="max-w-5xl mx-auto">
        <!-- Search Bar -->
        <div class="mb-8">
            <form method="GET" action="{{ route('posts.index') }}" class="flex gap-3">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search posts by title or content..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('posts.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">
                        Clear
                    </a>
                @endif
            </form>
        </div>


        @if(request('search'))
            <div class="mb-6 text-gray-600">
                Showing results for: <strong class="text-gray-800">"{{ request('search') }}"</strong>
                <span class="ml-2 text-sm">({{ $posts->total() }} results found)</span>
            </div>
        @endif

        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Blog</h1>
            <p class="text-gray-500">Stories from our community</p>
        </div>

        @guest
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center mb-8">
                <p class="text-blue-700 text-sm">
                     You're browsing as a guest.
                    <a href="{{ route('login') }}" class="font-semibold hover:underline">Login</a> or
                    <a href="{{ route('register') }}" class="font-semibold hover:underline">Register</a> to create your own posts!
                </p>
            </div>
        @endguest


        <div class="grid md:grid-cols-2 gap-6">
            @forelse($posts as $post)
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition">
                    <div class="p-5">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                {{ substr($post->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-semibold text-sm">{{ $post->user->name }}</div>
                                <div class="text-xs text-gray-400">{{ $post->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>

                        <h2 class="text-xl font-bold text-gray-800 mb-2">
                            <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-500">{{ $post->title }}</a>
                        </h2>

                        <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                            {{ Str::limit(strip_tags($post->body), 120) }}
                        </p>

                        <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-500 text-sm font-semibold hover:text-blue-600">
                            Read more →
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-12 text-gray-500">
                    @if(request('search'))
                        No posts found matching "{{ request('search') }}".
                    @else
                        No posts yet.
                    @endif
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $posts->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
