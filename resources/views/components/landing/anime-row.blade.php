{{-- CoCoFlix-style horizontal scroll row --}}
<section class="py-5 sm:py-7">

    <div class="mb-3 flex items-center justify-between px-4 sm:px-6 lg:px-8">
        <h2 class="flex items-center gap-2 text-sm font-black text-white sm:text-base">
            <i data-lucide="{{ $icon }}" class="h-4 w-4 {{ $iconColor }}"></i>
            {{ $title }}
        </h2>
        <button class="flex items-center gap-0.5 text-xs font-semibold text-fuchsia-400 hover:text-fuchsia-300 transition">
            See All
            <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
        </button>
    </div>

    {{-- Horizontal scroll strip — no snap so it feels natural like CoCoFlix --}}
    <div class="flex gap-3 overflow-x-auto pb-1 scrollbar-hide pl-4 pr-4 sm:pl-6 sm:pr-6 lg:pl-8 lg:pr-8"
         style="-webkit-overflow-scrolling:touch;">
        @foreach($items as $item)
            @include('components.landing.anime-card', [
                'item'  => $item,
                'index' => $loop->index + ($indexOffset ?? 0),
            ])
        @endforeach
    </div>

</section>
