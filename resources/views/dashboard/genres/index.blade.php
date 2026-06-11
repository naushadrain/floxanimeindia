@extends('dashboard.layout')

@section('title', 'Genres')
@section('page-title', 'Genre Management')
@section('page-subtitle', 'Manage anime categories and tags')

@section('content')

<div class="grid gap-6 xl:grid-cols-[1fr_320px]">

    {{-- ── Genre List ───────────────────────────────────────────────────── --}}
    <div class="rounded-3xl border border-white/8 bg-white/[0.03] p-5">
        <h2 class="mb-4 text-sm font-black text-white">All Genres ({{ $genres->count() }})</h2>

        @if($genres->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-slate-500">
                <i data-lucide="tag" style="height:40px;width:40px" class="mb-3 opacity-30"></i>
                <p class="font-semibold">No genres yet</p>
                <p class="text-sm mt-1">Add your first genre using the form.</p>
            </div>
        @else
            <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($genres as $genre)
                    <div class="flex items-center justify-between gap-3 rounded-2xl border border-white/8 bg-white/[0.03] px-4 py-3 hover:bg-white/[0.06] transition">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-white">{{ $genre->name }}</p>
                            <p class="text-xs text-slate-500">{{ $genre->animes_count }} anime</p>
                        </div>
                        <form method="POST" action="{{ route('dashboard.genres.destroy', $genre) }}"
                              onsubmit="return confirm('Delete genre « {{ addslashes($genre->name) }} »?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="shrink-0 rounded-xl p-1.5 text-slate-600 hover:bg-red-500/15 hover:text-red-400 transition">
                                <i data-lucide="trash-2" style="height:14px;width:14px"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ── Add Genre Form ───────────────────────────────────────────────── --}}
    <div class="rounded-3xl border border-white/8 bg-white/[0.03] p-5 h-fit">
        <h2 class="mb-5 text-sm font-black text-white flex items-center gap-2">
            <i data-lucide="plus-circle" style="height:16px;width:16px" class="text-violet-400"></i>
            Add New Genre
        </h2>

        <form method="POST" action="{{ route('dashboard.genres.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-slate-400">Genre Name <span class="text-red-400">*</span></label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="e.g. Action, Romance…"
                       class="w-full rounded-2xl border border-white/10 bg-white/[0.06] px-4 py-2.5 text-sm text-white outline-none placeholder:text-slate-600 focus:border-violet-500/50 transition">
                @error('name')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 py-3 text-sm font-bold text-white shadow-lg shadow-fuchsia-500/20 hover:opacity-90 transition flex items-center justify-center gap-2">
                <i data-lucide="plus" style="height:16px;width:16px"></i>
                Add Genre
            </button>
        </form>

        {{-- Quick add preset genres --}}
        <div class="mt-5">
            <p class="mb-2 text-xs font-semibold text-slate-500">Quick add presets</p>
            <div class="flex flex-wrap gap-1.5">
                @php
                    $presets = ['Action','Adventure','Comedy','Drama','Fantasy','Horror','Mecha','Mystery','Romance','Sci-Fi','Thriller','Slice of Life','Sports','Supernatural'];
                    $existing = $genres->pluck('name')->toArray();
                @endphp
                @foreach($presets as $preset)
                    @if(!in_array($preset, $existing))
                        <form method="POST" action="{{ route('dashboard.genres.store') }}">
                            @csrf
                            <input type="hidden" name="name" value="{{ $preset }}">
                            <button type="submit"
                                    class="rounded-full border border-white/10 bg-white/[0.04] px-2.5 py-1 text-[11px] font-semibold text-slate-400 hover:border-violet-500/40 hover:bg-violet-500/15 hover:text-violet-300 transition">
                                + {{ $preset }}
                            </button>
                        </form>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
