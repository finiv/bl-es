<?php

namespace App\Services;

use Elastic\Elasticsearch\Client;
use App\Traits\Paginates;

class ElasticSearchService
{
    use Paginates;

    public function __construct(private readonly Client $client)
    {
    }

    public function getAllPosts(int $page = 1, int $perPage = 10): object
    {
        $from = ($page - 1) * $perPage;

        $response = $this->client->search([
            'index' => 'posts',
            'body' => [
                'query' => [
                    'match_all' => (object) [],
                ],
                'size' => $perPage,
                'from' => $from,
            ],
        ]);

        $posts = collect($response['hits']['hits'])->map(function ($hit) {
            return $hit['_source'];
        });

        $total = $response['hits']['total']['value'];

        return (object) [
            'posts' => $posts,
            'pagination' => $this->paginate($total, $perPage, $page),
        ];
    }

    public function searchPosts(string $query, int $page = 1, int $perPage = 10): object
    {
        $from = ($page - 1) * $perPage;

        $response = $this->client->search([
            'index' => 'posts',
            'body' => [
                'query' => [
                    'multi_match' => [
                        'query' => $query,
                        'fields' => ['title', 'body'],
                    ],
                ],
                'size' => $perPage,
                'from' => $from,
            ],
        ]);

        $posts = collect($response['hits']['hits'])->map(function ($hit) {
            return $hit['_source'];
        });

        $total = max(1, $response['hits']['total']['value']);

        return (object) [
            'posts' => $posts,
            'pagination' => $this->paginate($total, $perPage, $page),
        ];
    }

    private function paginate(int $total, int $perPage, int $currentPage): object
    {
        $lastPage = (int) ceil($total / $perPage);

        return (object) [
            'current_page' => $currentPage,
            'last_page' => $lastPage,
            'total' => $total,
            'links' => [
                'prev' => $currentPage > 1 ? $currentPage - 1 : null,
                'next' => $currentPage < $lastPage ? $currentPage + 1 : null,
            ],
        ];
    }
}
