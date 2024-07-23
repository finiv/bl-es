<?php

namespace App\Services;

use Elastic\Elasticsearch\Client;
use App\Traits\Paginates;

class ElasticSearchService
{
    use Paginates;

    public function __construct(private readonly Client $client) {}

    public function searchPosts(string $query = null, int $page = 1, int $perPage = 10): object
    {
        $from = ($page - 1) * $perPage;

        $params = [
            'index' => 'posts',
            'body' => [
                'query' => [],
            ],
            'size' => $perPage,
            'from' => $from,
        ];

        if ($query !== null) {
            $params['body']['query'] = ['multi_match' => ['query' => $query, 'fields' => ['title', 'body']]];
        } else {
            $params['body']['query'] = ['match_all' => (object) []];
        }

        $response = $this->client->search($params);
        $posts = collect($response['hits']['hits'])->map(function ($hit) {
            return $hit['_source'];
        });

        $total = max(1, $response['hits']['total']['value']);

        return (object) [
            'posts' => $posts,
            'pagination' => $this->paginate($total, $perPage, $page),
        ];
    }
}
