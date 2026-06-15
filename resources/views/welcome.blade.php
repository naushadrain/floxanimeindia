<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>floxanimeindia — Watch Anime Online</title>

    <link rel="icon" href="{{ asset('logo/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body { background:#070713; }
        .scrollbar-hide::-webkit-scrollbar { display:none; }
        .scrollbar-hide { -ms-overflow-style:none; scrollbar-width:none; }
        #videoModal { backdrop-filter: blur(14px); }

        .video-frame {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%;
            background: #000;
        }

        .video-frame iframe {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
        }

        @media(max-width:639px){
            #videoModal .player-box {
                border-radius: 24px 24px 0 0;
                max-height: 94vh;
                overflow-y: auto;
            }
        }
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
            'image' => 'https://images.unsplash.com/photo-1604871000636-074fa5117945?q=80&w=1200&auto=format&fit=crop',
            'description' => 'A futuristic samurai fights through neon cities, cyber enemies, and broken memories in search of truth.',
        ],
        [
            'title' => 'BloodMoon Rising',
            'year' => '2025',
            'category' => 'Horror',
            'rating' => '8.5',
            'votes' => '28K',
            'episodes' => '13',
            'duration' => '22 min',
            'studio' => 'Wit Studio',
            'director' => 'Tetsuro Araki',
            'video_url' => 'https://www.youtube.com/embed/TKF4ovKg3-c',
            'image' => 'https://images.unsplash.com/photo-1535930891776-0c2dfb7fda1a?q=80&w=800&auto=format&fit=crop',
            'description' => 'Ancient vampires awaken and a lone hunter must stop the world from falling into eternal night.',
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
            'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=900&auto=format&fit=crop',
            'description' => 'Piloting a forbidden mech, a young soldier wages war against an empire.',
        ],
        [
            'title' => 'Ocean Spirit',
            'year' => '2026',
            'category' => 'Adventure',
            'rating' => '8.6',
            'votes' => '19K',
            'episodes' => '14',
            'duration' => '22 min',
            'studio' => 'Studio Ghibli',
            'director' => 'Hayao Miyazaki',
            'video_url' => 'https://www.youtube.com/embed/aqz-KE-bpKQ',
            'image' => 'https://images.unsplash.com/photo-1505118380757-91f5f5632de0?q=80&w=900&auto=format&fit=crop',
            'description' => 'A young girl bonded with an ancient sea spirit travels to the edge of the world.',
        ],
    ];

    $newUploads = [
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
            'image' => 'https://images.unsplash.com/photo-1419242902214-272b3f66ee7a?q=80&w=900&auto=format&fit=crop',
            'description' => 'A detective enters the space between dimensions to hunt a killer who leaves no trace.',
        ],
        [
            'title' => 'Neon Butterfly',
            'year' => '2026',
            'category' => 'Romance',
            'rating' => '8.4',
            'votes' => '8K',
            'episodes' => '12',
            'duration' => '23 min',
            'studio' => 'Kyoto Animation',
            'director' => 'Naoko Yamada',
            'video_url' => 'https://www.youtube.com/embed/R6MlUcmOul8',
            'image' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?q=80&w=900&auto=format&fit=crop',
            'description' => 'Two rivals at an animation school find unexpected love through their shared passion.',
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
            'image' => 'https://images.unsplash.com/photo-1520637102912-2df6bb2aec6d?q=80&w=900&auto=format&fit=crop',
            'description' => 'A botanist discovers a hidden garden where rare crystals reveal the future.',
        ],
    ];

    $allAnime = array_values(array_merge($trending, $latest, $newUploads));
@endphp

<header class="sticky top-0 z-50 border-b border-white/10 bg-[#080812]/90 backdrop-blur-xl">
    <div class="flex items-center gap-3 px-4 py-3 sm:px-6 lg:px-8">
        <img src="{{ asset('logo/logo.png') }}" class="h-9 w-auto" alt="Logo">

        <nav class="hidden items-center gap-5 text-sm text-slate-300 lg:flex">
            <button class="transition hover:text-white">Browse</button>
            <button class="transition hover:text-white">Trending</button>
            <button class="transition hover:text-white">Latest</button>
            <button class="transition hover:text-white">New Uploads</button>
        </nav>

        <div class="ml-auto flex items-center gap-2">
            <button class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/10 text-slate-300 hover:bg-white/15">
                <i data-lucide="search" class="h-4 w-4"></i>
            </button>

            <a href="{{ route('login') }}"
               class="hidden rounded-xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-4 py-2 text-xs font-bold text-white sm:block">
                Admin Login
            </a>
        </div>
    </div>
</header>

