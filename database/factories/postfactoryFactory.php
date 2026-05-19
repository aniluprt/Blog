<?php
namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(rand(4, 8));

        return [
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 99999),
            'body' => $this->faker->paragraphs(rand(4, 8), true),
            'user_id' => User::factory(),
//            'is_published' => $this->faker->boolean(70),
            'view_count' => $this->faker->numberBetween(0, 500),
        ];
    }
}
//    public function published(): static
//    {
//        return $this->state(['is_published' => true]);
//    }
//    public function draft(): static
//    {
//        return $this->state(['is_published' => false]);
//    }
