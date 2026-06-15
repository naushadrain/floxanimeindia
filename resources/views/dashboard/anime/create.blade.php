@extends('dashboard.layout')

@section('title', 'Add Anime')
@section('page-title', 'Add New Anime')
@section('page-subtitle', 'Fill in the details to add a new anime title')

@section('content')

<form method="POST" action="{{ route('dashboard.anime.store') }}" enctype="multipart/form-data" class="space-y-5">
    @csrf

    {{-- ── Row 1: Images ───────────────────────────────────────────────── --}}
    <div class="grid gap-5 lg:grid-cols-2">

        <div class="rounded-3xl border border-white/8 bg-white/3 p-5">
            <p class="mb-3 text-sm font-black text-white">Cover Image</p>
            <label id="coverLabel"
                   class="flex h-52 w-full cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-white/15 bg-white/3 hover:border-violet-500/50 hover:bg-white/5 transition"
                   for="cover_image">
                <i data-lucide="image-plus" style="height:28px;width:28px" class="mb-2 text-slate-600"></i>
                <p class="text-xs font-semibold text-slate-500">Click to upload cover</p>
                <p class="mt-1 text-[10px] text-slate-600">JPG, PNG, WEBP · Max 4 MB</p>
            </label>
            <input type="file" name="cover_image" id="cover_image" accept="image/*" class="hidden"
                   onchange="previewImage(this,'coverPreview','coverLabel')">
            <img id="coverPreview" src="" alt="" class="mt-3 hidden h-52 w-full rounded-2xl object-cover">
            @error('cover_image') <p class="form-error mt-2">{{ $message }}</p> @enderror
        </div>

        <div class="rounded-3xl border border-white/8 bg-white/3 p-5">
            <p class="mb-3 text-sm font-black text-white">Banner Image</p>
            <label id="bannerLabel"
                   class="flex h-52 w-full cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-white/15 bg-white/3 hover:border-fuchsia-500/50 hover:bg-white/5 transition"
                   for="banner_image">
                <i data-lucide="panorama" style="height:28px;width:28px" class="mb-2 text-slate-600"></i>
                <p class="text-xs font-semibold text-slate-500">Click to upload banner</p>
                <p class="mt-1 text-[10px] text-slate-600">Wide image · Max 4 MB</p>
            </label>
            <input type="file" name="banner_image" id="banner_image" accept="image/*" class="hidden"
                   onchange="previewImage(this,'bannerPreview','bannerLabel')">
            <img id="bannerPreview" src="" alt="" class="mt-3 hidden h-52 w-full rounded-2xl object-cover">
            @error('banner_image') <p class="form-error mt-2">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- ── Row 2: Basic Info ────────────────────────────────────────────── --}}
    <div class="rounded-3xl border border-white/8 bg-white/3 p-5 space-y-4">
        <p class="text-sm font-black text-white">Basic Info</p>

        <div class="grid gap-4 lg:grid-cols-2">
            <div>
                <label class="form-label">Title <span class="text-red-400">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Demon Slayer" class="form-input">
                @error('title') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="form-label">Release Year</label>
                    <input type="number" name="release_year" value="{{ old('release_year', date('Y')) }}" min="1900" max="2099" class="form-input">
                    @error('release_year') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Status <span class="text-red-400">*</span></label>
                    <select name="status" class="form-input">
                        <option value="ongoing"   {{ old('status','ongoing') === 'ongoing'   ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="upcoming"  {{ old('status') === 'upcoming'  ? 'selected' : '' }}>Upcoming</option>
                    </select>
                    @error('status') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div>
            <label class="form-label">Description / Synopsis</label>
            <textarea name="description" rows="3" placeholder="Brief synopsis of the anime…" class="form-input">{{ old('description') }}</textarea>
            @error('description') <p class="form-error">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- ── Row 3: Details ──────────────────────────────────────────────── --}}
    <div class="rounded-3xl border border-white/8 bg-white/3 p-5 space-y-4">
        <p class="text-sm font-black text-white">Details</p>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <label class="form-label">Total Episodes</label>
                <input type="number" name="total_episodes" value="{{ old('total_episodes', 0) }}" min="0" class="form-input">
            </div>
            <div>
                <label class="form-label">Episode Duration (min)</label>
                <input type="number" name="episode_duration" value="{{ old('episode_duration', 24) }}" min="0" class="form-input">
            </div>
            <div>
                <label class="form-label">Studio</label>
                <input type="text" name="studio" value="{{ old('studio') }}" placeholder="e.g. ufotable" class="form-input">
            </div>
            <div>
                <label class="form-label">Director</label>
                <input type="text" name="director" value="{{ old('director') }}" placeholder="Director name" class="form-input">
            </div>
        </div>

        <div>
            <label class="form-label">Trailer URL</label>
            <input type="url" name="trailer_url" value="{{ old('trailer_url') }}" placeholder="https://youtube.com/watch?v=…" class="form-input">
            @error('trailer_url') <p class="form-error">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- ── Row 4: Genres ───────────────────────────────────────────────── --}}
    <div class="rounded-3xl border border-white/8 bg-white/3 p-5">
        <p class="mb-3 text-sm font-black text-white">Genres</p>
        @if($genres->isEmpty())
            <p class="text-sm text-slate-500">No genres available. <a href="{{ route('dashboard.genres.index') }}" class="text-violet-400 hover:underline">Add genres first →</a></p>
        @else
            <div class="flex flex-wrap gap-2">
                @foreach($genres as $genre)
                    <label class="cursor-pointer">
                        <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                               {{ in_array($genre->id, old('genres', [])) ? 'checked' : '' }}
                               class="peer hidden">
                        <span class="inline-block rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-semibold text-slate-400 transition peer-checked:border-violet-500/50 peer-checked:bg-violet-500/20 peer-checked:text-violet-300">
                            {{ $genre->name }}
                        </span>
                    </label>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ── Row 5: Visibility ───────────────────────────────────────────── --}}
    <div class="rounded-3xl border border-white/8 bg-white/3 p-5">
        <p class="mb-4 text-sm font-black text-white">Visibility Flags</p>
        <div class="flex flex-wrap gap-6">
            <label class="flex items-center gap-2.5 cursor-pointer">
                <div class="relative">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="peer sr-only">
                    <div class="h-5 w-9 rounded-full bg-white/10 peer-checked:bg-fuchsia-500 transition"></div>
                    <div class="absolute top-0.5 left-0.5 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-4"></div>
                </div>
                <span class="text-sm text-slate-300">Featured (shown in hero slider)</span>
            </label>
            <label class="flex items-center gap-2.5 cursor-pointer">
                <div class="relative">
                    <input type="hidden" name="is_trending" value="0">
                    <input type="checkbox" name="is_trending" value="1" {{ old('is_trending') ? 'checked' : '' }} class="peer sr-only">
                    <div class="h-5 w-9 rounded-full bg-white/10 peer-checked:bg-orange-500 transition"></div>
                    <div class="absolute top-0.5 left-0.5 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-4"></div>
                </div>
                <span class="text-sm text-slate-300">Trending (shown in trending row)</span>
            </label>
        </div>
    </div>

    {{-- ── Submit ───────────────────────────────────────────────────────── --}}
    <div class="flex gap-3">
        <button type="submit"
                class="flex items-center gap-2 rounded-2xl bg-linear-to-r from-violet-500 to-fuchsia-500 px-8 py-3 font-bold text-white shadow-lg shadow-fuchsia-500/20 hover:opacity-90 transition">
            <i data-lucide="save" style="height:16px;width:16px"></i>
            Save Anime
        </button>
        <a href="{{ route('dashboard.anime.index') }}"
           class="flex items-center gap-2 rounded-2xl border border-white/10 bg-white/6 px-8 py-3 font-bold text-white hover:bg-white/10 transition">
            Cancel
        </a>
    </div>
</form>

@push('scripts')
<script>
    function previewImage(input, previewId, labelId) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (e) => {
            const preview = document.getElementById(previewId);
            const label   = document.getElementById(labelId);
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            label.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
</script>
@endpush

@endsection
