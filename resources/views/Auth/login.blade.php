@extends('layouts.app')
@section('title', 'Login')
@section('content')
    <div class="max-w-md mx-auto bg-white border border-gray-200 rounded-lg p-8 mt-10">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login to Your Account</h2>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 border border-red-200 rounded p-3 mb-5 text-sm">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <input type="password" name="password"
                       class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded font-semibold hover:bg-blue-600">
                Login
            </button>
        </form>

        <div class="text-center mt-4 text-sm">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-600">Sign up</a>
        </div>
    </div>
@endsection
