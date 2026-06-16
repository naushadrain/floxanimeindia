<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — FloxAnime</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        * { -webkit-tap-highlight-color: transparent; }
        body { background: #070713; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(168,85,247,.25); border-radius: 99px; }

        /* ── Sidebar ── */
        .sidebar { width: 256px; transition: transform .3s cubic-bezier(.4,0,.2,1); }
        .main-content { margin-left: 256px; }

        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); position: fixed; }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }

        /* ── Nav link ── */
        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 14px; border-radius: 14px;
            font-size: 13.5px; font-weight: 500;
            color: #94a3b8; transition: all .18s ease;
            border-left: 2px solid transparent;
        }
        .nav-link:hover { background: rgba(255,255,255,.06); color: #e2e8f0; }
        .nav-link.active {
            background: rgba(168,85,247,.12);
            color: #fff;
            border-left-color: #a855f7;
            padding-left: 12px;
        }
        .nav-link.active .nav-icon { color: #d946ef; }
        .nav-section {
            font-size: 9.5px; font-weight: 700; letter-spacing: .12em;
            text-transform: uppercase; color: #334155;
            padding: 0 14px; margin: 18px 0 6px;
        }

        /* ── Form helpers (global) ── */
        .form-label { display: block; margin-bottom: 5px; font-size: 11.5px; font-weight: 600; color: #94a3b8; }
        .form-input {
            width: 100%; border-radius: 14px;
            border: 1px solid rgba(255,255,255,.1);
            background: rgba(255,255,255,.04);
            padding: 9px 14px; font-size: 13px; color: #fff;
            outline: none; transition: border .18s, background .18s;
        }
        .form-input::placeholder { color: #475569; }
        .form-input:focus { border-color: rgba(168,85,247,.5); background: rgba(255,255,255,.07); }
        select.form-input option { background: #0f0f23; }
        textarea.form-input { resize: none; }
        input[type="date"].form-input::-webkit-calendar-picker-indicator { filter: invert(.6); }
        .form-error { margin-top: 4px; font-size: 11px; color: #f87171; }

        /* ── Gradient button ── */
        .btn-primary {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #8b5cf6, #d946ef);
            padding: 9px 22px; border-radius: 14px;
            font-size: 13px; font-weight: 700; color: #fff;
            box-shadow: 0 4px 20px rgba(217,70,239,.25);
            transition: opacity .18s, transform .12s;
        }
        .btn-primary:hover { opacity: .9; }
        .btn-primary:active { transform: scale(.97); }

        /* ── Alert flash ── */
        .flash-success {
            display: flex; align-items: center; gap: 10px;
            background: rgba(34,197,94,.08); border: 1px solid rgba(34,197,94,.25);
            border-radius: 14px; padding: 11px 16px;
            font-size: 13px; color: #4ade80;
        }
        .flash-error {
            display: flex; align-items: center; gap: 10px;
            background: rgba(239,68,68,.08); border: 1px solid rgba(239,68,68,.25);
            border-radius: 14px; padding: 11px 16px;
            font-size: 13px; color: #f87171;
        }
    </style>

    @stack('styles')
</head>

<body class="min-h-screen bg-[#070713] text-white antialiased">

{{-- ══ SIDEBAR ══════════════════════════════════════════════════════════════ --}}
<aside id="sidebar"
       class="sidebar fixed inset-y-0 left-0 z-50 flex flex-col
              border-r border-white/[0.07] bg-[#080814]">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-5 py-[18px] border-b border-white/[0.07]">
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-2xl
                    bg-linear-to-br from-violet-500 to-fuchsia-500 shadow-lg shadow-fuchsia-500/25">
            <i data-lucide="film" class="h-4 w-4 text-white"></i>
        </div>
        <div class="min-w-0">
            <p class="text-sm font-black leading-tight text-white tracking-tight">FloxAnime</p>
            <p class="text-[10px] text-slate-500 font-medium">Admin Panel</p>
        </div>
        <button onclick="toggleSidebar()"
                class="ml-auto flex h-7 w-7 items-center justify-center rounded-xl
                       text-slate-500 hover:bg-white/8 hover:text-white transition lg:hidden">
            <i data-lucide="x" class="h-4 w-4"></i>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-3 py-3">

        <p class="nav-section">Main</p>

        <a href="{{ route('dashboard.index') }}"
           class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
            <i data-lucide="layout-dashboard" class="nav-icon h-[17px] w-[17px] shrink-0"></i>
            Dashboard
        </a>

        <p class="nav-section">Content</p>

        <a href="{{ route('dashboard.anime.index') }}"
           class="nav-link {{ request()->routeIs('dashboard.anime.*') ? 'active' : '' }}">
            <i data-lucide="tv-2" class="nav-icon h-[17px] w-[17px] shrink-0"></i>
            Anime
            @php $animeCount = \App\Models\Anime::count(); @endphp
            @if($animeCount)
                <span class="ml-auto rounded-full bg-white/8 px-2 py-0.5 text-[10px] font-bold text-slate-400">
                    {{ $animeCount }}
                </span>
            @endif
        </a>

        <a href="{{ route('dashboard.episodes.index') }}"
           class="nav-link {{ request()->routeIs('dashboard.episodes.*') ? 'active' : '' }}">
            <i data-lucide="video" class="nav-icon h-[17px] w-[17px] shrink-0"></i>
            Videos
            @php $epCount = \App\Models\Episode::count(); @endphp
            @if($epCount)
                <span class="ml-auto rounded-full bg-white/8 px-2 py-0.5 text-[10px] font-bold text-slate-400">
                    {{ $epCount }}
                </span>
            @endif
        </a>

        <a href="{{ route('dashboard.genres.index') }}"
           class="nav-link {{ request()->routeIs('dashboard.genres.*') ? 'active' : '' }}">
            <i data-lucide="tag" class="nav-icon h-[17px] w-[17px] shrink-0"></i>
            Genres
        </a>

        <p class="nav-section">Appearance</p>

        <a href="{{ route('dashboard.slider.index') }}"
           class="nav-link {{ request()->routeIs('dashboard.slider.*') ? 'active' : '' }}">
            <i data-lucide="images" class="nav-icon h-[17px] w-[17px] shrink-0"></i>
            Sliders
        </a>

        <p class="nav-section">Site</p>

        <a href="{{ url('/') }}" target="_blank"
           class="nav-link">
            <i data-lucide="external-link" class="nav-icon h-[17px] w-[17px] shrink-0"></i>
            View Website
        </a>

    </nav>

    {{-- User card --}}
    <div class="border-t border-white/[0.07] p-3">
        <div class="flex items-center gap-3 rounded-2xl bg-white/4 px-3 py-2.5 border border-white/6">
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full
                        bg-linear-to-br from-violet-500 to-fuchsia-500 text-xs font-black">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="truncate text-xs font-bold text-white">{{ auth()->user()->name }}</p>
                <p class="truncate text-[10px] text-slate-500">{{ auth()->user()->email }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Logout"
                        class="flex h-7 w-7 items-center justify-center rounded-xl
                               text-slate-500 hover:bg-red-500/15 hover:text-red-400 transition">
                    <i data-lucide="log-out" class="h-3.5 w-3.5"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- Mobile overlay --}}
<div id="sidebarOverlay" onclick="toggleSidebar()"
     class="fixed inset-0 z-40 hidden bg-black/60 backdrop-blur-sm lg:hidden"></div>

{{-- ══ MAIN ══════════════════════════════════════════════════════════════════ --}}
<div class="main-content min-h-screen flex flex-col">

    {{-- Top bar --}}
    <header class="sticky top-0 z-30 border-b border-white/[0.07] bg-[#080814]/90 backdrop-blur-xl">
        <div class="flex items-center gap-4 px-6 py-3.5">

            <button onclick="toggleSidebar()"
                    class="flex h-8 w-8 items-center justify-center rounded-xl
                           bg-white/6 text-slate-400 hover:bg-white/10 hover:text-white transition lg:hidden">
                <i data-lucide="menu" class="h-4 w-4"></i>
            </button>

            <div class="min-w-0">
                <h1 class="text-sm font-black text-white leading-tight">
                    @yield('page-title', 'Dashboard')
                </h1>
                <p class="text-[11px] text-slate-500">
                    @yield('page-subtitle', 'Platform overview')
                </p>
            </div>

            <div class="ml-auto flex items-center gap-2">
                {{-- Breadcrumb / action slot --}}
                @yield('header-actions')

                <div class="hidden items-center gap-1.5 rounded-full border border-violet-500/25
                            bg-violet-500/10 px-3 py-1 sm:flex">
                    <div class="h-1.5 w-1.5 rounded-full bg-violet-400"></div>
                    <span class="text-[11px] font-semibold text-violet-300">Admin</span>
                </div>
            </div>
        </div>
    </header>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="mx-6 mt-4">
            <div class="flash-success">
                <i data-lucide="check-circle-2" class="h-4 w-4 shrink-0"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mx-6 mt-4">
            <div class="flash-error">
                <i data-lucide="alert-circle" class="h-4 w-4 shrink-0"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Page content --}}
    <main class="flex-1 @yield('main-class', 'p-6')">
        @yield('content')
    </main>
</div>

<script>
    lucide.createIcons();

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const isOpen  = sidebar.classList.contains('open');
        sidebar.classList.toggle('open', !isOpen);
        overlay.classList.toggle('hidden', isOpen);
    }
</script>

@stack('scripts')
</body>
</html>
