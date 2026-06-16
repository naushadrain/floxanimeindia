<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>floxanimeindia — Watch Anime Online</title>

    <link rel="icon" href="{{ asset('logo/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        * { -webkit-tap-highlight-color: transparent; }
        body { background:#070713; }
        .scrollbar-hide::-webkit-scrollbar { display:none; }
        .scrollbar-hide { -ms-overflow-style:none; scrollbar-width:none; }

        /* ── DETAIL BOTTOM SHEET ── */
        #detailModal {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        #detailModal.open {
            opacity: 1;
            pointer-events: all;
        }
        #detailSheet {
            transform: translateY(100%);
            transition: transform 0.42s cubic-bezier(0.32, 0.72, 0, 1);
            max-height: 92vh;
            overflow-y: auto;
        }
        #detailSheet::-webkit-scrollbar { display:none; }
        #detailModal.open #detailSheet {
            transform: translateY(0);
        }

        /* ── NETFLIX PLAYER ── */
        #fullVideoModal {
            transition: opacity 0.25s ease;
        }
        #fullVideoModal.hidden { opacity:0; pointer-events:none; display:flex !important; }
        #fullVideoModal.visible { opacity:1; pointer-events:all; }

        #ytWrapper {
            position: relative;
            width: 100%;
            height: 100%;
        }

        #fullVideoFrame {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Player overlays */
        #playerTopBar {
            background: linear-gradient(to bottom, rgba(0,0,0,0.88) 0%, transparent 100%);
            transition: opacity 0.3s ease;
            padding-top: max(12px, env(safe-area-inset-top));
        }
        #playerBottomBar {
            background: linear-gradient(to top, rgba(0,0,0,0.92) 0%, transparent 100%);
            transition: opacity 0.3s ease;
            padding-bottom: max(16px, env(safe-area-inset-bottom));
        }
        .ctrl-hidden {
            opacity: 0 !important;
            pointer-events: none !important;
        }

        /* Progress bar */
        .prog-track {
            height: 3px;
            background: rgba(255,255,255,0.22);
            border-radius: 99px;
            cursor: pointer;
            position: relative;
        }
        .prog-track:hover, .prog-track:active { height: 5px; }
        .prog-fill {
            height: 100%;
            background: linear-gradient(90deg, #a855f7, #ec4899);
            border-radius: 99px;
            position: relative;
            transition: width 0.5s linear;
        }
        .prog-thumb {
            position: absolute;
            right: -7px;
            top: 50%;
            transform: translateY(-50%) scale(0);
            width: 14px; height: 14px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(168,85,247,0.9);
            transition: transform 0.15s ease;
        }
        .prog-track:hover .prog-thumb,
        .prog-track:active .prog-thumb { transform: translateY(-50%) scale(1); }

        /* Center play/pause tap flash */
        #tapFlash {
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.15s ease;
        }
        #tapFlash.show { opacity: 1; }

        /* ── CARD ── */
        .v-card { cursor: pointer; }
        .v-card .card-overlay { opacity: 0; transition: opacity 0.2s; }
        @media (hover: hover) {
            .v-card:hover .card-overlay { opacity: 1; }
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(14px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .fade-up { animation: fadeUp 0.35s ease both; }

        @keyframes pulse-ring {
            0%   { transform: scale(1);   opacity: 1; }
            60%  { transform: scale(1.18); opacity: 0.7; }
            100% { transform: scale(1);   opacity: 1; }
        }
        .pulse { animation: pulse-ring 2.2s ease infinite; }

        @keyframes spin { to { transform: rotate(360deg); } }
        .spin { animation: spin 1s linear infinite; }

        /* Match badge gradient */
        .match-badge {
            background: linear-gradient(90deg, #22c55e, #16a34a);
        }

        /* Pill tabs */
        .tab-btn.active {
            border-bottom: 2px solid #a855f7;
            color: white;
        }
        .tab-btn { border-bottom: 2px solid transparent; }
    </style>
</head>

<body class="min-h-screen bg-[#070713] text-white">

@php
    $trending = [
        [
            'title' => 'Demon Slayer',
            'year' => '2024',
            'category' => 'Action',
            'rating' => '9.1',
            'votes' => '45K',
            'episodes' => '26',
            'duration' => '24 min',
            'studio' => 'ufotable',
            'director' => 'Haruo Sotozaki',
            'video_url' => 'https://www.youtube.com/embed/aqz-KE-bpKQ',
            'video_id'  => 'aqz-KE-bpKQ',
            'image' => 'https://images.unsplash.com/photo-1578632767115-351597cf2477?q=80&w=1200&auto=format&fit=crop',
            'description' => 'A powerful anime story filled with emotional battles, beautiful animation, and unforgettable characters fighting against darkness.',
        ],
        [
            'title' => 'Shadow Kingdom',
            'year' => '2025',
            'category' => 'Fantasy',
            'rating' => '8.8',
            'votes' => '32K',
            'episodes' => '18',
            'duration' => '25 min',
            'studio' => 'Madhouse',
            'director' => 'Hiroshi Kojima',
            'video_url' => 'https://www.youtube.com/embed/eRsGyueVLvQ',
            'video_id'  => 'eRsGyueVLvQ',
            'image' => 'https://images.unsplash.com/photo-1618336753974-aae8e04506aa?q=80&w=1200&auto=format&fit=crop',
            'description' => 'A mysterious hero rises in a world of magic, shadows, and ancient secrets waiting to be uncovered.',
        ],
        [
            'title' => 'Cyber Ronin',
            'year' => '2026',
            'category' => 'Sci-Fi',
            'rating' => '9.4',
            'votes' => '61K',
            'episodes' => '12',
            'duration' => '23 min',
            'studio' => 'Production I.G',
            'director' => 'Kenji Nakamura',
            'video_url' => 'https://www.youtube.com/embed/R6MlUcmOul8',
            'video_id'  => 'R6MlUcmOul8',
            'image' => 'https://images.unsplash.com/photo-1604871000636-074fa5117945?q=80&w=1200&auto=format&fit=crop',
            'description' => 'A futuristic samurai fights through neon cities, cyber enemies, and broken memories in search of truth.',
        ],
    ];

    $latest = [
        [
            'title' => 'Galaxy Drift',
            'year' => '2026',
            'category' => 'Sci-Fi',
            'rating' => '8.7',
            'votes' => '37K',
            'episodes' => '22',
            'duration' => '24 min',
            'studio' => 'Bones',
            'director' => 'Seiji Mizushima',
            'video_url' => 'https://www.youtube.com/embed/WhWc3b3KhnY',
            'video_id'  => 'WhWc3b3KhnY',
            'image' => 'https://images.unsplash.com/photo-1462331940025-496dfbfc7564?q=80&w=900&auto=format&fit=crop',
            'description' => 'Stranded in deep space, a crew of misfits must navigate alien territories to return home.',
        ],
        [
            'title' => 'Eternal Flame',
            'year' => '2026',
            'category' => 'Fantasy',
            'rating' => '8.9',
            'votes' => '41K',
            'episodes' => '20',
            'duration' => '23 min',
            'studio' => 'A-1 Pictures',
            'director' => 'Yoshiyuki Asai',
            'video_url' => 'https://www.youtube.com/embed/Y-rmzh0PI3c',
            'video_id'  => 'Y-rmzh0PI3c',
            'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=900&auto=format&fit=crop',
            'description' => 'A fire mage discovers her powers are the key to breaking a century-old curse.',
        ],
        [
            'title' => 'Iron Phantom',
            'year' => '2026',
            'category' => 'Mecha',
            'rating' => '8.3',
            'votes' => '22K',
            'episodes' => '16',
            'duration' => '26 min',
            'studio' => 'Sunrise',
            'director' => 'Goro Taniguchi',
            'video_url' => 'https://www.youtube.com/embed/TICHVBCGT2k',
            'video_id'  => 'TICHVBCGT2k',
            'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=900&auto=format&fit=crop',
            'description' => 'Piloting a forbidden mech, a young soldier wages war against an empire.',
        ],
    ];

    $uploads = [
        [
            'title' => 'Void Walker',
            'year' => '2026',
            'category' => 'Mystery',
            'rating' => '9.2',
            'votes' => '12K',
            'episodes' => '10',
            'duration' => '24 min',
            'studio' => 'Trigger',
            'director' => 'Hiroyuki Imaishi',
            'video_url' => 'https://www.youtube.com/embed/eRsGyueVLvQ',
            'video_id'  => 'eRsGyueVLvQ',
            'image' => 'https://images.unsplash.com/photo-1419242902214-272b3f66ee7a?q=80&w=900&auto=format&fit=crop',
            'description' => 'A detective enters the space between dimensions to hunt a killer who leaves no trace.',
        ],
        [
            'title' => 'Dragon Reborn',
            'year' => '2026',
            'category' => 'Action',
            'rating' => '9.5',
            'votes' => '21K',
            'episodes' => '24',
            'duration' => '25 min',
            'studio' => 'ufotable',
            'director' => 'Haruo Sotozaki',
            'video_url' => 'https://www.youtube.com/embed/TKF4ovKg3-c',
            'video_id'  => 'TKF4ovKg3-c',
            'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?q=80&w=900&auto=format&fit=crop',
            'description' => 'The last dragon rider awakens after centuries to reclaim a stolen world.',
        ],
        [
            'title' => 'Crystal Garden',
            'year' => '2026',
            'category' => 'Fantasy',
            'rating' => '8.1',
            'votes' => '6K',
            'episodes' => '13',
            'duration' => '22 min',
            'studio' => 'P.A.Works',
            'director' => 'Shinya Kawatsura',
            'video_url' => 'https://www.youtube.com/embed/Y-rmzh0PI3c',
            'video_id'  => 'Y-rmzh0PI3c',
            'image' => 'https://images.unsplash.com/photo-1520637102912-2df6bb2aec6d?q=80&w=900&auto=format&fit=crop',
            'description' => 'A botanist discovers a hidden garden where rare crystals reveal the future.',
        ],
    ];

    $allAnime = array_values(array_merge($trending, $latest, $uploads));
@endphp

{{-- HEADER --}}
<header class="sticky top-0 z-50 border-b border-white/10 bg-[#080812]/90 backdrop-blur-xl">
    <div class="flex items-center gap-3 px-4 py-3 sm:px-6 lg:px-8">
        <img src="{{ asset('logo/logo.png') }}" class="h-9 w-auto" alt="Logo">

        <nav class="hidden items-center gap-5 text-sm text-slate-300 lg:flex">
            <button class="transition hover:text-white">Browse</button>
            <button class="transition hover:text-white">Trending</button>
            <button class="transition hover:text-white">Latest</button>
            <button class="transition hover:text-white">New Uploads</button>
        </nav>

        <div class="ml-auto">
            <a href="{{ route('login') }}"
               class="rounded-xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-4 py-2 text-xs font-bold text-white">
                Admin Login
            </a>
        </div>
    </div>
</header>

<main class="pb-24">

    {{-- HERO --}}
    <section class="relative overflow-hidden">
        <div class="relative h-[62vh] min-h-[430px] sm:h-[76vh]">
            <img src="{{ $allAnime[0]['image'] }}"
                 class="absolute inset-0 h-full w-full object-cover"
                 alt="{{ $allAnime[0]['title'] }}">

            <div class="absolute inset-0 bg-gradient-to-t from-[#070713] via-[#070713]/75 to-black/30"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#070713]/85 via-transparent to-transparent"></div>

            <div class="absolute bottom-0 left-0 right-0 px-4 pb-8 sm:px-8 lg:px-12 lg:pb-16">
                <div class="max-w-2xl">
                    <span class="rounded-full bg-fuchsia-500 px-3 py-1 text-[10px] font-black text-white">
                        #1 Featured
                    </span>

                    <h1 class="mt-3 text-4xl font-black leading-tight sm:text-6xl">
                        {{ $allAnime[0]['title'] }}
                    </h1>

                    <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-slate-300">
                        <span class="match-badge rounded px-1.5 py-0.5 text-[10px] font-black text-white">97% Match</span>
                        <span>{{ $allAnime[0]['year'] }}</span>
                        <span class="rounded border border-white/30 px-1 text-[10px]">HD</span>
                        <span>{{ $allAnime[0]['episodes'] }} Eps</span>
                        <span>{{ $allAnime[0]['duration'] }}</span>
                        <span>{{ $allAnime[0]['studio'] }}</span>
                    </div>

                    <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-300 sm:max-w-xl">
                        {{ $allAnime[0]['description'] }}
                    </p>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <button onclick="openFullVideo(0)"
                                class="flex items-center gap-2 rounded-xl bg-white px-6 py-2.5 text-sm font-black text-black shadow-lg active:scale-95 transition">
                            <i data-lucide="play" class="h-4 w-4 fill-black"></i>
                            Play
                        </button>

                        <button onclick="openDetailModal(0)"
                                class="flex items-center gap-2 rounded-xl bg-white/20 px-5 py-2.5 text-sm font-bold text-white backdrop-blur active:scale-95 transition">
                            <i data-lucide="info" class="h-4 w-4"></i>
                            More Info
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- TRENDING --}}
    <section class="px-4 py-5 sm:px-6 lg:px-8">
        <div class="mb-3 flex items-center justify-between">
            <div>
                <h2 class="flex items-center gap-2 text-base font-black">
                    <i data-lucide="trending-up" class="h-4 w-4 text-fuchsia-400"></i>
                    Trending Now
                </h2>
                <p class="text-[11px] text-slate-500">Most watched anime today</p>
            </div>
            <button class="text-[11px] font-semibold text-fuchsia-400">See All</button>
        </div>

        <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
            @foreach($trending as $index => $item)
                @php $realIndex = $index; @endphp
                @include('components.video-card-fixed', ['item' => $item, 'realIndex' => $realIndex])
            @endforeach
        </div>
    </section>

    {{-- LATEST --}}
    <section class="px-4 py-5 sm:px-6 lg:px-8">
        <div class="mb-3 flex items-center justify-between">
            <div>
                <h2 class="flex items-center gap-2 text-base font-black">
                    <i data-lucide="clock" class="h-4 w-4 text-yellow-400"></i>
                    Latest Episodes
                </h2>
                <p class="text-[11px] text-slate-500">Fresh serial episodes added recently</p>
            </div>
            <button class="text-[11px] font-semibold text-yellow-400">See All</button>
        </div>

        <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
            @foreach($latest as $index => $item)
                @php $realIndex = $index + count($trending); @endphp
                @include('components.video-card-fixed', ['item' => $item, 'realIndex' => $realIndex])
            @endforeach
        </div>
    </section>

    {{-- NEW UPLOADS --}}
    <section class="px-4 py-5 sm:px-6 lg:px-8">
        <div class="mb-3 flex items-center justify-between">
            <div>
                <h2 class="flex items-center gap-2 text-base font-black">
                    <i data-lucide="upload-cloud" class="h-4 w-4 text-cyan-400"></i>
                    New Uploads
                </h2>
                <p class="text-[11px] text-slate-500">Newly uploaded anime videos</p>
            </div>
            <button class="text-[11px] font-semibold text-cyan-400">See All</button>
        </div>

        <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
            @foreach($uploads as $index => $item)
                @php $realIndex = $index + count($trending) + count($latest); @endphp
                @include('components.video-card-fixed', ['item' => $item, 'realIndex' => $realIndex])
            @endforeach
        </div>
    </section>

</main>

{{-- MOBILE BOTTOM NAV --}}
<nav class="fixed bottom-0 left-0 right-0 z-50 border-t border-white/10 bg-[#080812]/95 backdrop-blur-xl lg:hidden">
    <div class="flex items-center justify-around px-2 pt-2" style="padding-bottom:max(8px,env(safe-area-inset-bottom));">
        <button class="flex flex-col items-center gap-0.5 px-4 py-1 text-fuchsia-400">
            <i data-lucide="home" class="h-5 w-5"></i>
            <span class="text-[10px] font-semibold">Home</span>
        </button>
        <button class="flex flex-col items-center gap-0.5 px-4 py-1 text-slate-500">
            <i data-lucide="search" class="h-5 w-5"></i>
            <span class="text-[10px]">Search</span>
        </button>
        <button class="flex flex-col items-center gap-0.5 px-4 py-1 text-slate-500">
            <i data-lucide="compass" class="h-5 w-5"></i>
            <span class="text-[10px]">Genres</span>
        </button>
        <a href="{{ route('login') }}" class="flex flex-col items-center gap-0.5 px-4 py-1 text-slate-500">
            <i data-lucide="user" class="h-5 w-5"></i>
            <span class="text-[10px]">Admin</span>
        </a>
    </div>
</nav>

{{-- ═══════════════════════════════════════════════════════
     DETAIL MODAL — Netflix-style Bottom Sheet
═══════════════════════════════════════════════════════ --}}
<div id="detailModal"
     class="fixed inset-0 z-[130] flex items-end justify-center"
     style="background:rgba(0,0,0,0.75);"
     onclick="detailBackdrop(event)">

    <div id="detailSheet"
         class="w-full max-w-lg overflow-hidden rounded-t-3xl bg-[#111122] shadow-2xl sm:max-w-xl">

        {{-- Drag Handle --}}
        <div class="flex justify-center pt-3 pb-1">
            <div class="h-1 w-10 rounded-full bg-white/25"></div>
        </div>

        {{-- Thumbnail --}}
        <div class="relative aspect-video bg-black">
            <img id="detailImage" src="" class="h-full w-full object-cover" alt="">
            <div class="absolute inset-0 bg-gradient-to-t from-[#111122] via-black/30 to-transparent"></div>

            {{-- Close --}}
            <button onclick="closeDetailModal()"
                    class="absolute right-3 top-3 flex h-8 w-8 items-center justify-center rounded-full bg-[#111122]/80 backdrop-blur">
                <i data-lucide="x" class="h-4 w-4 text-white"></i>
            </button>

            {{-- Big play --}}
            <div class="absolute inset-0 flex items-center justify-center">
                <button id="detailPlayCenter"
                        class="pulse flex h-16 w-16 items-center justify-center rounded-full bg-white/20 backdrop-blur-sm ring-2 ring-white/30">
                    <i data-lucide="play" class="h-8 w-8 fill-white text-white"></i>
                </button>
            </div>

            {{-- Bottom info badges --}}
            <div class="absolute bottom-3 left-3 flex flex-wrap items-center gap-1.5">
                <span id="detailCatBadge" class="rounded-full bg-fuchsia-500 px-2.5 py-0.5 text-[9px] font-black text-white"></span>
                <span id="detailMatchBadge" class="match-badge rounded px-1.5 py-0.5 text-[9px] font-black text-white">97% Match</span>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center gap-3 px-4 py-3">
            <button id="detailPlayBtn"
                    class="flex flex-1 items-center justify-center gap-2 rounded-xl bg-white py-2.5 text-sm font-black text-black transition active:scale-95">
                <i data-lucide="play" class="h-4 w-4 fill-black"></i>
                Play
            </button>
            <button class="flex h-10 w-10 items-center justify-center rounded-full border border-white/25 bg-white/10 text-white transition active:scale-95">
                <i data-lucide="plus" class="h-4 w-4"></i>
            </button>
            <button class="flex h-10 w-10 items-center justify-center rounded-full border border-white/25 bg-white/10 text-white transition active:scale-95">
                <i data-lucide="thumbs-up" class="h-4 w-4"></i>
            </button>
            <button class="flex h-10 w-10 items-center justify-center rounded-full border border-white/25 bg-white/10 text-white transition active:scale-95">
                <i data-lucide="share-2" class="h-4 w-4"></i>
            </button>
        </div>

        {{-- Meta row --}}
        <div class="flex flex-wrap items-center gap-2 px-4 pb-2 text-xs text-slate-400">
            <span id="detailYear" class="font-semibold text-white"></span>
            <span class="rounded border border-white/20 px-1 text-[10px] text-slate-300">HD</span>
            <span id="detailEps" class="text-slate-400"></span>
            <span>•</span>
            <span id="detailDur" class="text-slate-400"></span>
            <span class="ml-auto font-bold text-yellow-400" id="detailRating"></span>
        </div>

        {{-- Title + Desc --}}
        <div class="px-4 pb-3">
            <h2 id="detailTitle" class="text-xl font-black text-white"></h2>
            <p id="detailStudio" class="mt-0.5 text-[11px] text-slate-500"></p>
            <p id="detailDescription" class="mt-2 text-sm leading-6 text-slate-300"></p>
        </div>

        {{-- Tabs --}}
        <div class="border-t border-white/10 px-4">
            <div class="flex gap-6 text-sm">
                <button class="tab-btn active py-3 font-semibold text-white text-sm">Episodes</button>
                <button class="tab-btn py-3 font-semibold text-slate-400 text-sm">Similar</button>
                <button class="tab-btn py-3 font-semibold text-slate-400 text-sm">About</button>
            </div>
        </div>

        {{-- Episodes list (static preview) --}}
        <div id="detailEpisodeList" class="px-4 pb-6 pt-1 space-y-0.5">
            {{-- Filled by JS --}}
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     FULLSCREEN PLAYER — Netflix Mobile Style
═══════════════════════════════════════════════════════ --}}
<div id="fullVideoModal"
     class="fixed inset-0 z-150 hidden flex-col items-center justify-center bg-black">

    {{-- YouTube iframe fills entire screen --}}
    <div id="ytWrapper" class="relative h-full w-full">
        <iframe id="fullVideoFrame"
                src=""
                title="Video Player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen>
        </iframe>

        {{-- Tap zone (catches taps to toggle controls) --}}
        <div id="tapZone"
             class="absolute inset-0 z-10"
             onclick="toggleControls()"
             style="background:transparent;"></div>

        {{-- Center tap flash (big play/pause icon) --}}
        <div id="tapFlash"
             class="pointer-events-none absolute left-1/2 top-1/2 z-20 flex -translate-x-1/2 -translate-y-1/2 h-20 w-20 items-center justify-center rounded-full bg-black/50 backdrop-blur-sm">
            <i id="tapFlashIcon" data-lucide="play" class="h-9 w-9 fill-white text-white"></i>
        </div>

        {{-- TOP BAR --}}
        <div id="playerTopBar"
             class="absolute left-0 right-0 top-0 z-30 flex items-center gap-3 px-4 pb-8 pt-3">
            <button onclick="closeFullVideo()"
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-black/40 backdrop-blur-sm transition active:scale-90">
                <i data-lucide="arrow-left" class="h-5 w-5 text-white"></i>
            </button>

            <div class="flex-1 min-w-0">
                <p id="playerTitle" class="truncate text-sm font-black text-white leading-tight"></p>
                <p id="playerMeta"  class="truncate text-[11px] text-slate-300"></p>
            </div>

            <button class="flex h-9 w-9 items-center justify-center rounded-full bg-black/40 backdrop-blur-sm">
                <i data-lucide="cast" class="h-4 w-4 text-white"></i>
            </button>
            <button class="flex h-9 w-9 items-center justify-center rounded-full bg-black/40 backdrop-blur-sm">
                <i data-lucide="settings" class="h-4 w-4 text-white"></i>
            </button>
        </div>

        {{-- BOTTOM BAR --}}
        <div id="playerBottomBar"
             class="absolute bottom-0 left-0 right-0 z-30 px-4 pb-4 pt-10">

            {{-- Progress bar --}}
            <div class="mb-3 flex items-center gap-3">
                <span id="timeCurrent" class="w-10 shrink-0 text-right text-[11px] font-semibold text-white tabular-nums">0:00</span>

                <div class="prog-track flex-1" id="progressBar" onclick="seekVideo(event)">
                    <div id="progressFill" class="prog-fill" style="width:0%">
                        <div class="prog-thumb"></div>
                    </div>
                </div>

                <span id="timeDuration" class="w-10 shrink-0 text-[11px] font-semibold text-slate-400 tabular-nums">0:00</span>
            </div>

            {{-- Control row --}}
            <div class="flex items-center gap-4">
                <button onclick="skipBack()" class="transition active:scale-90">
                    <i data-lucide="skip-back" class="h-5 w-5 text-white"></i>
                </button>

                <button id="playPauseBtn" onclick="togglePlayPause()"
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-white shadow-lg shadow-white/20 transition active:scale-90">
                    <i data-lucide="pause" class="h-6 w-6 fill-black text-black"></i>
                </button>

                <button onclick="skipForward()" class="transition active:scale-90">
                    <i data-lucide="skip-forward" class="h-5 w-5 text-white"></i>
                </button>

                <div class="flex-1"></div>

                <button id="muteBtn" onclick="toggleMute()" class="transition active:scale-90">
                    <i data-lucide="volume-2" class="h-5 w-5 text-white"></i>
                </button>

                <button onclick="requestFullscreen()" class="transition active:scale-90">
                    <i data-lucide="maximize" class="h-5 w-5 text-white"></i>
                </button>

                <button class="transition active:scale-90">
                    <i data-lucide="subtitles" class="h-5 w-5 text-white"></i>
                </button>
            </div>
        </div>

        {{-- Episode nav chips --}}
        <div id="playerEpChips"
             class="absolute bottom-28 left-0 right-0 z-30 flex gap-2 overflow-x-auto px-4 pb-1 scrollbar-hide">
            {{-- filled by JS --}}
        </div>
    </div>
