@extends('dashboard.layout')

@section('title', 'Edit — ' . $anime->title)
@section('page-title', 'Edit Anime')
@section('page-subtitle', $anime->title)

@section('content')

<div class="max-w-4xl">
    <form method="POST" action="{{ route('dashboard.anime.update', $anime) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')

        <div class="grid gap-6 lg:grid-cols-3">

            {{-- ── Images ───────────────────────────────────────────────── --}}
            <div class="space-y-4">

                <div class="rounded-3xl border border-white/8 bg-white/[0.03] p-5">
                    <p class="mb-3 text-sm font-black text-white">Cover Image</p>
                    @if($anime->cover_image)
                        <img id="coverPreview" src="{{ Storage::url($anime->cover_image) }}" alt="{{ $anime->title }}"
                             class="h-52 w-full rounded-2xl object-cover">
                    @else
                        <img id="coverPreview" src="" alt="" class="hidden h-52 w-full rounded-2xl object-cover">
                    @endif
                    <label id="coverLabel" class="mt-3 flex cursor-pointer items-center justify-center gap-2 rounded-2xl border border-dashed border-white/15 py-2.5 text-xs font-semibold text-slate-500 hover:border-violet-500/50 hover:text-violet-400 transition" for="cover_image">
                        <i data-lucide="upload" style="height:14px;width:14px"></i>
                        Replace image
                    </label>
                    <input type="file" name="cover_image" id="cover_image" accept="image/*" class="hidden" onchange="previewImage(this,'coverPreview','coverLabel')">
                    @error('cover_image') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="rounded-3xl border border-white/8 bg-white/[0.03] p-5">
                    <p class="mb-3 text-sm font-black text-white">Banner Image</p>
                    @if($anime->banner_image)
                        <img id="bannerPreview" src="{{ Storage::url($anime->banner_image) }}" alt="{{ $anime->title }}"
                             class="h-28 w-full rounded-2xl object-cover">
                    @else
                        <img id="bannerPreview" src="" alt="" class="hidden h-28 w-full rounded-2xl object-cover">
                    @endif
                    <label id="bannerLabel" class="mt-3 flex cursor-pointer items-center justify-center gap-2 rounded-2xl border border-dashed border-white/15 py-2.5 text-xs font-semibold text-slate-500 hover:border-fuchsia-500/50 hover:text-fuchsia-400 transition" for="banner_image">
                        <i data-lucide="upload" style="height:14px;width:14px"></i>
                        Replace banner
                    </label>
                    <input type="file" name="banner_image" id="banner_image" accept="image/*" class="hidden" onchange="previewImage(this,'bannerPreview','bannerLabel')">
                </div>
            </div>

            {{-- ── Details ──────────────────────────────────────────────── --}}
            <div class="lg:col-span-2 space-y-4">

                <div class="rounded-3xl border border-white/8 bg-white/[0.03] p-5 space-y-4">
                    <p class="text-sm font-black text-white">Basic Info</p>

                    <div>
                        <label class="form-label">Title <span class="text-red-400">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $anime->title) }}" class="form-input">
                        @error('title') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="4" class="form-input resize-none">{{ old('description', $anime->description) }}</textarea>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="form-label">Release Year</label>
                            <input type="number" name="release_year" value="{{ old('release_year', $anime->release_year) }}" min="1900" max="2099" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Status <span class="text-red-400">*</span></label>
                            <select name="status" class="form-input">
                                @foreach(['ongoing','completed','upcoming'] as $s)
                                    <option value="{{ $s }}" {{ old('status', $anime->status) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-white/8 bg-white/[0.03] p-5 space-y-4">
                    <p class="text-sm font-black text-white">Details</p>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="form-label">Total Episodes</label>
                            <input type="number" name="total_episodes" value="{{ old('total_episodes', $anime->total_episodes) }}" min="0" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Episode Duration (min)</label>
                            <input type="number" name="episode_duration" value="{{ old('episode_duration', $anime->episode_duration) }}" min="0" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Studio</label>
                            <input type="text" name="studio" value="{{ old('studio', $anime->studio) }}" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Director</label>
                            <input type="text" name="director" value="{{ old('director', $anime->director) }}" class="form-input">
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Trailer URL</label>
                        <input type="url" name="trailer_url" value="{{ old('trailer_url', $anime->trailer_url) }}" placeholder="https://youtube.com/..." class="form-input">
                    </div>
                </div>

                <div class="rounded-3xl border border-white/8 bg-white/[0.03] p-5">
                    <p class="mb-3 text-sm font-black text-white">Genres</p>
                    <div class="flex flex-wrap gap-2">
                        @php $selectedGenres = old('genres', $anime->genres->pluck('id')->toArray()); @endphp
                        @foreach($genres as $genre)
                            <label class="cursor-pointer">
                                <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                       {{ in_array($genre->id, $selectedGenres) ? 'checked' : '' }} class="peer hidden">
                                <span class="inline-block rounded-full border border-white/10 bg-white/6 px-3 py-1.5 text-xs font-semibold text-slate-400 transition peer-checked:border-violet-500/50 peer-checked:bg-violet-500/20 peer-checked:text-violet-300">
                                    {{ $genre->name }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-3xl border border-white/8 bg-white/[0.03] p-5">
                    <p class="mb-3 text-sm font-black text-white">Visibility</p>
                    <div class="flex flex-wrap gap-4">
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <div class="relative">
                                <input type="hidden" name="is_featured" value="0">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $anime->is_featured) ? 'checked' : '' }} class="peer sr-only">
                                <div class="h-5 w-9 rounded-full bg-white/10 peer-checked:bg-fuchsia-500 transition"></div>
                                <div class="absolute top-0.5 left-0.5 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-4"></div>
                            </div>
                            <span class="text-sm text-slate-300">Featured</span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <div class="relative">
                                <input type="hidden" name="is_trending" value="0">
                                <input type="checkbox" name="is_trending" value="1" {{ old('is_trending', $anime->is_trending) ? 'checked' : '' }} class="peer sr-only">
                                <div class="h-5 w-9 rounded-full bg-white/10 peer-checked:bg-orange-500 transition"></div>
                                <div class="absolute top-0.5 left-0.5 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-4"></div>
                            </div>
                            <span class="text-sm text-slate-300">Trending</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="flex items-center gap-2 rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-7 py-3 font-bold text-white shadow-lg shadow-fuchsia-500/20 hover:opacity-90 transition">
                <i data-lucide="save" style="height:16px;width:16px"></i>
                Update Anime
            </button>
            <a href="{{ route('dashboard.anime.index') }}"
               class="flex items-center gap-2 rounded-2xl border border-white/10 bg-white/6 px-7 py-3 font-bold text-white hover:bg-white/10 transition">
                Cancel
            </a>
        </div>
    </form>
</div>

<style>
    .form-label { @apply mb-1.5 block text-xs font-semibold text-slate-400; }
    .form-input  { @apply w-full rounded-2xl border border-white/10 bg-white/[0.06] px-4 py-2.5 text-sm text-white outline-none placeholder:text-slate-600 focus:border-violet-500/50 focus:bg-white/[0.08] transition; }
    .form-error  { @apply mt-1 text-xs text-red-400; }
    select.form-input option { background: #111122; }
</style>

@push('scripts')
<script>
    function previewImage(input, previewId, labelId) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (e) => {
            const preview = document.getElementById(previewId);
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
</script>
@endpush

@endsection
