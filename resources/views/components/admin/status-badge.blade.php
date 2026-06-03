@props(['status'])

@php
    $classes = match ($status->value) {
        'pending' => 'bg-amber-50 text-amber-700 ring-amber-600/15',
        'confirmed' => 'bg-primary-fixed/40 text-primary ring-primary/15',
        'cancelled' => 'bg-red-50 text-red-700 ring-red-600/15',
        'completed' => 'bg-primary/10 text-primary ring-primary/15',
        default => 'bg-slate-100 text-slate-600 ring-slate-500/15',
    };
@endphp

<span {{ $attributes->class(['inline-flex rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset', $classes]) }}>
    {{ $status->label() }}
</span>
