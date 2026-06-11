<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WatchHistory extends Model
{
    protected $fillable = [
        'user_id',
        'episode_id',
        'watched_seconds',
        'completed',
        'watched_at',
    ];

    protected $casts = [
        'completed'  => 'boolean',
        'watched_at' => 'datetime',
    ];

    /* ── Relationships ──────────────────────────────────────────────────── */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function episode(): BelongsTo
    {
        return $this->belongsTo(Episode::class);
    }
}
