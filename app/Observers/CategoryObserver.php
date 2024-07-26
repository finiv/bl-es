<?php

namespace App\Observers;

use App\Models\Category;
use App\Traits\HandlesElasticsearch;
use Elastic\Elasticsearch\Client;

class CategoryObserver
{
    use HandlesElasticsearch;

    public function __construct(private readonly Client $client) {}

    public function created(Category $category): void
    {
        $this->elasticsearchOnCreate($category);
    }

    public function updated(Category $category): void
    {
        $this->elasticsearchOnUpdate($category);
    }

    public function deleting(Category $category): void
    {
        $this->elasticsearchOnDelete($category);
    }
}
