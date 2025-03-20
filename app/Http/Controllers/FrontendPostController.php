<?php

namespace App\Http\Controllers;

use App\Models\Post;

class FrontendPostController extends Controller
{
    //

    public function show(Post $post)
    {

        return view('frontend.post', compact('post'));
    }
}
