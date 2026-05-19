<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['name' => 'Create Post', 'slug' => 'create-post'],
            ['name' => 'Edit Post', 'slug' => 'edit-post'],
            ['name' => 'Delete Post', 'slug' => 'delete-post'],
            ['name' => 'Publish Post', 'slug' => 'publish-post'],
            ['name' => 'Manage Users', 'slug' => 'manage-users'],
            ['name' => 'Manage Roles', 'slug' => 'manage-roles'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $adminRole = Role::where('name', 'admin')->first(); //admin ko lagi
        $userRole = Role::where('name', 'user')->first();
        $allPermissions = Permission::all();
        $adminRole->permissions()->attach($allPermissions);


        $userPermissions = Permission::whereIn('name', ['create-post', 'edit-post'])->get(); //users (limited)
        $userRole->permissions()->attach($userPermissions);
    }
}
