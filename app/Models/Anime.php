<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Anime extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'release_year',
        'status',
        'total_episodes',
        'episode_duration',
        'avg_rating',
        'votes_count',
        'studio',
        'director',
        'cover_image',
        'banner_image',
        'trailer_url',
        'is_featured',
        'is_trending',
    ];

    protected $casts = [
        'is_featured'  => 'boolean',
        'is_trending'  => 'boolean',
        'avg_rating'   => 'float',
        'release_year' => 'integer',
    ];

    /* ── Relationships ──────────────────────────────────────────────────── */

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class)->orderBy('episode_number');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function watchlists(): HasMany
    {
        return $this->hasMany(Watchlist::class);
    }

    /* ── Scopes ─────────────────────────────────────────────────────────── */

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeTrending($query)
    {
        return $query->where('is_trending', true);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
