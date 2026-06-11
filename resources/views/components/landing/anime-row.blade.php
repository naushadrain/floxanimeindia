<section class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8">
    <div class="mb-5 flex items-center justify-between">
        <h2 class="flex items-center gap-2 text-2xl font-black text-white">
            <i data-lucide="{{ $icon }}" class="h-6 w-6 {{ $iconColor }}"></i>
            {{ $title }}
        </h2>

        <button class="flex items-center rounded-2xl px-4 py-2 text-sm font-semibold text-slate-300 transition hover:bg-white/10 hover:text-white">
            View All
            <i data-lucide="chevron-right" class="ml-1 h-4 w-4"></i>
        </button>
    </div>

    <div class="flex gap-5 overflow-x-auto pb-3 scrollbar-hide">
        @foreach($items as $item)
            @include('components.landing.anime-card', [
                'item' => $item,
                'index' => $loop->index
            ])
        @endforeach
    </div>
</section>