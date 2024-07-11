<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function show(Post $post)
    {
        //return Inertia::render('Post/Show', [
        //    'post' => $post,
        //]);
    }
}
