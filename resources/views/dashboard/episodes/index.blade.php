@extends('dashboard.layout')

@section('title', 'Videos')
@section('page-title', 'Video Management')
@section('page-subtitle', 'Upload & manage episode video URLs')

@section('header-actions')
    <div class="flex items-center gap-2">
        <span class="rounded-full border border-cyan-500/25 bg-cyan-500/10 px-3 py-1 text-[11px] font-semibold text-cyan-300">
            {{ $episodes->total() }} Videos
        </span>
    </div>
@endsection

{{-- No padding wrapper — we handle padding ourselves inside the two-column panel --}}
@section('main-class', 'flex-1 overflow-hidden')

@section('content')

<div class="flex h-full overflow-hidden" style="height: calc(100vh - 60px);">

    {{-- ══════════════════════════════════════════════════════════════════════
         LEFT PANEL — Category-filtered video list
    ══════════════════════════════════════════════════════════════════════ --}}
    <aside class="flex w-80 shrink-0 flex-col overflow-hidden border-r border-white/8 bg-[#080814]">

        {{-- Panel header --}}
        <div class="border-b border-white/8 px-4 py-4">
            <p class="text-xs font-black uppercase tracking-widest text-slate-500 mb-3">Filter by Category</p>

            {{-- Category chips --}}
            <div class="flex flex-wrap gap-1.5">
                <a href="{{ route('dashboard.episodes.index', request()->except('genre_id')) }}"
                   class="rounded-full px-3 py-1 text-[11px] font-semibold transition
                          {{ !request('genre_id') ? 'bg-violet-500 text-white' : 'bg-white/6 text-slate-400 hover:bg-white/10 hover:text-white' }}">
                    All
                </a>
                @foreach($genres as $genre)
                    <a href="{{ route('dashboard.episodes.index', array_merge(request()->except('genre_id','page'), ['genre_id' => $genre->id])) }}"
                       class="rounded-full px-3 py-1 text-[11px] font-semibold transition
                              {{ request('genre_id') == $genre->id
                                  ? 'bg-fuchsia-500 text-white'
                                  : 'bg-white/6 text-slate-400 hover:bg-white/10 hover:text-white' }}">
                        {{ $genre->name }}
                        <span class="opacity-60">({{ $genre->animes_count }})</span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Anime quick-filter --}}
        <div class="border-b border-white/8 px-4 py-3">
            <form method="GET" action="{{ route('dashboard.episodes.index') }}">
                @if(request('genre_id'))
                    <input type="hidden" name="genre_id" value="{{ request('genre_id') }}">
                @endif
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-slate-500"></i>
                    <select name="anime_id" onchange="this.form.submit()"
                            class="form-input pl-9 py-2 text-xs">
                        <option value="">All Anime</option>
                        @foreach($animes as $anime)
                            <option value="{{ $anime->id }}" {{ request('anime_id') == $anime->id ? 'selected' : '' }}>
                                {{ $anime->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        {{-- Episode list (scrollable) --}}
        <div class="flex-1 overflow-y-auto px-3 py-3 space-y-1.5">

            @if($episodes->isEmpty())
                <div class="flex flex-col items-center justify-center py-16 text-slate-600">
                    <i data-lucide="video-off" class="mb-3 h-9 w-9 opacity-40"></i>
                    <p class="text-sm font-semibold text-slate-500">No videos yet</p>
                    <p class="mt-1 text-xs text-slate-600 text-center">Add your first episode using the form →</p>
                </div>
            @else
                @php
                    $grouped = $episodes->groupBy(fn($ep) => $ep->anime?->genres?->first()?->name ?? 'Uncategorised');
                @endphp

                @foreach($grouped as $category => $catEpisodes)
                    {{-- Category label --}}
                    <div class="flex items-center gap-2 px-2 pt-3 pb-1">
                        <div class="h-px flex-1 bg-white/8"></div>
                        <span class="rounded-full bg-fuchsia-500/15 px-2.5 py-0.5 text-[9px] font-black
                                     uppercase tracking-wider text-fuchsia-400">
                            {{ $category }}
                        </span>
                        <div class="h-px flex-1 bg-white/8"></div>
                    </div>

                    @foreach($catEpisodes as $episode)
                        <div class="group relative flex items-center gap-3 rounded-2xl border border-transparent
                                    bg-white/3 px-3 py-2.5 hover:border-white/10 hover:bg-white/6 transition">

                            {{-- Thumbnail or EP number --}}
                            <div class="relative shrink-0">
                                @php
                                    $thumb = $episode->thumbnail_url ?: ($episode->thumbnail ? Storage::url($episode->thumbnail) : null);
                                @endphp
                                @if($thumb)
                                    <img src="{{ $thumb }}" alt=""
                                         class="h-10 w-16 rounded-lg object-cover">
                                @else
                                    <div class="flex h-10 w-16 items-center justify-center rounded-lg
                                                bg-linear-to-br from-violet-500/30 to-fuchsia-500/30">
                                        <span class="text-xs font-black text-white">EP {{ $episode->episode_number }}</span>
                                    </div>
                                @endif
                                {{-- Video dot --}}
                                @if($episode->video_url)
                                    <span class="absolute -right-0.5 -top-0.5 h-2.5 w-2.5 rounded-full
                                                 bg-green-400 ring-2 ring-[#080814]"></span>
                                @else
                                    <span class="absolute -right-0.5 -top-0.5 h-2.5 w-2.5 rounded-full
                                                 bg-red-400 ring-2 ring-[#080814]"></span>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-[12px] font-bold text-white leading-tight">
                                    {{ $episode->anime?->title ?? '—' }}
                                </p>
                                <p class="mt-0.5 truncate text-[10px] text-slate-400">
                                    EP {{ $episode->episode_number }}
                                    @if($episode->title) · {{ $episode->title }} @endif
                                </p>
                                @if($episode->is_filler)
                                    <span class="rounded-full bg-yellow-500/15 px-1.5 py-px text-[9px]
                                                 font-bold text-yellow-400">FILLER</span>
                                @endif
                            </div>

                            {{-- Actions (visible on hover) --}}
                            <div class="flex shrink-0 flex-col gap-1 opacity-0 group-hover:opacity-100 transition">
                                <a href="{{ route('dashboard.episodes.edit', $episode) }}"
                                   class="flex h-6 w-6 items-center justify-center rounded-lg
                                          bg-white/8 text-slate-300 hover:bg-white/15 transition">
                                    <i data-lucide="pencil" class="h-3 w-3"></i>
                                </a>
                                <form method="POST" action="{{ route('dashboard.episodes.destroy', $episode) }}"
                                      onsubmit="return confirm('Delete EP {{ $episode->episode_number }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="flex h-6 w-6 items-center justify-center rounded-lg
                                                   bg-red-500/10 text-red-400 hover:bg-red-500/20 transition">
                                        <i data-lucide="trash-2" class="h-3 w-3"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endforeach

                {{-- Pagination --}}
                @if($episodes->hasPages())
                    <div class="pt-3">
                        {{ $episodes->withQueryString()->links() }}
                    </div>
                @endif
            @endif
        </div>
    </aside>

    {{-- ══════════════════════════════════════════════════════════════════════
         RIGHT PANEL — URL Upload Form
    ══════════════════════════════════════════════════════════════════════ --}}
    <main class="flex-1 overflow-y-auto bg-[#070713] p-6">

        {{-- Flash inside panel --}}
        @if (session('success'))
            <div class="mb-5 flex items-center gap-3 rounded-2xl border border-green-500/25
                        bg-green-500/8 px-4 py-3 text-sm text-green-400">
                <i data-lucide="check-circle-2" class="h-4 w-4 shrink-0"></i>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-5 flex items-center gap-3 rounded-2xl border border-red-500/25
                        bg-red-500/8 px-4 py-3 text-sm text-red-400">
                <i data-lucide="alert-circle" class="h-4 w-4 shrink-0"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="mx-auto max-w-xl">

            {{-- Form card --}}
            <div class="rounded-3xl border border-white/8 bg-white/2 overflow-hidden">

                {{-- Card header --}}
                <div class="flex items-center gap-4 border-b border-white/8
                            bg-linear-to-r from-cyan-500/10 to-violet-500/5 px-6 py-5">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl
                                bg-linear-to-br from-cyan-500 to-violet-500 shadow-lg shadow-cyan-500/25">
                        <i data-lucide="video" class="h-5 w-5 text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-black text-white">Upload Video Episode</h2>
                        <p class="text-[11px] text-slate-500">Paste a stream or YouTube URL to link the video</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('dashboard.episodes.store') }}"
                      class="p-6 space-y-5">
                    @csrf

                    {{-- ── Anime + Episode # ──────────────────────────────── --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="form-label">Anime <span class="text-red-400">*</span></label>
                            <div class="relative">
                                <i data-lucide="tv-2" class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500"></i>
                                <select name="anime_id" required class="form-input pl-9">
                                    <option value="">— Select anime —</option>
                                    @foreach($animes as $anime)
                                        <option value="{{ $anime->id }}"
                                                {{ old('anime_id') == $anime->id ? 'selected' : '' }}>
                                            {{ $anime->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('anime_id') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="form-label">Episode # <span class="text-red-400">*</span></label>
                            <input type="number" name="episode_number"
                                   value="{{ old('episode_number', 1) }}" min="1"
                                   required class="form-input text-center tabular-nums font-bold">
                            @error('episode_number') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="form-label">Duration <span class="text-slate-600">(seconds)</span></label>
                            <input type="number" name="duration"
                                   value="{{ old('duration') }}" min="0" max="86400"
                                   placeholder="e.g. 1440"
                                   class="form-input">
                            @error('duration') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- ── Episode Title ───────────────────────────────────── --}}
                    <div>
                        <label class="form-label">Episode Title</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               placeholder="e.g. The Final Battle (optional)"
                               class="form-input">
                    </div>

                    {{-- ── Video URL ───────────────────────────────────────── --}}
                    <div class="rounded-2xl border border-cyan-500/20 bg-cyan-500/5 p-4 space-y-3">
                        <p class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-cyan-400">
                            <i data-lucide="link-2" class="h-3.5 w-3.5"></i>
                            Video URL
                            <span class="text-red-400 normal-case tracking-normal font-semibold">* required</span>
                        </p>

                        <div>
                            <label class="form-label">Stream / Embed URL</label>
                            <div class="relative">
                                <i data-lucide="play-circle" class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-cyan-500"></i>
                                <input type="url" name="video_url" id="videoUrl"
                                       value="{{ old('video_url') }}"
                                       placeholder="https://www.youtube.com/embed/… or stream URL"
                                       required class="form-input pl-9 border-cyan-500/30 focus:border-cyan-500/60"
                                       oninput="previewVideoUrl(this.value)">
                            </div>
                            @error('video_url')
                                <p class="form-error">{{ $message }}</p>
                            @else
                                <p class="mt-1 text-[10px] text-slate-600">
                                    Supports YouTube embeds, HLS (.m3u8), MP4, or any stream URL
                                </p>
                            @enderror
                        </div>

                        {{-- Video preview badge --}}
                        <div id="urlPreviewBadge" class="hidden items-center gap-2 rounded-xl
                             border border-green-500/25 bg-green-500/8 px-3 py-2">
                            <i data-lucide="check-circle-2" class="h-3.5 w-3.5 text-green-400 shrink-0"></i>
                            <span id="urlPreviewText" class="truncate text-[11px] text-green-300"></span>
                        </div>
                    </div>

                    {{-- ── Thumbnail URL ───────────────────────────────────── --}}
                    <div>
                        <label class="form-label">Thumbnail URL <span class="text-slate-600">(optional)</span></label>
                        <div class="relative">
                            <i data-lucide="image" class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500"></i>
                            <input type="url" name="thumbnail_url"
                                   value="{{ old('thumbnail_url') }}"
                                   placeholder="https://example.com/thumbnail.jpg"
                                   class="form-input pl-9">
                        </div>
                        @error('thumbnail_url') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- ── Air Date + Description ──────────────────────────── --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Air Date</label>
                            <input type="date" name="aired_at" value="{{ old('aired_at') }}"
                                   class="form-input">
                        </div>
                        <div class="flex items-end pb-0.5">
                            <label class="flex cursor-pointer items-center gap-3">
                                <div class="relative shrink-0">
                                    <input type="hidden" name="is_filler" value="0">
                                    <input type="checkbox" name="is_filler" value="1"
                                           {{ old('is_filler') ? 'checked' : '' }}
                                           class="peer sr-only">
                                    <div class="h-5 w-9 rounded-full bg-white/10
                                                peer-checked:bg-yellow-500 transition"></div>
                                    <div class="absolute top-0.5 left-0.5 h-4 w-4 rounded-full bg-white
                                                transition peer-checked:translate-x-4"></div>
                                </div>
                                <span class="text-xs font-semibold text-slate-300">Filler episode</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3"
                                  placeholder="Brief synopsis of this episode…"
                                  class="form-input">{{ old('description') }}</textarea>
                        @error('description') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- ── Submit ──────────────────────────────────────────── --}}
                    <div class="flex items-center gap-3 border-t border-white/8 pt-5">
                        <button type="submit" class="btn-primary flex-1 justify-center py-3 text-sm">
                            <i data-lucide="upload-cloud" class="h-4 w-4"></i>
                            Upload Episode
                        </button>
                        <button type="reset" onclick="clearForm()"
                                class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3
                                       text-sm font-bold text-slate-400 hover:bg-white/10 transition">
                            Clear
                        </button>
                    </div>
                </form>
            </div>

            {{-- Help box --}}
            <div class="mt-5 rounded-2xl border border-white/6 bg-white/2 p-4">
                <p class="mb-3 text-[11px] font-bold uppercase tracking-widest text-slate-500">
                    Supported URL formats
                </p>
                <div class="space-y-2 text-[11px] text-slate-500">
                    <div class="flex items-start gap-2">
                        <span class="mt-0.5 rounded bg-red-500/15 px-1.5 py-0.5 font-bold text-red-400">YT</span>
                        <span>https://www.youtube.com/embed/<em class="text-slate-400">VIDEO_ID</em></span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="mt-0.5 rounded bg-blue-500/15 px-1.5 py-0.5 font-bold text-blue-400">HLS</span>
                        <span>https://cdn.example.com/anime/ep1.m3u8</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="mt-0.5 rounded bg-violet-500/15 px-1.5 py-0.5 font-bold text-violet-400">MP4</span>
                        <span>https://cdn.example.com/anime/ep1.mp4</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script>
    function previewVideoUrl(url) {
        const badge = document.getElementById('urlPreviewBadge');
        const text  = document.getElementById('urlPreviewText');
        if (!url) {
            badge.classList.add('hidden');
            badge.classList.remove('flex');
            return;
        }
        try {
            const parsed = new URL(url);
            text.textContent = parsed.hostname + parsed.pathname;
            badge.classList.remove('hidden');
            badge.classList.add('flex');
            lucide.createIcons();
        } catch {
            badge.classList.add('hidden');
            badge.classList.remove('flex');
        }
    }

    function clearForm() {
        document.getElementById('urlPreviewBadge').classList.add('hidden');
        document.getElementById('urlPreviewBadge').classList.remove('flex');
        document.getElementById('videoUrl').value = '';
    }
</script>
@endpush

@endsection
