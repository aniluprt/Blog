@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Welcome, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-500 mb-8">Here's what's happening with your blog today.</p>


        <div class="flex justify-center">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl w-full">

                <div class="bg-white p-8 rounded-lg shadow border-l-4 border-blue-500 text-center">
                    <div class="text-4xl font-bold text-blue-500">{{ $totalUsers ?? 0 }}</div>
                    <div class="text-gray-600 mt-2 font-medium">Total Users</div>
                </div>


                <div class="bg-white p-8 rounded-lg shadow border-l-4 border-green-500 text-center">
                    <div class="text-4xl font-bold text-green-500">{{ $totalPosts ?? 0 }}</div>
                    <div class="text-gray-600 mt-2 font-medium">Total Posts</div>
                </div>


                <div class="bg-white p-8 rounded-lg shadow border-l-4 border-yellow-500 text-center">
                    <div class="text-4xl font-bold text-yellow-500">{{ $publishedPosts ?? 0 }}</div>
                    <div class="text-gray-600 mt-2 font-medium">Published Posts</div>
                </div>


                <div class="bg-white p-8 rounded-lg shadow border-l-4 border-purple-500 text-center">
                    <div class="text-4xl font-bold text-purple-500">{{ ($totalPosts ?? 0) - ($publishedPosts ?? 0) }}</div>
                    <div class="text-gray-600 mt-2 font-medium">Draft Posts</div>
                </div>
            </div>
        </div>
    </div>
@endsection
