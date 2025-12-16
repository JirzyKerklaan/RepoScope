<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FrequentMember extends Model
{
    protected $table = 'frequent_members';

    protected $fillable = ['user_id', 'github_id', 'username', 'display_name', 'avatar_url'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
