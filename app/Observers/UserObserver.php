<?php

namespace App\Observers;

use App\Models\User;
use App\Traits\HandlesElasticsearch;
use Elastic\Elasticsearch\Client;

class UserObserver
{
    use HandlesElasticsearch;
    public function __construct(private readonly Client $client) {}

    public function created(User $user): void
    {
        $this->elasticsearchOnCreate($user);
    }

    public function updated(User $user): void
    {
        $this->elasticsearchOnUpdate($user);
    }

    public function deleted(User $user): void
    {
        $this->elasticsearchOnDelete($user);
    }
}
