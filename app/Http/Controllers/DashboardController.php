<?php

namespace App\Http\Controllers;

use App\Services\ElasticSearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(private readonly ElasticSearchService $elasticSearchService) {}

    public function form(Request $request): Response
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);

        return Inertia::render('Dashboard', [
            'data' => $this->elasticSearchService->searchPosts(query: $request->get('q') ?? null, page: $page, perPage: $perPage),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);

        return response()->json($this->elasticSearchService->searchPosts($query, $page, $perPage));
    }
}
