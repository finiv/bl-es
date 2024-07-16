<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Elastic\Elasticsearch\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    protected $elasticsearch;

    public function __construct(Client $client)
    {
        $this->elasticsearch = $client;
    }

    public function form(Request $request): Response
    {
        $response = $this->elasticsearch->search([
            'index' => 'posts',
            'body'  => [
                'query' => [
                    'match_all' => (object) [],
                ],
                'size' => 10,
                'from' => ($request->input('page', 1) - 1) * 10
            ],
        ]);

        $posts = collect($response['hits']['hits'])->map(function ($hit) {
            return $hit['_source'];
        });

        $total = $response['hits']['total']['value'];
        $perPage = 10;
        $currentPage = $request->input('page', 1);
        $lastPage = ceil($total / $perPage);
        $links = [
            'prev' => $currentPage > 1 ? route('dashboard', ['page' => $currentPage - 1]) : null,
            'next' => $currentPage < $lastPage ? route('dashboard', ['page' => $currentPage + 1]) : null,
        ];

        return Inertia::render('Dashboard', [
            'posts' => $posts,
            'current_page' => $currentPage,
            'last_page' => $lastPage,
            'links' => $links,
        ]);
    }
}
