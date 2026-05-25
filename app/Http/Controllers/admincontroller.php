<?php

namespace App\Http\Controllers;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class admincontroller extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_posts' => \App\Models\Post::count(),
            'published'   => \App\Models\Post::published()->count(),
            'drafts'      => \App\Models\Post::where('is_published', false)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users(): View
    {
        $users = User::with(['role'])->latest()->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function roles(): View
    {
        $roles       = Role::with('permissions')->get();
        $permissions = Permission::orderBy('name')->get();
        return view('admin.roles', compact('roles', 'permissions'));
    }

    public function updateRolePermissions(Request $request, Role $role): RedirectResponse
    {
        $request->validate([
            'permission_ids'=> ['nullable', 'array'],
            'permission_ids.*' => ['exists:permissions,id'],
        ]);

        $role->permissions()->sync($request->permission_ids ?? []);
        return redirect()
            ->route('admin.roles')
            ->with('success', "Permissions updated for role: {$role->name}");
    }

    public function toggleUserActive(User $user): RedirectResponse
    {
        $user->update(['is_active' => ! $user->is_active]);
        $status = $user->is_active ? 'activated' : 'suspended';
        return redirect()
            ->route('admin.users')
            ->with('success', "User {$user->name} has been {$status}.");
    }
}
