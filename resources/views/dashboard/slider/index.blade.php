@extends('dashboard.layout')

@section('title', 'Sliders')
@section('page-title', 'Slider Management')
@section('page-subtitle', 'Upload and manage hero banner slides')

@section('content')

<div class="grid gap-8 xl:grid-cols-[1fr_380px]">

    {{-- ── Existing Sliders ─────────────────────────────────────────────── --}}
    <div>
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-sm font-black uppercase tracking-widest text-slate-500">
                All Sliders ({{ $sliders->count() }})
            </h2>
        </div>

        @if($sliders->isEmpty())
            <div class="flex flex-col items-center justify-center rounded-3xl border border-white/8 bg-white/[0.03] py-20 text-slate-500">
                <i data-lucide="image" style="height:48px;width:48px" class="mb-4 opacity-30"></i>
                <p class="font-semibold">No sliders yet</p>
                <p class="mt-1 text-sm">Upload your first slider banner using the form.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($sliders as $slider)
                    <div class="group relative overflow-hidden rounded-3xl border border-white/8 bg-white/[0.03]">

                        {{-- Banner preview --}}
                        <div class="relative h-44">
                            <img src="{{ Storage::url($slider->image_path) }}" alt="{{ $slider->title }}"
                                 class="h-full w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-r from-[#080814]/90 via-[#080814]/40 to-transparent"></div>

                            {{-- Text overlay --}}
                            <div class="absolute bottom-0 left-0 p-5">
                                <p class="text-lg font-black text-white drop-shadow">{{ $slider->title }}</p>
                                @if($slider->subtitle)
                                    <p class="text-sm text-slate-300">{{ $slider->subtitle }}</p>
                                @endif
                            </div>

                            {{-- Sort order badge --}}
                            <span class="absolute left-3 top-3 flex h-6 w-6 items-center justify-center rounded-full bg-black/60 text-xs font-bold text-white backdrop-blur">
                                {{ $slider->sort_order }}
                            </span>
                        </div>

                        {{-- Controls --}}
                        <div class="flex items-center gap-3 border-t border-white/8 px-5 py-3">

                            {{-- Active toggle --}}
                            <form method="POST" action="{{ route('dashboard.slider.toggle', $slider) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="flex items-center gap-2 rounded-xl px-3 py-1.5 text-xs font-semibold transition
                                               {{ $slider->is_active ? 'bg-green-500/15 text-green-400 hover:bg-green-500/25' : 'bg-white/8 text-slate-500 hover:bg-white/12' }}">
                                    <i data-lucide="{{ $slider->is_active ? 'eye' : 'eye-off' }}" style="height:12px;width:12px"></i>
                                    {{ $slider->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>

                            @if($slider->button_text)
                                <span class="rounded-xl border border-white/10 px-3 py-1.5 text-xs text-slate-400">
                                    {{ $slider->button_text }}
                                </span>
                            @endif

                            <div class="ml-auto flex items-center gap-2">

                                {{-- Edit button (opens modal) --}}
                                <button type="button"
                                        onclick="openEditModal({{ $slider->id }}, '{{ addslashes($slider->title) }}', '{{ addslashes($slider->subtitle ?? '') }}', '{{ addslashes($slider->description ?? '') }}', '{{ addslashes($slider->button_text ?? '') }}', '{{ addslashes($slider->button_link ?? '') }}', {{ $slider->sort_order }})"
                                        class="flex items-center gap-1.5 rounded-xl border border-white/10 bg-white/6 px-3 py-1.5 text-xs font-semibold text-white hover:bg-white/12 transition">
                                    <i data-lucide="pencil" style="height:12px;width:12px"></i>
                                    Edit
                                </button>

                                {{-- Delete --}}
                                <form method="POST" action="{{ route('dashboard.slider.destroy', $slider) }}"
                                      onsubmit="return confirm('Delete this slider?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="flex items-center gap-1.5 rounded-xl border border-red-500/20 bg-red-500/10 px-3 py-1.5 text-xs font-semibold text-red-400 hover:bg-red-500/20 transition">
                                        <i data-lucide="trash-2" style="height:12px;width:12px"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ── Upload Form ──────────────────────────────────────────────────── --}}
    <div class="rounded-3xl border border-white/8 bg-white/[0.03] p-5 h-fit">
        <h2 class="mb-5 text-sm font-black text-white flex items-center gap-2">
            <i data-lucide="upload-cloud" style="height:16px;width:16px" class="text-fuchsia-400"></i>
            Upload New Slider
        </h2>

        <form method="POST" action="{{ route('dashboard.slider.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            {{-- Image drop zone --}}
            <div>
                <label id="sliderDropLabel"
                       class="flex h-40 w-full cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-white/15 bg-white/[0.03] hover:border-fuchsia-500/50 hover:bg-white/[0.06] transition"
                       for="slider_image">
                    <i data-lucide="image-plus" style="height:28px;width:28px" class="mb-2 text-slate-600"></i>
                    <p class="text-xs font-semibold text-slate-500">Click to upload image</p>
                    <p class="mt-1 text-[10px] text-slate-600">JPG, PNG, WEBP · Max 5MB</p>
                </label>
                <input type="file" name="image" id="slider_image" accept="image/*" required class="hidden"
                       onchange="previewSlider(this)">
                <img id="sliderPreview" src="" alt="" class="mt-3 hidden h-40 w-full rounded-2xl object-cover">
                @error('image') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Title <span class="text-red-400">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Slide title" class="form-input">
                @error('title') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Subtitle</label>
                <input type="text" name="subtitle" value="{{ old('subtitle') }}" placeholder="Short tagline" class="form-input">
            </div>

            <div>
                <label class="form-label">Description</label>
                <textarea name="description" rows="2" placeholder="Optional description..." class="form-input resize-none">{{ old('description') }}</textarea>
            </div>

            <div class="grid gap-3 grid-cols-2">
                <div>
                    <label class="form-label">Button Text</label>
                    <input type="text" name="button_text" value="{{ old('button_text', 'Watch Now') }}" class="form-input">
                </div>
                <div>
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="form-input">
                </div>
            </div>

            <div>
                <label class="form-label">Button Link</label>
                <input type="text" name="button_link" value="{{ old('button_link') }}" placeholder="/anime/1 or https://..." class="form-input">
            </div>

            <button type="submit"
                    class="w-full rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 py-3 text-sm font-bold text-white shadow-lg shadow-fuchsia-500/20 hover:opacity-90 transition flex items-center justify-center gap-2">
                <i data-lucide="upload" style="height:16px;width:16px"></i>
                Upload Slider
            </button>
        </form>
    </div>
