<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Episode extends Model
{
    protected $fillable = [
        'anime_id',
        'episode_number',
        'title',
        'description',
        'duration',
        'video_url',
        'thumbnail',
        'is_filler',
        'aired_at',
    ];

    protected $casts = [
        'is_filler' => 'boolean',
        'aired_at'  => 'date',
    ];

    /* ── Relationships ──────────────────────────────────────────────────── */

    public function anime(): BelongsTo
    {
        return $this->belongsTo(Anime::class);
    }

    public function watchHistories(): HasMany
    {
        return $this->hasMany(WatchHistory::class);
    }
}
