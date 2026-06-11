<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AnimeStreamer</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Lucide Icons CDN --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            background: #070713;
        }
    </style>
</head>

<body class="min-h-screen bg-[#070713] text-white">

@php
    $anime = [
        [
            'id' => 1,
            'title' => 'Demon Slayer',
            'year' => '2024',
            'category' => 'Action',
            'rating' => '9.1',
            'votes' => '45K',
            'episodes' => '26',
            'duration' => '24 min',
            'image' => 'https://images.unsplash.com/photo-1578632767115-351597cf2477?q=80&w=1200&auto=format&fit=crop',
            'description' => 'A powerful anime story filled with emotional battles, beautiful animation, and unforgettable characters fighting against darkness.',
        ],
        [
            'id' => 2,
            'title' => 'Shadow Kingdom',
            'year' => '2025',
            'category' => 'Fantasy',
            'rating' => '8.8',
            'votes' => '32K',
            'episodes' => '18',
            'duration' => '25 min',
            'image' => 'https://images.unsplash.com/photo-1618336753974-aae8e04506aa?q=80&w=1200&auto=format&fit=crop',
            'description' => 'A mysterious hero rises in a world of magic, shadows, and ancient secrets.',
        ],
        [
            'id' => 3,
            'title' => 'Cyber Ronin',
            'year' => '2026',
            'category' => 'Sci-Fi',
            'rating' => '9.4',
            'votes' => '61K',
            'episodes' => '12',
            'duration' => '23 min',
            'image' => 'https://images.unsplash.com/photo-1604871000636-074fa5117945?q=80&w=1200&auto=format&fit=crop',
            'description' => 'A futuristic samurai fights through neon cities, cyber enemies, and broken memories.',
        ],
    ];
@endphp

{{-- Navbar --}}
<header class="sticky top-0 z-50 border-b border-white/10 bg-[#080812]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-7xl items-center gap-4 px-4 py-4 sm:px-6 lg:px-8">

        {{-- Logo --}}
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-500 to-fuchsia-500 shadow-lg shadow-fuchsia-500/25">
                <i data-lucide="film" class="h-6 w-6 text-white"></i>
            </div>

            <div>
                <h1 class="text-xl font-black leading-none text-white">
                    AnimeStreamer
                </h1>
                <p class="mt-1 hidden text-xs text-slate-400 sm:block">
                    Watch animated videos online
                </p>
            </div>
        </div>

        {{-- Desktop Nav --}}
        <nav class="hidden items-center gap-6 text-sm text-slate-300 lg:flex">
            <button class="transition hover:text-white">Browse</button>
            <button class="transition hover:text-white">Trending</button>
            <button class="transition hover:text-white">New Releases</button>
            <button onclick="openGenresModal()" class="transition hover:text-white">
                Genres
            </button>
        </nav>

        {{-- Search Desktop --}}
        <div class="mx-auto hidden w-full max-w-md items-center gap-2 rounded-2xl border border-white/10 bg-white/[0.06] px-3 py-2 md:flex">
            <i data-lucide="search" class="h-5 w-5 text-slate-400"></i>
            <input
                type="text"
                placeholder="Search anime..."
                class="h-9 w-full border-0 bg-transparent text-white shadow-none outline-none placeholder:text-slate-500"
            />
        </div>

        {{-- Right Buttons --}}
        <div class="ml-auto flex items-center gap-2">

            <button
                onclick="openMyListModal()"
                class="hidden h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white hover:bg-white/15 sm:inline-flex"
            >
                <i data-lucide="heart" class="h-5 w-5"></i>
            </button>

            <button class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white hover:bg-white/15">
                <i data-lucide="bell" class="h-5 w-5"></i>
            </button>

            {{-- Profile Dropdown --}}
            <div class="relative hidden sm:block">
                <button
                    onclick="toggleProfileDropdown()"
                    class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white hover:bg-white/15"
                >
                    <i data-lucide="user-circle" class="h-6 w-6"></i>
                </button>

                <div
                    id="profileDropdown"
                    class="absolute right-0 mt-3 hidden w-48 overflow-hidden rounded-xl border border-white/10 bg-[#111122] shadow-xl"
                >
                    <button onclick="openProfileModal()" class="block w-full px-4 py-3 text-left text-sm text-slate-200 hover:bg-white/10">
                        Profile
                    </button>

                    <button class="block w-full px-4 py-3 text-left text-sm text-slate-200 hover:bg-white/10">
                        Settings
                    </button>

                    <div class="border-t border-white/10"></div>

                    <button onclick="openLoginModal()" class="block w-full px-4 py-3 text-left text-sm font-semibold text-fuchsia-400 hover:bg-fuchsia-500/10">
                        LogIn
                    </button>
                </div>
            </div>

            {{-- Mobile Menu Button --}}
            <button
                onclick="openMobileMenu()"
                class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white hover:bg-white/15 lg:hidden"
            >
                <i data-lucide="menu" class="h-5 w-5"></i>
            </button>
        </div>
    </div>

    {{-- Search Mobile --}}
    <div class="px-4 pb-4 md:hidden">
        <div class="flex items-center gap-2 rounded-2xl border border-white/10 bg-white/[0.06] px-3 py-2">
            <i data-lucide="search" class="h-5 w-5 text-slate-400"></i>
            <input
                type="text"
                placeholder="Search anime..."
                class="h-9 w-full border-0 bg-transparent text-white shadow-none outline-none placeholder:text-slate-500"
            />
        </div>
    </div>
