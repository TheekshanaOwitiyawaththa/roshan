@props([
    'name' => 'image',
    'label' => 'Image',
    'currentUrl' => null,
    'required' => false,
    'hint' => null,
    'accept' => 'image/jpeg,image/png,image/webp',
])

<div>
    <label for="{{ $name }}" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    @if ($currentUrl)
        <div class="mb-3 overflow-hidden rounded-admin-surface border border-slate-200">
            <img src="{{ $currentUrl }}" alt="Current image" class="aspect-video w-full object-cover">
        </div>
    @endif

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="file"
        accept="{{ $accept }}"
        @if ($required && ! $currentUrl) required @endif
        class="admin-input file:mr-4 file:rounded-admin-control file:border-0 file:bg-primary file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-primary-container"
    >

    @if ($hint)
        <p class="mt-1 text-xs text-slate-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
