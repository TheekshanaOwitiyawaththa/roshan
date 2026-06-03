@props([
    'name',
    'filled' => false,
])

<span
    {{ $attributes->class([
        'material-symbols-outlined leading-none',
        'material-symbol' => ! $filled,
        'material-symbol-filled' => $filled,
    ]) }}
    aria-hidden="true"
>{{ $name }}</span>
