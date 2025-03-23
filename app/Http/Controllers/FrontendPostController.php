<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComment;

class FrontendPostController extends Controller
{
    public function show($id)
    {
        $post = Post::where('id', $id)->firstOrFail();
        $comments = $post
            ->comments()
            ->with('user.photo','children.user.photo','children.parent.user','parent.user.photo')
            ->whereNull('parent_id')
            ->get();

        return view('frontend.post', compact('post', 'comments'));
    }
}
