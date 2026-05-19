<?php

namespace Database\Seeders;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
class PostSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        User::all()->each(function (User $user) use ($categories) {
            $postCount = rand(2, 5);
            Post::factory($postCount)
                ->create(['user_id' => $user->id])
                ->each(function (Post $post) use ($categories) {
                    $post->categories()->attach(
                        $categories->random(rand(1, 3))->pluck('id')
                    );
                });
        });
        $this->command->info('Posts seeded with categories attached.');
    }
}
