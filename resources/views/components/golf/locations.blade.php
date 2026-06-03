@props([
    'locations',
])

<section id="locations" class="bg-surface px-5 py-(--spacing-section-gap) md:px-(--spacing-margin-desktop)">
    <div class="mx-auto max-w-(--spacing-container-max)">
        <div data-animate class="mb-16 text-center">
            <span class="mb-4 block font-display text-label-lg tracking-[0.2em] text-secondary uppercase">
                Where We Coach
            </span>
            <h2 class="font-display text-headline-lg text-primary">Perth Coaching Locations</h2>
        </div>

        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
            @forelse ($locations as $location)
                <article
                    data-animate
                    class="group overflow-hidden rounded-2xl border border-hairline bg-surface-container-lowest transition-transform duration-300 hover:-translate-y-1"
                >
                    @if ($location->image_url)
                        <div class="relative h-64 overflow-hidden">
                            <img
                                src="{{ $location->image_url }}"
                                alt="{{ $location->image_alt ?? $location->name }}"
                                width="640"
                                height="256"
                                loading="lazy"
                                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                            >
                            <div class="absolute inset-0 bg-primary/20"></div>
                        </div>
                    @endif
                    <div class="p-8">
                        <h3 class="mb-2 font-display text-headline-sm">{{ $location->name }}</h3>
                        <p class="mb-6 flex items-center gap-2 text-on-surface-variant">
                            <x-golf.icon name="location_on" class="text-sm" />
                            {{ $location->address }}
                        </p>
                        @if ($location->map_url)
                            <a
                                href="{{ $location->map_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center gap-2 font-display text-label-lg text-primary transition-all group-hover:gap-4"
                            >
                                View on Map
                                <x-golf.icon name="arrow_forward" />
                            </a>
                        @endif
                    </div>
                </article>
            @empty
                <p class="col-span-full text-center text-on-surface-variant">Locations will be listed here soon.</p>
            @endforelse
        </div>
    </div>
</section>
