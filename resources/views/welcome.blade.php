<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AnimeStreamer — Watch Anime Online</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Lucide Icons CDN --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body { background: #070713; }

        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.55s ease both; }

        @keyframes glowPulse {
            0%, 100% { box-shadow: 0 0 20px 4px rgba(217,70,239,.35); }
            50%       { box-shadow: 0 0 40px 10px rgba(217,70,239,.6); }
        }
        .glow-pulse { animation: glowPulse 3s ease-in-out infinite; }
    </style>
</head>

<body class="min-h-screen bg-[#070713] text-white">

@php
    /* ─── Hero / Featured anime ──────────────────────────────────────────── */
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
            'image'       => 'https://images.unsplash.com/photo-1604871000636-074fa5117945?q=80&w=1200&auto=format&fit=crop',
            'description' => 'A futuristic samurai fights through neon cities, cyber enemies, and broken memories in a relentless pursuit of truth.',
        ],
    ];

    /* ─── Trending anime row ─────────────────────────────────────────────── */
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
            'image'       => 'https://images.unsplash.com/photo-1505118380757-91f5f5632de0?q=80&w=800&auto=format&fit=crop',
            'description' => 'A young girl bonded with an ancient sea spirit embarks on a voyage to the edge of the world.',
        ],
    ];

    /* ─── New Releases row ───────────────────────────────────────────────── */
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
            'image'       => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?q=80&w=800&auto=format&fit=crop',
            'description' => 'Five strangers with extraordinary voices are chosen to perform a concert that could save the world.',
        ],
    ];

    /* ─── Top Rated row ──────────────────────────────────────────────────── */
    $topRated = array_merge(
        array_slice($anime, 2),
        array_slice($trending, 1, 4),
        array_slice($newReleases, 0, 3)
    );

    /* ─── Genre list ─────────────────────────────────────────────────────── */
    $genres = [
        'Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy',
        'Horror', 'Mecha', 'Musical', 'Mystery', 'Romance',
        'Sci-Fi', 'Slice of Life', 'Sports', 'Supernatural', 'Thriller',
    ];
@endphp

{{-- ═══════════════════════════════════════════════════════════════════════ --}}
{{-- NAVBAR  +  Mobile Menu  +  Login Modal                                 --}}
{{-- ═══════════════════════════════════════════════════════════════════════ --}}
@include('components.landing.navbar')

{{-- ═══════════════════════════════════════════════════════════════════════ --}}
{{-- HERO SECTION                                                            --}}
{{-- ═══════════════════════════════════════════════════════════════════════ --}}
@include('components.landing.hero-section', ['animeList' => $anime])

{{-- ═══════════════════════════════════════════════════════════════════════ --}}
{{-- ANIME ROWS                                                              --}}
{{-- ═══════════════════════════════════════════════════════════════════════ --}}

@include('components.landing.anime-row', [
    'title'     => 'Trending Now',
    'icon'      => 'trending-up',
    'iconColor' => 'text-fuchsia-400',
    'items'     => $trending,
])

@include('components.landing.anime-row', [
    'title'     => 'New Releases',
    'icon'      => 'sparkles',
    'iconColor' => 'text-yellow-400',
    'items'     => $newReleases,
])

@include('components.landing.anime-row', [
    'title'     => 'Top Rated',
    'icon'      => 'star',
    'iconColor' => 'text-orange-400',
    'items'     => $topRated,
])

{{-- ═══════════════════════════════════════════════════════════════════════ --}}
{{-- GENRE OFFCANVAS                                                         --}}
{{-- ═══════════════════════════════════════════════════════════════════════ --}}
@include('components.landing.genre-offcanvas', ['genres' => $genres])

{{-- ═══════════════════════════════════════════════════════════════════════ --}}
{{-- ANIME DETAIL MODAL                                                      --}}
{{-- ═══════════════════════════════════════════════════════════════════════ --}}
@include('components.landing.anime-detail-modal')

{{-- ═══════════════════════════════════════════════════════════════════════ --}}
{{-- PROFILE MODAL                                                           --}}
{{-- ═══════════════════════════════════════════════════════════════════════ --}}
@include('components.landing.profile-modal')

{{-- ═══════════════════════════════════════════════════════════════════════ --}}
{{-- CONFIRM MODAL  (My List)                                                --}}
{{-- ═══════════════════════════════════════════════════════════════════════ --}}
@include('components.landing.confirm-modal', [
    'title'       => 'Added to My List',
    'message'     => 'This anime has been saved to your watchlist. Sign in to sync your list across all devices.',
    'confirmText' => 'Got it',
])

