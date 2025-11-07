<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Repository extends Model
{
    protected $fillable = [
        'github_id',
        'user_id',
        'name',
        'private',
        'description',
        'html_url',
        'default_branch',
        'last_synced_at',
    ];

    protected $casts = [
        'private' => 'boolean',
        'last_synced_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
