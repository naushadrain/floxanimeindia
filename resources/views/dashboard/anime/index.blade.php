@extends('dashboard.layout')

@section('title', 'Anime')
@section('page-title', 'Anime Management')
@section('page-subtitle', 'Add, edit and manage all anime titles')

@section('content')

{{-- ── Header ───────────────────────────────────────────────────────────── --}}
<div class="mb-5 flex flex-wrap items-center justify-between gap-3">
    <p class="text-sm text-slate-400">{{ $animes->total() }} total anime</p>
    <a href="{{ route('dashboard.anime.create') }}"
       class="flex items-center gap-2 rounded-2xl bg-linear-to-r from-violet-500 to-fuchsia-500 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-fuchsia-500/20 hover:opacity-90 transition">
        <i data-lucide="plus" style="height:16px;width:16px"></i>
        Add Anime
    </a>
</div>

{{-- ── Anime Table ──────────────────────────────────────────────────────── --}}
<div class="rounded-3xl border border-white/8 bg-white/3 overflow-hidden">
    @if($animes->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 text-slate-500">
            <i data-lucide="tv-2" style="height:56px;width:56px" class="mb-4 opacity-30"></i>
            <p class="text-lg font-semibold">No anime yet</p>
            <p class="mt-1 text-sm">Start by adding your first title.</p>
            <a href="{{ route('dashboard.anime.create') }}"
               class="mt-5 rounded-2xl bg-violet-500/20 px-5 py-2.5 text-sm font-bold text-violet-400 hover:bg-violet-500/30 transition">
                Add Anime
            </a>
        </div>
    @else
        <table class="w-full text-sm">
            <thead class="border-b border-white/8 bg-white/2">
                <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <th class="px-6 py-3">Anime</th>
                    <th class="px-6 py-3 hidden md:table-cell">Genres</th>
                    <th class="px-6 py-3 hidden sm:table-cell text-center">Status</th>
                    <th class="px-6 py-3 hidden lg:table-cell text-center">Episodes</th>
                    <th class="px-6 py-3 hidden lg:table-cell text-center">Year</th>
                    <th class="px-6 py-3 hidden xl:table-cell text-center">Rating</th>
                    <th class="px-6 py-3 hidden xl:table-cell text-center">Flags</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($animes as $anime)
                    <tr class="hover:bg-white/3 transition">
                        {{-- Cover + title --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($anime->cover_image)
                                    <img src="{{ Storage::url($anime->cover_image) }}" alt="{{ $anime->title }}"
                                         class="h-14 w-10 shrink-0 rounded-xl object-cover">
                                @else
                                    <div class="flex h-14 w-10 shrink-0 items-center justify-center rounded-xl bg-linear-to-br from-violet-500 to-fuchsia-500">
                                        <i data-lucide="film" style="height:16px;width:16px" class="text-white"></i>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="font-black text-white line-clamp-1">{{ $anime->title }}</p>
                                    @if($anime->studio)
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $anime->studio }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Genres --}}
                        <td class="hidden px-6 py-4 md:table-cell">
                            <div class="flex flex-wrap gap-1">
                                @foreach($anime->genres->take(3) as $genre)
                                    <span class="rounded-full border border-white/10 bg-white/5 px-2 py-0.5 text-[10px] font-medium text-slate-400">
                                        {{ $genre->name }}
                                    </span>
                                @endforeach
                                @if($anime->genres->count() > 3)
                                    <span class="rounded-full bg-white/5 px-2 py-0.5 text-[10px] text-slate-600">+{{ $anime->genres->count() - 3 }}</span>
                                @endif
                            </div>
                        </td>

                        {{-- Status --}}
                        <td class="hidden px-6 py-4 text-center sm:table-cell">
                            <span class="rounded-full px-2.5 py-0.5 text-[10px] font-bold
                                {{ $anime->status === 'ongoing'   ? 'bg-green-500/20 text-green-400'  :
                                   ($anime->status === 'completed' ? 'bg-blue-500/20 text-blue-400'   :
                                                                     'bg-yellow-500/20 text-yellow-400') }}">
                                {{ ucfirst($anime->status) }}
                            </span>
                        </td>

                        {{-- Episodes --}}
                        <td class="hidden px-6 py-4 text-center text-slate-400 lg:table-cell">
                            {{ $anime->total_episodes }} ep
                        </td>

                        {{-- Year --}}
                        <td class="hidden px-6 py-4 text-center text-slate-400 lg:table-cell">
                            {{ $anime->release_year ?? '—' }}
                        </td>

                        {{-- Rating --}}
                        <td class="hidden px-6 py-4 xl:table-cell">
                            <div class="flex items-center justify-center gap-1">
                                <i data-lucide="star" style="height:12px;width:12px" class="fill-yellow-400 text-yellow-400"></i>
                                <span class="text-xs font-semibold text-white">{{ $anime->avg_rating }}</span>
                            </div>
                        </td>

                        {{-- Flags --}}
                        <td class="hidden px-6 py-4 xl:table-cell">
                            <div class="flex items-center justify-center gap-1.5">
                                @if($anime->is_featured)
                                    <span class="rounded-full bg-fuchsia-500/20 px-2 py-0.5 text-[10px] font-bold text-fuchsia-400">Featured</span>
                                @endif
                                @if($anime->is_trending)
                                    <span class="rounded-full bg-orange-500/20 px-2 py-0.5 text-[10px] font-bold text-orange-400">Trending</span>
                                @endif
                                @if(!$anime->is_featured && !$anime->is_trending)
                                    <span class="text-xs text-slate-600">—</span>
                                @endif
                            </div>
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('dashboard.anime.edit', $anime) }}"
                                   class="inline-flex items-center gap-1.5 rounded-xl border border-white/10 bg-white/6 px-3 py-1.5 text-xs font-semibold text-white hover:bg-white/10 transition">
                                    <i data-lucide="pencil" style="height:11px;width:11px"></i>
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('dashboard.anime.destroy', $anime) }}"
                                      onsubmit="return confirm('Delete « {{ addslashes($anime->title) }} »? This cannot be undone.')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-red-500/20 bg-red-500/10 px-3 py-1.5 text-xs font-semibold text-red-400 hover:bg-red-500/20 transition">
                                        <i data-lucide="trash-2" style="height:11px;width:11px"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-4 border-t border-white/8">
            {{ $animes->links() }}
        </div>
    @endif
</div>

@endsection
