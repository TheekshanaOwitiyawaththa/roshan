<header class="relative flex min-h-screen items-center overflow-hidden bg-surface-container-low pt-24 pb-12">
    <div class="pointer-events-none absolute top-0 right-0 h-full w-1/2 translate-x-1/4 -skew-x-12 bg-surface-bright/50"></div>

    <div class="relative z-10 mx-auto w-full max-w-(--spacing-container-max) px-5 md:px-(--spacing-margin-desktop)">
        <div class="grid grid-cols-1 items-center gap-6 lg:grid-cols-2 lg:gap-16">
            {{-- Intro: eyebrow + headline (first on mobile) --}}
            <div data-animate class="order-1 lg:col-start-1 lg:row-start-1">
                <span class="mb-4 inline-block font-display text-label-lg uppercase tracking-[0.28em] text-secondary">
                    Elite Performance Coaching
                </span>
                <h1 class="font-display text-[2rem] leading-[1.12] tracking-tight text-primary sm:text-display-md lg:mb-0 lg:text-display-lg">
                    Helping golfers of all levels improve their game through simple and effective coaching.
                </h1>
            </div>

            {{-- Portrait + stats --}}
            <div class="order-2 lg:col-start-2 lg:row-span-2 lg:row-start-1">
                <div
                    class="relative mx-auto flex h-[360px] w-full max-w-sm items-end justify-center sm:h-[420px] lg:mx-0 lg:h-[700px] lg:max-w-none lg:justify-end"
                >
                    <img
                        src="{{ config('golf.images.hero_portrait') }}"
                        alt="Roshan Fernando"
                        width="600"
                        height="700"
                        fetchpriority="high"
                        class="relative z-10 h-full w-auto max-w-full object-contain object-bottom"
                    >

                    @foreach (config('golf.hero_stats') as $stat)
                        <div
                            class="absolute {{ $stat['position'] }} z-20 hidden items-center gap-4 rounded-xl border border-white/50 bg-white/50 p-5 shadow-xl backdrop-blur-md transition-transform duration-500 hover:-translate-y-1 lg:flex"
                        >
                            <div class="flex size-11 shrink-0 items-center justify-center rounded-full {{ $stat['icon_bg'] }}">
                                <x-golf.icon :name="$stat['icon']" />
                            </div>
                            <div class="min-w-0">
                                <p class="font-display text-lg leading-none font-semibold text-primary">{{ $stat['title'] }}</p>
                                <p class="mt-1.5 font-body text-[10px] font-medium tracking-[0.14em] text-on-surface-variant uppercase">
                                    {{ $stat['subtitle'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Mobile stats: editorial strip, no icon bubbles --}}
                <div class="relative -mt-px border border-hairline bg-surface-container-lowest lg:hidden">
                    <div class="absolute inset-x-0 top-0 h-0.5 bg-secondary-container"></div>
                    <div class="grid grid-cols-3 divide-x divide-hairline">
                        @foreach (config('golf.hero_stats') as $stat)
                            <div class="px-3 py-5 text-center sm:px-4">
                                <p class="font-display text-lg font-semibold tracking-tight text-primary sm:text-xl">
                                    {{ $stat['title'] }}
                                </p>
                                <p class="mx-auto mt-1.5 max-w-[8rem] font-body text-[9px] leading-snug tracking-[0.12em] text-on-surface-variant uppercase sm:text-[10px]">
                                    {{ $stat['subtitle'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Body + CTAs (below stats on mobile) --}}
            <div data-animate class="order-3 lg:col-start-1 lg:row-start-2">
                <p class="mb-8 max-w-lg font-body text-body-md leading-relaxed text-on-surface-variant sm:text-body-lg">
                    Professional golf coaching in Perth tailored to your unique swing and goals.
                    Experience precision instruction that delivers repeatable results.
                </p>
                <div class="flex flex-col gap-4 sm:flex-row sm:gap-5">
                    <button
                        type="button"
                        data-booking-open
                        class="rounded-full bg-primary px-8 py-3.5 text-center font-display text-label-lg uppercase tracking-[0.08em] text-on-primary transition-all hover:shadow-lg hover:shadow-primary/20 active:scale-[0.98] sm:px-10 sm:py-4"
                    >
                        Book a Lesson
                    </button>
                    <a
                        href="#services"
                        class="rounded-full border border-primary/30 px-8 py-3.5 text-center font-display text-label-lg uppercase tracking-[0.08em] text-primary transition-all hover:border-primary hover:bg-primary/5 active:scale-[0.98] sm:px-10 sm:py-4"
                    >
                        View Services
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