</div>

{{-- ── Edit Modal ────────────────────────────────────────────────────────── --}}
<div id="editModal" class="fixed inset-0 z-[120] hidden items-center justify-center bg-black/70 px-4">
    <div class="w-full max-w-lg rounded-3xl border border-white/10 bg-[#111122] p-6 shadow-2xl">
        <div class="mb-5 flex items-center justify-between">
            <h3 class="text-lg font-black text-white">Edit Slider</h3>
            <button onclick="closeEditModal()" class="rounded-xl bg-white/10 p-2 hover:bg-white/15">
                <i data-lucide="x" style="height:16px;width:16px"></i>
            </button>
        </div>

        <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="form-label">Title</label>
                <input type="text" name="title" id="editTitle" class="form-input">
            </div>
            <div>
                <label class="form-label">Subtitle</label>
                <input type="text" name="subtitle" id="editSubtitle" class="form-input">
            </div>
            <div>
                <label class="form-label">Description</label>
                <textarea name="description" id="editDescription" rows="2" class="form-input resize-none"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="form-label">Button Text</label>
                    <input type="text" name="button_text" id="editButtonText" class="form-input">
                </div>
                <div>
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" id="editSortOrder" min="0" class="form-input">
                </div>
            </div>
            <div>
                <label class="form-label">Button Link</label>
                <input type="text" name="button_link" id="editButtonLink" class="form-input">
            </div>
            <div>
                <label class="form-label">Replace Image (optional)</label>
                <input type="file" name="image" accept="image/*" class="form-input py-2 text-xs">
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="flex flex-1 items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 py-3 text-sm font-bold text-white hover:opacity-90 transition">
                    <i data-lucide="save" style="height:14px;width:14px"></i>
                    Save Changes
                </button>
                <button type="button" onclick="closeEditModal()"
                        class="rounded-2xl border border-white/10 bg-white/6 px-5 py-3 text-sm font-bold text-white hover:bg-white/10 transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .form-label { @apply mb-1.5 block text-xs font-semibold text-slate-400; }
    .form-input  { @apply w-full rounded-2xl border border-white/10 bg-white/[0.06] px-4 py-2.5 text-sm text-white outline-none placeholder:text-slate-600 focus:border-violet-500/50 transition; }
    .form-error  { @apply mt-1 text-xs text-red-400; }
</style>

@push('scripts')
<script>
    function previewSlider(input) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (e) => {
            const preview = document.getElementById('sliderPreview');
            const label   = document.getElementById('sliderDropLabel');
            preview.src   = e.target.result;
            preview.classList.remove('hidden');
            label.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }

    function openEditModal(id, title, subtitle, description, buttonText, buttonLink, sortOrder) {
        document.getElementById('editForm').action = `/dashboard/slider/${id}`;
        document.getElementById('editTitle').value       = title;
        document.getElementById('editSubtitle').value    = subtitle;
        document.getElementById('editDescription').value = description;
        document.getElementById('editButtonText').value  = buttonText;
        document.getElementById('editButtonLink').value  = buttonLink;
        document.getElementById('editSortOrder').value   = sortOrder;

        const modal = document.getElementById('editModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        lucide.createIcons();
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) closeEditModal();
    });
</script>
@endpush

@endsection