<main class="pb-24 lg:pb-10">

    {{-- HERO --}}
    <section class="relative overflow-hidden">
        <div class="relative h-[68vh] min-h-[480px] sm:h-[76vh]">
            <img src="{{ $allAnime[0]['image'] }}"
                 class="absolute inset-0 h-full w-full object-cover"
                 alt="{{ $allAnime[0]['title'] }}">

            <div class="absolute inset-0 bg-gradient-to-t from-[#070713] via-[#070713]/75 to-black/30"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#070713]/85 via-transparent to-transparent"></div>

            <div class="absolute bottom-0 left-0 right-0 px-4 pb-8 sm:px-8 lg:px-12 lg:pb-16">
                <div class="max-w-2xl">
                    <div class="mb-3 flex flex-wrap items-center gap-2">
                        <span class="rounded-full bg-fuchsia-500 px-3 py-1 text-[10px] font-black text-white">
                            Trending
                        </span>
                        <span class="rounded-full bg-white/10 px-3 py-1 text-[10px] text-white">
                            {{ $allAnime[0]['year'] }}
                        </span>
                        <span class="rounded-full bg-black/50 px-3 py-1 text-[10px] font-bold text-yellow-400">
                            ★ {{ $allAnime[0]['rating'] }}/10
                        </span>
                    </div>

                    <h1 class="text-4xl font-black leading-tight sm:text-6xl">
                        {{ $allAnime[0]['title'] }}
                    </h1>

                    <p class="mt-3 text-sm text-slate-300 sm:text-base">
                        {{ $allAnime[0]['episodes'] }} Episodes • {{ $allAnime[0]['duration'] }} • {{ $allAnime[0]['studio'] }}
                    </p>

                    <p class="mt-4 line-clamp-3 text-sm leading-6 text-slate-300 sm:max-w-xl sm:text-base">
                        {{ $allAnime[0]['description'] }}
                    </p>

                    <div class="mt-6 flex gap-3">
                        <button onclick="openVideoPlayer(0)"
                                class="flex items-center gap-2 rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-6 py-3 text-sm font-black text-white shadow-lg shadow-fuchsia-500/30 active:scale-95">
                            <i data-lucide="play" class="h-4 w-4 fill-white"></i>
                            Play Now
                        </button>

                        <button onclick="openVideoPlayer(0)"
                                class="flex items-center gap-2 rounded-2xl border border-white/15 bg-white/10 px-5 py-3 text-sm font-bold text-white backdrop-blur active:scale-95">
                            <i data-lucide="info" class="h-4 w-4"></i>
                            Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- TRENDING --}}
    @include('components.video-row-inline', [
        'sectionTitle' => 'Trending Now',
        'sectionSub' => 'Most watched anime today',
        'sectionIcon' => 'trending-up',
        'items' => $trending,
        'offset' => 0,
    ])

    {{-- LATEST --}}
    @include('components.video-row-inline', [
        'sectionTitle' => 'Latest Episodes',
        'sectionSub' => 'Fresh serial episodes added recently',
        'sectionIcon' => 'clock',
        'items' => $latest,
        'offset' => count($trending),
    ])

    {{-- NEW UPLOADS --}}
    @include('components.video-row-inline', [
        'sectionTitle' => 'New Uploads',
        'sectionSub' => 'Newly uploaded anime videos',
        'sectionIcon' => 'upload-cloud',
        'items' => $newUploads,
        'offset' => count($trending) + count($latest),
    ])

</main>

{{-- INLINE COMPONENT TEMPLATE --}}
@once
    @push('dummy')
    @endpush
@endonce

{{-- Because this is one-file code, paste this row manually instead of include if component not exists --}}

<section class="hidden"></section>

{{-- MOBILE BOTTOM NAV --}}
<nav class="fixed bottom-0 left-0 right-0 z-50 border-t border-white/10 bg-[#080812]/95 backdrop-blur-xl lg:hidden">
    <div class="flex items-center justify-around px-2 pt-2" style="padding-bottom:max(8px, env(safe-area-inset-bottom));">
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

{{-- VIDEO PLAYER MODAL --}}
<div id="videoModal"
     class="fixed inset-0 z-[140] hidden items-end justify-center bg-black/80 sm:items-center"
     onclick="handleVideoBackdrop(event)">

    <div class="player-box w-full border border-white/10 bg-[#0a0a1a] shadow-2xl sm:mx-4 sm:max-w-5xl sm:rounded-3xl">

        <div class="flex items-start justify-between gap-4 px-4 py-4 sm:px-6">
            <div class="min-w-0">
                <h3 id="videoTitle" class="truncate text-lg font-black text-white"></h3>

                <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-slate-400">
                    <span id="videoCategory" class="rounded-full bg-fuchsia-500/20 px-2.5 py-1 font-bold text-fuchsia-300"></span>
                    <span id="videoYear"></span>
                    <span id="videoEpisodes"></span>
                    <span id="videoDuration"></span>
                </div>
            </div>

            <button onclick="closeVideoPlayer()"
                    class="rounded-2xl bg-white/10 p-2.5 text-white hover:bg-white/20">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <div class="mx-4 overflow-hidden rounded-2xl bg-black sm:mx-6">
            <div class="video-frame">
                <iframe id="videoFrame"
                        src=""
                        title="Video Player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen>
                </iframe>
            </div>
        </div>

        <div class="px-4 py-5 sm:px-6">
            <p id="videoDescription" class="text-sm leading-6 text-slate-400"></p>

            <div class="mt-4 grid grid-cols-3 gap-2 text-center">
                <div class="rounded-2xl bg-white/6 p-3">
                    <p class="text-[10px] text-slate-500">Studio</p>
                    <p id="videoStudio" class="truncate text-xs font-bold text-white"></p>
                </div>

                <div class="rounded-2xl bg-white/6 p-3">
                    <p class="text-[10px] text-slate-500">Director</p>
                    <p id="videoDirector" class="truncate text-xs font-bold text-white"></p>
                </div>

                <div class="rounded-2xl bg-white/6 p-3">
                    <p class="text-[10px] text-slate-500">Votes</p>
                    <p id="videoVotes" class="text-xs font-bold text-white"></p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ROWS --}}
