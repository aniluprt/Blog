@extends('layouts.app')
@section('title', 'Account Suspended')
@section('content')
    <div class="flex-center" style="min-height: 50vh;">
        <div class="empty-state">
            <div style="font-size: 4rem; margin-bottom: 1rem;"></div>
            <h1 class="empty-state__title" style="color: var(--color-danger);">
                Account Suspended
            </h1>
            <p class="empty-state__text">
                Your account has been suspended and cannot be accessed at this time.
                <br>Please contact our support team for assistance.
            </p>
            <a href="{{ route('posts.index') }}" class="btn btn--ghost">
                ← View Public Posts
            </a>
        </div>
    </div>
@endsection
