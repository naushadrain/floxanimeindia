<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use App\Models\Episode;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EpisodeController extends Controller
{
    public function index(Request $request)
    {
        $animes = Anime::orderBy('title')->get();
        $genres = Genre::orderBy('name')->withCount('animes')->get();

        $episodes = Episode::with(['anime.genres'])
            ->when($request->anime_id, fn ($q) => $q->where('anime_id', $request->anime_id))
            ->when($request->genre_id, fn ($q) => $q->whereHas('anime.genres', fn ($g) => $g->where('genres.id', $request->genre_id)))
            ->orderBy('anime_id')
            ->orderBy('episode_number')
            ->paginate(30);

        return view('dashboard.episodes.index', compact('episodes', 'animes', 'genres'));
    }

    public function create()
    {
        $animes = Anime::orderBy('title')->get();
        return view('dashboard.episodes.create', compact('animes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'anime_id'       => ['required', 'exists:animes,id'],
            'episode_number' => ['required', 'integer', 'min:1'],
            'title'          => ['nullable', 'string', 'max:255'],
            'description'    => ['nullable', 'string', 'max:2000'],
            'duration'       => ['nullable', 'integer', 'min:0', 'max:86400'],
            'video_url'      => ['required', 'url', 'max:1000'],
            'thumbnail_url'  => ['nullable', 'url', 'max:1000'],
            'is_filler'      => ['boolean'],
            'aired_at'       => ['nullable', 'date'],
        ]);

        $data['is_filler'] = $request->boolean('is_filler');

        Episode::create($data);

        return back()->with('success', 'Episode added successfully.');
    }

    public function edit(Episode $episode)
    {
        $animes = Anime::orderBy('title')->get();
        return view('dashboard.episodes.edit', compact('episode', 'animes'));
    }

    public function update(Request $request, Episode $episode)
    {
        $data = $request->validate([
            'anime_id'       => ['required', 'exists:animes,id'],
            'episode_number' => ['required', 'integer', 'min:1'],
            'title'          => ['nullable', 'string', 'max:255'],
            'description'    => ['nullable', 'string', 'max:2000'],
            'duration'       => ['nullable', 'integer', 'min:0', 'max:86400'],
            'video_url'      => ['required', 'url', 'max:1000'],
            'thumbnail_url'  => ['nullable', 'url', 'max:1000'],
            'is_filler'      => ['boolean'],
            'aired_at'       => ['nullable', 'date'],
        ]);

        $data['is_filler'] = $request->boolean('is_filler');

        $episode->update($data);

        return redirect()->route('dashboard.episodes.index')
            ->with('success', 'Episode updated successfully.');
    }

    public function destroy(Episode $episode)
    {
        if ($episode->thumbnail) Storage::disk('public')->delete($episode->thumbnail);
        $episode->delete();

        return back()->with('success', 'Episode deleted.');
    }
}
