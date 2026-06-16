@extends('dashboard.layout')

@section('title', 'Add Slider')
@section('page-title', 'Add New Slider')
@section('page-subtitle', 'Create a new homepage banner slide')

@section('header-actions')
    <a href="{{ route('dashboard.slider.index') }}"
       class="flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5
              px-4 py-2 text-xs font-semibold text-slate-300 hover:bg-white/10 transition">
        <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
        Back to Sliders
    </a>
@endsection

@section('content')

<div class="mx-auto max-w-2xl">

    {{-- Card --}}
    <div class="rounded-3xl border border-white/8 bg-white/2 overflow-hidden">

        {{-- Header strip --}}
        <div class="flex items-center gap-4 border-b border-white/8 bg-linear-to-r
                    from-violet-500/10 to-fuchsia-500/5 px-6 py-5">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl
                        bg-linear-to-br from-violet-500 to-fuchsia-500 shadow-lg shadow-fuchsia-500/25">
                <i data-lucide="images" class="h-5 w-5 text-white"></i>
            </div>
            <div>
                <h2 class="text-base font-black text-white">Slider Details</h2>
                <p class="text-[11px] text-slate-500">Fill in the banner information below</p>
            </div>
        </div>

        <form method="POST" action="{{ route('dashboard.slider.store') }}"
              enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf

            {{-- ── Image section ──────────────────────────────────────────── --}}
            <div class="rounded-2xl border border-white/8 bg-white/2 p-4 space-y-4">
                <p class="text-xs font-bold uppercase tracking-widest text-slate-500">Banner Image</p>

                {{-- Preview area --}}
                <div id="previewWrap" class="relative hidden aspect-video w-full overflow-hidden rounded-2xl border border-white/10 bg-black">
                    <img id="imgPreview" src="" alt="" class="h-full w-full object-cover">
                    <button type="button" onclick="clearPreview()"
                            class="absolute right-2 top-2 flex h-7 w-7 items-center justify-center
                                   rounded-full bg-black/70 text-white hover:bg-black transition">
                        <i data-lucide="x" class="h-3.5 w-3.5"></i>
                    </button>
                </div>

                {{-- Option A: Upload file --}}
                <div>
                    <label class="form-label">Upload Image File</label>
                    <label id="dropLabel"
                           class="flex h-28 w-full cursor-pointer flex-col items-center justify-center
                                  rounded-2xl border-2 border-dashed border-white/12 bg-white/2
                                  transition hover:border-violet-500/50 hover:bg-violet-500/5"
                           for="slider_image">
                        <i data-lucide="upload-cloud" class="mb-2 h-6 w-6 text-slate-500"></i>
                        <p class="text-xs font-semibold text-slate-400">Click to upload</p>
                        <p class="mt-0.5 text-[10px] text-slate-600">JPG · PNG · WEBP · Max 5 MB</p>
                    </label>
                    <input type="file" name="image" id="slider_image" accept="image/*"
                           class="hidden" onchange="handleFile(this)">
                    @error('image') <p class="form-error mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Divider --}}
                <div class="flex items-center gap-3">
                    <div class="h-px flex-1 bg-white/8"></div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-600">or paste URL</span>
                    <div class="h-px flex-1 bg-white/8"></div>
                </div>

                {{-- Option B: Image URL --}}
                <div>
                    <label class="form-label">Image URL</label>
                    <div class="relative">
                        <i data-lucide="link" class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500"></i>
                        <input type="url" name="image_url" id="imageUrlInput"
                               value="{{ old('image_url') }}"
                               placeholder="https://example.com/banner.jpg"
                               class="form-input pl-9"
                               onchange="handleUrl(this.value)">
                    </div>
                    @error('image_url') <p class="form-error mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- ── Title & Subtitle ───────────────────────────────────────── --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2 sm:col-span-1">
                    <label class="form-label">Title <span class="text-red-400">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           placeholder="e.g. Demon Slayer — New Season"
                           required class="form-input">
                    @error('title') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label class="form-label">Subtitle</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle') }}"
                           placeholder="Short tagline or season info"
                           class="form-input">
                </div>
            </div>

            {{-- ── Description ────────────────────────────────────────────── --}}
            <div>
                <label class="form-label">Description</label>
                <textarea name="description" rows="2"
                          placeholder="Optional short description shown on the banner…"
                          class="form-input">{{ old('description') }}</textarea>
            </div>

            {{-- ── CTA Button ─────────────────────────────────────────────── --}}
            <div class="rounded-2xl border border-white/8 bg-white/2 p-4 space-y-3">
                <p class="text-xs font-bold uppercase tracking-widest text-slate-500">Call-to-Action Button</p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Button Text</label>
                        <input type="text" name="button_text" value="{{ old('button_text', 'Watch Now') }}"
                               placeholder="Watch Now"
                               class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Button Link</label>
                        <div class="relative">
                            <i data-lucide="arrow-up-right" class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500"></i>
                            <input type="text" name="button_link" value="{{ old('button_link') }}"
                                   placeholder="/anime/1 or https://…"
                                   class="form-input pl-9">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Sort Order ──────────────────────────────────────────────── --}}
            <div class="flex items-center gap-4">
                <div class="w-36">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                           min="0" class="form-input text-center tabular-nums">
                    <p class="mt-1 text-[10px] text-slate-600">Lower = shows first</p>
                </div>
                <div class="flex-1 rounded-2xl border border-white/8 bg-white/2 p-3 text-xs text-slate-500 leading-5">
                    Sliders are ordered by sort number, then by creation date.<br>
                    New sliders are set to <strong class="text-slate-400">Active</strong> by default.
                </div>
            </div>

            {{-- ── Actions ─────────────────────────────────────────────────── --}}
            <div class="flex items-center gap-3 pt-2 border-t border-white/8">
                <button type="submit" class="btn-primary flex-1 justify-center py-3 text-sm">
                    <i data-lucide="upload-cloud" class="h-4 w-4"></i>
                    Create Slider
                </button>
                <a href="{{ route('dashboard.slider.index') }}"
                   class="rounded-2xl border border-white/10 bg-white/5 px-6 py-3 text-sm
                          font-bold text-slate-300 hover:bg-white/10 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function handleFile(input) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => showPreview(e.target.result);
        reader.readAsDataURL(file);
        // Clear URL field if file chosen
        document.getElementById('imageUrlInput').value = '';
    }

    function handleUrl(url) {
        if (!url) return;
        showPreview(url);
        // Clear file input if URL given
        document.getElementById('slider_image').value = '';
    }

    function showPreview(src) {
        const wrap  = document.getElementById('previewWrap');
        const img   = document.getElementById('imgPreview');
        const label = document.getElementById('dropLabel');
        img.src = src;
        wrap.classList.remove('hidden');
        label.classList.add('hidden');
        lucide.createIcons();
    }

    function clearPreview() {
        document.getElementById('previewWrap').classList.add('hidden');
        document.getElementById('dropLabel').classList.remove('hidden');
        document.getElementById('imgPreview').src = '';
        document.getElementById('slider_image').value = '';
        document.getElementById('imageUrlInput').value = '';
    }
</script>
@endpush

@endsection
