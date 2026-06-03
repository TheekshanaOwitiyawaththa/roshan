<nav class="fixed top-0 z-50 w-full border-b border-outline-variant/30 bg-surface/90 backdrop-blur-[10px]">
    <div class="mx-auto flex max-w-(--spacing-container-max) items-center justify-between px-5 py-4 md:px-(--spacing-margin-desktop)">
        <a href="#" class="font-display text-headline-sm font-bold tracking-tight text-primary">
            Roshan Fernando Golf
        </a>

        <div class="hidden items-center gap-8 md:flex">
            @foreach (config('golf.nav_links') as $link)
                <a
                    href="{{ $link['href'] }}"
                    data-nav-link
                    @class([
                        'font-display text-label-lg uppercase transition-colors',
                        'border-b-2 border-primary pb-1 font-bold text-primary' => $link['href'] === '#about',
                        'text-on-surface-variant hover:text-primary' => $link['href'] !== '#about',
                    ])
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        <button
            type="button"
            data-booking-open
            class="rounded-full bg-on-surface px-6 py-2.5 font-display text-label-lg uppercase text-surface transition-all duration-200 hover:opacity-80 active:scale-95"
        >
            Book Now
        </button>
    </div>
</nav>