<section class="px-4 py-5 sm:px-6 lg:px-8">
    <div class="mb-3 flex items-end justify-between">
        <div>
            <h2 class="flex items-center gap-2 text-lg font-black text-white">
                <i data-lucide="trending-up" class="h-5 w-5 text-fuchsia-400"></i>
                Trending Now
            </h2>
            <p class="mt-1 text-xs text-slate-500">Most watched anime today</p>
        </div>
        <button onclick="scrollRow('rowTrending', 320)" class="hidden rounded-xl bg-white/10 p-2 text-white lg:block">
            <i data-lucide="chevron-right" class="h-5 w-5"></i>
        </button>
    </div>

    <div id="rowTrending" class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
        @foreach($trending as $index => $item)
            @include('components.video-card-inline', ['item' => $item, 'realIndex' => $index])
        @endforeach
    </div>
</section>

<section class="px-4 py-5 sm:px-6 lg:px-8">
    <div class="mb-3 flex items-end justify-between">
        <div>
            <h2 class="flex items-center gap-2 text-lg font-black text-white">
                <i data-lucide="clock" class="h-5 w-5 text-yellow-400"></i>
                Latest Episodes
            </h2>
            <p class="mt-1 text-xs text-slate-500">Fresh serial episodes added recently</p>
        </div>
        <button onclick="scrollRow('rowLatest', 320)" class="hidden rounded-xl bg-white/10 p-2 text-white lg:block">
            <i data-lucide="chevron-right" class="h-5 w-5"></i>
        </button>
    </div>

    <div id="rowLatest" class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
        @foreach($latest as $index => $item)
            @include('components.video-card-inline', ['item' => $item, 'realIndex' => $index + count($trending)])
        @endforeach
    </div>
</section>

<section class="px-4 py-5 sm:px-6 lg:px-8">
    <div class="mb-3 flex items-end justify-between">
        <div>
            <h2 class="flex items-center gap-2 text-lg font-black text-white">
                <i data-lucide="upload-cloud" class="h-5 w-5 text-cyan-400"></i>
                New Uploads
            </h2>
            <p class="mt-1 text-xs text-slate-500">Newly uploaded anime videos</p>
        </div>
        <button onclick="scrollRow('rowUploads', 320)" class="hidden rounded-xl bg-white/10 p-2 text-white lg:block">
            <i data-lucide="chevron-right" class="h-5 w-5"></i>
        </button>
    </div>

    <div id="rowUploads" class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
        @foreach($newUploads as $index => $item)
            @include('components.video-card-inline', ['item' => $item, 'realIndex' => $index + count($trending) + count($latest)])
        @endforeach
    </div>
</section>

{{-- CARD COMPONENT FALLBACK --}}
@php
    // If you do not want separate components, replace @include('components.video-card-inline')
    // with this card block manually.
@endphp

<script>
    const animeData = @json($allAnime);

    function refreshIcons() {
        lucide.createIcons();
    }

    function scrollRow(id, amount) {
        const el = document.getElementById(id);
        if (el) el.scrollBy({ left: amount, behavior: 'smooth' });
    }

    function openVideoPlayer(index) {
        const item = animeData[index];
        if (!item) return;

        document.getElementById('videoTitle').innerText = item.title;
        document.getElementById('videoCategory').innerText = item.category;
        document.getElementById('videoYear').innerText = item.year;
        document.getElementById('videoEpisodes').innerText = item.episodes + ' eps';
        document.getElementById('videoDuration').innerText = '• ' + item.duration;
        document.getElementById('videoDescription').innerText = item.description;
        document.getElementById('videoStudio').innerText = item.studio;
        document.getElementById('videoDirector').innerText = item.director;
        document.getElementById('videoVotes').innerText = item.votes;

        document.getElementById('videoFrame').src =
            item.video_url + '?autoplay=1&rel=0&modestbranding=1';

        const modal = document.getElementById('videoModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.body.style.overflow = 'hidden';
        refreshIcons();
    }

    function closeVideoPlayer() {
        document.getElementById('videoFrame').src = '';

        const modal = document.getElementById('videoModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');

        document.body.style.overflow = '';
    }

    function handleVideoBackdrop(e) {
        if (e.target === document.getElementById('videoModal')) {
            closeVideoPlayer();
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeVideoPlayer();
    });

    refreshIcons();
</script>

</body>
</html>