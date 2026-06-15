<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — AnimeStreamer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { background: #070713; }
        .sidebar { width: 260px; }
        .main-content { margin-left: 260px; }
        .nav-link { transition: all .2s; }
        .nav-link.active,
        .nav-link:hover {
            background: rgba(255,255,255,.07);
            color: #fff;
        }
        .nav-link.active { border-left: 3px solid #a855f7; padding-left: calc(1rem - 3px); }
        .scrollbar-thin::-webkit-scrollbar { width: 4px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 4px; }
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
    {{-- Global form styles (works with Tailwind CDN) --}}
    <style type="text/tailwindcss">
        .form-label { @apply mb-1.5 block text-xs font-semibold text-slate-400; }
        .form-input  { @apply w-full rounded-2xl border border-white/10 bg-white/6 px-4 py-2.5 text-sm text-white outline-none placeholder:text-slate-600 focus:border-violet-500/50 focus:bg-white/8 transition; }
        .form-error  { @apply mt-1 text-xs text-red-400; }
        select.form-input option { background: #111122; }
        input[type="date"].form-input::-webkit-calendar-picker-indicator { filter: invert(1) opacity(0.5); }
        textarea.form-input { resize: none; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-[#070713] text-white">

    {{-- ── Sidebar ──────────────────────────────────────────────────────── --}}
    <aside id="sidebar" class="sidebar fixed inset-y-0 left-0 z-50 flex flex-col border-r border-white/8 bg-[#080814] transition-transform duration-300">

        {{-- Logo --}}
        <div class="flex items-center gap-3 border-b border-white/8 px-5 py-5">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-500 to-fuchsia-500 shadow-lg shadow-fuchsia-500/25">
                <i data-lucide="film" class="h-5 w-5 text-white"></i>
            </div>
            <div>
                <p class="text-sm font-black leading-none text-white">AnimeStreamer</p>
                <p class="mt-0.5 text-xs text-slate-500">Admin Panel</p>
            </div>
            <button onclick="toggleSidebar()" class="ml-auto rounded-xl p-1.5 text-slate-500 hover:bg-white/10 hover:text-white lg:hidden">
                <i data-lucide="x" class="h-4 w-4"></i>
            </button>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto scrollbar-thin px-3 py-4 space-y-0.5">

            <p class="mb-2 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-600">Main</p>

            <a href="{{ route('dashboard.index') }}"
               class="nav-link flex items-center gap-3 rounded-2xl px-4 py-2.5 text-sm font-medium text-slate-400 {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard" class="h-4.5 w-4.5 shrink-0" style="height:18px;width:18px"></i>
                Dashboard
            </a>

            <p class="mb-2 mt-4 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-600">Content</p>

            <a href="{{ route('dashboard.anime.index') }}"
               class="nav-link flex items-center gap-3 rounded-2xl px-4 py-2.5 text-sm font-medium text-slate-400 {{ request()->routeIs('dashboard.anime.*') ? 'active' : '' }}">
                <i data-lucide="tv-2" style="height:18px;width:18px" class="shrink-0"></i>
                Anime
            </a>

            <a href="{{ route('dashboard.episodes.index') }}"
               class="nav-link flex items-center gap-3 rounded-2xl px-4 py-2.5 text-sm font-medium text-slate-400 {{ request()->routeIs('dashboard.episodes.*') ? 'active' : '' }}">
                <i data-lucide="play-circle" style="height:18px;width:18px" class="shrink-0"></i>
                Episodes
            </a>

            <a href="{{ route('dashboard.genres.index') }}"
               class="nav-link flex items-center gap-3 rounded-2xl px-4 py-2.5 text-sm font-medium text-slate-400 {{ request()->routeIs('dashboard.genres.*') ? 'active' : '' }}">
                <i data-lucide="tag" style="height:18px;width:18px" class="shrink-0"></i>
                Genres
            </a>

            <p class="mb-2 mt-4 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-600">Appearance</p>

            <a href="{{ route('dashboard.slider.index') }}"
               class="nav-link flex items-center gap-3 rounded-2xl px-4 py-2.5 text-sm font-medium text-slate-400 {{ request()->routeIs('dashboard.slider.*') ? 'active' : '' }}">
                <i data-lucide="image" style="height:18px;width:18px" class="shrink-0"></i>
                Sliders
            </a>

            <p class="mb-2 mt-4 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-600">Site</p>

            <a href="{{ url('/') }}" target="_blank"
               class="nav-link flex items-center gap-3 rounded-2xl px-4 py-2.5 text-sm font-medium text-slate-400">
                <i data-lucide="external-link" style="height:18px;width:18px" class="shrink-0"></i>
                View Site
            </a>
        </nav>

        {{-- User --}}
        <div class="border-t border-white/8 p-3">
            <div class="flex items-center gap-3 rounded-2xl px-3 py-2">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-violet-500 to-fuchsia-500 text-sm font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                    <p class="truncate text-xs text-slate-500">{{ auth()->user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-xl p-1.5 text-slate-500 hover:bg-white/10 hover:text-red-400 transition" title="Logout">
                        <i data-lucide="log-out" style="height:16px;width:16px"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Overlay for mobile --}}
    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 z-40 hidden bg-black/60 lg:hidden"></div>

    {{-- ── Main content ─────────────────────────────────────────────────── --}}
    <div class="main-content min-h-screen flex flex-col">

        {{-- Top bar --}}
        <header class="sticky top-0 z-30 border-b border-white/8 bg-[#080814]/90 backdrop-blur-xl">
            <div class="flex items-center gap-4 px-6 py-4">
                <button onclick="toggleSidebar()" class="rounded-xl bg-white/8 p-2 text-slate-400 hover:bg-white/12 hover:text-white lg:hidden">
                    <i data-lucide="menu" style="height:18px;width:18px"></i>
                </button>

                <div>
                    <h1 class="text-base font-black text-white">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs text-slate-500">@yield('page-subtitle', 'Welcome back, ' . auth()->user()->name)</p>
                </div>

                <div class="ml-auto flex items-center gap-2">
                    <span class="hidden rounded-full border border-violet-500/30 bg-violet-500/10 px-3 py-1 text-xs font-semibold text-violet-400 sm:inline-flex">
                        Admin
                    </span>
                </div>
            </div>
        </header>

        {{-- Flash messages --}}
        @if (session('success'))
            <div x-data="{ show: true }" class="mx-6 mt-5">
                <div class="flex items-center gap-3 rounded-2xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-400">
                    <i data-lucide="check-circle-2" style="height:16px;width:16px;flex-shrink:0"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mx-6 mt-5">
                <div class="flex items-center gap-3 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-400">
                    <i data-lucide="alert-circle" style="height:16px;width:16px;flex-shrink:0"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        {{-- Page content --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    <script>
        lucide.createIcons();

        function toggleSidebar() {
            const sidebar  = document.getElementById('sidebar');
            const overlay  = document.getElementById('sidebarOverlay');
            const isOpen   = sidebar.classList.contains('open');
            sidebar.classList.toggle('open', !isOpen);
            overlay.classList.toggle('hidden', isOpen);
        }
    </script>
    @stack('scripts')
</body>
</html>
