<section id="testimonials" class="overflow-hidden bg-surface-container-low px-5 py-(--spacing-section-gap) md:px-(--spacing-margin-desktop)">
    <div class="mx-auto max-w-(--spacing-container-max)">
        <h2 data-animate class="mb-16 text-center font-display text-headline-lg text-primary">
            Results on the Green
        </h2>

        <div class="overflow-hidden" data-lenis-prevent>
            <div id="testimonial-track" class="flex cursor-grab gap-(--spacing-gutter) active:cursor-grabbing">
                @foreach (config('golf.testimonials') as $testimonial)
                    <article
                        data-testimonial-card
                        class="min-w-[300px] shrink-0 rounded-2xl border border-hairline bg-surface-container-lowest p-10 shadow-ambient md:min-w-[500px]"
                    >
                        <div class="mb-6 flex gap-1 text-secondary">
                            @for ($i = 0; $i < 5; $i++)
                                <x-golf.icon name="star" filled class="text-xl" />
                            @endfor
                        </div>
                        <p class="mb-8 font-body text-body-lg text-on-surface italic">
                            &ldquo;{{ $testimonial['quote'] }}&rdquo;
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="size-12 overflow-hidden rounded-full">
                                <img
                                    src="{{ $testimonial['image'] }}"
                                    alt="{{ $testimonial['alt'] }}"
                                    width="48"
                                    height="48"
                                    class="h-full w-full object-cover"
                                    loading="lazy"
                                >
                            </div>
                            <div>
                                <p class="text-base font-bold">{{ $testimonial['name'] }}</p>
                                <p class="text-sm tracking-wider text-on-surface-variant uppercase">
                                    {{ $testimonial['role'] }}
                                </p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

        <div class="mt-12 flex justify-center gap-4">
            <button
                type="button"
                data-testimonial-prev
                class="flex size-12 items-center justify-center rounded-full border border-hairline transition-all hover:bg-primary hover:text-on-primary"
                aria-label="Previous testimonial"
            >
                <x-golf.icon name="chevron_left" />
            </button>
            <button
                type="button"
                data-testimonial-next
                class="flex size-12 items-center justify-center rounded-full border border-hairline transition-all hover:bg-primary hover:text-on-primary"
                aria-label="Next testimonial"
            >
                <x-golf.icon name="chevron_right" />
            </button>
        </div>
    </div>
</section>
