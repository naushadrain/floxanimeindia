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

        .video-frame {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%;
            background:#000;
        }

        .video-frame iframe {
            position:absolute;
            inset:0;
            width:100%;
            height:100%;
        }

        .fullscreen-video iframe {
            width:100%;
            height:100%;
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

    $allAnime = array_values(array_merge($trending, $latest, $uploads));
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
                        Featured
                    </span>

                    <h1 class="mt-3 text-4xl font-black leading-tight sm:text-6xl">
                        {{ $allAnime[0]['title'] }}
                    </h1>

                    <p class="mt-3 text-sm text-slate-300">
                        {{ $allAnime[0]['episodes'] }} Episodes • {{ $allAnime[0]['duration'] }} • {{ $allAnime[0]['studio'] }}
                    </p>

                    <p class="mt-4 line-clamp-3 text-sm leading-6 text-slate-300 sm:max-w-xl">
                        {{ $allAnime[0]['description'] }}
                    </p>

                    <div class="mt-6 flex gap-3">
                        <button onclick="openFullVideo(0)"
                                class="flex items-center gap-2 rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-6 py-3 text-sm font-black text-white shadow-lg shadow-fuchsia-500/30 active:scale-95">
                            <i data-lucide="play" class="h-4 w-4 fill-white"></i>
                            Play
                        </button>

                        <button onclick="openDetailModal(0)"
                                class="rounded-2xl border border-white/15 bg-white/10 px-5 py-3 text-sm font-bold text-white backdrop-blur active:scale-95">
                            Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ROW FUNCTION REPEATED --}}
    <section class="px-4 py-5 sm:px-6 lg:px-8">
        <div class="mb-3 flex items-center justify-between">
            <div>
                <h2 class="flex items-center gap-2 text-lg font-black">
                    <i data-lucide="trending-up" class="h-5 w-5 text-fuchsia-400"></i>
                    Trending Now
                </h2>
                <p class="text-xs text-slate-500">Most watched anime today</p>
            </div>
        </div>

        <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
            @foreach($trending as $index => $item)
                @php $realIndex = $index; @endphp
                @include('components.video-card-fixed', ['item' => $item, 'realIndex' => $realIndex])
            @endforeach
        </div>
    </section>

    <section class="px-4 py-5 sm:px-6 lg:px-8">
        <div class="mb-3 flex items-center justify-between">
            <div>
                <h2 class="flex items-center gap-2 text-lg font-black">
                    <i data-lucide="clock" class="h-5 w-5 text-yellow-400"></i>
                    Latest Episodes
                </h2>
                <p class="text-xs text-slate-500">Fresh serial episodes added recently</p>
            </div>
        </div>

        <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
            @foreach($latest as $index => $item)
                @php $realIndex = $index + count($trending); @endphp
                @include('components.video-card-fixed', ['item' => $item, 'realIndex' => $realIndex])
            @endforeach
        </div>
    </section>

    <section class="px-4 py-5 sm:px-6 lg:px-8">
        <div class="mb-3 flex items-center justify-between">
            <div>
                <h2 class="flex items-center gap-2 text-lg font-black">
                    <i data-lucide="upload-cloud" class="h-5 w-5 text-cyan-400"></i>
                    New Uploads
                </h2>
                <p class="text-xs text-slate-500">Newly uploaded anime videos</p>
            </div>
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

