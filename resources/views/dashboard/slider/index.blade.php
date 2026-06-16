@extends('dashboard.layout')

@section('title', 'Sliders')
@section('page-title', 'Slider Management')
@section('page-subtitle', 'Manage homepage banner slides')

@section('header-actions')
    <a href="{{ route('dashboard.slider.create') }}" class="btn-primary text-xs px-4 py-2">
        <i data-lucide="plus" class="h-3.5 w-3.5"></i>
        Add Slider
    </a>
@endsection

@section('content')

{{-- ── Stats bar ──────────────────────────────────────────────────────────── --}}
<div class="mb-6 flex flex-wrap items-center gap-4">
    <div class="flex items-center gap-2 rounded-2xl border border-white/8 bg-white/3 px-4 py-2.5">
        <i data-lucide="images" class="h-4 w-4 text-fuchsia-400"></i>
        <span class="text-sm font-bold text-white">{{ $sliders->count() }}</span>
        <span class="text-xs text-slate-500">Total Sliders</span>
    </div>
    <div class="flex items-center gap-2 rounded-2xl border border-white/8 bg-white/3 px-4 py-2.5">
        <i data-lucide="eye" class="h-4 w-4 text-green-400"></i>
        <span class="text-sm font-bold text-white">{{ $sliders->where('is_active', true)->count() }}</span>
        <span class="text-xs text-slate-500">Active</span>
    </div>
    <div class="flex items-center gap-2 rounded-2xl border border-white/8 bg-white/3 px-4 py-2.5">
        <i data-lucide="eye-off" class="h-4 w-4 text-slate-500"></i>
        <span class="text-sm font-bold text-white">{{ $sliders->where('is_active', false)->count() }}</span>
        <span class="text-xs text-slate-500">Inactive</span>
    </div>
</div>

{{-- ── Slider Cards Grid ──────────────────────────────────────────────────── --}}
@if($sliders->isEmpty())
    <div class="flex flex-col items-center justify-center rounded-3xl border border-dashed border-white/15
                bg-white/2 py-24 text-slate-500">
        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-3xl
                    bg-linear-to-br from-fuchsia-500/20 to-violet-500/20">
            <i data-lucide="images" class="h-8 w-8 text-fuchsia-400/60"></i>
        </div>
        <p class="text-base font-bold text-slate-400">No sliders yet</p>
        <p class="mt-1 text-sm text-slate-600">Create your first homepage banner.</p>
        <a href="{{ route('dashboard.slider.create') }}"
           class="mt-5 btn-primary text-sm">
            <i data-lucide="plus" class="h-4 w-4"></i>
            Add First Slider
        </a>
    </div>

@else
    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
        @foreach($sliders as $slider)
            @php
                $imgSrc = $slider->image_url
                    ?: ($slider->image_path ? Storage::url($slider->image_path) : null);
            @endphp

            <div class="group relative flex flex-col overflow-hidden rounded-3xl border border-white/8
                        bg-white/3 transition hover:border-white/15 hover:bg-white/5">

                {{-- ── Thumbnail ── --}}
                <div class="relative aspect-video overflow-hidden bg-[#0d0d20]">
                    @if($imgSrc)
                        <img src="{{ $imgSrc }}" alt="{{ $slider->title }}"
                             class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    @else
                        <div class="flex h-full w-full items-center justify-center">
                            <i data-lucide="image" class="h-10 w-10 text-slate-700"></i>
                        </div>
                    @endif

                    {{-- Overlay gradient --}}
                    <div class="absolute inset-0 bg-linear-to-t from-black/70 via-transparent to-transparent"></div>

                    {{-- Sort order badge --}}
                    <div class="absolute left-3 top-3 flex h-7 w-7 items-center justify-center
                                rounded-full bg-black/60 backdrop-blur-sm
                                text-xs font-black text-white border border-white/15">
                        {{ $slider->sort_order ?? 0 }}
                    </div>

                    {{-- Status badge --}}
                    <div class="absolute right-3 top-3">
                        <form method="POST" action="{{ route('dashboard.slider.toggle', $slider) }}">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="flex items-center gap-1.5 rounded-full px-3 py-1 text-[11px] font-bold
                                           backdrop-blur-sm border transition
                                           {{ $slider->is_active
                                               ? 'bg-green-500/20 border-green-500/40 text-green-300 hover:bg-green-500/30'
                                               : 'bg-black/50 border-white/15 text-slate-400 hover:bg-white/10' }}">
                                <span class="h-1.5 w-1.5 rounded-full
                                             {{ $slider->is_active ? 'bg-green-400' : 'bg-slate-500' }}"></span>
                                {{ $slider->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </div>

                    {{-- Bottom title overlay --}}
                    <div class="absolute bottom-0 left-0 right-0 px-4 pb-3">
                        <p class="text-sm font-black text-white leading-tight drop-shadow-lg">
                            {{ $slider->title }}
                        </p>
                        @if($slider->subtitle)
                            <p class="mt-0.5 text-[11px] text-slate-300 drop-shadow">{{ $slider->subtitle }}</p>
                        @endif
                    </div>
                </div>

                {{-- ── Card Body ── --}}
                <div class="flex flex-1 flex-col gap-3 p-4">

                    {{-- Description --}}
                    @if($slider->description)
                        <p class="line-clamp-2 text-xs leading-5 text-slate-400">
                            {{ $slider->description }}
                        </p>
                    @endif

                    {{-- Button info --}}
                    @if($slider->button_text)
                        <div class="flex items-center gap-2">
                            <i data-lucide="mouse-pointer-2" class="h-3.5 w-3.5 shrink-0 text-violet-400"></i>
                            <span class="rounded-lg border border-violet-500/20 bg-violet-500/10
                                         px-2.5 py-0.5 text-[11px] font-semibold text-violet-300">
                                {{ $slider->button_text }}
                            </span>
                            @if($slider->button_link)
                                <span class="truncate text-[10px] text-slate-600">
                                    {{ $slider->button_link }}
                                </span>
                            @endif
                        </div>
                    @endif

                    {{-- Actions --}}
                    <div class="mt-auto flex items-center gap-2 pt-1">
                        <button type="button"
                                onclick="openEditModal(
                                    {{ $slider->id }},
                                    '{{ addslashes($slider->title) }}',
                                    '{{ addslashes($slider->subtitle ?? '') }}',
                                    '{{ addslashes($slider->description ?? '') }}',
                                    '{{ addslashes($slider->button_text ?? '') }}',
                                    '{{ addslashes($slider->button_link ?? '') }}',
                                    {{ $slider->sort_order ?? 0 }},
                                    '{{ addslashes($slider->image_url ?? '') }}'
                                )"
                                class="flex flex-1 items-center justify-center gap-1.5 rounded-2xl
                                       border border-white/10 bg-white/5 py-2 text-xs font-semibold
                                       text-white hover:bg-white/10 transition">
                            <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                            Edit
                        </button>

                        <form method="POST" action="{{ route('dashboard.slider.destroy', $slider) }}"
                              onsubmit="return confirm('Delete « {{ addslashes($slider->title) }} »?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="flex items-center gap-1.5 rounded-2xl border border-red-500/20
                                           bg-red-500/8 px-4 py-2 text-xs font-semibold
                                           text-red-400 hover:bg-red-500/15 transition">
                                <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- ══ EDIT MODAL ══════════════════════════════════════════════════════════ --}}