</header>

{{-- Mobile Sidebar --}}
<div id="mobileMenu" class="fixed inset-0 z-[100] hidden">
    <div onclick="closeMobileMenu()" class="absolute inset-0 bg-black/60"></div>

    <div class="absolute right-0 top-0 h-full w-80 border-l border-white/10 bg-[#090918] p-6 text-white shadow-2xl">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold">Menu</h2>
            <button onclick="closeMobileMenu()" class="rounded-xl bg-white/10 p-2 hover:bg-white/15">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <div class="mt-8 space-y-3">
            <button class="w-full rounded-xl px-4 py-3 text-left text-white hover:bg-white/10">
                Browse
            </button>

            <button class="w-full rounded-xl px-4 py-3 text-left text-white hover:bg-white/10">
                Trending
            </button>

            <button class="w-full rounded-xl px-4 py-3 text-left text-white hover:bg-white/10">
                New Releases
            </button>

            <button onclick="openGenresModal()" class="w-full rounded-xl px-4 py-3 text-left text-white hover:bg-white/10">
                Genres
            </button>

            <button onclick="openProfileModal()" class="w-full rounded-xl px-4 py-3 text-left text-white hover:bg-white/10">
                Profile
            </button>

            <button onclick="openLoginModal()" class="w-full rounded-2xl bg-fuchsia-500 px-4 py-3 text-left font-bold text-white hover:bg-fuchsia-600">
                LogIn
            </button>
        </div>
    </div>
</div>

