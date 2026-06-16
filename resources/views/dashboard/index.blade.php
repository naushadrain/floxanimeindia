@extends('dashboard.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Platform overview & quick actions')

@section('header-actions')
    <a href="{{ route('dashboard.anime.create') }}" class="btn-primary text-xs px-4 py-2">
        <i data-lucide="plus" class="h-3.5 w-3.5"></i>
        Add Anime
    </a>
@endsection

@section('content')

{{-- ── Stat Cards ─────────────────────────────────────────────────────────── --}}
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

    @php
        $cards = [
            ['label' => 'Total Anime',    'value' => $stats['animes'],     'icon' => 'tv-2',        'color' => 'from-violet-500 to-fuchsia-500', 'glow' => 'shadow-fuchsia-500/20', 'href' => route('dashboard.anime.index')],
            ['label' => 'Video Episodes', 'value' => $stats['episodes'],   'icon' => 'video',       'color' => 'from-blue-500 to-cyan-500',       'glow' => 'shadow-cyan-500/20',   'href' => route('dashboard.episodes.index')],
            ['label' => 'Genres',         'value' => $stats['genres'],     'icon' => 'tag',         'color' => 'from-emerald-500 to-teal-500',    'glow' => 'shadow-teal-500/20',   'href' => route('dashboard.genres.index')],
            ['label' => 'Active Sliders', 'value' => $stats['sliders'],    'icon' => 'images',      'color' => 'from-orange-500 to-amber-500',    'glow' => 'shadow-amber-500/20',  'href' => route('dashboard.slider.index')],
            ['label' => 'Watchlists',     'value' => $stats['watchlists'], 'icon' => 'bookmark',    'color' => 'from-pink-500 to-rose-500',       'glow' => 'shadow-rose-500/20',   'href' => '#'],
            ['label' => 'User Ratings',   'value' => $stats['ratings'],    'icon' => 'star',        'color' => 'from-yellow-500 to-orange-400',   'glow' => 'shadow-orange-500/20', 'href' => '#'],
        ];
    @endphp

    @foreach($cards as $card)
        <a href="{{ $card['href'] }}"
           class="group relative overflow-hidden rounded-3xl border border-white/8 bg-white/3
                  p-5 transition hover:border-white/15 hover:bg-white/6">

            {{-- Glow bg --}}
            <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-linear-to-br {{ $card['color'] }}
                        opacity-0 blur-2xl transition group-hover:opacity-15"></div>

            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500">{{ $card['label'] }}</p>
                    <p class="mt-2 text-3xl font-black text-white tabular-nums">
                        {{ number_format($card['value']) }}
                    </p>
                </div>
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl
                            bg-linear-to-br {{ $card['color'] }} shadow-lg {{ $card['glow'] }}">
                    <i data-lucide="{{ $card['icon'] }}" class="h-5 w-5 text-white"></i>
                </div>
            </div>
        </a>
    @endforeach
</div>

{{-- ── Quick Actions ───────────────────────────────────────────────────────── --}}
<div class="mt-6 rounded-3xl border border-white/8 bg-white/2 p-5">
    <p class="mb-4 text-[11px] font-bold uppercase tracking-widest text-slate-500">Quick Actions</p>
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('dashboard.anime.create') }}"
           class="flex items-center gap-2 rounded-2xl bg-linear-to-r from-violet-500 to-fuchsia-500
                  px-5 py-2.5 text-xs font-bold text-white shadow-lg shadow-fuchsia-500/20 hover:opacity-90 transition">
            <i data-lucide="plus-circle" class="h-3.5 w-3.5"></i>
            Add Anime
        </a>
        <a href="{{ route('dashboard.slider.create') }}"
           class="flex items-center gap-2 rounded-2xl border border-fuchsia-500/30 bg-fuchsia-500/10
                  px-5 py-2.5 text-xs font-bold text-fuchsia-300 hover:bg-fuchsia-500/15 transition">
            <i data-lucide="images" class="h-3.5 w-3.5"></i>
            Add Slider
        </a>
        <a href="{{ route('dashboard.episodes.index') }}"
           class="flex items-center gap-2 rounded-2xl border border-cyan-500/30 bg-cyan-500/10
                  px-5 py-2.5 text-xs font-bold text-cyan-300 hover:bg-cyan-500/15 transition">
            <i data-lucide="video" class="h-3.5 w-3.5"></i>
            Upload Video
        </a>
        <a href="{{ route('dashboard.genres.index') }}"
           class="flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5
                  px-5 py-2.5 text-xs font-bold text-slate-300 hover:bg-white/10 transition">
            <i data-lucide="tag" class="h-3.5 w-3.5"></i>
            Manage Genres
        </a>
    </div>
</div>

