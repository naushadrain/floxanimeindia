<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EpisodeController extends Controller
{
    public function index(Request $request)
    {
        $animes = Anime::orderBy('title')->get();
        $episodes = Episode::with('anime')
            ->when($request->anime_id, fn ($q) => $q->where('anime_id', $request->anime_id))
            ->orderBy('anime_id')
            ->orderBy('episode_number')
            ->paginate(15);

        return view('dashboard.episodes.index', compact('episodes', 'animes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'anime_id'       => ['required', 'exists:animes,id'],
            'episode_number' => ['required', 'integer', 'min:1'],
            'title'          => ['nullable', 'string', 'max:255'],
            'description'    => ['nullable', 'string'],
            'duration'       => ['nullable', 'integer', 'min:0'],
            'video_url'      => ['nullable', 'url'],
            'thumbnail'      => ['nullable', 'image', 'max:2048'],
            'is_filler'      => ['boolean'],
            'aired_at'       => ['nullable', 'date'],
        ]);

        $data['is_filler'] = $request->boolean('is_filler');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('episodes/thumbnails', 'public');
        }

        Episode::create($data);

        return redirect()->route('dashboard.episodes.index')
            ->with('success', 'Episode added successfully.');
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
            'description'    => ['nullable', 'string'],
            'duration'       => ['nullable', 'integer', 'min:0'],
            'video_url'      => ['nullable', 'url'],
            'thumbnail'      => ['nullable', 'image', 'max:2048'],
            'is_filler'      => ['boolean'],
            'aired_at'       => ['nullable', 'date'],
        ]);

        $data['is_filler'] = $request->boolean('is_filler');

        if ($request->hasFile('thumbnail')) {
            if ($episode->thumbnail) Storage::disk('public')->delete($episode->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('episodes/thumbnails', 'public');
        }

        $episode->update($data);

        return redirect()->route('dashboard.episodes.index')
            ->with('success', 'Episode updated successfully.');
    }

    public function destroy(Episode $episode)
    {
        if ($episode->thumbnail) Storage::disk('public')->delete($episode->thumbnail);
        $episode->delete();

        return redirect()->route('dashboard.episodes.index')
            ->with('success', 'Episode deleted.');
    }
}
