@extends('dashboard.layout')

@section('title', 'Edit Episode')
@section('page-title', 'Edit Episode')
@section('page-subtitle', $episode->anime->title . ' — Episode ' . $episode->episode_number)

@section('content')

<div class="max-w-2xl">
    <form method="POST" action="{{ route('dashboard.episodes.update', $episode) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('PUT')

        <div class="rounded-3xl border border-white/8 bg-white/[0.03] p-6 space-y-4">

            <div>
                <label class="form-label">Anime <span class="text-red-400">*</span></label>
                <select name="anime_id" class="form-input">
                    @foreach($animes as $anime)
                        <option value="{{ $anime->id }}" {{ old('anime_id', $episode->anime_id) == $anime->id ? 'selected' : '' }}>
                            {{ $anime->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Episode #</label>
                    <input type="number" name="episode_number" value="{{ old('episode_number', $episode->episode_number) }}" min="1" class="form-input">
                </div>
                <div>
                    <label class="form-label">Duration (seconds)</label>
                    <input type="number" name="duration" value="{{ old('duration', $episode->duration) }}" min="0" class="form-input">
                </div>
            </div>

            <div>
                <label class="form-label">Title</label>
                <input type="text" name="title" value="{{ old('title', $episode->title) }}" class="form-input">
            </div>

            <div>
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-input resize-none">{{ old('description', $episode->description) }}</textarea>
            </div>

            <div>
                <label class="form-label">Video URL</label>
                <input type="url" name="video_url" value="{{ old('video_url', $episode->video_url) }}" class="form-input">
            </div>

            <div>
                <label class="form-label">Thumbnail</label>
                @if($episode->thumbnail)
                    <img src="{{ Storage::url($episode->thumbnail) }}" alt="thumbnail" class="mb-2 h-24 rounded-xl object-cover">
                @endif
                <input type="file" name="thumbnail" accept="image/*" class="form-input py-2 text-xs">
            </div>

            <div>
                <label class="form-label">Air Date</label>
                <input type="date" name="aired_at" value="{{ old('aired_at', $episode->aired_at?->format('Y-m-d')) }}" class="form-input">
            </div>

            <label class="flex items-center gap-2.5 cursor-pointer">
                <div class="relative">
                    <input type="hidden" name="is_filler" value="0">
                    <input type="checkbox" name="is_filler" value="1" {{ old('is_filler', $episode->is_filler) ? 'checked' : '' }} class="peer sr-only">
                    <div class="h-5 w-9 rounded-full bg-white/10 peer-checked:bg-yellow-500 transition"></div>
                    <div class="absolute top-0.5 left-0.5 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-4"></div>
                </div>
                <span class="text-sm text-slate-300">Mark as filler</span>
            </label>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="flex items-center gap-2 rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-7 py-3 font-bold text-white shadow-lg shadow-fuchsia-500/20 hover:opacity-90 transition">
                <i data-lucide="save" style="height:16px;width:16px"></i>
                Update Episode
            </button>
            <a href="{{ route('dashboard.episodes.index') }}"
               class="flex items-center gap-2 rounded-2xl border border-white/10 bg-white/6 px-7 py-3 font-bold text-white hover:bg-white/10 transition">
                Cancel
            </a>
        </div>
    </form>
</div>

<style>
    .form-label { @apply mb-1.5 block text-xs font-semibold text-slate-400; }
    .form-input  { @apply w-full rounded-2xl border border-white/10 bg-white/[0.06] px-4 py-2.5 text-sm text-white outline-none placeholder:text-slate-600 focus:border-violet-500/50 transition; }
    select.form-input option { background: #111122; }
    input[type="date"].form-input::-webkit-calendar-picker-indicator { filter: invert(1) opacity(0.5); }
</style>

@endsection
