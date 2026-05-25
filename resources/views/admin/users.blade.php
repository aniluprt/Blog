@extends('layouts.app')
@section('title', 'Manage Users')
@section('content')
    <div class="page-header">
        <div>
            <h1>Manage Users</h1>
            <p class="text-muted">{{ $users->total() }} users total</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn--ghost">← Dashboard</a>
    </div>

    <div class="table-wrapper">
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td class="text-muted">#{{ $user->id }}</td>

                    <td>
                        <strong>{{ $user->name }}</strong>
                        {{-- Highlight the currently logged-in admin --}}
                        @if($user->id === auth()->id())
                            <span class="badge badge--primary" style="margin-left: 0.5rem;">You</span>
                        @endif
                    </td>

                    <td>{{ $user->email }}</td>

                    <td>
                        @if($user->role?->name === 'admin')
                            <span class="badge badge--warning">Admin</span>
                        @else
                            <span class="badge badge--gray">User</span>
                        @endif
                    </td>

                    <td>
                        @if($user->is_active)
                            <span class="badge badge--success">Active</span>
                        @else
                            <span class="badge badge--danger">Suspended</span>
                        @endif
                    </td>

                    <td class="text-muted">{{ $user->created_at->format('M d, Y') }}</td>

                    <td>
                        <div class="table__actions">
                            @if($user->id !== auth()->id())
                                <form method="POST"
                                      action="{{ route('admin.users.toggle-active', $user) }}"
                                      onsubmit="return confirm('{{ $user->is_active ? 'Suspend' : 'Activate' }} this user?')">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn--sm {{ $user->is_active ? 'btn--danger' : 'btn--secondary' }}">
                                        {{ $user->is_active ? 'Suspend' : 'Activate' }}
                                    </button>
                                </form>
                            @else
                                <span class="text-muted text-sm">—</span>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No users found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $users->links() }}
    </div>

@endsection
