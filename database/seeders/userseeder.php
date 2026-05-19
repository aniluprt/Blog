<?php

namespace Database\Seeders;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $userRole  = Role::where('name', 'user')->first();

        $admins = [
            ['name' => 'Admin One',   'email' => 'admin@blog.com'],
            ['name' => 'Admin Two',   'email' => 'admin2@blog.com'],
            ['name' => 'Admin Three', 'email' => 'admin3@blog.com'],
        ];

        foreach ($admins as $admin) {
            User::firstOrCreate(
                ['email' => $admin['email']],
                [
                    'name'      => $admin['name'],
                    'password'  => Hash::make('password'),
                    'role_id'   => $adminRole->id,
                    'is_active' => true,
                ]
            );
        }

        User::factory(10)->create([
            'role_id'   => $userRole->id,
            'is_active' => true,
        ]);

        $this->command->info('Users seeded: 3 admins + 10 regular users');
    }
}
