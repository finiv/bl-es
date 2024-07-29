<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([CategoryObserver::class])]
class Category extends Model
{
    use HasFactory;

    public function getAliasAttribute(): string
    {
        return 'categories';
    }

    public function getElasticSearchParamsAttribute(): array
    {
        return [
            'index' => $this->alias . '_' . time(),
            'body' => [
                'mappings' => [
                    'properties' => [
                        'name' => [
                            'type' => 'text'
                        ],
                    ]
                ]
            ]
        ];
    }

    public function getElasticsearchBodyAttribute(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
