<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>floxanimeindia — Watch Anime Online</title>
    <link rel="icon" href={{asset('logo/logo.png')}}>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body { background: #070713; }

        /* hide scrollbar */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        /* hero fade-in */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.55s ease both; }

        /* glow pulse */
        @keyframes glowPulse {
            0%, 100% { box-shadow: 0 0 20px 4px rgba(217,70,239,.35); }
            50%       { box-shadow: 0 0 40px 10px rgba(217,70,239,.6); }
        }
        .glow-pulse { animation: glowPulse 3s ease-in-out infinite; }

        /* video modal backdrop blur */
        #videoModal { backdrop-filter: blur(12px); }

        /* video player iframe aspect-ratio fallback */
        .video-container {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%; /* 16:9 */
        }
        .video-container iframe {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
        }

        /* mobile: video fills screen */
        @media (max-width: 639px) {
            #videoModal .video-box {
                border-radius: 0;
                margin: 0;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-[#070713] text-white">

@php
    /* ── Free Creative-Commons demo video embeds (Blender Open Movies) ── */
    $demoVideos = [
        'https://www.youtube.com/embed/aqz-KE-bpKQ',   /* Big Buck Bunny      */
        'https://www.youtube.com/embed/eRsGyueVLvQ',   /* Sintel               */
        'https://www.youtube.com/embed/R6MlUcmOul8',   /* Tears of Steel       */
        'https://www.youtube.com/embed/TKF4ovKg3-c',   /* Elephants Dream      */
        'https://www.youtube.com/embed/Y-rmzh0PI3c',   /* Cosmos Laundromat    */
        'https://www.youtube.com/embed/WhWc3b3KhnY',   /* Caminandes 1         */
        'https://www.youtube.com/embed/TICHVBCGT2k',   /* Caminandes 2         */
        'https://www.youtube.com/embed/aqz-KE-bpKQ',
        'https://www.youtube.com/embed/eRsGyueVLvQ',
        'https://www.youtube.com/embed/R6MlUcmOul8',
        'https://www.youtube.com/embed/TKF4ovKg3-c',
        'https://www.youtube.com/embed/Y-rmzh0PI3c',
        'https://www.youtube.com/embed/WhWc3b3KhnY',
        'https://www.youtube.com/embed/TICHVBCGT2k',
        'https://www.youtube.com/embed/aqz-KE-bpKQ',
    ];

    /* ─── Hero / Featured anime ─────────────────────────────────────── */
    $anime = [
        [
            'id'          => 1,
            'title'       => 'Demon Slayer',
            'year'        => '2024',
            'category'    => 'Action',
            'rating'      => '9.1',
            'votes'       => '45K',
            'episodes'    => '26',
            'duration'    => '24 min',
            'studio'      => 'ufotable',
            'director'    => 'Haruo Sotozaki',
            'video_url'   => $demoVideos[0],
            'image'       => 'https://images.unsplash.com/photo-1578632767115-351597cf2477?q=80&w=1200&auto=format&fit=crop',
            'description' => 'A powerful anime story filled with emotional battles, beautiful animation, and unforgettable characters fighting against darkness.',
        ],
        [
            'id'          => 2,
            'title'       => 'Shadow Kingdom',
            'year'        => '2025',
            'category'    => 'Fantasy',
            'rating'      => '8.8',
            'votes'       => '32K',
            'episodes'    => '18',
            'duration'    => '25 min',
            'studio'      => 'Madhouse',
            'director'    => 'Hiroshi Kojima',
            'video_url'   => $demoVideos[1],
            'image'       => 'https://images.unsplash.com/photo-1618336753974-aae8e04506aa?q=80&w=1200&auto=format&fit=crop',
            'description' => 'A mysterious hero rises in a world of magic, shadows, and ancient secrets waiting to be uncovered.',
        ],
        [
            'id'          => 3,
            'title'       => 'Cyber Ronin',
            'year'        => '2026',
            'category'    => 'Sci-Fi',
            'rating'      => '9.4',
            'votes'       => '61K',
            'episodes'    => '12',
            'duration'    => '23 min',
            'studio'      => 'Production I.G',
            'director'    => 'Kenji Nakamura',
            'video_url'   => $demoVideos[2],
            'image'       => 'https://images.unsplash.com/photo-1604871000636-074fa5117945?q=80&w=1200&auto=format&fit=crop',
            'description' => 'A futuristic samurai fights through neon cities, cyber enemies, and broken memories in a relentless pursuit of truth.',
        ],
    ];

    /* ─── Trending row ───────────────────────────────────────────────── */
    $trending = [
        [
            'id'          => 4,
            'title'       => 'BloodMoon Rising',
            'year'        => '2025',
            'category'    => 'Horror',
            'rating'      => '8.5',
            'votes'       => '28K',
            'episodes'    => '13',
            'duration'    => '22 min',
            'studio'      => 'Wit Studio',
            'director'    => 'Tetsuro Araki',
            'video_url'   => $demoVideos[3],
            'image'       => 'https://images.unsplash.com/photo-1535930891776-0c2dfb7fda1a?q=80&w=800&auto=format&fit=crop',
            'description' => 'Ancient vampires awaken and a lone hunter must stop the world from falling into eternal night.',
        ],
        [
            'id'          => 5,
            'title'       => 'Storm Breaker',
            'year'        => '2025',
            'category'    => 'Action',
            'rating'      => '9.0',
            'votes'       => '54K',
            'episodes'    => '24',
            'duration'    => '25 min',
            'studio'      => 'MAPPA',
            'director'    => 'Ryuichi Takahashi',
            'video_url'   => $demoVideos[4],
            'image'       => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?q=80&w=800&auto=format&fit=crop',
            'description' => 'A prodigy warrior challenges the strongest fighters across three kingdoms to protect his homeland.',
        ],
        [
            'id'          => 6,
            'title'       => 'Galaxy Drift',
            'year'        => '2024',
            'category'    => 'Sci-Fi',
            'rating'      => '8.7',
            'votes'       => '37K',
            'episodes'    => '22',
            'duration'    => '24 min',
            'studio'      => 'Bones',
            'director'    => 'Seiji Mizushima',
            'video_url'   => $demoVideos[5],
            'image'       => 'https://images.unsplash.com/photo-1462331940025-496dfbfc7564?q=80&w=800&auto=format&fit=crop',
            'description' => 'Stranded in deep space, a crew of misfits must navigate alien territories to return home.',
        ],
        [
            'id'          => 7,
            'title'       => 'Eternal Flame',
            'year'        => '2026',
            'category'    => 'Fantasy',
            'rating'      => '8.9',
            'votes'       => '41K',
            'episodes'    => '20',
            'duration'    => '23 min',
            'studio'      => 'A-1 Pictures',
            'director'    => 'Yoshiyuki Asai',
            'video_url'   => $demoVideos[6],
            'image'       => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=800&auto=format&fit=crop',
            'description' => 'A fire mage discovers her powers are the key to breaking a century-old curse on her kingdom.',
        ],
        [
            'id'          => 8,
            'title'       => 'Iron Phantom',
            'year'        => '2025',
            'category'    => 'Mecha',
            'rating'      => '8.3',
            'votes'       => '22K',
            'episodes'    => '16',
            'duration'    => '26 min',
            'studio'      => 'Sunrise',
            'director'    => 'Goro Taniguchi',
            'video_url'   => $demoVideos[7],
            'image'       => 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=800&auto=format&fit=crop',
            'description' => 'Piloting a forbidden mech, a young soldier wages war against an empire that controls humanity.',
        ],
        [
            'id'          => 9,
            'title'       => 'Ocean Spirit',
            'year'        => '2024',
            'category'    => 'Adventure',
            'rating'      => '8.6',
            'votes'       => '19K',
            'episodes'    => '14',
            'duration'    => '22 min',
            'studio'      => 'Studio Ghibli',
            'director'    => 'Hayao Miyazaki',
            'video_url'   => $demoVideos[8],
            'image'       => 'https://images.unsplash.com/photo-1505118380757-91f5f5632de0?q=80&w=800&auto=format&fit=crop',
            'description' => 'A young girl bonded with an ancient sea spirit embarks on a voyage to the edge of the world.',
        ],
    ];

    /* ─── New Releases row ───────────────────────────────────────────── */
    $newReleases = [
        [
            'id'          => 10,
            'title'       => 'Void Walker',
            'year'        => '2026',
            'category'    => 'Mystery',
            'rating'      => '9.2',
            'votes'       => '12K',
            'episodes'    => '10',
            'duration'    => '24 min',
            'studio'      => 'Trigger',
            'director'    => 'Hiroyuki Imaishi',
            'video_url'   => $demoVideos[9],
            'image'       => 'https://images.unsplash.com/photo-1419242902214-272b3f66ee7a?q=80&w=800&auto=format&fit=crop',
            'description' => 'A detective who can enter the space between dimensions hunts a killer who leaves no trace.',
        ],
        [
            'id'          => 11,
            'title'       => 'Neon Butterfly',
            'year'        => '2026',
            'category'    => 'Romance',
            'rating'      => '8.4',
            'votes'       => '8K',
            'episodes'    => '12',
            'duration'    => '23 min',
            'studio'      => 'Kyoto Animation',
            'director'    => 'Naoko Yamada',
            'video_url'   => $demoVideos[10],
            'image'       => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?q=80&w=800&auto=format&fit=crop',
            'description' => 'Two rivals at a prestigious animation school find unexpected love through their shared passion.',
        ],
        [
            'id'          => 12,
            'title'       => 'Dragon Reborn',
            'year'        => '2026',
            'category'    => 'Action',
            'rating'      => '9.5',
            'votes'       => '21K',
            'episodes'    => '24',
            'duration'    => '25 min',
            'studio'      => 'ufotable',
            'director'    => 'Haruo Sotozaki',
            'video_url'   => $demoVideos[11],
            'image'       => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?q=80&w=800&auto=format&fit=crop',
            'description' => 'The last dragon rider awakens after centuries to reclaim a world stolen by shadow demons.',
        ],
        [
            'id'          => 13,
            'title'       => 'Crystal Garden',
            'year'        => '2026',
            'category'    => 'Fantasy',
            'rating'      => '8.1',
            'votes'       => '6K',
            'episodes'    => '13',
            'duration'    => '22 min',
            'studio'      => 'P.A.Works',
            'director'    => 'Shinya Kawatsura',
            'video_url'   => $demoVideos[12],
            'image'       => 'https://images.unsplash.com/photo-1520637102912-2df6bb2aec6d?q=80&w=800&auto=format&fit=crop',
            'description' => 'A botanist discovers a hidden garden where rare crystals grant visions of the future.',
        ],
        [
            'id'          => 14,
            'title'       => 'Silent Blade',
            'year'        => '2026',
            'category'    => 'Thriller',
            'rating'      => '8.8',
            'votes'       => '15K',
            'episodes'    => '11',
            'duration'    => '24 min',
            'studio'      => 'Production I.G',
            'director'    => 'Sayo Yamamoto',
            'video_url'   => $demoVideos[13],
            'image'       => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=800&auto=format&fit=crop',
            'description' => 'A retired assassin is pulled back into the shadows when her daughter is taken hostage.',
        ],
        [
            'id'          => 15,
            'title'       => 'Star Chorus',
            'year'        => '2026',
            'category'    => 'Musical',
            'rating'      => '7.9',
            'votes'       => '4K',
            'episodes'    => '12',
            'duration'    => '23 min',
            'studio'      => 'Doga Kobo',
            'director'    => 'Yoshiaki Iwasaki',
            'video_url'   => $demoVideos[14],
            'image'       => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?q=80&w=800&auto=format&fit=crop',
            'description' => 'Five strangers with extraordinary voices are chosen to perform a concert that could save the world.',
        ],
    ];

    /* ─── Genre list ─────────────────────────────────────────────────── */
    $genres = [
        'Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy',
        'Horror', 'Mecha', 'Musical', 'Mystery', 'Romance',
        'Sci-Fi', 'Slice of Life', 'Sports', 'Supernatural', 'Thriller',
    ];

    /* flat array for JS (hero items first so index 0-2 map correctly) */
    $allAnime = array_values(array_merge($anime, $trending, $newReleases));
@endphp

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- NAVBAR  +  Mobile Bottom Tab Bar  +  Login Modal                   --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}
@include('components.landing.navbar')

{{-- ── Main scrollable content (pb-20 reserves space for bottom tab) ── --}}
<main class="pb-20 lg:pb-0">

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- HERO SECTION                                                        --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}
@include('components.landing.hero-section', ['animeList' => $anime])

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- TRENDING  —  horizontal scroll, index offset 3                     --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}
@include('components.landing.anime-row', [
    'title'       => 'Trending Now',
    'icon'        => 'trending-up',
    'iconColor'   => 'text-fuchsia-400',
    'items'       => $trending,
    'indexOffset' => 3,
])

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- NEW RELEASES  —  index offset 9 (3 hero + 6 trending)              --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}
@include('components.landing.anime-row', [
    'title'       => 'New Releases',
    'icon'        => 'sparkles',
    'iconColor'   => 'text-yellow-400',
    'items'       => $newReleases,
    'indexOffset' => 9,
])

