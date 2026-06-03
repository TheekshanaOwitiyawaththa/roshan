@props(['title' => null, 'subtitle' => null])

<div {{ $attributes->class(['overflow-hidden rounded-admin-surface border border-slate-200/90 bg-white shadow-admin-card']) }}>
    @if ($title || isset($actions))
        <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-start sm:justify-between">
            <div>
                @if ($title)
                    <h2 class="text-base font-semibold text-slate-900">{{ $title }}</h2>
                @endif
                @if ($subtitle)
                    <p class="mt-1 text-sm text-slate-500">{{ $subtitle }}</p>
                @endif
            </div>
            @isset($actions)
                <div class="flex shrink-0 items-center gap-2">{{ $actions }}</div>
            @endisset
        </div>
    @endif
    <div @class(['px-6 py-5' => $slot->isNotEmpty()])>
        {{ $slot }}
    </div>
</div>
