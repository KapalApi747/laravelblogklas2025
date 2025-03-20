<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostComment>
 */
class PostCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'post_id'=> Post::inRandomOrder()->first()->id ?? null,
            'user_id'=> User::inRandomOrder()->first()->id ?? User::factory(),
            'body'=> $this->faker->paragraphs(3,true),
            'parent_id' => function (array $attributes) {
                // Check if there are existing comments under this post
                $parentComment = PostComment::where('post_id', $attributes['post_id'])->inRandomOrder()->first();

                // If there are comments, randomly assign one as parent, otherwise set parent_id to null
                return $parentComment ? $parentComment->id : null;
            },
        ];
    }
}
