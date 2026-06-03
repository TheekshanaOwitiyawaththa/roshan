@props([
    'linkPosts',
])

<section class="bg-surface-container-lowest px-5 py-(--spacing-section-gap) md:px-(--spacing-margin-desktop)">
    <div class="mx-auto max-w-(--spacing-container-max)">
        <div data-animate class="mb-16 flex flex-col items-center justify-between gap-6 md:flex-row">
            <div>
                <h2 class="text-center font-display text-headline-lg text-primary md:text-left">
                    Life on the Links
                </h2>
                <p class="text-center text-on-surface-variant md:text-left">
                    Follow the journey on Instagram @RoshanFernandoGolf
                </p>
            </div>
            <a
                href="{{ \App\Models\SiteSetting::instagramProfileUrl() }}"
                target="_blank"
                rel="noopener noreferrer"
                class="flex items-center gap-2 rounded-full bg-primary px-8 py-3 font-display text-label-lg uppercase text-on-primary transition-all hover:opacity-90"
            >
                <x-golf.icon name="camera" />
                Follow on Instagram
            </a>
        </div>

        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
            @forelse ($linkPosts as $post)
                @if ($post->instagram_url)
                    <a
                        href="{{ $post->instagram_url }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        data-animate
                        class="group relative block aspect-square cursor-pointer overflow-hidden rounded-lg"
                    >
                        <img
                            src="{{ $post->image_url }}"
                            alt="{{ $post->image_alt }}"
                            width="400"
                            height="400"
                            loading="lazy"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                        >
                    </a>
                @else
                    <div
                        data-animate
                        class="group relative aspect-square overflow-hidden rounded-lg"
                    >
                        <img
                            src="{{ $post->image_url }}"
                            alt="{{ $post->image_alt }}"
                            width="400"
                            height="400"
                            loading="lazy"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                        >
                    </div>
                @endif
            @empty
                <p class="col-span-full text-center text-on-surface-variant">Gallery images coming soon.</p>
            @endforelse
        </div>
    </div>
</section>