{{-- CENTER DETAILS MODAL --}}
<div id="detailModal"
     class="fixed inset-0 z-[130] hidden items-center justify-center bg-black/75 px-4 backdrop-blur-md"
     onclick="detailBackdrop(event)">

    <div class="w-full max-w-md overflow-hidden rounded-3xl border border-white/10 bg-[#111122] shadow-2xl sm:max-w-2xl">
        <div class="relative aspect-video bg-black">
            <img id="detailImage" src="" class="h-full w-full object-cover" alt="">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent"></div>

            <button onclick="closeDetailModal()"
                    class="absolute right-3 top-3 rounded-2xl bg-black/60 p-2 text-white backdrop-blur">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>

            <button id="detailPlayBtn"
                    class="absolute left-1/2 top-1/2 flex h-16 w-16 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-gradient-to-r from-violet-500 to-fuchsia-500 shadow-xl shadow-fuchsia-500/40">
                <i data-lucide="play" class="h-7 w-7 fill-white"></i>
            </button>
        </div>

        <div class="p-5">
            <div class="mb-2 flex flex-wrap items-center gap-2">
                <span id="detailCategory" class="rounded-full bg-fuchsia-500/20 px-3 py-1 text-[10px] font-bold text-fuchsia-300"></span>
                <span id="detailYear" class="text-xs text-slate-400"></span>
                <span id="detailRating" class="text-xs font-bold text-yellow-400"></span>
            </div>

            <h2 id="detailTitle" class="text-2xl font-black text-white"></h2>

            <p id="detailMeta" class="mt-2 text-sm text-slate-400"></p>

            <p id="detailDescription" class="mt-4 text-sm leading-6 text-slate-300"></p>

            <button id="detailPlayBtnBottom"
                    class="mt-5 flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 py-3 text-sm font-black text-white">
                <i data-lucide="play" class="h-4 w-4 fill-white"></i>
                Play Full Screen
            </button>
        </div>
    </div>
</div>

{{-- FULLSCREEN VIDEO MODAL --}}
<div id="fullVideoModal" class="fixed inset-0 z-[150] hidden bg-black">
    <button onclick="closeFullVideo()"
            class="absolute right-4 top-4 z-10 rounded-2xl bg-white/10 p-3 text-white backdrop-blur hover:bg-white/20">
        <i data-lucide="x" class="h-6 w-6"></i>
    </button>

    <div class="fullscreen-video h-screen w-screen">
        <iframe id="fullVideoFrame"
                src=""
                title="Video Player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen>
        </iframe>
    </div>
</div>

<script>
    const animeData = @json($allAnime);

    function refreshIcons() {
        lucide.createIcons();
    }

    function openDetailModal(index) {
        const item = animeData[index];
        if (!item) return;

        document.getElementById('detailImage').src = item.image;
        document.getElementById('detailCategory').innerText = item.category;
        document.getElementById('detailYear').innerText = item.year;
        document.getElementById('detailRating').innerText = '★ ' + item.rating;
        document.getElementById('detailTitle').innerText = item.title;
        document.getElementById('detailMeta').innerText =
            item.episodes + ' Episodes • ' + item.duration + ' • ' + item.studio;
        document.getElementById('detailDescription').innerText = item.description;

        document.getElementById('detailPlayBtn').onclick = function () {
            closeDetailModal();
            openFullVideo(index);
        };

        document.getElementById('detailPlayBtnBottom').onclick = function () {
            closeDetailModal();
            openFullVideo(index);
        };

        const modal = document.getElementById('detailModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.body.style.overflow = 'hidden';
        refreshIcons();
    }

    function closeDetailModal() {
        const modal = document.getElementById('detailModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    function detailBackdrop(e) {
        if (e.target === document.getElementById('detailModal')) {
            closeDetailModal();
        }
    }

    function openFullVideo(index) {
        const item = animeData[index];
        if (!item) return;

        document.getElementById('fullVideoFrame').src =
            item.video_url + '?autoplay=1&rel=0&modestbranding=1';

        const modal = document.getElementById('fullVideoModal');
        modal.classList.remove('hidden');

        document.body.style.overflow = 'hidden';
        refreshIcons();
    }

    function closeFullVideo() {
        document.getElementById('fullVideoFrame').src = '';

        const modal = document.getElementById('fullVideoModal');
        modal.classList.add('hidden');

        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeFullVideo();
            closeDetailModal();
        }
    });

    refreshIcons();
</script>

</body>
</html>