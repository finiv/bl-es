<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function form(Request $request): Response
    {
        $posts = Post::paginate(10);

        return Inertia::render('Dashboard', [
            'posts' => $posts,
        ]);
    }
}
