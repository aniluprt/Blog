<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Role;
use Illuminate\Http\Request;

class admincontroller extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalPosts = Post::count();
        $publishedPosts = Post::where('is_published', true)->count();

        return view('admin.dashboard', compact('totalUsers', 'totalPosts', 'publishedPosts'));
    }

    public function users()
    {
        $users = User::with('role')->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function allPosts()
    {
        $posts = Post::with('user', 'categories')->latest()->paginate(20);
        return view('admin.posts', compact('posts'));
    }

    public function deletePost(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts')->with('success', 'Post deleted successfully');
    }

    public function roles()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles', compact('roles'));
    }

    public function updateRolePermissions(Request $request, Role $role)
    {
        $role->permissions()->sync($request->permissions ?? []);
        return back()->with('success', 'Permissions updated');
    }

    public function toggleUserActive(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();
        return back()->with('success', 'User status updated');
    }
}