{{-- Hero Section --}}
<section class="w-full">
    <div class="relative min-h-[620px] w-full overflow-hidden bg-[#070713]">

        @foreach($anime as $index => $item)
            <div
                class="hero-slide absolute inset-0 bg-cover bg-center transition-all duration-700 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                style="background-image: url('{{ $item['image'] }}')"
                data-index="{{ $index }}"
            ></div>
        @endforeach

        <div class="absolute inset-0 bg-gradient-to-r from-[#070713] via-[#070713]/85 to-[#070713]/20"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#070713] via-transparent to-[#070713]/30"></div>

        <div class="relative z-10 mx-auto grid min-h-[620px] max-w-7xl items-center gap-10 px-4 py-10 sm:px-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">

            <div class="max-w-3xl">

                @foreach($anime as $index => $item)
                    <div class="hero-content {{ $index === 0 ? 'block' : 'hidden' }}" data-index="{{ $index }}">

                        <div class="mb-5 flex flex-wrap items-center gap-3">
                            <span class="rounded-full bg-fuchsia-500 px-4 py-1.5 text-sm font-semibold text-white">
                                Featured Anime
                            </span>

                            <span class="rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-sm text-white backdrop-blur">
                                {{ $item['year'] }}
                            </span>

                            <span class="rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-sm text-white backdrop-blur">
                                {{ $item['category'] }}
                            </span>
                        </div>

                        <h2 class="text-4xl font-black leading-tight tracking-tight text-white sm:text-6xl lg:text-7xl">
                            {{ $item['title'] }}
                        </h2>

                        <div class="mt-5 flex flex-wrap items-center gap-4 text-sm text-slate-300">
                            <span class="flex items-center gap-2">
                                <i data-lucide="star" class="h-5 w-5 fill-yellow-400 text-yellow-400"></i>
                                {{ $item['rating'] }}/10
                            </span>

                            <span>{{ $item['votes'] }} votes</span>
                            <span>{{ $item['episodes'] }} episodes</span>
                            <span>{{ $item['duration'] }}</span>
                        </div>

                        <p class="mt-6 max-w-2xl text-base leading-7 text-slate-300 sm:text-lg">
                            {{ $item['description'] }}
                        </p>

                        <div class="mt-8 flex flex-wrap gap-4">
                            <button class="flex h-12 items-center rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-7 text-base font-bold text-white shadow-lg shadow-fuchsia-500/25 hover:opacity-90">
                                <i data-lucide="play" class="mr-2 h-5 w-5 fill-white"></i>
                                Play Now
                            </button>

                            <button class="flex h-12 items-center rounded-2xl border border-white/15 bg-white/10 px-7 text-base font-bold text-white backdrop-blur hover:bg-white/15">
                                <i data-lucide="bookmark" class="mr-2 h-5 w-5"></i>
                                My List
                            </button>

                            <button onclick="openInfoModal({{ $index }})" class="flex h-12 items-center rounded-2xl border border-white/15 bg-white/10 px-7 text-base font-bold text-white backdrop-blur hover:bg-white/15">
                                <i data-lucide="info" class="mr-2 h-5 w-5"></i>
                                Info
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Right Poster --}}
            <div class="hidden justify-end lg:flex">
                @foreach($anime as $index => $item)
                    <div class="hero-poster relative {{ $index === 0 ? 'block' : 'hidden' }}" data-index="{{ $index }}">
                        <div class="absolute -inset-4 rounded-[2.5rem] bg-fuchsia-500/20 blur-2xl"></div>
                        <img
                            src="{{ $item['image'] }}"
                            alt="{{ $item['title'] }}"
                            class="relative h-[470px] w-[330px] rounded-[2rem] object-cover shadow-2xl transition-all duration-700"
                        />
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Previous --}}
        <button
            type="button"
            onclick="prevSlide()"
            class="absolute left-4 top-1/2 z-20 hidden h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full border border-white/10 bg-black/40 text-white backdrop-blur transition hover:bg-black/70 md:flex"
        >
            <i data-lucide="chevron-left" class="h-6 w-6"></i>
        </button>

        {{-- Next --}}
        <button
            type="button"
            onclick="nextSlide()"
            class="absolute right-4 top-1/2 z-20 hidden h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full border border-white/10 bg-black/40 text-white backdrop-blur transition hover:bg-black/70 md:flex"
        >
            <i data-lucide="chevron-right" class="h-6 w-6"></i>
        </button>

        {{-- Dots --}}
        <div class="absolute bottom-8 left-1/2 z-20 flex -translate-x-1/2 items-center gap-2">
            @foreach($anime as $index => $item)
                <button
                    type="button"
                    onclick="setSlide({{ $index }})"
                    class="hero-dot h-2 rounded-full transition-all {{ $index === 0 ? 'w-9 bg-fuchsia-400' : 'w-2 bg-white/40 hover:bg-white/70' }}"
                    data-index="{{ $index }}"
                ></button>
            @endforeach
        </div>
    </div>
</section>

{{-- Login Modal --}}
<div id="loginModal" class="fixed inset-0 z-[120] hidden items-center justify-center bg-black/70 px-4">
    <div class="w-full max-w-md rounded-3xl border border-white/10 bg-[#111122] p-6 shadow-2xl">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-black text-white">LogIn</h2>
            <button onclick="closeLoginModal()" class="rounded-xl bg-white/10 p-2 hover:bg-white/15">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <div class="mt-6 space-y-4">
            <input
                type="email"
                placeholder="Email address"
                class="w-full rounded-2xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500"
            />

            <input
                type="password"
                placeholder="Password"
                class="w-full rounded-2xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500"
            />

            <button class="w-full rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-4 py-3 font-bold text-white hover:opacity-90">
                LogIn
            </button>
        </div>
    </div>
