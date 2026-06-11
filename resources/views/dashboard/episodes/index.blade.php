@extends('dashboard.layout')

@section('title', 'Episodes')
@section('page-title', 'Episode Management')
@section('page-subtitle', 'Add and manage anime episodes')

@section('content')

<div class="grid gap-8 xl:grid-cols-[1fr_360px]">

    {{-- ── Episode List ─────────────────────────────────────────────────── --}}
    <div>
        {{-- Filter bar --}}
        <form method="GET" action="{{ route('dashboard.episodes.index') }}" class="mb-4 flex gap-3">
            <select name="anime_id" class="rounded-2xl border border-white/10 bg-white/[0.06] px-4 py-2.5 text-sm text-white outline-none focus:border-violet-500/50 transition flex-1"
                    onchange="this.form.submit()">
                <option value="">All Anime</option>
                @foreach($animes as $anime)
                    <option value="{{ $anime->id }}" {{ request('anime_id') == $anime->id ? 'selected' : '' }}>
                        {{ $anime->title }}
                    </option>
                @endforeach
            </select>
        </form>

        @if($episodes->isEmpty())
            <div class="flex flex-col items-center justify-center rounded-3xl border border-white/8 bg-white/[0.03] py-16 text-slate-500">
                <i data-lucide="play-circle" style="height:40px;width:40px" class="mb-3 opacity-30"></i>
                <p class="font-semibold">No episodes yet</p>
                <p class="text-sm mt-1">Add your first episode using the form.</p>
            </div>
        @else
            <div class="rounded-3xl border border-white/8 bg-white/[0.03] overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="border-b border-white/8">
                        <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            <th class="px-5 py-3">#</th>
                            <th class="px-5 py-3">Anime</th>
                            <th class="px-5 py-3">Title</th>
                            <th class="px-5 py-3 hidden sm:table-cell">Duration</th>
                            <th class="px-5 py-3 hidden md:table-cell">Aired</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($episodes as $episode)
                            <tr class="hover:bg-white/[0.03] transition">
                                <td class="px-5 py-3 text-slate-400 font-mono">
                                    {{ $episode->episode_number }}
                                    @if($episode->is_filler)
                                        <span class="ml-1 rounded-full bg-yellow-500/15 px-1.5 text-[9px] font-bold text-yellow-400">FILLER</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    <p class="line-clamp-1 font-semibold text-white max-w-[140px]">{{ $episode->anime->title }}</p>
                                </td>
                                <td class="px-5 py-3 text-slate-300">
                                    {{ $episode->title ?: 'Episode ' . $episode->episode_number }}
                                </td>
                                <td class="hidden px-5 py-3 text-slate-400 sm:table-cell">
                                    {{ $episode->duration ? gmdate('i:s', $episode->duration) : '—' }}
                                </td>
                                <td class="hidden px-5 py-3 text-slate-400 md:table-cell">
                                    {{ $episode->aired_at?->format('d M Y') ?? '—' }}
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('dashboard.episodes.edit', $episode) }}"
                                           class="rounded-xl border border-white/10 bg-white/6 px-3 py-1.5 text-xs font-semibold text-white hover:bg-white/12 transition">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('dashboard.episodes.destroy', $episode) }}"
                                              onsubmit="return confirm('Delete this episode?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="rounded-xl border border-red-500/20 bg-red-500/10 px-3 py-1.5 text-xs font-semibold text-red-400 hover:bg-red-500/20 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $episodes->withQueryString()->links() }}
            </div>
        @endif
    </div>

    {{-- ── Add Episode Form ─────────────────────────────────────────────── --}}
    <div class="rounded-3xl border border-white/8 bg-white/[0.03] p-5 h-fit">
        <h2 class="mb-5 text-sm font-black text-white flex items-center gap-2">
            <i data-lucide="plus-circle" style="height:16px;width:16px" class="text-violet-400"></i>
            Add Episode
        </h2>

        <form method="POST" action="{{ route('dashboard.episodes.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="form-label">Anime <span class="text-red-400">*</span></label>
                <select name="anime_id" class="form-input">
                    <option value="">Select anime…</option>
                    @foreach($animes as $anime)
                        <option value="{{ $anime->id }}" {{ old('anime_id') == $anime->id ? 'selected' : '' }}>
                            {{ $anime->title }}
                        </option>
                    @endforeach
                </select>
                @error('anime_id') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="form-label">Episode # <span class="text-red-400">*</span></label>
                    <input type="number" name="episode_number" value="{{ old('episode_number', 1) }}" min="1" class="form-input">
                    @error('episode_number') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Duration (sec)</label>
                    <input type="number" name="duration" value="{{ old('duration') }}" min="0" placeholder="e.g. 1440" class="form-input">
                </div>
            </div>

            <div>
                <label class="form-label">Title</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Episode title" class="form-input">
            </div>

            <div>
                <label class="form-label">Description</label>
                <textarea name="description" rows="2" class="form-input resize-none" placeholder="Brief description…">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="form-label">Video URL</label>
                <input type="url" name="video_url" value="{{ old('video_url') }}" placeholder="https://..." class="form-input">
                @error('video_url') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Thumbnail</label>
                <input type="file" name="thumbnail" accept="image/*" class="form-input py-2 text-xs">
            </div>

            <div>
                <label class="form-label">Air Date</label>
                <input type="date" name="aired_at" value="{{ old('aired_at') }}" class="form-input">
            </div>

            <label class="flex items-center gap-2.5 cursor-pointer">
                <div class="relative">
                    <input type="hidden" name="is_filler" value="0">
                    <input type="checkbox" name="is_filler" value="1" {{ old('is_filler') ? 'checked' : '' }} class="peer sr-only">
                    <div class="h-5 w-9 rounded-full bg-white/10 peer-checked:bg-yellow-500 transition"></div>
                    <div class="absolute top-0.5 left-0.5 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-4"></div>
                </div>
                <span class="text-sm text-slate-300">Mark as filler</span>
            </label>

            <button type="submit"
                    class="w-full rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 py-3 text-sm font-bold text-white shadow-lg shadow-fuchsia-500/20 hover:opacity-90 transition flex items-center justify-center gap-2">
                <i data-lucide="plus" style="height:16px;width:16px"></i>
                Add Episode
            </button>
        </form>
    </div>
</div>

<style>
    .form-label { @apply mb-1.5 block text-xs font-semibold text-slate-400; }
    .form-input  { @apply w-full rounded-2xl border border-white/10 bg-white/[0.06] px-4 py-2.5 text-sm text-white outline-none placeholder:text-slate-600 focus:border-violet-500/50 transition; }
    .form-error  { @apply mt-1 text-xs text-red-400; }
    select.form-input option { background: #111122; }
    input[type="date"].form-input::-webkit-calendar-picker-indicator { filter: invert(1) opacity(0.5); }
</style>

@endsection