{{-- ═══════════════════════════════════════════════════════════════════════ --}}
{{-- JAVASCRIPT                                                              --}}
{{-- ═══════════════════════════════════════════════════════════════════════ --}}
<script>
    /* ── Data ──────────────────────────────────────────────────────────── */
    const animeData = @json(array_merge($anime, $trending, $newReleases));

    /* ── Lucide helper ─────────────────────────────────────────────────── */
    function refreshIcons() { lucide.createIcons(); }

    /* ── Hero Slider ───────────────────────────────────────────────────── */
    let activeIndex = 0;
    const heroSlides   = () => document.querySelectorAll('.hero-slide');
    const heroContents = () => document.querySelectorAll('.hero-content');
    const heroPosters  = () => document.querySelectorAll('.hero-poster');
    const heroDots     = () => document.querySelectorAll('.hero-dot');

    function setSlide(index) {
        activeIndex = index;

        heroSlides().forEach(el => { el.classList.add('opacity-0'); el.classList.remove('opacity-100'); });
        heroContents().forEach(el => { el.classList.add('hidden'); el.classList.remove('block'); });
        heroPosters().forEach(el => { el.classList.add('hidden'); el.classList.remove('block'); });
        heroDots().forEach(el => {
            el.className = 'hero-dot h-2 w-2 rounded-full bg-white/40 transition-all hover:bg-white/70';
        });

        const slideEl = document.querySelector(`.hero-slide[data-index="${index}"]`);
        if (slideEl) { slideEl.classList.remove('opacity-0'); slideEl.classList.add('opacity-100'); }

        const contentEl = document.querySelector(`.hero-content[data-index="${index}"]`);
        if (contentEl) { contentEl.classList.remove('hidden'); contentEl.classList.add('block'); }

        const posterEl = document.querySelector(`.hero-poster[data-index="${index}"]`);
        if (posterEl) { posterEl.classList.remove('hidden'); posterEl.classList.add('block'); }

        const dotEl = document.querySelector(`.hero-dot[data-index="${index}"]`);
        if (dotEl) dotEl.className = 'hero-dot h-2 w-9 rounded-full bg-fuchsia-400 transition-all';

        refreshIcons();
    }

    function nextSlide() {
        const totalSlides = document.querySelectorAll('.hero-slide').length;
        setSlide((activeIndex + 1) % totalSlides);
    }

    function prevSlide() {
        const totalSlides = document.querySelectorAll('.hero-slide').length;
        setSlide(activeIndex === 0 ? totalSlides - 1 : activeIndex - 1);
    }

    setInterval(nextSlide, 5500);

    /* ── Profile Dropdown ──────────────────────────────────────────────── */
    function toggleProfileDropdown() {
        document.getElementById('profileDropdown').classList.toggle('hidden');
    }

    document.addEventListener('click', function (event) {
        const dropdown = document.getElementById('profileDropdown');
        if (!event.target.closest('[data-profile-button]') && dropdown && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });

    /* ── Mobile Menu ───────────────────────────────────────────────────── */
    function openMobileMenu()  { document.getElementById('mobileMenu').classList.remove('hidden'); }
    function closeMobileMenu() { document.getElementById('mobileMenu').classList.add('hidden'); }

    /* ── Login Modal ───────────────────────────────────────────────────── */
    function openLoginModal() {
        document.getElementById('loginModal').classList.remove('hidden');
        document.getElementById('loginModal').classList.add('flex');
    }
    function closeLoginModal() {
        document.getElementById('loginModal').classList.add('hidden');
        document.getElementById('loginModal').classList.remove('flex');
    }

    /* ── Profile Modal ─────────────────────────────────────────────────── */
    function openProfileModal() {
        document.getElementById('profileModal').classList.remove('hidden');
        document.getElementById('profileModal').classList.add('flex');
        const dropdown = document.getElementById('profileDropdown');
        if (dropdown) dropdown.classList.add('hidden');
    }
    function closeProfileModal() {
        document.getElementById('profileModal').classList.add('hidden');
        document.getElementById('profileModal').classList.remove('flex');
    }

    /* ── Genre Offcanvas ───────────────────────────────────────────────── */
    function openGenreOffcanvas() {
        document.getElementById('genreOffcanvas').classList.remove('hidden');
        const dropdown = document.getElementById('profileDropdown');
        if (dropdown) dropdown.classList.add('hidden');
        closeMobileMenu();
    }
    function closeGenreOffcanvas() {
        document.getElementById('genreOffcanvas').classList.add('hidden');
    }

    /* ── Anime Detail Modal ────────────────────────────────────────────── */
    function openAnimeDetail(index) {
        const item = animeData[index];
        if (!item) return;

        document.getElementById('detailImage').src           = item.image;
        document.getElementById('detailImage').alt           = item.title;
        document.getElementById('detailCategory').innerText  = item.category;
        document.getElementById('detailYear').innerText      = item.year;
        document.getElementById('detailRating').innerText    = '★ ' + item.rating + ' / 10';
        document.getElementById('detailTitle').innerText     = item.title;
        document.getElementById('detailVotes').innerText     = item.votes + ' votes';
        document.getElementById('detailEpisodes').innerText  = item.episodes + ' episodes';
        document.getElementById('detailDuration').innerText  = item.duration;
        document.getElementById('detailDescription').innerText = item.description;
        document.getElementById('detailStudio').innerText    = item.studio   || '—';
        document.getElementById('detailDirector').innerText  = item.director || '—';

        document.getElementById('animeDetailModal').classList.remove('hidden');
        document.getElementById('animeDetailModal').classList.add('flex');
        refreshIcons();
    }
    function closeAnimeDetail() {
        document.getElementById('animeDetailModal').classList.add('hidden');
        document.getElementById('animeDetailModal').classList.remove('flex');
    }

    /* ── Confirm Modal ─────────────────────────────────────────────────── */
    function openConfirmModal() {
        document.getElementById('confirmModal').classList.remove('hidden');
        document.getElementById('confirmModal').classList.add('flex');
    }
    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
        document.getElementById('confirmModal').classList.remove('flex');
    }

    /* ── Close modals on backdrop click ────────────────────────────────── */
    ['loginModal', 'animeDetailModal', 'profileModal', 'confirmModal'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('click', function (e) {
                if (e.target === el) {
                    el.classList.add('hidden');
                    el.classList.remove('flex');
                }
            });
        }
    });

    /* ── Init ──────────────────────────────────────────────────────────── */
    refreshIcons();
</script>

</body>
</html>
