<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function show(Post $post)
    {
        return Inertia::render('Post/Show', [
            'post' => $post,
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Post/Create', ['categories' => Category::get(['id', 'name'])]);
    }

    public function store(PostCreateRequest $request)
    {

    }
}
