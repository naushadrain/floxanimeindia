<header class="sticky top-0 z-50 border-b border-white/10 bg-[#080812]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-7xl items-center gap-4 px-4 py-4 sm:px-6 lg:px-8">
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

        <nav class="hidden items-center gap-6 text-sm text-slate-300 lg:flex">
            <button class="transition hover:text-white">Browse</button>
            <button class="transition hover:text-white">Trending</button>
            <button class="transition hover:text-white">New Releases</button>
            <button onclick="openGenreOffcanvas()" class="transition hover:text-white">Genres</button>
        </nav>

        <div class="mx-auto hidden w-full max-w-md items-center gap-2 rounded-2xl border border-white/10 bg-white/[0.06] px-3 py-2 md:flex">
            <i data-lucide="search" class="h-5 w-5 text-slate-400"></i>
            <input
                placeholder="Search anime..."
                class="h-9 w-full border-0 bg-transparent text-white shadow-none outline-none placeholder:text-slate-500"
            />
        </div>

        <div class="ml-auto flex items-center gap-2">
            <button
                onclick="openConfirmModal()"
                class="hidden h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white hover:bg-white/15 sm:inline-flex"
            >
                <i data-lucide="heart" class="h-5 w-5"></i>
            </button>

            <button class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white hover:bg-white/15">
                <i data-lucide="bell" class="h-5 w-5"></i>
            </button>

            <div class="relative hidden sm:block">
                <button
                    data-profile-button="true"
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

            <button
                onclick="openMobileMenu()"
                class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white hover:bg-white/15 lg:hidden"
            >
                <i data-lucide="menu" class="h-5 w-5"></i>
            </button>
        </div>
    </div>

    <div class="px-4 pb-4 md:hidden">
        <div class="flex items-center gap-2 rounded-2xl border border-white/10 bg-white/[0.06] px-3 py-2">
            <i data-lucide="search" class="h-5 w-5 text-slate-400"></i>
            <input
                placeholder="Search anime..."
                class="h-9 w-full border-0 bg-transparent text-white shadow-none outline-none placeholder:text-slate-500"
            />
        </div>
    </div>
</header>

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
            <button class="w-full rounded-xl px-4 py-3 text-left text-white hover:bg-white/10">Browse</button>
            <button class="w-full rounded-xl px-4 py-3 text-left text-white hover:bg-white/10">Trending</button>
            <button class="w-full rounded-xl px-4 py-3 text-left text-white hover:bg-white/10">New Releases</button>
            <button onclick="openGenreOffcanvas()" class="w-full rounded-xl px-4 py-3 text-left text-white hover:bg-white/10">Genres</button>
            <button onclick="openProfileModal()" class="w-full rounded-xl px-4 py-3 text-left text-white hover:bg-white/10">Profile</button>
            <button onclick="openLoginModal()" class="w-full rounded-2xl bg-fuchsia-500 px-4 py-3 text-left font-bold text-white hover:bg-fuchsia-600">LogIn</button>
        </div>
    </div>
</div>

<div id="loginModal" class="fixed inset-0 z-[120] hidden items-center justify-center bg-black/70 px-4">
    <div class="w-full max-w-md rounded-3xl border border-white/10 bg-[#111122] p-6 shadow-2xl">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-black text-white">LogIn</h2>
            <button onclick="closeLoginModal()" class="rounded-xl bg-white/10 p-2 hover:bg-white/15">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <div class="mt-6 space-y-4">
            <input type="email" placeholder="Email address" class="w-full rounded-2xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500">
            <input type="password" placeholder="Password" class="w-full rounded-2xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500">

            <button class="w-full rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-4 py-3 font-bold text-white hover:opacity-90">
                LogIn
            </button>
        </div>
    </div>
</div>