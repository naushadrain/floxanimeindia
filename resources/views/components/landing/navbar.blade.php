{{-- ── Top Navigation Bar ────────────────────────────────────────────── --}}
<header class="sticky top-0 z-50 border-b border-white/8 bg-[#080812]/90 backdrop-blur-xl">
    <div class="flex items-center gap-3 px-4 py-3 sm:px-6 lg:px-8">

        {{-- Logo --}}
        <div class="flex shrink-0 items-center gap-2">
            <div class="flex h-9 w-auto">
                <img src="{{ asset('logo/logo.png') }}" alt="floxanimeindia"
                     class="h-9 w-auto object-contain">
            </div>
        </div>

        {{-- Desktop nav links --}}
        <nav class="hidden items-center gap-5 text-sm text-slate-300 lg:flex">
            <button class="font-medium transition hover:text-white">Browse</button>
            <button class="font-medium transition hover:text-white">Trending</button>
            <button class="font-medium transition hover:text-white">New Releases</button>
            <button onclick="openGenreOffcanvas()" class="font-medium transition hover:text-white">Genres</button>
        </nav>

        {{-- Search bar (desktop) --}}
        <div class="mx-auto hidden max-w-xs items-center gap-2 rounded-xl border border-white/10 bg-white/6 px-3 py-2 lg:flex xl:max-w-sm">
            <i data-lucide="search" class="h-4 w-4 shrink-0 text-slate-400"></i>
            <input placeholder="Search anime…"
                   class="w-full bg-transparent text-sm text-white outline-none placeholder:text-slate-500">
        </div>

        {{-- Right side icons --}}
        <div class="ml-auto flex items-center gap-1.5">

            {{-- Search icon (mobile/tablet — shows the mobile search bar below) --}}
            <button onclick="toggleMobileSearch()"
                    class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/8 text-slate-300 hover:bg-white/14 hover:text-white transition lg:hidden">
                <i data-lucide="search" class="h-4.5 w-4.5" style="height:18px;width:18px"></i>
            </button>

            {{-- Notification --}}
            <button class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/8 text-slate-300 hover:bg-white/14 hover:text-white transition">
                <i data-lucide="bell" class="h-4.5 w-4.5" style="height:18px;width:18px"></i>
            </button>

            {{-- Profile (desktop) --}}
            <div class="relative hidden sm:block">
                <button data-profile-button="true"
                        onclick="toggleProfileDropdown()"
                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/8 text-slate-300 hover:bg-white/14 hover:text-white transition">
                    <i data-lucide="user-circle" class="h-5 w-5"></i>
                </button>

                <div id="profileDropdown"
                     class="absolute right-0 mt-2 hidden w-48 overflow-hidden rounded-2xl border border-white/10 bg-[#111122] shadow-xl">
                    <button onclick="openProfileModal()"
                            class="block w-full px-4 py-3 text-left text-sm text-slate-200 hover:bg-white/8 transition">
                        Profile
                    </button>
                    <button class="block w-full px-4 py-3 text-left text-sm text-slate-200 hover:bg-white/8 transition">
                        Settings
                    </button>
                    <div class="border-t border-white/8"></div>
                    <a href="{{ route('login') }}"
                       class="block w-full px-4 py-3 text-left text-sm font-semibold text-fuchsia-400 hover:bg-fuchsia-500/10 transition">
                        Admin Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile search bar (expandable) --}}
    <div id="mobileSearchBar" class="hidden px-4 pb-3 sm:px-6 lg:hidden">
        <div class="flex items-center gap-2 rounded-xl border border-white/10 bg-white/6 px-3 py-2">
            <i data-lucide="search" class="h-4 w-4 shrink-0 text-slate-400"></i>
            <input placeholder="Search anime…"
                   class="w-full bg-transparent text-sm text-white outline-none placeholder:text-slate-500"
                   autofocus id="mobileSearchInput">
            <button onclick="toggleMobileSearch()" class="text-slate-500 hover:text-white">
                <i data-lucide="x" class="h-4 w-4"></i>
            </button>
        </div>
    </div>
</header>

