<?php

namespace Database\Factories;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence();
        return [
            //
            'author_id'=>User::inRandomOrder()->first()->id ?? User::factory(),
            'photo_id'=>Photo::inRandomOrder()->first()->id ?? null,
            'title'=>$title,
            'content'=>$this->faker->paragraphs(3,true),
            'slug'=>Str::slug($title), //koppeltekens tussen de woorden
            'is_published'=>1,
        ];
    }
}
