<?php

namespace App\Services;

use Elastic\Elasticsearch\Client;
use App\Traits\Paginates;

class ElasticSearchService
{
    use Paginates;

    public function __construct(private readonly Client $client) {}

    public function searchPosts(int $page = 1, int $perPage = 10): object
    {
        $from = ($page - 1) * $perPage;

        $response = $this->client->search([
            'index' => 'posts',
            'body'  => [
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
}
