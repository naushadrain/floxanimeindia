@extends('dashboard.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Platform overview')

@section('content')

    {{-- ── Stat cards ─────────────────────────────────────────────────────── --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

        @php
            $cards = [
                ['label' => 'Total Anime',     'value' => $stats['animes'],     'icon' => 'tv-2',          'from' => 'from-violet-500', 'to' => 'to-fuchsia-500'],
                ['label' => 'Episodes',        'value' => $stats['episodes'],   'icon' => 'play-circle',   'from' => 'from-blue-500',   'to' => 'to-cyan-500'],
                ['label' => 'Genres',          'value' => $stats['genres'],     'icon' => 'tag',           'from' => 'from-emerald-500','to' => 'to-teal-500'],
                ['label' => 'Active Sliders',  'value' => $stats['sliders'],    'icon' => 'image',         'from' => 'from-orange-500', 'to' => 'to-amber-500'],
                ['label' => 'Watchlists',      'value' => $stats['watchlists'], 'icon' => 'bookmark',      'from' => 'from-pink-500',   'to' => 'to-rose-500'],
                ['label' => 'User Ratings',    'value' => $stats['ratings'],    'icon' => 'star',          'from' => 'from-yellow-500', 'to' => 'to-orange-400'],
            ];
        @endphp

        @foreach($cards as $card)
            <div class="rounded-3xl border border-white/8 bg-white/[0.03] p-5 hover:bg-white/[0.06] transition">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-slate-400">{{ $card['label'] }}</p>
                        <p class="mt-2 text-3xl font-black text-white">{{ number_format($card['value']) }}</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br {{ $card['from'] }} {{ $card['to'] }} shadow-lg">
                        <i data-lucide="{{ $card['icon'] }}" style="height:20px;width:20px" class="text-white"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">

        {{-- ── Recent Anime ─────────────────────────────────────────────── --}}
        <div class="rounded-3xl border border-white/8 bg-white/[0.03] p-5">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-base font-black text-white flex items-center gap-2">
                    <i data-lucide="clock" style="height:16px;width:16px" class="text-violet-400"></i>
                    Recently Added
                </h2>
                <a href="{{ route('dashboard.anime.index') }}" class="text-xs text-violet-400 hover:text-violet-300 transition">View all →</a>
            </div>

            @if($recentAnime->isEmpty())
                <div class="flex flex-col items-center justify-center py-10 text-slate-500">
                    <i data-lucide="tv-2" style="height:32px;width:32px" class="mb-3 opacity-40"></i>
                    <p class="text-sm">No anime added yet</p>
                    <a href="{{ route('dashboard.anime.create') }}" class="mt-3 rounded-xl bg-violet-500/20 px-4 py-2 text-xs font-semibold text-violet-400 hover:bg-violet-500/30 transition">Add Anime</a>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($recentAnime as $item)
                        <div class="flex items-center gap-3 rounded-2xl border border-white/6 bg-white/[0.03] p-3">
                            @if($item->cover_image)
                                <img src="{{ Storage::url($item->cover_image) }}" alt="{{ $item->title }}" class="h-12 w-10 rounded-xl object-cover shrink-0">
                            @else
                                <div class="flex h-12 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-fuchsia-500">
                                    <i data-lucide="film" style="height:16px;width:16px" class="text-white"></i>
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-semibold text-white">{{ $item->title }}</p>
                                <p class="text-xs text-slate-500">{{ $item->status }} · {{ $item->release_year }}</p>
                            </div>
                            <span class="shrink-0 rounded-full px-2.5 py-0.5 text-xs font-semibold
                                {{ $item->status === 'ongoing' ? 'bg-green-500/15 text-green-400' : ($item->status === 'completed' ? 'bg-blue-500/15 text-blue-400' : 'bg-yellow-500/15 text-yellow-400') }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ── Active Sliders ────────────────────────────────────────────── --}}
        <div class="rounded-3xl border border-white/8 bg-white/[0.03] p-5">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-base font-black text-white flex items-center gap-2">
                    <i data-lucide="image" style="height:16px;width:16px" class="text-fuchsia-400"></i>
                    Active Sliders
                </h2>
                <a href="{{ route('dashboard.slider.index') }}" class="text-xs text-fuchsia-400 hover:text-fuchsia-300 transition">Manage →</a>
            </div>

            @if($activeSliders->isEmpty())
                <div class="flex flex-col items-center justify-center py-10 text-slate-500">
                    <i data-lucide="image" style="height:32px;width:32px" class="mb-3 opacity-40"></i>
                    <p class="text-sm">No sliders yet</p>
                    <a href="{{ route('dashboard.slider.index') }}" class="mt-3 rounded-xl bg-fuchsia-500/20 px-4 py-2 text-xs font-semibold text-fuchsia-400 hover:bg-fuchsia-500/30 transition">Upload Slider</a>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($activeSliders as $slider)
                        <div class="flex items-center gap-3 rounded-2xl border border-white/6 bg-white/[0.03] p-3">
                            <img src="{{ Storage::url($slider->image_path) }}" alt="{{ $slider->title }}" class="h-12 w-20 rounded-xl object-cover shrink-0">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-semibold text-white">{{ $slider->title }}</p>
                                <p class="truncate text-xs text-slate-500">{{ $slider->subtitle }}</p>
                            </div>
                            <span class="shrink-0 flex h-6 w-6 items-center justify-center rounded-full bg-green-500/15">
                                <i data-lucide="check" style="height:12px;width:12px" class="text-green-400"></i>
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- ── Quick actions ────────────────────────────────────────────────── --}}
    <div class="mt-6">
        <h2 class="mb-3 text-sm font-black uppercase tracking-widest text-slate-500">Quick Actions</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('dashboard.anime.create') }}" class="flex items-center gap-2 rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-fuchsia-500/20 hover:opacity-90 transition">
                <i data-lucide="plus-circle" style="height:16px;width:16px"></i>
                Add Anime
            </a>
            <a href="{{ route('dashboard.slider.index') }}" class="flex items-center gap-2 rounded-2xl border border-white/10 bg-white/6 px-5 py-2.5 text-sm font-bold text-white hover:bg-white/10 transition">
                <i data-lucide="upload" style="height:16px;width:16px"></i>
                Upload Slider
            </a>
            <a href="{{ route('dashboard.genres.index') }}" class="flex items-center gap-2 rounded-2xl border border-white/10 bg-white/6 px-5 py-2.5 text-sm font-bold text-white hover:bg-white/10 transition">
                <i data-lucide="tag" style="height:16px;width:16px"></i>
                Manage Genres
            </a>
            <a href="{{ route('dashboard.episodes.index') }}" class="flex items-center gap-2 rounded-2xl border border-white/10 bg-white/6 px-5 py-2.5 text-sm font-bold text-white hover:bg-white/10 transition">
                <i data-lucide="play-circle" style="height:16px;width:16px"></i>
                Manage Episodes
            </a>
        </div>
    </div>

@endsection
