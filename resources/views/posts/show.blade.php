@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white border border-gray-200 rounded-lg p-8 mb-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white text-lg font-bold">
                    {{ substr($post->user->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-semibold">{{ $post->user->name }}</div>
                    <div class="text-xs text-gray-400">{{ $post->created_at->format('F d, Y') }} • {{ $post->view_count }} views</div>
                </div>
            </div>

            <h1 class="text-3xl font-bold text-gray-800 mb-4 break-words">{{ $post->title }}</h1>

            @if($post->categories->count())
                <div class="flex gap-2 flex-wrap mb-6">
                    @foreach($post->categories as $category)
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">{{ $category->name }}</span>
                    @endforeach
                </div>
            @endif

            <div class="text-gray-700 leading-relaxed mb-6 overflow-x-auto break-words whitespace-normal">
                {!! nl2br(e($post->body)) !!}
            </div>

            @auth
                <div class="flex gap-3 pt-4 border-t border-gray-200">
                    @if(auth()->user()->id === $post->user_id)
                        <a href="{{ route('posts.edit', $post) }}" class="bg-yellow-500 text-white px-4 py-2 rounded text-sm font-semibold hover:bg-yellow-600">
                            Edit Post
                        </a>
                    @endif

                    @if(auth()->user()->id === $post->user_id || auth()->user()->isAdmin())
                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this post?')" class="bg-red-500 text-white px-4 py-2 rounded text-sm font-semibold hover:bg-red-600">
                                Delete Post
                            </button>
                        </form>
                    @endif
                </div>
            @else
                <div class="bg-gray-50 p-4 text-center rounded text-sm text-gray-600">
                    <a href="{{ route('login') }}" class="text-blue-500">Login</a> to edit or delete this post
                </div>
            @endauth
        </div>

        <div class="bg-white border border-gray-200 rounded-lg">
            <div class="border-b border-gray-200 px-6 py-3">
                <h3 class="font-semibold">Comments ({{ $post->comments->count() }})</h3>
            </div>

            @forelse($post->comments as $comment)
                <div class="border-b border-gray-200 px-6 py-4">
                    <div class="flex justify-between items-start mb-2">
                        <span class="font-semibold text-sm">{{ $comment->user->name }}</span>
                        <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-700 break-words whitespace-normal">{{ $comment->body }}</p>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500 text-sm">
                    No comments yet.
                </div>
            @endforelse

            @auth
                <div class="p-6 border-t border-gray-200">
                    <form action="{{ route('comments.store', $post) }}" method="POST">
                        @csrf
                        <textarea name="body" rows="3" placeholder="Write a comment..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 mb-3"></textarea>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded text-sm font-semibold hover:bg-blue-600">
                            Post Comment
                        </button>
                    </form>
                </div>
            @else
                <div class="text-center py-6 text-sm text-gray-500 border-t border-gray-200">
                    <a href="{{ route('login') }}" class="text-blue-500">Login</a> to leave a comment
                </div>
            @endauth
        </div>
    </div>
@endsection
