<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
        $categories = $request->input('c', []);

        return Inertia::render('Dashboard', [
            'data' => $this->elasticSearchService->searchPosts(
                query: $request->get('q') ?? null,
                categories: $categories,
                page: $page,
                perPage: $perPage
            ),
            'categories' => Category::all(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        if ($request->has('c') && $request->input('c')) {
            $categories = explode(',', $request->input('c'));
        }

        return response()->json($this->elasticSearchService->searchPosts(
            query: $query,
            categories: $categories ?? [],
            page: $page,
            perPage: $perPage
        ));
    }
}
