<?php

namespace App\Observers;

use App\Models\Post;
use Elastic\Elasticsearch\Client;
use Illuminate\Support\Facades\Log;

class PostObserver
{
    public function __construct(private readonly Client $client) {}

    public function created(Post $post): void
    {
        $this->ensureIndexExists();
        $this->indexToElasticsearch($post);
    }

    public function updated(Post $post): void
    {
        $this->ensureIndexExists();
        $this->indexToElasticsearch($post);
    }

    public function deleted(Post $post): void
    {
        $this->deleteFromElasticsearch($post);
    }

    protected function ensureIndexExists(): void
    {
        $indexAlias = 'posts';
        $exists = $this->client->indices()->existsAlias(['name' => $indexAlias]);

        if (!$exists) {
            $indexName = $indexAlias . '_' . time();
            $params = [
                'index' => $indexName,
                'body' => [
                    'mappings' => [
                        'properties' => [
                            'title' => [
                                'type' => 'text'
                            ],
                            'body' => [
                                'type' => 'text'
                            ],
                            'categories' => [
                                'type' => 'integer'
                            ]
                        ]
                    ]
                ]
            ];

            $this->client->indices()->create($params);

            $this->client->indices()->putAlias([
                'index' => $indexName,
                'name' => $indexAlias,
            ]);
        }
    }

    protected function getIndexForAlias(string $alias): string
    {
        $response = $this->client->indices()->getAlias(['name' => $alias]);
        $indices = array_keys($response->asArray());
        return $indices[0] ?? $alias;
    }

    protected function indexToElasticsearch(Post $post): void
    {
        $index = $this->getIndexForAlias('posts');

        $data = $post->toArray();
        $data['categories'] = array_map('intval', json_decode($post->categories, true));

        $this->client->index([
            'index' => $index,
            'id' => $post->id,
            'body' => $data,
        ]);
    }

    protected function deleteFromElasticsearch(Post $post): void
    {
        $index = $this->getIndexForAlias('posts');

        try {
            $this->client->delete([
                'index' => $index,
                'id' => $post->id,
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }
}
