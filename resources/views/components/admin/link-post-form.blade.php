@props(['linkPost' => null, 'action', 'method' => 'POST'])

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="max-w-2xl space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <x-admin.panel>
        <div class="space-y-5">
            <x-admin.image-upload
                :current-url="$linkPost?->image_url"
                :required="! $linkPost"
                hint="Square JPEG, PNG, or WebP images up to 5 MB work best in the gallery grid."
            />
            <div>
                <label for="image_alt" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Image alt text</label>
                <input id="image_alt" name="image_alt" type="text" value="{{ old('image_alt', $linkPost?->image_alt) }}" required class="admin-input">
            </div>
            <div>
                <label for="instagram_url" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Instagram post URL (optional)</label>
                <input id="instagram_url" name="instagram_url" type="url" value="{{ old('instagram_url', $linkPost?->instagram_url) }}" class="admin-input" placeholder="https://www.instagram.com/p/...">
            </div>
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="sort_order" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Sort order</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $linkPost?->sort_order ?? 0) }}" class="admin-input">
                </div>
                <div class="flex items-end">
                    <label class="flex w-full items-center gap-2 rounded-admin-control border border-slate-200 bg-slate-50 px-4 py-3">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $linkPost?->is_active ?? true)) class="rounded border-slate-300 text-primary focus:ring-primary/20">
                        <span class="text-sm font-medium text-slate-700">Active on website</span>
                    </label>
                </div>
            </div>
        </div>
    </x-admin.panel>

    <div class="flex gap-3">
        <x-admin.button type="submit" variant="primary">Save post</x-admin.button>
        <x-admin.button :href="route('admin.link-posts.index')" variant="secondary">Cancel</x-admin.button>
    </div>
</form>
