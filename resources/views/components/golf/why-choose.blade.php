<section class="bg-surface px-5 py-(--spacing-section-gap) md:px-(--spacing-margin-desktop)">
    <div class="mx-auto max-w-(--spacing-container-max)">
        <div data-animate class="mb-16 text-center">
            <h2 class="mb-4 font-display text-headline-lg text-primary">
                Precision, Performance, Prestige
            </h2>
            <p class="mx-auto max-w-2xl text-on-surface-variant">
                Elevate your game with a methodology built on accuracy and anatomical efficiency.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            @foreach (config('golf.bento_features') as $feature)
                <article
                    data-animate
                    class="flex flex-col gap-6 rounded-xl border border-hairline bg-surface-container-lowest p-8 transition-transform duration-300 ease-[cubic-bezier(0.2,0,0,1)] hover:-translate-y-1"
                >
                    <x-golf.icon :name="$feature['icon']" class="text-4xl text-primary" />
                    <div>
                        <h3 class="mb-2 font-display text-headline-sm">{{ $feature['title'] }}</h3>
                        <p class="text-on-surface-variant">{{ $feature['description'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
