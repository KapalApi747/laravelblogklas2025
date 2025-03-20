<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComment;

class FrontendPostController extends Controller
{
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $comments = $post->comments()->whereNull('parent_id')->with('user.photo','children.user.photo')->get();
        return view('frontend.post', compact('post', 'comments'));
    }
}
