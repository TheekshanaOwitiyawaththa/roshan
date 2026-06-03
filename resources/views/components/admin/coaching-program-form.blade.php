@props(['program' => null, 'action', 'method' => 'POST'])

<form method="POST" action="{{ $action }}" class="max-w-2xl space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <x-admin.panel>
        <div class="space-y-5">
            <div>
                <label for="title" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Title</label>
                <input id="title" name="title" type="text" value="{{ old('title', $program?->title) }}" required class="admin-input">
            </div>
            <x-admin.icon-picker
                name="icon"
                :value="$program?->icon ?? 'person'"
            />
            <div>
                <label for="description" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Description</label>
                <textarea id="description" name="description" rows="5" required class="admin-input">{{ old('description', $program?->description) }}</textarea>
            </div>
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="sort_order" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Sort order</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $program?->sort_order ?? 0) }}" class="admin-input">
                </div>
                <div class="flex items-end">
                    <label class="flex w-full items-center gap-2 rounded-admin-control border border-slate-200 bg-slate-50 px-4 py-3">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $program?->is_active ?? true)) class="rounded border-slate-300 text-primary focus:ring-primary/20">
                        <span class="text-sm font-medium text-slate-700">Active on website</span>
                    </label>
                </div>
            </div>
        </div>
    </x-admin.panel>

    <div class="flex gap-3">
        <x-admin.button type="submit" variant="primary">Save program</x-admin.button>
        <x-admin.button :href="route('admin.coaching-programs.index')" variant="secondary">Cancel</x-admin.button>
    </div>
</form>
