@props(['user' => null, 'action', 'method' => 'POST'])

@php
    $isEdit = $user !== null;
@endphp

<form method="POST" action="{{ $action }}" class="max-w-2xl space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <x-admin.panel>
        <div class="space-y-5">
            <div>
                <label for="name" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user?->name) }}" required class="admin-input">
            </div>
            <div>
                <label for="email" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user?->email) }}" required class="admin-input" autocomplete="email">
            </div>
            <div>
                <label for="password" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">
                    {{ $isEdit ? 'New password' : 'Password' }}
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    @required(! $isEdit)
                    class="admin-input"
                    autocomplete="{{ $isEdit ? 'new-password' : 'new-password' }}"
                >
                @if ($isEdit)
                    <p class="mt-1 text-xs text-slate-500">Leave blank to keep the current password.</p>
                @endif
            </div>
            <div>
                <label for="password_confirmation" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Confirm password</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    @required(! $isEdit)
                    class="admin-input"
                    autocomplete="new-password"
                >
            </div>
            <div>
                <label class="flex w-full items-center gap-2 rounded-admin-control border border-slate-200 bg-slate-50 px-4 py-3">
                    <input type="hidden" name="is_admin" value="0">
                    <input
                        type="checkbox"
                        name="is_admin"
                        value="1"
                        @checked(old('is_admin', $user?->is_admin ?? false))
                        @disabled($isEdit && $user->id === auth()->id())
                        class="rounded border-slate-300 text-primary focus:ring-primary/20 disabled:opacity-50"
                    >
                    <span class="text-sm font-medium text-slate-700">Admin access</span>
                </label>
                @if ($isEdit && $user->id === auth()->id())
                    <p class="mt-1 text-xs text-slate-500">You cannot remove admin access from your own account.</p>
                @endif
            </div>
        </div>
    </x-admin.panel>

    <div class="flex gap-3">
        <x-admin.button type="submit" variant="primary">{{ $isEdit ? 'Save user' : 'Create user' }}</x-admin.button>
        <x-admin.button :href="route('admin.users.index')" variant="secondary">Cancel</x-admin.button>
    </div>
</form>
