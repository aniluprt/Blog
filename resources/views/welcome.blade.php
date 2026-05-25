@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="text-center py-12">
        <h1 class="text-5xl font-bold text-gray-800 mb-4">Share Your Stories</h1>
        <p class="text-xl text-gray-500 mb-8 max-w-lg mx-auto">
            Join our community of writers. Express yourself through blog posts.
        </p>

        <div class="flex justify-center gap-12 mb-10">
            <div class="text-center">
            </div>
        </div>

        @guest
            <div class="flex gap-3 justify-center flex-wrap">
                <a href="{{ route('register') }}" class="bg-blue-500 text-white px-6 py-2 rounded text-sm font-semibold hover:bg-blue-600">
                    Create Account
                </a>
                <a href="{{ route('login') }}" class="bg-transparent text-blue-500 px-6 py-2 rounded text-sm font-semibold border border-blue-500 hover:bg-blue-50">
                    Login
                </a>
                <a href="{{ route('posts.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2 rounded text-sm font-semibold border border-gray-300 hover:bg-gray-200">
                    Browse as Guest
                </a>
            </div>
        @endguest

        @auth
            <div class="flex gap-3 justify-center flex-wrap">
                <a href="{{ route('dashboard') }}" class="bg-blue-500 text-white px-6 py-2 rounded text-sm font-semibold hover:bg-blue-600">
                    Go to Dashboard
                </a>
                <a href="{{ route('posts.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2 rounded text-sm font-semibold border border-gray-300 hover:bg-gray-200">
                    Browse Posts
                </a>
            </div>
        @endauth
    </div>

    <div class="bg-white border-t border-gray-100 py-12 -mx-4 px-4">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-10">
                <p class="text-gray-500 text-sm">Everything you need to share your ideas with the world</p>
            </div>
@endsection
