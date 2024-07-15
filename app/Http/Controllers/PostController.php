<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function show(Post $post): Response
    {
        return Inertia::render('Post/Show', [
            'post' => $post,
        ]);
    }

    public function create(Request $request): Response
    {
        return Inertia::render('Post/Create', [
            'categories' => Category::get(['id', 'name'])
        ]);
    }

    public function store(PostCreateRequest $request): void
    {
        $post = new Post([
            'title' => $request->title,
            'body' => $request->body,
            'author_id' => Auth::id(),
            'categories' => implode(',', $request->get('categories')),
        ]);

        $post->save();
    }
}
