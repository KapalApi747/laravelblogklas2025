<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::all()->each(function ($post) {
            // Create some top-level comments for each post
            $comments = PostComment::factory(5)->create([
                'post_id' => $post->id,
            ]);

            // Now create replies for some of the comments
            $comments->each(function ($comment) use ($post) {
                // For each comment, create 2-3 replies
                PostComment::factory(rand(2, 3))->create([
                    'post_id' => $post->id,
                    'parent_id' => $comment->id,  // Set the parent_id to the current comment's id
                ]);
            });
        });
    }
}
