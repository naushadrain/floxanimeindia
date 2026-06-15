@extends('dashboard.layout')

@section('title', 'Genres')
@section('page-title', 'Genre Management')
@section('page-subtitle', 'Manage anime categories and tags')

@section('content')

{{-- ── Add Genre Form ───────────────────────────────────────────────────── --}}
<div class="rounded-3xl border border-white/8 bg-white/3 p-6 mb-6">
    <h2 class="mb-5 text-sm font-black text-white flex items-center gap-2">
        <i data-lucide="plus-circle" style="height:16px;width:16px" class="text-violet-400"></i>
        Add New Genre
    </h2>

    <form method="POST" action="{{ route('dashboard.genres.store') }}">
        @csrf
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 items-end">
            <div class="sm:col-span-2 lg:col-span-3">
                <label class="form-label">Genre Name <span class="text-red-400">*</span></label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="e.g. Action, Romance, Sci-Fi…"
                       class="form-input">
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <button type="submit"
                        class="w-full rounded-2xl bg-linear-to-r from-violet-500 to-fuchsia-500 py-2.5 text-sm font-bold text-white shadow-lg shadow-fuchsia-500/20 hover:opacity-90 transition flex items-center justify-center gap-2">
                    <i data-lucide="plus" style="height:16px;width:16px"></i>
                    Add Genre
                </button>
            </div>
        </div>
    </form>

    {{-- Quick-add presets --}}
    @php
        $presets  = ['Action','Adventure','Comedy','Drama','Fantasy','Horror','Mecha','Mystery','Romance','Sci-Fi','Thriller','Slice of Life','Sports','Supernatural'];
        $existing = $genres->pluck('name')->toArray();
    @endphp
    @if(count(array_diff($presets, $existing)) > 0)
        <div class="mt-5 border-t border-white/8 pt-4">
            <p class="mb-2 text-xs font-semibold text-slate-500">Quick add presets</p>
            <div class="flex flex-wrap gap-1.5">
                @foreach($presets as $preset)
                    @if(!in_array($preset, $existing))
                        <form method="POST" action="{{ route('dashboard.genres.store') }}">
                            @csrf
                            <input type="hidden" name="name" value="{{ $preset }}">
                            <button type="submit"
                                    class="rounded-full border border-white/10 bg-white/4 px-2.5 py-1 text-[11px] font-semibold text-slate-400 hover:border-violet-500/40 hover:bg-violet-500/15 hover:text-violet-300 transition">
                                + {{ $preset }}
                            </button>
                        </form>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
</div>

{{-- ── Genre List ───────────────────────────────────────────────────────── --}}
<div class="rounded-3xl border border-white/8 bg-white/3 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-white/8">
        <h2 class="text-sm font-black text-white">All Genres</h2>
        <span class="rounded-full bg-violet-500/15 px-3 py-0.5 text-xs font-bold text-violet-400">{{ $genres->count() }} total</span>
    </div>

    @if($genres->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-slate-500">
            <i data-lucide="tag" style="height:48px;width:48px" class="mb-4 opacity-30"></i>
            <p class="font-semibold">No genres yet</p>
            <p class="text-sm mt-1">Add your first genre using the form above.</p>
        </div>
    @else
        <table class="w-full text-sm">
            <thead class="border-b border-white/8 bg-white/2">
                <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <th class="px-6 py-3 w-10">#</th>
                    <th class="px-6 py-3">Genre Name</th>
                    <th class="px-6 py-3 hidden sm:table-cell">Slug</th>
                    <th class="px-6 py-3 text-center">Anime Count</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($genres as $i => $genre)
                    <tr class="hover:bg-white/3 transition">
                        <td class="px-6 py-4 text-slate-600 text-xs">{{ $i + 1 }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-violet-500/15">
                                    <i data-lucide="tag" style="height:12px;width:12px" class="text-violet-400"></i>
                                </span>
                                <span class="font-semibold text-white">{{ $genre->name }}</span>
                            </div>
                        </td>
                        <td class="hidden px-6 py-4 font-mono text-xs text-slate-500 sm:table-cell">
                            {{ $genre->slug }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="rounded-full bg-violet-500/15 px-3 py-0.5 text-xs font-bold text-violet-400">
                                {{ $genre->animes_count }} anime
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form method="POST" action="{{ route('dashboard.genres.destroy', $genre) }}"
                                  onsubmit="return confirm('Delete genre « {{ addslashes($genre->name) }} »? This will detach it from all anime.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-red-500/20 bg-red-500/10 px-3 py-1.5 text-xs font-semibold text-red-400 hover:bg-red-500/20 transition">
                                    <i data-lucide="trash-2" style="height:12px;width:12px"></i>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
