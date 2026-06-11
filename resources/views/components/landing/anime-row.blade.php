<section class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8">

    {{-- Row header --}}
    <div class="mb-5 flex items-center justify-between">
        <h2 class="flex items-center gap-2 text-xl font-black text-white sm:text-2xl">
            <i data-lucide="{{ $icon }}" class="h-5 w-5 {{ $iconColor }}"></i>
            {{ $title }}
        </h2>

        <button class="flex items-center gap-1 rounded-2xl px-4 py-2 text-sm font-semibold text-slate-400 transition hover:bg-white/10 hover:text-white">
            View All
            <i data-lucide="chevron-right" class="h-4 w-4"></i>
        </button>
    </div>

    {{-- 3-column responsive grid --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($items as $item)
            @include('components.landing.anime-card', [
                'item'  => $item,
                'index' => $loop->index + ($indexOffset ?? 0),
            ])
        @endforeach
    </div>

</section>
