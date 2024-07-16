<?php

namespace App\Http\Controllers;

use App\Services\ElasticSearchService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(private readonly ElasticSearchService $elasticSearchService) {}

    public function form(Request $request): Response
    {
        return Inertia::render('Dashboard', [
            'data' => $this->elasticSearchService->searchPosts(
                page: $request->input('page', 1)
            ),
        ]);
    }
}
