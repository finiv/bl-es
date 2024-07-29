<?php

namespace App\Models;

use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getAliasAttribute(): string
    {
        return 'users';
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
                        'email' => [
                            'type' => 'text'
                        ],
                    ]
                ]
            ]
        ];
    }

    public function getElasticsearchBodyAttribute(): array
    {
        return $this->only(['id', 'name', 'email']);
    }
}
