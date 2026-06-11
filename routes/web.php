<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $genres = [
        'Action',
        'Adventure',
        'Comedy',
        'Drama',
        'Fantasy',
        'Horror',
        'Romance',
        'Sci-Fi',
        'Supernatural',
        'Slice of Life',
    ];

    $animeList = [
        [
            'id' => '1',
            'title' => 'Demon Slayer',
            'description' => 'A powerful anime story filled with emotional battles, beautiful animation, and unforgettable characters fighting against darkness.',
            'category' => 'Action',
            'year' => '2024',
            'rating' => '9.1',
            'votes' => '45K',
            'episodes' => '26',
            'studio' => 'Ufotable',
            'director' => 'Haruo Sotozaki',
            'duration' => '24 min',
            'image' => 'https://images.unsplash.com/photo-1578632767115-351597cf2477?q=80&w=1200&auto=format&fit=crop',
        ],
        [
            'id' => '2',
            'title' => 'Shadow Kingdom',
            'description' => 'A mysterious hero rises in a world of magic, shadows, ancient secrets, and dangerous enemies.',
            'category' => 'Fantasy',
            'year' => '2025',
            'rating' => '8.8',
            'votes' => '32K',
            'episodes' => '18',
            'studio' => 'Anime Studio',
            'director' => 'Unknown',
            'duration' => '25 min',
            'image' => 'https://images.unsplash.com/photo-1618336753974-aae8e04506aa?q=80&w=1200&auto=format&fit=crop',
        ],
        [
            'id' => '3',
            'title' => 'Cyber Ronin',
            'description' => 'A futuristic samurai fights through neon cities, cyber enemies, and broken memories.',
            'category' => 'Sci-Fi',
            'year' => '2026',
            'rating' => '9.4',
            'votes' => '61K',
            'episodes' => '12',
            'studio' => 'Cyber Studio',
            'director' => 'Kenji Mori',
            'duration' => '23 min',
            'image' => 'https://images.unsplash.com/photo-1604871000636-074fa5117945?q=80&w=1200&auto=format&fit=crop',
        ],
    ];

    return view('welcome', compact('animeList', 'genres'));
});