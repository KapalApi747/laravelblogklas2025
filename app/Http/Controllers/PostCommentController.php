<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $postId)
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'parent_id' => 'nullable|exists:post_comments,id', // Ensure parent_id is valid
        ]);

        $post = Post::findOrFail($postId);
        $comment = new PostComment();
        $comment->body = $request->message;
        $comment->user_id = auth()->id(); // The currently authenticated user
        $comment->post_id = $post->id;
        $comment->parent_id = $request->parent_id ?? null; // Reference to the parent comment
        $comment->save();

        return back();
        //return redirect()->route('frontend.post.show', ['post' => $post->id])->with('success', 'Comment added successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(PostComment $postComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostComment $postComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PostComment $postComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostComment $postComment)
    {
        //
    }
}
