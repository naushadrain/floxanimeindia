<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AnimeStreamer</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            background: #070713;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .line-clamp-1 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }

        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
    </style>
</head>

<body class="min-h-screen overflow-hidden bg-[#070713] text-white">

<main class="min-h-screen overflow-hidden bg-[#070713] text-white">

    {{-- Navbar --}}
    @include('components.landing.navbar')

    {{-- Hero Section --}}
    @if($apiError)
        <section class="flex min-h-[620px] items-center justify-center bg-[#070713] px-4 text-white">
            <div class="max-w-md rounded-3xl border border-red-500/20 bg-red-500/10 p-6 text-center">
                <p class="text-sm font-semibold text-red-300">
                    {{ $apiError }}
                </p>

                <a
                    href="{{ url('/') }}"
                    class="mt-5 inline-block rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-6 py-3 text-sm font-bold text-white"
                >
                    Retry
                </a>
            </div>
        </section>
    @elseif(count($animeList) > 0)
        @include('components.landing.hero-section', [
            'animeList' => $animeList
        ])
    @else
        <section class="flex min-h-[620px] items-center justify-center bg-[#070713] text-white">
            <p class="text-sm text-slate-400">No active sliders found.</p>
        </section>
    @endif

    {{-- Anime Rows --}}
    @if(count($animeList) > 0)

        @include('components.landing.anime-row', [
            'title' => 'Continue Watching',
            'icon' => 'clock',
            'iconColor' => 'text-sky-400',
            'items' => $animeList
        ])

        @include('components.landing.anime-row', [
            'title' => 'Top 10 This Week',
            'icon' => 'flame',
            'iconColor' => 'text-orange-400',
            'items' => $animeList
        ])

        @include('components.landing.anime-row', [
            'title' => 'Trending Now',
            'icon' => 'trending-up',
            'iconColor' => 'text-green-400',
            'items' => $animeList
        ])

        @include('components.landing.anime-row', [
            'title' => 'New Releases',
            'icon' => 'sparkles',
            'iconColor' => 'text-fuchsia-400',
            'items' => $animeList
        ])

    @endif

    {{-- Modals / Offcanvas --}}
    @include('components.landing.genre-offcanvas', [
        'genres' => $genres
    ])

    @include('components.landing.anime-detail-modal')

    @include('components.landing.profile-modal')

    @include('components.landing.confirm-modal', [
        'title' => 'My List',
        'message' => 'Your watchlist is empty. After adding anime, it will appear here.',
        'confirmText' => 'Okay'
    ])

</main>

<script>
    const animeData = @json($animeList);
    let activeIndex = 0;

    function refreshIcons() {
        if (window.lucide) {
            lucide.createIcons();
        }
    }

    function setSlide(index) {
        activeIndex = index;

        document.querySelectorAll('.hero-slide').forEach((slide) => {
            slide.classList.add('opacity-0');
            slide.classList.remove('opacity-100');
        });

        const activeSlide = document.querySelector(`.hero-slide[data-index="${index}"]`);
        if (activeSlide) {
            activeSlide.classList.remove('opacity-0');
            activeSlide.classList.add('opacity-100');
        }

        document.querySelectorAll('.hero-content').forEach((content) => {
            content.classList.add('hidden');
            content.classList.remove('block');
        });

        const activeContent = document.querySelector(`.hero-content[data-index="${index}"]`);
        if (activeContent) {
            activeContent.classList.remove('hidden');
            activeContent.classList.add('block');
        }

        document.querySelectorAll('.hero-poster').forEach((poster) => {
            poster.classList.add('hidden');
            poster.classList.remove('block');
        });

        const activePoster = document.querySelector(`.hero-poster[data-index="${index}"]`);
        if (activePoster) {
            activePoster.classList.remove('hidden');
            activePoster.classList.add('block');
        }

        document.querySelectorAll('.hero-dot').forEach((dot) => {
            dot.className = 'hero-dot h-2 w-2 rounded-full bg-white/40 transition-all hover:bg-white/70';
        });

        const activeDot = document.querySelector(`.hero-dot[data-index="${index}"]`);
        if (activeDot) {
            activeDot.className = 'hero-dot h-2 w-9 rounded-full bg-fuchsia-400 transition-all';
        }

        refreshIcons();
    }

    function nextSlide() {
        if (!animeData.length) return;
        const next = (activeIndex + 1) % animeData.length;
        setSlide(next);
    }

    function prevSlide() {
        if (!animeData.length) return;
        const prev = activeIndex === 0 ? animeData.length - 1 : activeIndex - 1;
        setSlide(prev);
    }

    if (animeData.length > 0) {
        setInterval(nextSlide, 5000);
    }

    function toggleProfileDropdown() {
        document.getElementById('profileDropdown')?.classList.toggle('hidden');
    }

    function openGenreOffcanvas() {
        document.getElementById('genreOffcanvas')?.classList.remove('hidden');
    }

    function closeGenreOffcanvas() {
        document.getElementById('genreOffcanvas')?.classList.add('hidden');
    }

    function openProfileModal() {
        document.getElementById('profileModal')?.classList.remove('hidden');
        document.getElementById('profileModal')?.classList.add('flex');
    }

    function closeProfileModal() {
        document.getElementById('profileModal')?.classList.add('hidden');
        document.getElementById('profileModal')?.classList.remove('flex');
    }

    function openConfirmModal() {
        document.getElementById('confirmModal')?.classList.remove('hidden');
        document.getElementById('confirmModal')?.classList.add('flex');
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal')?.classList.add('hidden');
        document.getElementById('confirmModal')?.classList.remove('flex');
    }

    function openLoginModal() {
        document.getElementById('loginModal')?.classList.remove('hidden');
        document.getElementById('loginModal')?.classList.add('flex');
    }

    function closeLoginModal() {
        document.getElementById('loginModal')?.classList.add('hidden');
        document.getElementById('loginModal')?.classList.remove('flex');
    }

    function openMobileMenu() {
        document.getElementById('mobileMenu')?.classList.remove('hidden');
    }

    function closeMobileMenu() {
        document.getElementById('mobileMenu')?.classList.add('hidden');
    }

    function openAnimeDetail(index) {
        const item = animeData[index];

        if (!item) return;

        document.getElementById('detailImage').src = item.image;
        document.getElementById('detailImage').alt = item.title;
        document.getElementById('detailTitle').innerText = item.title;
        document.getElementById('detailDescription').innerText = item.description;
        document.getElementById('detailCategory').innerText = item.category;
        document.getElementById('detailYear').innerText = item.year;
        document.getElementById('detailRating').innerText = item.rating + '/10';
        document.getElementById('detailVotes').innerText = item.votes + ' votes';
        document.getElementById('detailEpisodes').innerText = item.episodes + ' episodes';
        document.getElementById('detailDuration').innerText = item.duration;
        document.getElementById('detailStudio').innerText = item.studio || 'N/A';
        document.getElementById('detailDirector').innerText = item.director || 'N/A';

        document.getElementById('animeDetailModal')?.classList.remove('hidden');
        document.getElementById('animeDetailModal')?.classList.add('flex');
    }

    function closeAnimeDetail() {
        document.getElementById('animeDetailModal')?.classList.add('hidden');
        document.getElementById('animeDetailModal')?.classList.remove('flex');
    }

    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('profileDropdown');
        const profileButton = event.target.closest('[data-profile-button="true"]');

        if (!profileButton && dropdown && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });

    refreshIcons();
</script>

</body>
</html>