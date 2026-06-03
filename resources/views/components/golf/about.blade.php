<section id="about" class="bg-surface-container-lowest px-5 py-(--spacing-section-gap) md:px-(--spacing-margin-desktop)">
    <div class="mx-auto grid max-w-(--spacing-container-max) grid-cols-1 items-center gap-(--spacing-gutter) lg:grid-cols-2">
        <div data-animate class="group relative">
            <div class="aspect-4/5 overflow-hidden rounded-lg border border-hairline">
                <img
                    src="{{ config('golf.images.about_coach') }}"
                    alt="Professional golf coach on a Perth golf course at golden hour"
                    width="800"
                    height="1000"
                    class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                >
            </div>
            <div class="absolute -right-8 -bottom-8 hidden w-48 rounded-lg bg-primary p-8 shadow-ambient md:block">
                <span class="block font-display text-display-md leading-none text-on-primary">RF</span>
                <p class="mt-4 font-display text-label-sm tracking-widest text-primary-fixed-dim uppercase">
                    Premium Quality Guaranteed
                </p>
            </div>
        </div>

        <div data-animate class="lg:pl-20">
            <span class="mb-4 block font-display text-label-lg tracking-[0.2em] text-secondary uppercase">
                Meet Your Coach
            </span>
            <h2 class="mb-8 font-display text-headline-lg text-primary">
                Authoritative Guidance for the Modern Golfer
            </h2>
            <p class="mb-6 font-body text-body-lg leading-relaxed text-on-surface-variant">
                Independent golf professional Roshan Fernando brings a wealth of experience to every
                lesson. His philosophy focuses on simplifying the game to achieve consistent, repeatable
                results.
            </p>
            <p class="mb-10 font-body text-body-md text-on-surface-variant">
                Whether you're a beginner finding your grip or a seasoned player refining your fade,
                Roshan's data-driven approach combined with years of elite field experience provides
                the clarity your game deserves.
            </p>
            <a
                href="#about"
                class="inline-block rounded border border-on-surface px-10 py-4 font-display text-label-lg tracking-widest text-on-surface uppercase transition-all hover:bg-on-surface hover:text-surface"
            >
                Learn More
            </a>
        </div>
    </div>
</section>
