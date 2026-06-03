@props([
    'label',
    'value',
    'hint' => null,
    'hintColor' => 'text-slate-500',
    'icon',
    'iconBg' => 'bg-primary/10',
    'iconColor' => 'text-primary',
    'href' => null,
])

@php
    $tag = $href ? 'a' : 'div';
@endphp

<{{ $tag }}
    @if ($href) href="{{ $href }}" @endif
    {{ $attributes->class([
        'group block rounded-admin-surface border border-slate-200/90 bg-white p-6 shadow-admin-card transition-all',
        'hover:border-slate-300 hover:shadow-admin-card-hover' => (bool) $href,
    ]) }}
>
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0 flex-1">
            <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
            <p class="mt-2 text-[1.75rem] font-bold leading-none tracking-tight text-slate-900">{{ $value }}</p>
            @if ($hint)
                <p class="mt-2 text-sm font-medium {{ $hintColor }}">{{ $hint }}</p>
            @endif
        </div>
        <span class="flex size-11 shrink-0 items-center justify-center rounded-admin-control {{ $iconBg }} {{ $iconColor }}">
            <span class="material-symbols-outlined material-symbol text-[22px]">{{ $icon }}</span>
        </span>
    </div>
</{{ $tag }}>
