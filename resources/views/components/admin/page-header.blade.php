@props(['title', 'description' => null])

<header {{ $attributes->class(['mb-8']) }}>
    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-[1.75rem]">{{ $title }}</h1>
    @if ($description)
        <p class="mt-1.5 max-w-3xl text-sm leading-relaxed text-slate-500 sm:text-[15px]">{{ $description }}</p>
    @endif
</header>
