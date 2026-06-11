<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnimeController extends Controller
{
    public function index()
    {
        $animes = Anime::with('genres')->latest()->paginate(12);
        return view('dashboard.anime.index', compact('animes'));
    }

    public function create()
    {
        $genres = Genre::orderBy('name')->get();
        return view('dashboard.anime.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'release_year'     => ['nullable', 'integer', 'min:1900', 'max:2099'],
            'status'           => ['required', 'in:ongoing,completed,upcoming'],
            'total_episodes'   => ['nullable', 'integer', 'min:0'],
            'episode_duration' => ['nullable', 'integer', 'min:0'],
            'studio'           => ['nullable', 'string', 'max:255'],
            'director'         => ['nullable', 'string', 'max:255'],
            'trailer_url'      => ['nullable', 'url'],
            'is_featured'      => ['boolean'],
            'is_trending'      => ['boolean'],
            'genres'           => ['nullable', 'array'],
            'genres.*'         => ['exists:genres,id'],
            'cover_image'      => ['nullable', 'image', 'max:4096'],
            'banner_image'     => ['nullable', 'image', 'max:4096'],
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_trending'] = $request->boolean('is_trending');

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('anime/covers', 'public');
        }
        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('anime/banners', 'public');
        }

        $anime = Anime::create($data);

        if (!empty($data['genres'])) {
            $anime->genres()->sync($data['genres']);
        }

        return redirect()->route('dashboard.anime.index')
            ->with('success', 'Anime "' . $anime->title . '" created successfully.');
    }

    public function edit(Anime $anime)
    {
        $genres = Genre::orderBy('name')->get();
        $anime->load('genres');
        return view('dashboard.anime.edit', compact('anime', 'genres'));
    }

    public function update(Request $request, Anime $anime)
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'release_year'     => ['nullable', 'integer', 'min:1900', 'max:2099'],
            'status'           => ['required', 'in:ongoing,completed,upcoming'],
            'total_episodes'   => ['nullable', 'integer', 'min:0'],
            'episode_duration' => ['nullable', 'integer', 'min:0'],
            'studio'           => ['nullable', 'string', 'max:255'],
            'director'         => ['nullable', 'string', 'max:255'],
            'trailer_url'      => ['nullable', 'url'],
            'is_featured'      => ['boolean'],
            'is_trending'      => ['boolean'],
            'genres'           => ['nullable', 'array'],
            'genres.*'         => ['exists:genres,id'],
            'cover_image'      => ['nullable', 'image', 'max:4096'],
            'banner_image'     => ['nullable', 'image', 'max:4096'],
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_trending'] = $request->boolean('is_trending');

        if ($request->hasFile('cover_image')) {
            if ($anime->cover_image) Storage::disk('public')->delete($anime->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('anime/covers', 'public');
        }
        if ($request->hasFile('banner_image')) {
            if ($anime->banner_image) Storage::disk('public')->delete($anime->banner_image);
            $data['banner_image'] = $request->file('banner_image')->store('anime/banners', 'public');
        }

        $anime->update($data);
        $anime->genres()->sync($data['genres'] ?? []);

        return redirect()->route('dashboard.anime.index')
            ->with('success', 'Anime "' . $anime->title . '" updated successfully.');
    }

    public function destroy(Anime $anime)
    {
        if ($anime->cover_image)  Storage::disk('public')->delete($anime->cover_image);
        if ($anime->banner_image) Storage::disk('public')->delete($anime->banner_image);

        $anime->delete();

        return redirect()->route('dashboard.anime.index')
            ->with('success', 'Anime deleted successfully.');
    }
}
