<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = Category::whereIn('name', ['Politics', 'Lifestyle','Travel','Health','Entertainment','Sport'])->get();

        //10 posts maken en koppel ze aan categorieen
        Post::factory()->count(10)->create()->each(function ($post) use ($categories) {
            $randomCategories = $categories->random(rand(1,3));
            $post->categories()->attach($randomCategories);
        });
    }
}
