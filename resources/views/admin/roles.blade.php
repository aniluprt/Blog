@extends('layouts.app')
@section('title', 'Manage Roles & Permissions')
@section('content')

    <div class="page-header">
        <div>
            <h1>Roles & Permissions</h1>
            <p class="text-muted">Manage what each role can do in the system</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn--ghost">← Dashboard</a>
    </div>

    @foreach($roles as $role)
        <div class="form-card" style="margin-bottom: 2rem;">
            <h2 class="form-card__title" style="text-transform: capitalize;">
                Role: {{ $role->name }}
                <span class="badge {{ $role->name === 'admin' ? 'badge--warning' : 'badge--gray' }}"
                      style="margin-left: 0.5rem; vertical-align: middle;">
                    {{ $role->users_count ?? '' }}
                </span>
            </h2>

            <form method="POST"
                  action="{{ route('admin.roles.permissions', $role) }}">
                @csrf

                <p class="text-muted" style="margin-bottom: 1rem;">
                    Select the permissions this role should have:
                </p>

                <div class="form-checkbox-group">
                    @foreach($permissions as $permission)
                        <label class="form-checkbox-item">
                            <input
                                type="checkbox"
                                name="permission_ids[]"
                                value="{{ $permission->id }}"
                                {{ $role->permissions->contains('id', $permission->id) ? 'checked' : '' }}
                            >
                            <span>
                                <strong>{{ $permission->name }}</strong>
                                <small class="text-muted" style="display:block;">{{ $permission->slug }}</small>
                            </span>
                        </label>
                    @endforeach
                </div>

                <div class="form-actions" style="margin-top: 1.5rem;">
                    <button type="submit" class="btn btn--primary">
                        Save Permissions for "{{ ucfirst($role->name) }}"
                    </button>
                </div>
            </form>
        </div>
    @endforeach
@endsection
