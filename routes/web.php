<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\AnimeController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\EpisodeController;
use App\Http\Controllers\Dashboard\GenreController;
use App\Http\Controllers\Dashboard\SliderController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

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
        Route::resource('slider', SliderController::class)->except(['show', 'edit']);
        Route::patch('slider/{slider}/toggle', [SliderController::class, 'toggle'])->name('slider.toggle');

        // Genre management
        Route::resource('genres', GenreController::class)->only(['index', 'store', 'destroy']);

        // Episode management
        Route::resource('episodes', EpisodeController::class)->except(['show']);
    });
