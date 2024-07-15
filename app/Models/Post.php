<?php

namespace App\Models;

use Elastic\Elasticsearch\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($post) {
            $post->indexToElasticsearch();
        });

        static::updated(function ($post) {
            $post->indexToElasticsearch();
        });

        static::deleted(function ($post) {
            $post->deleteFromElasticsearch();
        });
    }

    public function indexToElasticsearch()
    {
        $client = app(Client::class);
        $client->index([
            'index' => 'posts',
            'id'    => $this->id,
            'body'  => $this->toArray(),
        ]);
    }

    public function deleteFromElasticsearch()
    {
        $client = app(Client::class);
        $response = $client->exists([
            'index' => 'posts',
            'id'    => $this->id,
        ]);

        if($response->getStatusCode() !== 404) {
            $client->delete([
                'index' => 'posts',
                'id'    => $this->id,
            ]);
        }

    }
}
