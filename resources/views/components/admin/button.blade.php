@props([
    'variant' => 'primary',
    'href' => null,
    'type' => 'button',
])

@php
    $classes = match ($variant) {
        'primary' => 'bg-primary text-on-primary hover:bg-primary-container shadow-sm',
        'secondary' => 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50',
        'danger' => 'border border-red-200 bg-white text-red-600 hover:bg-red-50',
        default => 'bg-primary text-on-primary hover:bg-primary-container',
    };
    $base = 'inline-flex items-center justify-center gap-2 rounded-admin-control px-4 py-2.5 text-sm font-semibold transition-colors';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class([$base, $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->class([$base, $classes]) }}>{{ $slot }}</button>
@endif