</main>{{-- end main --}}

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- GENRE OFFCANVAS                                                     --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}
@include('components.landing.genre-offcanvas', ['genres' => $genres])

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- ANIME DETAIL MODAL                                                  --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}
@include('components.landing.anime-detail-modal')

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- PROFILE MODAL                                                       --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}
@include('components.landing.profile-modal')

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- CONFIRM MODAL                                                       --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}
@include('components.landing.confirm-modal', [
    'title'       => 'Added to My List',
    'message'     => 'This anime has been saved to your watchlist. Sign in to sync your list across all devices.',
    'confirmText' => 'Got it',
])

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- VIDEO PLAYER MODAL                                                  --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}
<div
    id="videoModal"
    class="fixed inset-0 z-[140] hidden items-end justify-center bg-black/80 sm:items-center"
    onclick="handleVideoBackdrop(event)"
>
    {{-- Sheet on mobile, centered box on desktop --}}
    <div class="video-box w-full rounded-t-3xl border border-white/10 bg-[#0a0a1a] shadow-2xl sm:mx-4 sm:max-w-4xl sm:rounded-3xl">

        {{-- Top bar --}}
        <div class="flex items-start justify-between gap-4 px-4 py-4 sm:px-6 sm:py-5">
            <div class="min-w-0">
                <h3 id="videoTitle" class="truncate text-base font-black text-white sm:text-xl"></h3>
                <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-slate-400">
                    <span id="videoCategory" class="rounded-full bg-fuchsia-500/20 px-2.5 py-0.5 text-[11px] font-bold text-fuchsia-400"></span>
                    <span id="videoYear"></span>
                    <span id="videoEpisodes"></span>
                    <span id="videoDuration"></span>
                </div>
            </div>
            <button
                onclick="closeVideoPlayer()"
                class="shrink-0 rounded-2xl bg-white/10 p-2.5 text-white hover:bg-white/20 transition"
                aria-label="Close player"
            >
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        {{-- 16:9 video frame --}}
        <div class="video-container mx-4 mb-4 overflow-hidden rounded-2xl bg-black sm:mx-6 sm:mb-6">
            <iframe
                id="videoFrame"
                src=""
                title="Video Player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen
            ></iframe>
        </div>

        {{-- Description + actions --}}
        <div class="border-t border-white/8 px-4 py-4 sm:px-6 sm:py-5">
            <p id="videoDescription" class="line-clamp-2 text-sm leading-6 text-slate-400 sm:line-clamp-none"></p>

            <div class="mt-4 flex flex-wrap gap-3">
                <button
                    onclick="openConfirmModal()"
                    class="flex items-center gap-2 rounded-2xl border border-white/10 bg-white/6 px-5 py-2.5 text-sm font-semibold text-white hover:bg-white/10 transition"
                >
                    <i data-lucide="bookmark" class="h-4 w-4"></i>
                    Add to List
                </button>
                <button
                    id="videoInfoBtn"
                    class="flex items-center gap-2 rounded-2xl border border-white/10 bg-white/6 px-5 py-2.5 text-sm font-semibold text-white hover:bg-white/10 transition"
                >
                    <i data-lucide="info" class="h-4 w-4"></i>
                    More Info
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- JAVASCRIPT                                                          --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}
<script>
    /* ─── All anime data ───────────────────────────────────────────── */
    const animeData = @json($allAnime);

    /* ─── Lucide ───────────────────────────────────────────────────── */
    function refreshIcons() { lucide.createIcons(); }

    /* ─── Hero Slider (manual only — no auto-slide) ───────────────── */
    let activeIndex = 0;

    function setSlide(index) {
        activeIndex = index;

        document.querySelectorAll('.hero-slide').forEach(el => {
            el.classList.add('opacity-0'); el.classList.remove('opacity-100');
        });
        document.querySelectorAll('.hero-content').forEach(el => {
            el.classList.add('hidden'); el.classList.remove('block');
        });
        /* inactive dot style */
        document.querySelectorAll('.hero-dot').forEach(el => {
            el.className = 'hero-dot h-1 w-1 rounded-full bg-white/30 transition-all hover:bg-white/60 sm:h-1.5 sm:w-1.5';
        });

        const s = document.querySelector(`.hero-slide[data-index="${index}"]`);
        if (s) { s.classList.remove('opacity-0'); s.classList.add('opacity-100'); }

        const c = document.querySelector(`.hero-content[data-index="${index}"]`);
        if (c) { c.classList.remove('hidden'); c.classList.add('block'); }

        /* active dot style — pill shape */
        const d = document.querySelector(`.hero-dot[data-index="${index}"]`);
        if (d) d.className = 'hero-dot h-1 w-4 rounded-full bg-fuchsia-400 transition-all sm:h-1.5 sm:w-5';

        refreshIcons();
    }

    function nextSlide() {
        const total = document.querySelectorAll('.hero-slide').length;
        setSlide((activeIndex + 1) % total);
    }
    function prevSlide() {
        const total = document.querySelectorAll('.hero-slide').length;
        setSlide(activeIndex === 0 ? total - 1 : activeIndex - 1);
    }

    /* ── Touch / swipe support for hero on mobile ──────────────────── */
    (function () {
        let startX = 0;
        const hero = document.getElementById('heroSliderContainer');
        if (!hero) return;
        hero.addEventListener('touchstart', e => {
            startX = e.changedTouches[0].clientX;
        }, { passive: true });
        hero.addEventListener('touchend', e => {
            const diff = startX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 45) diff > 0 ? nextSlide() : prevSlide();
        }, { passive: true });
    })();

    /* ─── Profile Dropdown ─────────────────────────────────────────── */
    function toggleProfileDropdown() {
        document.getElementById('profileDropdown').classList.toggle('hidden');
    }
    document.addEventListener('click', function (e) {
        const d = document.getElementById('profileDropdown');
        if (!e.target.closest('[data-profile-button]') && d && !d.contains(e.target)) {
            d.classList.add('hidden');
        }
    });

    /* ─── Mobile Menu ──────────────────────────────────────────────── */
    function openMobileMenu()  { document.getElementById('mobileMenu').classList.remove('hidden'); }
    function closeMobileMenu() { document.getElementById('mobileMenu').classList.add('hidden'); }

    /* ─── Login Modal ──────────────────────────────────────────────── */
    function openLoginModal() {
        document.getElementById('loginModal').classList.remove('hidden');
        document.getElementById('loginModal').classList.add('flex');
    }
    function closeLoginModal() {
        document.getElementById('loginModal').classList.add('hidden');
        document.getElementById('loginModal').classList.remove('flex');
    }

    /* ─── Profile Modal ────────────────────────────────────────────── */
    function openProfileModal() {
        document.getElementById('profileModal').classList.remove('hidden');
        document.getElementById('profileModal').classList.add('flex');
        const d = document.getElementById('profileDropdown');
        if (d) d.classList.add('hidden');
    }
    function closeProfileModal() {
        document.getElementById('profileModal').classList.add('hidden');
        document.getElementById('profileModal').classList.remove('flex');
    }

    /* ─── Genre Offcanvas ──────────────────────────────────────────── */
    function openGenreOffcanvas() {
        document.getElementById('genreOffcanvas').classList.remove('hidden');
        const d = document.getElementById('profileDropdown');
        if (d) d.classList.add('hidden');
        closeMobileMenu();
    }
    function closeGenreOffcanvas() {
        document.getElementById('genreOffcanvas').classList.add('hidden');
    }

    /* ─── Anime Detail Modal ───────────────────────────────────────── */
    function openAnimeDetail(index) {
        const item = animeData[index];
        if (!item) return;

        document.getElementById('detailImage').src              = item.image;
        document.getElementById('detailImage').alt              = item.title;
        document.getElementById('detailCategory').innerText     = item.category;
        document.getElementById('detailYear').innerText         = item.year;
        document.getElementById('detailRating').innerText       = '★ ' + item.rating + ' / 10';
        document.getElementById('detailTitle').innerText        = item.title;
        document.getElementById('detailVotes').innerText        = item.votes + ' votes';
        document.getElementById('detailEpisodes').innerText     = item.episodes + ' episodes';
        document.getElementById('detailDuration').innerText     = item.duration;
        document.getElementById('detailDescription').innerText  = item.description;
        document.getElementById('detailStudio').innerText       = item.studio   || '—';
        document.getElementById('detailDirector').innerText     = item.director || '—';

        document.getElementById('animeDetailModal').classList.remove('hidden');
        document.getElementById('animeDetailModal').classList.add('flex');
        refreshIcons();
    }
    function closeAnimeDetail() {
        document.getElementById('animeDetailModal').classList.add('hidden');
        document.getElementById('animeDetailModal').classList.remove('flex');
    }

    /* ─── Confirm Modal ────────────────────────────────────────────── */
    function openConfirmModal() {
        document.getElementById('confirmModal').classList.remove('hidden');
        document.getElementById('confirmModal').classList.add('flex');
    }
    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
        document.getElementById('confirmModal').classList.remove('flex');
    }

    /* ─── VIDEO PLAYER ─────────────────────────────────────────────── */
    let currentVideoIndex = null;

    function openVideoPlayer(index) {
        const item = animeData[index];
        if (!item) return;

        currentVideoIndex = index;

        /* fill modal info */
        document.getElementById('videoTitle').innerText       = item.title;
        document.getElementById('videoCategory').innerText    = item.category;
        document.getElementById('videoYear').innerText        = item.year;
        document.getElementById('videoEpisodes').innerText    = item.episodes + ' eps';
        document.getElementById('videoDuration').innerText    = '· ' + item.duration;
        document.getElementById('videoDescription').innerText = item.description;

        /* More Info button wires to detail modal */
        document.getElementById('videoInfoBtn').onclick = function () {
            closeVideoPlayer();
            setTimeout(() => openAnimeDetail(index), 200);
        };

        /* load iframe — autoplay + no related videos */
        const base = item.video_url || '';
        document.getElementById('videoFrame').src = base + '?autoplay=1&rel=0&modestbranding=1&color=white';

        /* show modal */
        const modal = document.getElementById('videoModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        /* prevent body scroll */
        document.body.style.overflow = 'hidden';

        refreshIcons();
    }

    function closeVideoPlayer() {
        /* stop video by clearing src */
        document.getElementById('videoFrame').src = '';

        const modal = document.getElementById('videoModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');

        document.body.style.overflow = '';
        currentVideoIndex = null;
    }

    function handleVideoBackdrop(e) {
        /* close when clicking outside the video-box */
        if (e.target === document.getElementById('videoModal')) {
            closeVideoPlayer();
        }
    }

    /* ─── Escape key closes any open modal ─────────────────────────── */
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        if (!document.getElementById('videoModal').classList.contains('hidden')) {
            closeVideoPlayer(); return;
        }
        ['loginModal','animeDetailModal','profileModal','confirmModal'].forEach(id => {
            const el = document.getElementById(id);
            if (el && !el.classList.contains('hidden')) {
                el.classList.add('hidden'); el.classList.remove('flex');
            }
        });
    });

    /* ─── Backdrop click for non-video modals ───────────────────────── */
    ['loginModal','animeDetailModal','profileModal','confirmModal'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('click', function (e) {
                if (e.target === el) { el.classList.add('hidden'); el.classList.remove('flex'); }
            });
        }
    });

    /* ─── Init ──────────────────────────────────────────────────────── */
    refreshIcons();
</script>

</body>
</html>
