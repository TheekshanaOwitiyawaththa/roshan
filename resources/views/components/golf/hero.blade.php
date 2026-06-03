<header class="relative flex min-h-screen items-center overflow-hidden bg-surface-container-low pt-24 pb-12">
    <div class="pointer-events-none absolute top-0 right-0 h-full w-1/2 translate-x-1/4 -skew-x-12 bg-surface-bright/50"></div>

    <div class="relative z-10 mx-auto w-full max-w-(--spacing-container-max) px-5 md:px-(--spacing-margin-desktop)">
        <div class="grid grid-cols-1 items-center gap-16 lg:grid-cols-2">
            <div data-animate class="order-2 max-w-xl lg:order-1">
                <span class="mb-6 inline-block font-display text-label-lg uppercase tracking-[0.3em] text-secondary">
                    Elite Performance Coaching
                </span>
                <h1 class="mb-8 font-display text-display-md leading-[1.1] tracking-tight text-primary md:text-display-lg">
                    Helping golfers of all levels improve their game through simple and effective coaching.
                </h1>
                <p class="mb-12 max-w-lg font-body text-body-lg text-on-surface-variant">
                    Professional golf coaching in Perth tailored to your unique swing and goals.
                    Experience precision instruction that delivers repeatable results.
                </p>
                <div class="flex flex-col gap-5 sm:flex-row">
                    <button
                        type="button"
                        data-booking-open
                        class="rounded-full bg-primary px-10 py-4 text-center font-display text-label-lg uppercase text-on-primary transition-all hover:shadow-lg hover:shadow-primary/20 active:scale-95"
                    >
                        Book a Lesson
                    </button>
                    <a
                        href="#services"
                        class="rounded-full border border-primary px-10 py-4 text-center font-display text-label-lg uppercase text-primary transition-all hover:bg-primary/5 active:scale-95"
                    >
                        View Coaching Services
                    </a>
                </div>
            </div>

            <div class="relative order-1 flex h-[500px] items-end justify-center md:h-[700px] lg:order-2 lg:justify-end">
                <img
                    src="{{ config('golf.images.hero_portrait') }}"
                    alt="Roshan Fernando"
                    width="600"
                    height="700"
                    fetchpriority="high"
                    class="relative z-10 h-full w-auto object-contain"
                >

                @foreach (config('golf.hero_stats') as $stat)
                    <div class="absolute {{ $stat['position'] }} z-20 flex items-center gap-4 rounded-2xl border border-white/40 bg-white/40 p-5 shadow-xl backdrop-blur-md transition-transform duration-500 hover:-translate-y-2">
                        <div class="flex size-12 items-center justify-center rounded-full {{ $stat['icon_bg'] }}">
                            <x-golf.icon :name="$stat['icon']" />
                        </div>
                        <div>
                            <p class="text-lg leading-none font-bold text-primary">{{ $stat['title'] }}</p>
                            <p class="text-xs font-medium tracking-widest text-on-surface-variant uppercase">
                                {{ $stat['subtitle'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</header>
