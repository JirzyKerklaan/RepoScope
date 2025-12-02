<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'github_id',
        'name',
        'email',
        'password',
        'avatar',
        'url',
        'api_url',
        'token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'token' => 'encrypted',
        ];
    }

    public function repositories(): BelongsToMany
    {
        return $this->belongsToMany(Repository::class, 'user_repository')
            ->withPivot('commit_count', 'role')
            ->withTimestamps();
    }
}