</div>

{{-- YouTube IFrame API --}}
<script src="https://www.youtube.com/iframe_api"></script>

<script>
const animeData = @json($allAnime);

/* ── LUCIDE ── */
function refreshIcons() { lucide.createIcons(); }

/* ════════════════════════════════════════
   DETAIL MODAL
════════════════════════════════════════ */
function openDetailModal(index) {
    const item = animeData[index];
    if (!item) return;

    document.getElementById('detailImage').src        = item.image;
    document.getElementById('detailCatBadge').innerText = item.category;
    document.getElementById('detailYear').innerText   = item.year;
    document.getElementById('detailRating').innerText = '★ ' + item.rating;
    document.getElementById('detailTitle').innerText  = item.title;
    document.getElementById('detailStudio').innerText = item.studio + ' • Dir. ' + item.director;
    document.getElementById('detailEps').innerText    = item.episodes + ' Episodes';
    document.getElementById('detailDur').innerText    = item.duration;
    document.getElementById('detailDescription').innerText = item.description;

    /* Episode list preview */
    const list = document.getElementById('detailEpisodeList');
    list.innerHTML = '';
    const epCount = Math.min(parseInt(item.episodes) || 3, 4);
    for (let i = 1; i <= epCount; i++) {
        list.innerHTML += `
        <div class="flex items-center gap-3 rounded-xl py-2.5 px-1 transition hover:bg-white/5 cursor-pointer"
             onclick="closeDetailModal(); openFullVideo(${index})">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white/10 text-sm font-black text-white">${i}</div>
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-white">Episode ${i}</p>
                <p class="text-[11px] text-slate-400">${item.duration}</p>
            </div>
            <i data-lucide="play" class="h-4 w-4 shrink-0 text-slate-400 fill-slate-400"></i>
        </div>`;
    }

    const onPlay = () => { closeDetailModal(); openFullVideo(index); };
    document.getElementById('detailPlayBtn').onclick     = onPlay;
    document.getElementById('detailPlayCenter').onclick  = onPlay;

    const modal = document.getElementById('detailModal');
    modal.classList.remove('hidden');
    requestAnimationFrame(() => modal.classList.add('open'));

    document.body.style.overflow = 'hidden';
    refreshIcons();
}

