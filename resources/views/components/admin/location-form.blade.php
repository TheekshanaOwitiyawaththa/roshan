@props(['location' => null, 'action', 'method' => 'POST'])

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="max-w-2xl space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <x-admin.panel>
        <div class="space-y-5">
            <div>
                <label for="name" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name', $location?->name) }}" required class="admin-input">
            </div>
            <div>
                <label for="address" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Address</label>
                <input id="address" name="address" type="text" value="{{ old('address', $location?->address) }}" required class="admin-input">
            </div>
            <div>
                <label for="map_url" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Map URL</label>
                <input id="map_url" name="map_url" type="url" value="{{ old('map_url', $location?->map_url) }}" class="admin-input">
            </div>
            <x-admin.image-upload
                :current-url="$location?->image_url"
                hint="Landscape JPEG, PNG, or WebP images up to 5 MB work best for location cards."
            />
            <div>
                <label for="image_alt" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Image alt text</label>
                <input id="image_alt" name="image_alt" type="text" value="{{ old('image_alt', $location?->image_alt) }}" class="admin-input">
            </div>
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="sort_order" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Sort order</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $location?->sort_order ?? 0) }}" class="admin-input">
                </div>
                <div class="flex items-end">
                    <label class="flex w-full items-center gap-2 rounded-admin-control border border-slate-200 bg-slate-50 px-4 py-3">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $location?->is_active ?? true)) class="rounded border-slate-300 text-primary focus:ring-primary/20">
                        <span class="text-sm font-medium text-slate-700">Active on website</span>
                    </label>
                </div>
            </div>
        </div>
    </x-admin.panel>

    <div class="flex gap-3">
        <x-admin.button type="submit" variant="primary">Save location</x-admin.button>
        <x-admin.button :href="route('admin.locations.index')" variant="secondary">Cancel</x-admin.button>
    </div>
</form>
