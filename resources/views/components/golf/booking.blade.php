@props([
    'coachingPrograms',
    'locations',
])

<section id="booking" class="relative overflow-hidden bg-primary px-5 py-(--spacing-section-gap) md:px-(--spacing-margin-desktop)">
    <div class="pointer-events-none absolute top-0 right-0 h-full w-1/3 opacity-10">
        <x-golf.icon name="golf_course" class="absolute -top-20 -right-20 text-[400px] text-on-primary" />
    </div>

    <div class="relative z-10 mx-auto max-w-(--spacing-container-max) text-center">
        <div data-animate>
            <h2 class="mb-6 font-display text-display-md text-surface">
                Ready to Improve Your Golf Game?
            </h2>
            <p class="mx-auto mb-8 max-w-2xl font-body text-body-lg text-primary-fixed-dim">
                Join a community of dedicated golfers in Perth who have transformed their performance
                through expert, focused instruction.
            </p>

            @if (session('booking_success'))
                <div class="mx-auto mb-8 max-w-2xl rounded-xl border border-primary-fixed/30 bg-surface/10 px-6 py-4 text-surface">
                    {{ session('booking_success') }}
                </div>
            @endif

            <button
                type="button"
                data-booking-open
                class="inline-flex rounded-full bg-secondary px-10 py-4 font-display text-label-lg uppercase text-on-secondary shadow-xl transition-transform hover:scale-[1.02] active:scale-95"
            >
                Book Now
            </button>
        </div>
    </div>
</section>
