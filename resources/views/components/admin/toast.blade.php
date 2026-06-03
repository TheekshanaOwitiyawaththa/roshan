@props([
    'variant' => 'success',
    'title' => null,
    'message',
    'duration' => 5000,
])

@php
    $config = match ($variant) {
        'warning' => [
            'title' => $title ?? 'Warning',
            'icon' => 'warning',
            'iconBg' => 'bg-amber-50',
            'iconColor' => 'text-amber-500',
            'progress' => 'bg-amber-500',
        ],
        'error' => [
            'title' => $title ?? 'Error',
            'icon' => 'close',
            'iconBg' => 'bg-rose-50',
            'iconColor' => 'text-rose-500',
            'progress' => 'bg-rose-500',
        ],
        default => [
            'title' => $title ?? 'Success',
            'icon' => 'check_circle',
            'iconBg' => 'bg-emerald-50',
            'iconColor' => 'text-emerald-500',
            'progress' => 'bg-emerald-500',
        ],
    };
@endphp

<div
    role="alert"
    data-admin-toast
    data-duration="{{ $duration }}"
    {{ $attributes->class([
        'pointer-events-auto relative w-full overflow-hidden rounded-admin-surface border border-slate-200/90 bg-white shadow-admin-card-hover',
        'translate-x-8 opacity-0',
    ]) }}
>
    <div class="flex gap-3 p-4 pr-10">
        <span class="flex size-10 shrink-0 items-center justify-center rounded-admin-control {{ $config['iconBg'] }} {{ $config['iconColor'] }}">
            <span class="material-symbols-outlined material-symbol text-[22px]">{{ $config['icon'] }}</span>
        </span>
        <div class="min-w-0 pt-0.5">
            <p class="text-sm font-semibold text-slate-900">{{ $config['title'] }}</p>
            <p class="mt-0.5 text-sm text-slate-500">{{ $message }}</p>
        </div>
    </div>

    <button
        type="button"
        data-admin-toast-close
        class="absolute top-3 right-3 rounded-admin-control p-1 text-slate-400 transition-colors hover:bg-slate-50 hover:text-slate-600"
        aria-label="Dismiss notification"
    >
        <span class="material-symbols-outlined material-symbol text-lg">close</span>
    </button>

    <div class="h-1 bg-slate-100">
        <div
            data-admin-toast-progress
            class="h-full {{ $config['progress'] }}"
            style="--toast-duration: {{ $duration }}ms"
        ></div>
    </div>
</div>
