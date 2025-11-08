<?php

namespace App\Models;

use App\Casts\SizeCast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Repository extends Model
{
    protected $fillable = [
        'github_id',
        'name',
        'private',
        'description',
        'html_url',
        'default_branch',
        'branch_count',
        'pulls_count',
        'language',
        'last_pushed_at',
        'last_synced_at',
        'size',
    ];

    protected $casts = [
        'size' => SizeCast::class,
        'last_pushed_at' => 'datetime',
        'last_synced_at' => 'datetime',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_repository')
            ->withPivot('commit_count')
            ->withTimestamps();
    }

    public function scopeFilters(Builder $builder, $filter): void
    {
        $builder->where('name', 'like', "%{$filter}%")
            ->orWhere('kvk_number', 'like', "%{$filter}%");
    }
}
