@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <x-admin.data-table
        title="Users"
        description="Manage admin panel accounts and access levels."
        :paginator="$users"
        :search="$search"
        :per-page="$perPage"
        :form-action="route('admin.users.index')"
        :create-href="route('admin.users.create')"
        create-label="Add user"
        min-width="720px"
    >
        <x-slot:head>
            <tr>
                <th class="px-6 py-3 font-medium">#</th>
                <th class="px-6 py-3 font-medium">Name</th>
                <th class="px-6 py-3 font-medium">Email</th>
                <th class="px-6 py-3 font-medium">Role</th>
                <th class="px-6 py-3 text-right font-medium">Actions</th>
            </tr>
        </x-slot:head>

        @forelse ($users as $managedUser)
            <tr class="transition-colors hover:bg-slate-50/80">
                <td class="px-6 py-4 text-slate-500">{{ ($users->firstItem() ?? 0) + $loop->index }}</td>
                <td class="px-6 py-4">
                    <span class="font-semibold text-slate-900">{{ $managedUser->name }}</span>
                    @if ($managedUser->id === auth()->id())
                        <span class="ml-2 text-xs font-medium text-primary">(you)</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-slate-600">{{ $managedUser->email }}</td>
                <td class="px-6 py-4">
                    @if ($managedUser->is_admin)
                        <span class="inline-flex rounded-full bg-primary/10 px-2.5 py-1 text-xs font-semibold text-primary">Admin</span>
                    @else
                        <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">User</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if ($managedUser->id === auth()->id())
                        <a
                            href="{{ route('admin.users.edit', $managedUser) }}"
                            class="inline-flex size-8 items-center justify-center rounded-admin-control text-slate-500 transition-colors hover:bg-slate-100 hover:text-primary"
                            aria-label="Edit your account"
                        >
                            <span class="material-symbols-outlined material-symbol text-lg">edit</span>
                        </a>
                    @else
                        <x-admin.data-table-actions
                            :edit-href="route('admin.users.edit', $managedUser)"
                            :delete-action="route('admin.users.destroy', $managedUser)"
                            delete-confirm="Delete this user?"
                        />
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-slate-500">No users match your search.</td>
            </tr>
        @endforelse
    </x-admin.data-table>
@endsection
