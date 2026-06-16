<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Episode;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->get();

        $trending = Anime::with([
                'genres',
                'episodes' => fn ($q) => $q->whereNotNull('video_url')
                    ->orderBy('episode_number')
                    ->limit(1),
            ])
            ->where('is_trending', true)
            ->latest()
            ->take(10)
            ->get()
            ->map(fn ($a) => $this->animeCard($a))
            ->values()
            ->toArray();

        $latestEpisodes = Episode::with(['anime' => fn ($q) => $q->with('genres')])
            ->whereNotNull('video_url')
            ->orderByDesc('aired_at')
            ->orderByDesc('id')
            ->take(10)
            ->get()
            ->map(fn ($e) => $this->episodeCard($e))
            ->values()
            ->toArray();

        $newUploads = Episode::with(['anime' => fn ($q) => $q->with('genres')])
            ->whereNotNull('video_url')
            ->latest()
            ->take(10)
            ->get()
            ->map(fn ($e) => $this->episodeCard($e))
            ->values()
            ->toArray();

        return view('welcome', compact('sliders', 'trending', 'latestEpisodes', 'newUploads'));
    }

    private function animeCard(Anime $anime): array
    {
        $firstEp  = $anime->episodes->first();
        $videoUrl = $firstEp?->video_url ?? $anime->trailer_url ?? '';
        $image    = $anime->cover_image
            ? Storage::url($anime->cover_image)
            : 'https://images.unsplash.com/photo-1578632767115-351597cf2477?q=80&w=1200&auto=format&fit=crop';

        return [
            'id'          => $anime->id,
            'title'       => $anime->title,
            'year'        => (string) ($anime->release_year ?? date('Y')),
            'category'    => $anime->genres->first()?->name ?? 'Anime',
            'rating'      => number_format((float) ($anime->avg_rating ?? 0), 1),
            'votes'       => $this->formatCount($anime->votes_count ?? 0),
            'episodes'    => (string) ($anime->total_episodes ?? 0),
            'duration'    => ($anime->episode_duration ?? 24) . ' min',
            'studio'      => $anime->studio ?? 'Unknown Studio',
            'director'    => $anime->director ?? 'Unknown',
            'video_url'   => $videoUrl,
            'video_id'    => $this->youtubeId($videoUrl),
            'image'       => $image,
            'description' => $anime->description ?? '',
        ];
    }

    private function episodeCard(Episode $episode): array
    {
        $anime    = $episode->anime;
        $videoUrl = $episode->video_url ?? '';
        $image    = $episode->thumbnail_url
            ?: ($episode->thumbnail ? Storage::url($episode->thumbnail) : null)
            ?: ($anime?->cover_image ? Storage::url($anime->cover_image) : null)
            ?: 'https://images.unsplash.com/photo-1578632767115-351597cf2477?q=80&w=900&auto=format&fit=crop';

        return [
            'id'             => $anime?->id ?? 0,
            'episode_id'     => $episode->id,
            'episode_number' => $episode->episode_number,
            'title'          => ($anime?->title ?? 'Unknown') . ' · EP ' . $episode->episode_number,
            'ep_title'       => $episode->title,
            'year'           => (string) ($episode->aired_at?->year ?? $anime?->release_year ?? date('Y')),
            'category'       => $anime?->genres?->first()?->name ?? 'Anime',
            'rating'         => number_format((float) ($anime?->avg_rating ?? 0), 1),
            'votes'          => $this->formatCount($anime?->votes_count ?? 0),
            'episodes'       => (string) ($anime?->total_episodes ?? 0),
            'duration'       => $episode->duration ? ceil($episode->duration / 60) . ' min' : '24 min',
            'studio'         => $anime?->studio ?? 'Unknown Studio',
            'director'       => $anime?->director ?? 'Unknown',
            'video_url'      => $videoUrl,
            'video_id'       => $this->youtubeId($videoUrl),
            'image'          => $image,
            'description'    => $episode->description ?? $anime?->description ?? '',
        ];
    }

    private function youtubeId(string $url): string
    {
        if (preg_match('/(?:youtube\.com\/embed\/|youtu\.be\/|[?&]v=)([A-Za-z0-9_-]{11})/', $url, $m)) {
            return $m[1];
        }
        return '';
    }

    private function formatCount(int $n): string
    {
        if ($n >= 1_000_000) return round($n / 1_000_000, 1) . 'M';
        if ($n >= 1_000)     return round($n / 1_000, 1) . 'K';
        return (string) $n ?: '0';
    }
}
