<?php

namespace App\Models;

use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([PostObserver::class])]
class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'categories' => 'array',
    ];

    public function getAliasAttribute(): string
    {
        return 'posts';
    }

    public function getElasticSearchParamsAttribute(): array
    {
        return [
            'index' => $this->alias . '_' . time(),
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
    }

    public function getElasticsearchBodyAttribute(): array
    {
        $data = $this->toArray();
        $data['categories'] = array_map('intval', json_decode($this->categories, true));

        return $data;
    }
}