{{-- ── Two-Column: Recent Anime + Active Sliders ──────────────────────────── --}}
<div class="mt-6 grid gap-6 lg:grid-cols-2">

    {{-- Recent Anime --}}
    <div class="rounded-3xl border border-white/8 bg-white/2 overflow-hidden">
        <div class="flex items-center justify-between border-b border-white/8 px-5 py-4">
            <h2 class="flex items-center gap-2 text-sm font-black text-white">
                <i data-lucide="clock" class="h-4 w-4 text-violet-400"></i>
                Recently Added
            </h2>
            <a href="{{ route('dashboard.anime.index') }}"
               class="rounded-xl bg-violet-500/10 px-3 py-1 text-[11px] font-semibold
                      text-violet-400 hover:bg-violet-500/20 transition">
                View all →
            </a>
        </div>

        @if($recentAnime->isEmpty())
            <div class="flex flex-col items-center justify-center py-14 text-slate-600">
                <i data-lucide="tv-2" class="mb-3 h-10 w-10 opacity-30"></i>
                <p class="text-sm font-semibold">No anime added yet</p>
                <a href="{{ route('dashboard.anime.create') }}"
                   class="mt-3 rounded-xl bg-violet-500/15 px-4 py-1.5 text-xs font-bold text-violet-400 hover:bg-violet-500/25 transition">
                    Add first anime
                </a>
            </div>
        @else
            <div class="divide-y divide-white/5">
                @foreach($recentAnime as $item)
                    <div class="flex items-center gap-3 px-5 py-3 hover:bg-white/3 transition">
                        @if($item->cover_image)
                            <img src="{{ Storage::url($item->cover_image) }}" alt="{{ $item->title }}"
                                 class="h-12 w-9 shrink-0 rounded-xl object-cover">
                        @else
                            <div class="flex h-12 w-9 shrink-0 items-center justify-center rounded-xl
                                        bg-linear-to-br from-violet-500 to-fuchsia-500">
                                <i data-lucide="film" class="h-4 w-4 text-white"></i>
                            </div>
                        @endif
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-bold text-white">{{ $item->title }}</p>
                            <p class="text-[11px] text-slate-500">
                                {{ $item->studio ?? 'Unknown Studio' }} · {{ $item->release_year ?? '—' }}
                            </p>
                        </div>
                        <span class="shrink-0 rounded-full px-2.5 py-0.5 text-[10px] font-bold
                            {{ $item->status === 'ongoing'   ? 'bg-green-500/15 text-green-400'  :
                               ($item->status === 'completed' ? 'bg-blue-500/15 text-blue-400'   :
                                                               'bg-yellow-500/15 text-yellow-400') }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Active Sliders --}}
    <div class="rounded-3xl border border-white/8 bg-white/2 overflow-hidden">
        <div class="flex items-center justify-between border-b border-white/8 px-5 py-4">
            <h2 class="flex items-center gap-2 text-sm font-black text-white">
                <i data-lucide="images" class="h-4 w-4 text-fuchsia-400"></i>
                Active Sliders
            </h2>
            <a href="{{ route('dashboard.slider.index') }}"
               class="rounded-xl bg-fuchsia-500/10 px-3 py-1 text-[11px] font-semibold
                      text-fuchsia-400 hover:bg-fuchsia-500/20 transition">
                Manage →
            </a>
        </div>

        @if($activeSliders->isEmpty())
            <div class="flex flex-col items-center justify-center py-14 text-slate-600">
                <i data-lucide="images" class="mb-3 h-10 w-10 opacity-30"></i>
                <p class="text-sm font-semibold">No sliders yet</p>
                <a href="{{ route('dashboard.slider.create') }}"
                   class="mt-3 rounded-xl bg-fuchsia-500/15 px-4 py-1.5 text-xs font-bold text-fuchsia-400 hover:bg-fuchsia-500/25 transition">
                    Create first slider
                </a>
            </div>
        @else
            <div class="divide-y divide-white/5">
                @foreach($activeSliders as $slider)
                    @php
                        $imgSrc = $slider->image_url ?: ($slider->image_path ? Storage::url($slider->image_path) : null);
                    @endphp
                    <div class="flex items-center gap-3 px-5 py-3 hover:bg-white/3 transition">
                        @if($imgSrc)
                            <img src="{{ $imgSrc }}" alt="{{ $slider->title }}"
                                 class="h-11 w-20 shrink-0 rounded-xl object-cover">
                        @else
                            <div class="flex h-11 w-20 shrink-0 items-center justify-center rounded-xl
                                        bg-linear-to-br from-fuchsia-500 to-pink-500">
                                <i data-lucide="image" class="h-4 w-4 text-white"></i>
                            </div>
                        @endif
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-bold text-white">{{ $slider->title }}</p>
                            <p class="truncate text-[11px] text-slate-500">{{ $slider->subtitle ?? 'No subtitle' }}</p>
                        </div>
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-green-500/15">
                            <i data-lucide="check" class="h-3 w-3 text-green-400"></i>
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection
