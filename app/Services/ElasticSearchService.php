<?php

namespace App\Services;

use Elastic\Elasticsearch\Client;
use App\Traits\Paginates;
use Illuminate\Support\Collection;

class ElasticSearchService
{
    use Paginates;

    public function __construct(private readonly Client $client) {}

    public function searchPosts(string $query = null, array $categories = [], int $page = 1, int $perPage = 10): object
    {
        $from = ($page - 1) * $perPage;

        $params = [
            'index' => 'posts',
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [],
                    ],
                ],
                'size' => $perPage,
                'from' => $from,
            ],
        ];

        if ($query !== null) {
            $params['body']['query']['bool']['must'][] = [
                'multi_match' => [
                    'query' => $query,
                    'fields' => ['title', 'body'],
                ],
            ];
        }

        if (!empty($categories)) {
            $params['body']['query']['bool']['must'][] = [
                'terms' => [
                    'categories' => $categories,
                ],
            ];
        } else {
            $params['body']['query']['bool']['must'][] = [
                'match_all' => (object)[],
            ];
        }

        $response = $this->client->search($params);
        $posts = collect($response['hits']['hits'])->map(function ($hit) {
            return $hit['_source'];
        });

        $total = max(1, $response['hits']['total']['value']);

        return (object) [
            'posts' => $posts,
            'pagination' => $this->paginate($total, $perPage, $page),
            'categories' => $this->getCategories() // todo fix categories filter
        ];
    }

    public function getCategories(): Collection
    {
        $params = [
            'index' => 'categories',
            'body' => [
                'query' => [
                    'match_all' => (object)[],
                ],
                'size' => 1000,
            ],
        ];

        $response = $this->client->search($params);

        return collect($response['hits']['hits'])->map(function ($hit) {
            return $hit['_source'];
        });
    }
}
