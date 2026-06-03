@props([
    'name' => 'icon',
    'value' => null,
    'label' => 'Icon',
])

@php
    $selected = old($name, $value ?? 'person');
    $groups = \App\Support\MaterialIcons::pickerGroupsWith($selected);
@endphp

<div data-icon-picker class="space-y-3">
    <span class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">{{ $label }}</span>

    <input type="hidden" name="{{ $name }}" value="{{ $selected }}" data-icon-picker-input required>

    <div
        class="flex items-center gap-3 rounded-admin-control border border-slate-200 bg-slate-50 px-4 py-3"
        data-icon-picker-preview
    >
        <span class="flex size-11 shrink-0 items-center justify-center rounded-admin-control bg-primary/10 text-primary">
            <span class="material-symbols-outlined material-symbol text-[22px]" data-icon-picker-preview-icon>{{ $selected }}</span>
        </span>
        <div class="min-w-0 flex-1">
            <p class="text-sm font-semibold text-slate-900" data-icon-picker-preview-label>{{ str_replace('_', ' ', $selected) }}</p>
            <p class="text-xs text-slate-500" data-icon-picker-preview-name>{{ $selected }}</p>
        </div>
    </div>

    <div>
        <label for="{{ $name }}-search" class="sr-only">Search icons</label>
        <input
            id="{{ $name }}-search"
            type="search"
            placeholder="Search icons…"
            autocomplete="off"
            class="admin-input"
            data-icon-picker-search
        >
    </div>

    <div
        class="max-h-64 overflow-y-auto rounded-admin-surface border border-slate-200/90 bg-white p-3 shadow-admin-card"
        data-icon-picker-grid
    >
        @foreach ($groups as $group => $icons)
            <div class="mb-4 last:mb-0" data-icon-picker-group>
                <p class="mb-2 text-[11px] font-semibold tracking-wide text-slate-400 uppercase">{{ $group }}</p>
                <div class="grid grid-cols-6 gap-1.5 sm:grid-cols-8">
                    @foreach ($icons as $icon)
                        <button
                            type="button"
                            title="{{ $icon }}"
                            data-icon-picker-option="{{ $icon }}"
                            data-icon-label="{{ $icon }}"
                            @class([
                                'flex aspect-square items-center justify-center rounded-admin-control border text-slate-600 transition-colors hover:border-primary/30 hover:bg-primary/5 hover:text-primary',
                                'border-primary bg-primary/10 text-primary ring-2 ring-primary/20' => $icon === $selected,
                                'border-transparent bg-slate-50' => $icon !== $selected,
                            ])
                        >
                            <span class="material-symbols-outlined material-symbol text-[22px]">{{ $icon }}</span>
                            <span class="sr-only">{{ $icon }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        @endforeach
        <p class="hidden py-8 text-center text-sm text-slate-500" data-icon-picker-empty>No icons match your search.</p>
    </div>
</div>
