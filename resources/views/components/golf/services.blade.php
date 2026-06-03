@props([
    'coachingPrograms',
])

<section id="services" class="bg-surface-container-lowest px-5 py-(--spacing-section-gap) md:px-(--spacing-margin-desktop)">
    <div class="mx-auto max-w-(--spacing-container-max)">
        <div data-animate class="mb-16 flex flex-col justify-between gap-6 md:flex-row md:items-end">
            <div>
                <span class="mb-4 block font-display text-label-lg tracking-[0.2em] text-secondary uppercase">
                    Our Services
                </span>
                <h2 class="font-display text-headline-lg text-primary">Tailored Coaching Programs</h2>
            </div>
            <p class="max-w-md text-on-surface-variant">
                Comprehensive instruction tiers designed for progressive improvement and long-term mastery.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-(--spacing-gutter) md:grid-cols-2 lg:grid-cols-3">
            @forelse ($coachingPrograms as $service)
                <div
                    data-animate
                    class="group relative flex flex-col items-center overflow-hidden rounded-xl border border-hairline bg-background p-10 text-center transition-transform duration-300 hover:-translate-y-1"
                >
                    <div class="mb-8 flex size-16 items-center justify-center rounded-full bg-surface-container transition-colors group-hover:bg-primary-container">
                        <x-golf.icon :name="$service->icon" class="text-3xl text-primary group-hover:text-on-primary-container" />
                    </div>
                    <h3 class="mb-4 font-display text-headline-sm">{{ $service->title }}</h3>
                    <p class="mb-8 grow text-on-surface-variant">{{ $service->description }}</p>
                    <button
                        type="button"
                        data-booking-open
                        data-coaching-program-id="{{ $service->id }}"
                        class="w-full rounded bg-on-surface py-3 font-display text-label-lg uppercase text-surface transition-all group-hover:bg-primary"
                    >
                        Book Now
                    </button>
                </div>
            @empty
                <p class="col-span-full text-center text-on-surface-variant">Coaching programs will be listed here soon.</p>
            @endforelse
        </div>
    </div>
</section>