<div id="editModal"
     class="fixed inset-0 z-120 hidden items-center justify-center bg-black/70 px-4 backdrop-blur-sm"
     onclick="if(event.target===this) closeEditModal()">

    <div class="w-full max-w-lg rounded-3xl border border-white/10 bg-[#0f0f23] shadow-2xl">

        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-white/8 px-6 py-5">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-2xl
                            bg-linear-to-br from-violet-500 to-fuchsia-500">
                    <i data-lucide="pencil" class="h-4 w-4 text-white"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-white">Edit Slider</h3>
                    <p class="text-[11px] text-slate-500">Update banner details</p>
                </div>
            </div>
            <button onclick="closeEditModal()"
                    class="flex h-8 w-8 items-center justify-center rounded-xl
                           bg-white/6 text-slate-400 hover:bg-white/10 hover:text-white transition">
                <i data-lucide="x" class="h-4 w-4"></i>
            </button>
        </div>

        {{-- Form --}}
        <form id="editForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="form-label">Title <span class="text-red-400">*</span></label>
                    <input type="text" name="title" id="editTitle" required class="form-input"
                           placeholder="Banner headline">
                </div>
                <div>
                    <label class="form-label">Subtitle</label>
                    <input type="text" name="subtitle" id="editSubtitle" class="form-input"
                           placeholder="Short tagline">
                </div>
                <div>
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" id="editSortOrder" min="0" class="form-input">
                </div>
                <div class="col-span-2">
                    <label class="form-label">Description</label>
                    <textarea name="description" id="editDescription" rows="2" class="form-input"
                              placeholder="Optional description…"></textarea>
                </div>
                <div>
                    <label class="form-label">Button Text</label>
                    <input type="text" name="button_text" id="editButtonText" class="form-input"
                           placeholder="Watch Now">
                </div>
                <div>
                    <label class="form-label">Button Link</label>
                    <input type="text" name="button_link" id="editButtonLink" class="form-input"
                           placeholder="/anime/1">
                </div>
                <div class="col-span-2">
                    <label class="form-label">Image URL (paste a new URL to replace)</label>
                    <input type="url" name="image_url" id="editImageUrl" class="form-input"
                           placeholder="https://…">
                </div>
                <div class="col-span-2">
                    <label class="form-label">— or — Replace with file upload</label>
                    <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-dashed
                                  border-white/15 bg-white/3 px-4 py-3 hover:border-violet-500/40 transition"
                           for="editImage">
                        <i data-lucide="upload-cloud" class="h-5 w-5 text-slate-500"></i>
                        <span class="text-xs text-slate-500">Click to upload image (max 5 MB)</span>
                    </label>
                    <input type="file" name="image" id="editImage" accept="image/*" class="hidden">
                </div>
            </div>

            <div class="flex gap-3 pt-1">
                <button type="submit" class="btn-primary flex-1 justify-center py-2.5 text-sm">
                    <i data-lucide="save" class="h-4 w-4"></i>
                    Save Changes
                </button>
                <button type="button" onclick="closeEditModal()"
                        class="rounded-2xl border border-white/10 bg-white/5 px-5
                               text-sm font-bold text-slate-300 hover:bg-white/10 transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEditModal(id, title, subtitle, description, buttonText, buttonLink, sortOrder, imageUrl) {
        document.getElementById('editForm').action = `/dashboard/slider/${id}`;
        document.getElementById('editTitle').value       = title;
        document.getElementById('editSubtitle').value    = subtitle;
        document.getElementById('editDescription').value = description;
        document.getElementById('editButtonText').value  = buttonText;
        document.getElementById('editButtonLink').value  = buttonLink;
        document.getElementById('editSortOrder').value   = sortOrder;
        document.getElementById('editImageUrl').value    = imageUrl;

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

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeEditModal();
    });
</script>
@endpush

@endsection
