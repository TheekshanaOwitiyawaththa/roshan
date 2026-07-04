<nav class="fixed top-0 z-50 w-full border-b border-outline-variant/20 bg-surface/95 backdrop-blur-md">
    <div class="mx-auto flex max-w-(--spacing-container-max) items-center justify-between gap-4 px-5 py-3.5 md:px-(--spacing-margin-desktop) md:py-4">
        <a href="#" class="min-w-0 font-display text-base font-semibold tracking-tight text-primary sm:text-headline-sm">
            <span class="sm:hidden">Roshan Fernando</span>
            <span class="hidden sm:inline">Roshan Fernando Golf</span>
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
            class="shrink-0 rounded-full bg-primary px-5 py-2 font-display text-[11px] uppercase tracking-[0.14em] text-on-primary transition-all duration-200 hover:bg-primary-container hover:text-on-primary active:scale-[0.98] sm:px-6 sm:py-2.5 sm:text-label-lg sm:tracking-[0.1em]"
        >
            Book Now
        </button>
    </div>
</nav>
