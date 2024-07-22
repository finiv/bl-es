<?php

namespace App\Observers;

use App\Models\Post;
use Elastic\Elasticsearch\Client;
use Illuminate\Support\Facades\Log;

class PostObserver
{
    public function __construct(private readonly Client $client)
    {
    }

    public function created(Post $post): void
    {
        $this->indexToElasticsearch($post);
    }

    public function updated(Post $post): void
    {
        $this->indexToElasticsearch($post);
    }

    public function deleted(Post $post): void
    {
        $this->deleteFromElasticsearch($post);
    }

    protected function indexToElasticsearch(Post $post): void
    {
        $this->client->index([
            'index' => 'posts',
            'id' => $post->id,
            'body' => $post->toArray(),
        ]);
    }

    protected function deleteFromElasticsearch(Post $post): void
    {
        //$response = $this->client->exists([
        //    'index' => 'posts',
        //    'id' => $post->id,
        //]);
        //
        //if ($response->getStatusCode() !== 404) {
        try {
            $this->client->delete([
                'index' => 'posts',
                'id' => $post->id,
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
        //}
    }
}