{{-- ── Mobile Bottom Tab Bar ─────────────────────────────────────────── --}}
<nav class="fixed bottom-0 left-0 right-0 z-50 border-t border-white/10 bg-[#080812]/95 backdrop-blur-xl lg:hidden">
    <div class="flex items-center justify-around px-2 pb-safe pt-2"
         style="padding-bottom: max(8px, env(safe-area-inset-bottom));">

        {{-- Home --}}
        <button class="bottom-tab active-tab flex flex-col items-center gap-0.5 px-4 py-1 text-fuchsia-400">
            <i data-lucide="home" class="h-5 w-5"></i>
            <span class="text-[10px] font-semibold">Home</span>
        </button>

        {{-- Search --}}
        <button onclick="toggleMobileSearch()"
                class="bottom-tab flex flex-col items-center gap-0.5 px-4 py-1 text-slate-500 hover:text-white transition">
            <i data-lucide="search" class="h-5 w-5"></i>
            <span class="text-[10px]">Search</span>
        </button>

        {{-- Genres --}}
        <button onclick="openGenreOffcanvas()"
                class="bottom-tab flex flex-col items-center gap-0.5 px-4 py-1 text-slate-500 hover:text-white transition">
            <i data-lucide="compass" class="h-5 w-5"></i>
            <span class="text-[10px]">Genres</span>
        </button>

        {{-- Profile --}}
        <button onclick="openLoginModal()"
                class="bottom-tab flex flex-col items-center gap-0.5 px-4 py-1 text-slate-500 hover:text-white transition">
            <i data-lucide="user" class="h-5 w-5"></i>
            <span class="text-[10px]">Profile</span>
        </button>

    </div>
</nav>

{{-- ── Mobile full-screen menu (hamburger sheet) ────────────────────── --}}
<div id="mobileMenu" class="fixed inset-0 z-100 hidden">
    <div onclick="closeMobileMenu()" class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
    <div class="absolute right-0 top-0 h-full w-72 border-l border-white/10 bg-[#090918] p-6 text-white shadow-2xl">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-black">Menu</h2>
            <button onclick="closeMobileMenu()" class="rounded-xl bg-white/8 p-2 hover:bg-white/14">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>
        <div class="mt-6 space-y-1">
            <button class="w-full rounded-xl px-4 py-3 text-left text-sm font-medium text-white hover:bg-white/8 transition">Browse</button>
            <button class="w-full rounded-xl px-4 py-3 text-left text-sm font-medium text-white hover:bg-white/8 transition">Trending</button>
            <button class="w-full rounded-xl px-4 py-3 text-left text-sm font-medium text-white hover:bg-white/8 transition">New Releases</button>
            <button onclick="openGenreOffcanvas()" class="w-full rounded-xl px-4 py-3 text-left text-sm font-medium text-white hover:bg-white/8 transition">Genres</button>
            <button onclick="openProfileModal()" class="w-full rounded-xl px-4 py-3 text-left text-sm font-medium text-white hover:bg-white/8 transition">Profile</button>
        </div>
        <div class="mt-4 border-t border-white/8 pt-4">
            <a href="{{ route('login') }}"
               class="flex w-full items-center justify-center gap-2 rounded-2xl bg-linear-to-r from-violet-500 to-fuchsia-500 px-4 py-3 text-sm font-bold text-white hover:opacity-90 transition">
                <i data-lucide="log-in" class="h-4 w-4"></i>
                Admin Login
            </a>
        </div>
    </div>
</div>

{{-- ── Login Modal ───────────────────────────────────────────────────── --}}
<div id="loginModal" class="fixed inset-0 z-120 hidden items-center justify-center bg-black/70 px-4 backdrop-blur-sm">
    <div class="w-full max-w-sm rounded-3xl border border-white/10 bg-[#111122] p-6 shadow-2xl">
        <div class="mb-5 flex items-center justify-between">
            <h2 class="text-lg font-black text-white">Sign In</h2>
            <button onclick="closeLoginModal()" class="rounded-xl bg-white/8 p-2 hover:bg-white/14 transition">
                <i data-lucide="x" class="h-4 w-4"></i>
            </button>
        </div>
        <div class="space-y-3">
            <input type="email" placeholder="Email address"
                   class="w-full rounded-2xl border border-white/10 bg-white/6 px-4 py-3 text-sm text-white outline-none placeholder:text-slate-500 focus:border-violet-500/50 transition">
            <input type="password" placeholder="Password"
                   class="w-full rounded-2xl border border-white/10 bg-white/6 px-4 py-3 text-sm text-white outline-none placeholder:text-slate-500 focus:border-violet-500/50 transition">
            <button class="w-full rounded-2xl bg-linear-to-r from-violet-500 to-fuchsia-500 py-3 text-sm font-bold text-white hover:opacity-90 transition">
                Sign In
            </button>
            <p class="text-center text-xs text-slate-500">
                Admin?
                <a href="{{ route('login') }}" class="text-fuchsia-400 hover:underline">Go to admin panel →</a>
            </p>
        </div>
    </div>
</div>

<script>
    function toggleMobileSearch() {
        const bar   = document.getElementById('mobileSearchBar');
        const input = document.getElementById('mobileSearchInput');
        const isHidden = bar.classList.contains('hidden');
        bar.classList.toggle('hidden', !isHidden);
        if (isHidden && input) setTimeout(() => input.focus(), 50);
    }
</script>
