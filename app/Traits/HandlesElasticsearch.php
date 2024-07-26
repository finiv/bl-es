<?php

namespace App\Traits;

use Elastic\Elasticsearch\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

trait HandlesElasticsearch
{
    public function __construct(private readonly Client $client) {}

    public function elasticsearchOnCreate(Model $model)
    {
        $indexAlias = $model->alias;
        $this->ensureIndexExists($indexAlias, $model->elasticsearchParams);
        $this->indexToElasticsearch($model, $indexAlias, $model->elasticsearchBody);
    }

    public function elasticsearchOnUpdate(Model $model)
    {
        $indexAlias = $model->alias;
        $this->ensureIndexExists($indexAlias, $model->elasticsearchParams);
        $this->indexToElasticsearch($model, $indexAlias, $model->elasticsearchBody);
    }

    public function elasticsearchOnDelete(Model $model): void
    {
        $this->deleteFromElasticsearch($model);
    }

    protected function ensureIndexExists(string $indexAlias, array $params): void
    {
        $exists = $this->client->indices()->existsAlias(['name' => $indexAlias])->asBool();

        if (! $exists) {
            $indexName = $indexAlias.'_'.time();
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

    protected function indexToElasticsearch(Model $model, string $indexAlias, array $body): void
    {
        $index = $this->getIndexForAlias($indexAlias);
        $this->client->index([
            'index' => $index,
            'id' => $model->id,
            'body' => $body,
        ]);
    }

    protected function deleteFromElasticsearch(Model $model): void
    {
        $index = $this->getIndexForAlias($model->alias);

        try {
            $this->client->delete([
                'index' => $index,
                'id' => $model->id,
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }
}
