@extends('dashboard.layout')

@section('title', 'Episodes')
@section('page-title', 'Episode Management')
@section('page-subtitle', 'Add and manage anime episodes with video streams')

@section('content')

{{-- ── Add Episode Form ─────────────────────────────────────────────────── --}}
<div class="rounded-3xl border border-white/8 bg-white/3 p-6 mb-6">
    <h2 class="mb-5 text-sm font-black text-white flex items-center gap-2">
        <i data-lucide="plus-circle" style="height:16px;width:16px" class="text-violet-400"></i>
        Add New Episode
    </h2>

    <form method="POST" action="{{ route('dashboard.episodes.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Row 1: Anime + Episode # + Duration --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-4">
            <div class="lg:col-span-2">
                <label class="form-label">Anime <span class="text-red-400">*</span></label>
                <select name="anime_id" class="form-input">
                    <option value="">— Select anime —</option>
                    @foreach($animes as $anime)
                        <option value="{{ $anime->id }}" {{ old('anime_id') == $anime->id ? 'selected' : '' }}>
                            {{ $anime->title }}
                        </option>
                    @endforeach
                </select>
                @error('anime_id') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">Episode # <span class="text-red-400">*</span></label>
                <input type="number" name="episode_number" value="{{ old('episode_number', 1) }}" min="1" class="form-input">
                @error('episode_number') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">Duration (seconds)</label>
                <input type="number" name="duration" value="{{ old('duration') }}" min="0" placeholder="e.g. 1440" class="form-input">
            </div>
        </div>

        {{-- Row 2: Title + Air Date --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-4">
            <div class="lg:col-span-2">
                <label class="form-label">Episode Title</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Episode title (optional)" class="form-input">
            </div>
            <div>
                <label class="form-label">Air Date</label>
                <input type="date" name="aired_at" value="{{ old('aired_at') }}" class="form-input">
            </div>
            <div class="flex items-end">
                <label class="flex items-center gap-2.5 cursor-pointer pb-2.5">
                    <div class="relative">
                        <input type="hidden" name="is_filler" value="0">
                        <input type="checkbox" name="is_filler" value="1" {{ old('is_filler') ? 'checked' : '' }} class="peer sr-only">
                        <div class="h-5 w-9 rounded-full bg-white/10 peer-checked:bg-yellow-500 transition"></div>
                        <div class="absolute top-0.5 left-0.5 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-4"></div>
                    </div>
                    <span class="text-sm text-slate-300">Mark as filler</span>
                </label>
            </div>
        </div>

        {{-- Row 3: Video URL + Thumbnail --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-4">
            <div class="lg:col-span-2">
                <label class="form-label">Video Stream URL</label>
                <input type="url" name="video_url" value="{{ old('video_url') }}" placeholder="https://stream.example.com/ep1.m3u8" class="form-input">
                @error('video_url') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div class="lg:col-span-2">
                <label class="form-label">Thumbnail Image</label>
                <input type="file" name="thumbnail" accept="image/*" class="form-input py-2 text-xs">
                @error('thumbnail') <p class="form-error">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Row 4: Description --}}
        <div class="mb-5">
            <label class="form-label">Description</label>
            <textarea name="description" rows="2" placeholder="Brief synopsis of this episode…" class="form-input">{{ old('description') }}</textarea>
        </div>

        <button type="submit"
                class="flex items-center gap-2 rounded-2xl bg-linear-to-r from-violet-500 to-fuchsia-500 px-7 py-3 text-sm font-bold text-white shadow-lg shadow-fuchsia-500/20 hover:opacity-90 transition">
            <i data-lucide="plus" style="height:16px;width:16px"></i>
            Add Episode
        </button>
    </form>
</div>

{{-- ── Episode List ─────────────────────────────────────────────────────── --}}
<div class="rounded-3xl border border-white/8 bg-white/3 overflow-hidden">
    <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-b border-white/8">
        <h2 class="text-sm font-black text-white">All Episodes</h2>
        <form method="GET" action="{{ route('dashboard.episodes.index') }}" class="flex items-center gap-2">
            <select name="anime_id" class="rounded-xl border border-white/10 bg-white/6 px-3 py-1.5 text-xs text-white outline-none focus:border-violet-500/50 transition" onchange="this.form.submit()">
                <option value="">All Anime</option>
                @foreach($animes as $anime)
                    <option value="{{ $anime->id }}" {{ request('anime_id') == $anime->id ? 'selected' : '' }}>
                        {{ $anime->title }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    @if($episodes->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-slate-500">
            <i data-lucide="play-circle" style="height:48px;width:48px" class="mb-4 opacity-30"></i>
            <p class="font-semibold">No episodes found</p>
            <p class="text-sm mt-1">Add your first episode using the form above.</p>
        </div>
    @else
        <table class="w-full text-sm">
            <thead class="border-b border-white/8 bg-white/2">
                <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Anime</th>
                    <th class="px-6 py-3">Episode Title</th>
                    <th class="px-6 py-3 hidden md:table-cell">Video URL</th>
                    <th class="px-6 py-3 hidden sm:table-cell text-center">Duration</th>
                    <th class="px-6 py-3 hidden lg:table-cell text-center">Aired</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($episodes as $episode)
                    <tr class="hover:bg-white/3 transition">
                        <td class="px-6 py-4">
                            <span class="font-mono text-sm font-bold text-white">{{ $episode->episode_number }}</span>
                            @if($episode->is_filler)
                                <span class="ml-1 rounded-full bg-yellow-500/15 px-1.5 py-0.5 text-[9px] font-bold text-yellow-400">FILLER</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="line-clamp-1 font-semibold text-white max-w-40">{{ $episode->anime->title }}</p>
                        </td>
                        <td class="px-6 py-4 text-slate-300">
                            {{ $episode->title ?: '— untitled —' }}
                        </td>
                        <td class="hidden px-6 py-4 md:table-cell">
                            @if($episode->video_url)
                                <a href="{{ $episode->video_url }}" target="_blank"
                                   class="inline-flex items-center gap-1 rounded-lg bg-green-500/10 px-2 py-1 text-xs font-semibold text-green-400 hover:bg-green-500/20 transition">
                                    <i data-lucide="play" style="height:10px;width:10px"></i>
                                    Stream
                                </a>
                            @else
                                <span class="text-xs text-slate-600">No URL</span>
                            @endif
                        </td>
                        <td class="hidden px-6 py-4 text-center text-slate-400 sm:table-cell">
                            {{ $episode->duration ? gmdate('i:s', $episode->duration) : '—' }}
                        </td>
                        <td class="hidden px-6 py-4 text-center text-slate-400 lg:table-cell">
                            {{ $episode->aired_at?->format('d M Y') ?? '—' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('dashboard.episodes.edit', $episode) }}"
                                   class="inline-flex items-center gap-1.5 rounded-xl border border-white/10 bg-white/6 px-3 py-1.5 text-xs font-semibold text-white hover:bg-white/10 transition">
                                    <i data-lucide="pencil" style="height:11px;width:11px"></i>
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('dashboard.episodes.destroy', $episode) }}"
                                      onsubmit="return confirm('Delete this episode?')">
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
            {{ $episodes->withQueryString()->links() }}
        </div>
    @endif
</div>

@endsection
