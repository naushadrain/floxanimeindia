<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::withCount('animes')->orderBy('name')->get();
        return view('dashboard.genres.index', compact('genres'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:genres,name'],
        ]);

        $data['slug'] = Str::slug($data['name']);

        Genre::create($data);

        return redirect()->route('dashboard.genres.index')
            ->with('success', 'Genre "' . $data['name'] . '" added.');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return redirect()->route('dashboard.genres.index')
            ->with('success', 'Genre deleted.');
    }
}
