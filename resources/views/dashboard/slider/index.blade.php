@extends('dashboard.layout')

@section('title', 'Sliders')
@section('page-title', 'Slider Management')
@section('page-subtitle', 'Upload and manage hero banner slides')

@section('content')

{{-- ── Upload Form ──────────────────────────────────────────────────────── --}}
<div class="rounded-3xl border border-white/8 bg-white/3 p-6 mb-6">
    <h2 class="mb-5 text-sm font-black text-white flex items-center gap-2">
        <i data-lucide="upload-cloud" style="height:16px;width:16px" class="text-fuchsia-400"></i>
        Upload New Slider
    </h2>

    <form method="POST" action="{{ route('dashboard.slider.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Row 1: Image drop zone --}}
        <div class="mb-4">
            <label class="form-label">Banner Image <span class="text-red-400">*</span></label>
            <label id="sliderDropLabel"
                   class="flex h-36 w-full cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-white/15 bg-white/3 hover:border-fuchsia-500/50 hover:bg-white/5 transition"
                   for="slider_image">
                <i data-lucide="image-plus" style="height:28px;width:28px" class="mb-2 text-slate-600"></i>
                <p class="text-xs font-semibold text-slate-500">Click to upload banner image</p>
                <p class="mt-1 text-[10px] text-slate-600">JPG, PNG, WEBP · Max 5 MB</p>
            </label>
            <input type="file" name="image" id="slider_image" accept="image/*" required class="hidden"
                   onchange="previewSlider(this)">
            <img id="sliderPreview" src="" alt="" class="mt-3 hidden h-36 w-full rounded-2xl object-cover">
            @error('image') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        {{-- Row 2: Title + Subtitle + Sort Order --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-4">
            <div class="lg:col-span-2">
                <label class="form-label">Title <span class="text-red-400">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Slide headline" class="form-input">
                @error('title') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">Subtitle</label>
                <input type="text" name="subtitle" value="{{ old('subtitle') }}" placeholder="Short tagline" class="form-input">
            </div>
            <div>
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="form-input">
            </div>
        </div>

        {{-- Row 3: Button text + Button link + Description --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-5">
            <div>
                <label class="form-label">Button Text</label>
                <input type="text" name="button_text" value="{{ old('button_text', 'Watch Now') }}" class="form-input">
            </div>
            <div class="lg:col-span-2">
                <label class="form-label">Button Link</label>
                <input type="text" name="button_link" value="{{ old('button_link') }}" placeholder="/anime/1 or https://…" class="form-input">
            </div>
            <div>
                <label class="form-label">Description</label>
                <textarea name="description" rows="1" placeholder="Optional description…" class="form-input">{{ old('description') }}</textarea>
            </div>
        </div>

        <button type="submit"
                class="flex items-center gap-2 rounded-2xl bg-linear-to-r from-violet-500 to-fuchsia-500 px-7 py-3 text-sm font-bold text-white shadow-lg shadow-fuchsia-500/20 hover:opacity-90 transition">
            <i data-lucide="upload" style="height:16px;width:16px"></i>
            Upload Slider
        </button>
    </form>
</div>

{{-- ── Slider List ──────────────────────────────────────────────────────── --}}
<div class="rounded-3xl border border-white/8 bg-white/3 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-white/8">
        <h2 class="text-sm font-black text-white">All Sliders</h2>
        <span class="rounded-full bg-fuchsia-500/15 px-3 py-0.5 text-xs font-bold text-fuchsia-400">{{ $sliders->count() }} total</span>
    </div>

    @if($sliders->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-slate-500">
            <i data-lucide="image" style="height:48px;width:48px" class="mb-4 opacity-30"></i>
            <p class="font-semibold">No sliders yet</p>
            <p class="text-sm mt-1">Upload your first banner using the form above.</p>
        </div>
    @else
        <table class="w-full text-sm">
            <thead class="border-b border-white/8 bg-white/2">
                <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <th class="px-6 py-3 w-12">Order</th>
                    <th class="px-6 py-3">Preview</th>
                    <th class="px-6 py-3">Title / Subtitle</th>
                    <th class="px-6 py-3 hidden md:table-cell">Button</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($sliders as $slider)
                    <tr class="hover:bg-white/3 transition">
                        <td class="px-6 py-4 text-center">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-white/8 text-xs font-bold text-white mx-auto">
                                {{ $slider->sort_order }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <img src="{{ Storage::url($slider->image_path) }}" alt="{{ $slider->title }}"
                                 class="h-12 w-24 rounded-xl object-cover">
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-white">{{ $slider->title }}</p>
                            @if($slider->subtitle)
                                <p class="text-xs text-slate-500 mt-0.5">{{ $slider->subtitle }}</p>
                            @endif
                        </td>
                        <td class="hidden px-6 py-4 md:table-cell">
                            @if($slider->button_text)
                                <span class="rounded-lg border border-white/10 bg-white/5 px-2.5 py-1 text-xs text-slate-300">
                                    {{ $slider->button_text }}
                                </span>
                            @else
                                <span class="text-xs text-slate-600">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form method="POST" action="{{ route('dashboard.slider.toggle', $slider) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 rounded-xl px-3 py-1.5 text-xs font-semibold transition
                                               {{ $slider->is_active ? 'bg-green-500/15 text-green-400 hover:bg-green-500/25' : 'bg-white/8 text-slate-500 hover:bg-white/12' }}">
                                    <i data-lucide="{{ $slider->is_active ? 'eye' : 'eye-off' }}" style="height:11px;width:11px"></i>
                                    {{ $slider->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button type="button"
                                        onclick="openEditModal({{ $slider->id }}, '{{ addslashes($slider->title) }}', '{{ addslashes($slider->subtitle ?? '') }}', '{{ addslashes($slider->description ?? '') }}', '{{ addslashes($slider->button_text ?? '') }}', '{{ addslashes($slider->button_link ?? '') }}', {{ $slider->sort_order ?? 0 }})"
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-white/10 bg-white/6 px-3 py-1.5 text-xs font-semibold text-white hover:bg-white/10 transition">
                                    <i data-lucide="pencil" style="height:11px;width:11px"></i>
                                    Edit
                                </button>
                                <form method="POST" action="{{ route('dashboard.slider.destroy', $slider) }}"
                                      onsubmit="return confirm('Delete this slider?')">
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
    @endif
</div>

{{-- ── Edit Modal ───────────────────────────────────────────────────────── --}}
<div id="editModal" class="fixed inset-0 z-120 hidden items-center justify-center bg-black/70 px-4">
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
                <label class="form-label">Title <span class="text-red-400">*</span></label>
                <input type="text" name="title" id="editTitle" class="form-input">
            </div>
            <div>
                <label class="form-label">Subtitle</label>
                <input type="text" name="subtitle" id="editSubtitle" class="form-input">
            </div>
            <div>
                <label class="form-label">Description</label>
                <textarea name="description" id="editDescription" rows="2" class="form-input"></textarea>
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
                        class="flex flex-1 items-center justify-center gap-2 rounded-2xl bg-linear-to-r from-violet-500 to-fuchsia-500 py-3 text-sm font-bold text-white hover:opacity-90 transition">
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

@push('scripts')
<script>
    function previewSlider(input) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (e) => {
            const preview = document.getElementById('sliderPreview');
            const label   = document.getElementById('sliderDropLabel');
            preview.src = e.target.result;
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
