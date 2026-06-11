<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\AnimeController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\EpisodeController;
use App\Http\Controllers\Dashboard\GenreController;
use App\Http\Controllers\Dashboard\SliderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $genres = [
        'Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy',
        'Horror', 'Romance', 'Sci-Fi', 'Supernatural', 'Slice of Life',
    ];

    $animeList = [
        [
            'id'          => '1',
            'title'       => 'Demon Slayer',
            'description' => 'A powerful anime story filled with emotional battles, beautiful animation, and unforgettable characters fighting against darkness.',
            'category'    => 'Action',
            'year'        => '2024',
            'rating'      => '9.1',
            'votes'       => '45K',
            'episodes'    => '26',
            'studio'      => 'Ufotable',
            'director'    => 'Haruo Sotozaki',
            'duration'    => '24 min',
            'image'       => 'https://images.unsplash.com/photo-1578632767115-351597cf2477?q=80&w=1200&auto=format&fit=crop',
        ],
        [
            'id'          => '2',
            'title'       => 'Shadow Kingdom',
            'description' => 'A mysterious hero rises in a world of magic, shadows, ancient secrets, and dangerous enemies.',
            'category'    => 'Fantasy',
            'year'        => '2025',
            'rating'      => '8.8',
            'votes'       => '32K',
            'episodes'    => '18',
            'studio'      => 'Madhouse',
            'director'    => 'Hiroshi Kojima',
            'duration'    => '25 min',
            'image'       => 'https://images.unsplash.com/photo-1618336753974-aae8e04506aa?q=80&w=1200&auto=format&fit=crop',
        ],
        [
            'id'          => '3',
            'title'       => 'Cyber Ronin',
            'description' => 'A futuristic samurai fights through neon cities, cyber enemies, and broken memories.',
            'category'    => 'Sci-Fi',
            'year'        => '2026',
            'rating'      => '9.4',
            'votes'       => '61K',
            'episodes'    => '12',
            'studio'      => 'Production I.G',
            'director'    => 'Kenji Nakamura',
            'duration'    => '23 min',
            'image'       => 'https://images.unsplash.com/photo-1604871000636-074fa5117945?q=80&w=1200&auto=format&fit=crop',
        ],
    ];

    return view('welcome', compact('animeList', 'genres'));
})->name('home');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard (auth protected)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {

        // Overview
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        // Anime CRUD
        Route::resource('anime', AnimeController::class);

        // Slider management
        Route::resource('slider', SliderController::class)->except(['show', 'create', 'edit']);
        Route::patch('slider/{slider}/toggle', [SliderController::class, 'toggle'])->name('slider.toggle');

        // Genre management
        Route::resource('genres', GenreController::class)->only(['index', 'store', 'destroy']);

        // Episode management
        Route::resource('episodes', EpisodeController::class)->except(['show', 'create']);
    });
