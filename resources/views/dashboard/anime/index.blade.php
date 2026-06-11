@extends('dashboard.layout')

@section('title', 'Anime')
@section('page-title', 'Anime Management')
@section('page-subtitle', 'Add, edit and manage all anime titles')

@section('content')

    {{-- Header --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <p class="text-sm text-slate-400">{{ $animes->total() }} total anime</p>
        <a href="{{ route('dashboard.anime.create') }}"
           class="flex items-center gap-2 rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-fuchsia-500/20 hover:opacity-90 transition">
            <i data-lucide="plus" style="height:16px;width:16px"></i>
            Add Anime
        </a>
    </div>

    @if($animes->isEmpty())
        <div class="flex flex-col items-center justify-center rounded-3xl border border-white/8 bg-white/[0.03] py-20 text-slate-500">
            <i data-lucide="tv-2" style="height:48px;width:48px" class="mb-4 opacity-30"></i>
            <p class="text-lg font-semibold">No anime yet</p>
            <p class="mt-1 text-sm">Start by adding your first title.</p>
            <a href="{{ route('dashboard.anime.create') }}" class="mt-5 rounded-2xl bg-violet-500/20 px-5 py-2.5 text-sm font-bold text-violet-400 hover:bg-violet-500/30 transition">
                Add Anime
            </a>
        </div>
    @else
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
            @foreach($animes as $anime)
                <div class="group relative flex flex-col overflow-hidden rounded-3xl border border-white/8 bg-white/[0.03] hover:bg-white/[0.06] transition">

                    {{-- Cover --}}
                    <div class="relative h-52 overflow-hidden bg-[#0f0f24]">
                        @if($anime->cover_image)
                            <img src="{{ Storage::url($anime->cover_image) }}" alt="{{ $anime->title }}"
                                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div class="flex h-full w-full items-center justify-center">
                                <i data-lucide="film" style="height:40px;width:40px" class="text-slate-700"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-[#080814] via-transparent to-transparent"></div>

                        {{-- Badges --}}
                        <div class="absolute left-3 top-3 flex gap-2">
                            @if($anime->is_featured)
                                <span class="rounded-full bg-fuchsia-500 px-2.5 py-0.5 text-[10px] font-bold text-white">Featured</span>
                            @endif
                            @if($anime->is_trending)
                                <span class="rounded-full bg-orange-500 px-2.5 py-0.5 text-[10px] font-bold text-white">Trending</span>
                            @endif
                        </div>

                        {{-- Status --}}
                        <span class="absolute right-3 top-3 rounded-full px-2.5 py-0.5 text-[10px] font-bold
                            {{ $anime->status === 'ongoing' ? 'bg-green-500/20 text-green-400' : ($anime->status === 'completed' ? 'bg-blue-500/20 text-blue-400' : 'bg-yellow-500/20 text-yellow-400') }}">
                            {{ ucfirst($anime->status) }}
                        </span>
                    </div>

                    {{-- Info --}}
                    <div class="flex flex-1 flex-col p-4">
                        <h3 class="line-clamp-1 font-black text-white">{{ $anime->title }}</h3>
                        <p class="mt-1 text-xs text-slate-500">
                            {{ $anime->release_year }} · {{ $anime->total_episodes }} eps · {{ $anime->episode_duration }}min
                        </p>

                        @if($anime->genres->isNotEmpty())
                            <div class="mt-2 flex flex-wrap gap-1.5">
                                @foreach($anime->genres->take(3) as $genre)
                                    <span class="rounded-full border border-white/10 bg-white/6 px-2 py-0.5 text-[10px] font-medium text-slate-400">
                                        {{ $genre->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="mt-3 flex items-center gap-1 text-xs text-slate-500">
                            <i data-lucide="star" style="height:12px;width:12px" class="fill-yellow-400 text-yellow-400"></i>
                            <span class="text-white font-semibold">{{ $anime->avg_rating }}</span>
                            <span>/ 10</span>
                        </div>

                        {{-- Actions --}}
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('dashboard.anime.edit', $anime) }}"
                               class="flex flex-1 items-center justify-center gap-1.5 rounded-xl border border-white/10 bg-white/6 py-2 text-xs font-semibold text-white hover:bg-white/12 transition">
                                <i data-lucide="pencil" style="height:12px;width:12px"></i>
                                Edit
                            </a>

                            <form method="POST" action="{{ route('dashboard.anime.destroy', $anime) }}"
                                  onsubmit="return confirm('Delete « {{ addslashes($anime->title) }} »? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="flex items-center justify-center gap-1.5 rounded-xl border border-red-500/20 bg-red-500/10 px-3 py-2 text-xs font-semibold text-red-400 hover:bg-red-500/20 transition">
                                    <i data-lucide="trash-2" style="height:12px;width:12px"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $animes->links() }}
        </div>
    @endif

@endsection