</div>

{{-- Info Modal --}}
<div id="infoModal" class="fixed inset-0 z-[120] hidden items-center justify-center bg-black/70 px-4">
    <div class="w-full max-w-lg rounded-3xl border border-white/10 bg-[#111122] p-6 shadow-2xl">
        <div class="flex items-center justify-between">
            <h2 id="infoTitle" class="text-xl font-black text-white"></h2>
            <button onclick="closeInfoModal()" class="rounded-xl bg-white/10 p-2 hover:bg-white/15">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <p id="infoDescription" class="mt-4 text-slate-300"></p>
    </div>
</div>

<script>
    const animeData = @json($anime);
    let activeIndex = 0;

    function refreshIcons() {
        lucide.createIcons();
    }

    function setSlide(index) {
        activeIndex = index;

        document.querySelectorAll('.hero-slide').forEach((slide) => {
            slide.classList.add('opacity-0');
            slide.classList.remove('opacity-100');
        });

        document.querySelector(`.hero-slide[data-index="${index}"]`).classList.remove('opacity-0');
        document.querySelector(`.hero-slide[data-index="${index}"]`).classList.add('opacity-100');

        document.querySelectorAll('.hero-content').forEach((content) => {
            content.classList.add('hidden');
            content.classList.remove('block');
        });

        document.querySelector(`.hero-content[data-index="${index}"]`).classList.remove('hidden');
        document.querySelector(`.hero-content[data-index="${index}"]`).classList.add('block');

        document.querySelectorAll('.hero-poster').forEach((poster) => {
            poster.classList.add('hidden');
            poster.classList.remove('block');
        });

        document.querySelector(`.hero-poster[data-index="${index}"]`).classList.remove('hidden');
        document.querySelector(`.hero-poster[data-index="${index}"]`).classList.add('block');

        document.querySelectorAll('.hero-dot').forEach((dot) => {
            dot.className = 'hero-dot h-2 w-2 rounded-full bg-white/40 transition-all hover:bg-white/70';
        });

        document.querySelector(`.hero-dot[data-index="${index}"]`).className = 'hero-dot h-2 w-9 rounded-full bg-fuchsia-400 transition-all';

        refreshIcons();
    }

    function nextSlide() {
        const next = (activeIndex + 1) % animeData.length;
        setSlide(next);
    }

    function prevSlide() {
        const prev = activeIndex === 0 ? animeData.length - 1 : activeIndex - 1;
        setSlide(prev);
    }

    setInterval(nextSlide, 5000);

    function toggleProfileDropdown() {
        document.getElementById('profileDropdown').classList.toggle('hidden');
    }

    function openMobileMenu() {
        document.getElementById('mobileMenu').classList.remove('hidden');
    }

    function closeMobileMenu() {
        document.getElementById('mobileMenu').classList.add('hidden');
    }

    function openLoginModal() {
        document.getElementById('loginModal').classList.remove('hidden');
        document.getElementById('loginModal').classList.add('flex');
    }

    function closeLoginModal() {
        document.getElementById('loginModal').classList.add('hidden');
        document.getElementById('loginModal').classList.remove('flex');
    }

    function openInfoModal(index) {
        const item = animeData[index];

        document.getElementById('infoTitle').innerText = item.title;
        document.getElementById('infoDescription').innerText = item.description;

        document.getElementById('infoModal').classList.remove('hidden');
        document.getElementById('infoModal').classList.add('flex');
    }

    function closeInfoModal() {
        document.getElementById('infoModal').classList.add('hidden');
        document.getElementById('infoModal').classList.remove('flex');
    }

    function openProfileModal() {
        alert('Profile clicked');
    }

    function openMyListModal() {
        alert('My List clicked');
    }

    function openGenresModal() {
        alert('Genres clicked');
    }

    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('profileDropdown');
        const profileButton = event.target.closest('[onclick="toggleProfileDropdown()"]');

        if (!profileButton && dropdown && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });

    refreshIcons();
</script>

</body>
</html>