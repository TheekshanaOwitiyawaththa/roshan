<footer class="border-t border-outline-variant/20 bg-surface-container-lowest py-(--spacing-section-gap)">
    <div class="mx-auto grid max-w-(--spacing-container-max) grid-cols-1 gap-(--spacing-gutter) px-5 md:grid-cols-4 md:px-(--spacing-margin-desktop)">
        <div class="md:col-span-2">
            <a href="#" class="mb-6 block font-display text-headline-sm font-bold text-primary">
                Roshan Fernando Golf
            </a>
            <p class="mb-8 max-w-sm text-on-surface-variant">
                Elevating the standard of golf instruction in Western Australia through a blend of
                technical precision and practical playing experience.
            </p>
            <div class="flex gap-4">
                @foreach (['public', 'mail'] as $icon)
                    <a
                        href="#"
                        class="flex size-10 items-center justify-center rounded-full border border-outline-variant text-primary transition-all hover:bg-primary hover:text-surface"
                    >
                        <x-golf.icon :name="$icon" class="text-sm" />
                    </a>
                @endforeach
            </div>
        </div>

        <div>
            <h4 class="mb-6 font-display text-label-lg uppercase tracking-widest text-primary">
                Navigation
            </h4>
            <ul class="space-y-4">
                @foreach (config('golf.nav_links') as $link)
                    <li>
                        <a
                            href="{{ $link['href'] }}"
                            class="font-body text-body-md text-on-surface-variant transition-colors hover:text-secondary"
                        >
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div>
            <h4 class="mb-6 font-display text-label-lg uppercase tracking-widest text-primary">
                Connect
            </h4>
            <ul class="space-y-4">
                @foreach (config('golf.connect_links') as $label)
                    <li>
                        <a
                            href="#"
                            class="font-body text-body-md text-on-surface-variant transition-colors hover:text-secondary"
                        >
                            {{ $label }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="mx-auto mt-20 max-w-(--spacing-container-max) border-t border-outline-variant/10 px-5 pt-8 text-center md:px-(--spacing-margin-desktop) md:text-left">
        <p class="font-display text-label-sm text-on-surface-variant">
            &copy; {{ date('Y') }} Roshan Fernando Golf. All rights reserved. Perth, Western Australia.
        </p>
    </div>
</footer>