function closeDetailModal() {
    const modal = document.getElementById('detailModal');
    modal.classList.remove('open');
    setTimeout(() => modal.classList.add('hidden'), 420);
    document.body.style.overflow = '';
}

function detailBackdrop(e) {
    if (e.target === document.getElementById('detailModal')) closeDetailModal();
}

/* ════════════════════════════════════════
   YOUTUBE PLAYER + FULLSCREEN MODAL
════════════════════════════════════════ */
let ytPlayer     = null;
let ytReady      = false;
let isPlaying    = true;
let isMuted      = false;
let progressInt  = null;
let ctrlTimer    = null;
let ctrlVisible  = true;
let currentIndex = 0;

window.onYouTubeIframeAPIReady = function () { ytReady = true; };

function openFullVideo(index) {
    const item = animeData[index];
    if (!item) return;
    currentIndex = index;

    document.getElementById('playerTitle').innerText = item.title;
    document.getElementById('playerMeta').innerText  = 'EP 1 · ' + item.duration;

    /* Build episode chips */
    const chipsEl = document.getElementById('playerEpChips');
    chipsEl.innerHTML = '';
    const epN = Math.min(parseInt(item.episodes) || 1, 6);
    for (let i = 1; i <= epN; i++) {
        chipsEl.innerHTML += `
        <button onclick="event.stopPropagation()"
                class="shrink-0 rounded-lg ${i===1?'bg-fuchsia-500 text-white font-black':'bg-white/10 text-slate-300'} px-3 py-1 text-xs font-semibold">
            EP ${i}
        </button>`;
    }

    const modal = document.getElementById('fullVideoModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
    isPlaying = true;

    /* Build or load YT player */
    if (ytReady) {
        if (ytPlayer) {
            ytPlayer.loadVideoById(item.video_id);
        } else {
            ytPlayer = new YT.Player('fullVideoFrame', {
                videoId: item.video_id,
                playerVars: {
                    autoplay: 1,
                    rel: 0,
                    modestbranding: 1,
                    iv_load_policy: 3,
                    color: 'white',
                },
                events: {
                    onReady: onPlayerReady,
                    onStateChange: onPlayerState,
                }
            });
        }
    } else {
        /* Fallback: plain embed */
        document.getElementById('fullVideoFrame').src =
            item.video_url + '?autoplay=1&rel=0&modestbranding=1';
    }

    showControls();
    refreshIcons();
}

function onPlayerReady(e) {
    e.target.playVideo();
    startProgress();
}

function onPlayerState(e) {
    isPlaying = (e.data === YT.PlayerState.PLAYING);
    updatePlayBtn();
    if (isPlaying) startProgress(); else stopProgress();
}

function closeFullVideo() {
    stopProgress();
    clearTimeout(ctrlTimer);

    if (ytPlayer && typeof ytPlayer.stopVideo === 'function') {
        ytPlayer.stopVideo();
    } else {
        document.getElementById('fullVideoFrame').src = '';
    }

    const modal = document.getElementById('fullVideoModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';

    document.getElementById('progressFill').style.width = '0%';
    document.getElementById('timeCurrent').innerText = '0:00';
    document.getElementById('timeDuration').innerText = '0:00';
}

/* ── Controls visibility ── */
function showControls() {
    ctrlVisible = true;
    document.getElementById('playerTopBar').classList.remove('ctrl-hidden');
    document.getElementById('playerBottomBar').classList.remove('ctrl-hidden');
    document.getElementById('playerEpChips').classList.remove('ctrl-hidden');
    clearTimeout(ctrlTimer);
    ctrlTimer = setTimeout(hideControls, 3500);
}

function hideControls() {
    ctrlVisible = false;
    document.getElementById('playerTopBar').classList.add('ctrl-hidden');
    document.getElementById('playerBottomBar').classList.add('ctrl-hidden');
    document.getElementById('playerEpChips').classList.add('ctrl-hidden');
}

function toggleControls() {
    if (ctrlVisible) hideControls(); else showControls();
}

/* ── Play / Pause ── */
function togglePlayPause() {
    if (!ytPlayer || typeof ytPlayer.getPlayerState !== 'function') return;
    if (isPlaying) { ytPlayer.pauseVideo(); } else { ytPlayer.playVideo(); }
    showFlash();
    showControls();
}

function showFlash() {
    const flash = document.getElementById('tapFlash');
    const icon  = document.getElementById('tapFlashIcon');
    icon.setAttribute('data-lucide', isPlaying ? 'pause' : 'play');
    refreshIcons();
    flash.classList.add('show');
    setTimeout(() => flash.classList.remove('show'), 600);
}

function updatePlayBtn() {
    const btn = document.getElementById('playPauseBtn');
    if (!btn) return;
    btn.innerHTML = isPlaying
        ? '<i data-lucide="pause" class="h-6 w-6 fill-black text-black"></i>'
        : '<i data-lucide="play"  class="h-6 w-6 fill-black text-black"></i>';
    refreshIcons();
}

/* ── Skip ── */
function skipBack() {
    if (ytPlayer && ytPlayer.getCurrentTime) {
        ytPlayer.seekTo(Math.max(0, ytPlayer.getCurrentTime() - 10), true);
        showControls();
    }
}
function skipForward() {
    if (ytPlayer && ytPlayer.getCurrentTime) {
        ytPlayer.seekTo(ytPlayer.getCurrentTime() + 10, true);
        showControls();
    }
}

/* ── Mute ── */
function toggleMute() {
    if (!ytPlayer) return;
    if (isMuted) { ytPlayer.unMute(); isMuted = false; }
    else         { ytPlayer.mute();   isMuted = true;  }
    const btn = document.getElementById('muteBtn');
    btn.innerHTML = isMuted
        ? '<i data-lucide="volume-x" class="h-5 w-5 text-white"></i>'
        : '<i data-lucide="volume-2" class="h-5 w-5 text-white"></i>';
    refreshIcons();
    showControls();
}

/* ── Fullscreen ── */
function requestFullscreen() {
    const el = document.getElementById('fullVideoModal');
    if (el.requestFullscreen)            el.requestFullscreen();
    else if (el.webkitRequestFullscreen) el.webkitRequestFullscreen();
    showControls();
}

/* ── Seek ── */
function seekVideo(e) {
    if (!ytPlayer || typeof ytPlayer.getDuration !== 'function') return;
    const bar  = document.getElementById('progressBar');
    const rect = bar.getBoundingClientRect();
    const pct  = Math.min(1, Math.max(0, (e.clientX - rect.left) / rect.width));
    const dur  = ytPlayer.getDuration();
    ytPlayer.seekTo(pct * dur, true);
    document.getElementById('progressFill').style.width = (pct * 100) + '%';
    showControls();
}

/* ── Progress tracking ── */
function startProgress() {
    stopProgress();
    progressInt = setInterval(updateProgress, 500);
}
function stopProgress() {
    clearInterval(progressInt);
}
function updateProgress() {
    if (!ytPlayer || typeof ytPlayer.getCurrentTime !== 'function') return;
    const cur = ytPlayer.getCurrentTime() || 0;
    const dur = ytPlayer.getDuration()    || 0;
    if (dur > 0) {
        document.getElementById('progressFill').style.width = ((cur / dur) * 100) + '%';
    }
    document.getElementById('timeCurrent').innerText  = fmtTime(cur);
    document.getElementById('timeDuration').innerText = fmtTime(dur);
}

function fmtTime(s) {
    const m = Math.floor(s / 60);
    const sec = Math.floor(s % 60);
    return m + ':' + String(sec).padStart(2, '0');
}

/* ── Keyboard ── */
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { closeFullVideo(); closeDetailModal(); }
    if (e.key === ' ')      { e.preventDefault(); togglePlayPause(); }
    if (e.key === 'ArrowLeft')  skipBack();
    if (e.key === 'ArrowRight') skipForward();
});

/* ── Tab switching ── */
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
    });
});

refreshIcons();
</script>

</body>
</html>
