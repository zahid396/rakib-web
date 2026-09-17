<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class VisitLog extends Model
{
    protected $fillable = [
        'url', 'ip_hash', 'device', 'user_agent', 'referer', 'visited_at',
    ];

    protected function casts(): array
    {
        return [
            'visited_at' => 'datetime',
        ];
    }

    /**
     * Scope to visits on or after the given date.
     */
    public function scopeSince(Builder $query, $date): Builder
    {
        return $query->where('visited_at', '>=', $date);
    }
}