<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use App\Models\Episode;
use App\Models\Genre;
use App\Models\Rating;
use App\Models\Slider;
use App\Models\Watchlist;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'animes'     => Anime::count(),
            'episodes'   => Episode::count(),
            'genres'     => Genre::count(),
            'sliders'    => Slider::count(),
            'watchlists' => Watchlist::count(),
            'ratings'    => Rating::count(),
        ];

        $recentAnime  = Anime::latest()->take(5)->get();
        $activeSliders = Slider::active()->get();

        return view('dashboard.index', compact('stats', 'recentAnime', 'activeSliders'));
    }
}
