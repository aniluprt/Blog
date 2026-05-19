<?php

namespace Database\Seeders;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Technology', 'Travel', 'Laravel', 'PHP', 'Lifestyle', 'Business', 'Health', 'Food', 'Science', 'Education',
        ];
        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
        $this->command->info('Categories seeded: ' . count($categories) . ' categories');
    }
}
