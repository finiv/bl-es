<?php

namespace App\Observers;

use App\Models\Post;
use App\Traits\HandlesElasticsearch;
use Elastic\Elasticsearch\Client;

class PostObserver
{
    use HandlesElasticsearch;
    public function __construct(private readonly Client $client) {}

    public function created(Post $post): void
    {
        $this->elasticsearchOnCreate($post);
    }

    public function updated(Post $post): void
    {
        $this->elasticsearchOnUpdate($post);
    }

    public function deleted(Post $post): void
    {
        $this->elasticsearchOnDelete($post);
    }
}
