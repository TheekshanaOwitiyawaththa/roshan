@extends('layouts.admin')

@section('title', 'Coaching Programs')

@section('content')
    <x-admin.data-table
        title="Coaching programs"
        description="Search, sort, and manage programs shown on the public website."
        :paginator="$programs"
        :search="$search"
        :per-page="$perPage"
        :form-action="route('admin.coaching-programs.index')"
        :create-href="route('admin.coaching-programs.create')"
        create-label="Add program"
        min-width="720px"
    >
        <x-slot:head>
            <tr>
                <th class="px-6 py-3 font-medium">#</th>
                <th class="px-6 py-3 font-medium">Title</th>
                <th class="px-6 py-3 font-medium">Icon</th>
                <th class="px-6 py-3 font-medium">Status</th>
                <th class="px-6 py-3 text-right font-medium">Actions</th>
            </tr>
        </x-slot:head>

        @forelse ($programs as $program)
            <tr class="transition-colors hover:bg-slate-50/80">
                <td class="px-6 py-4 text-slate-500">{{ ($programs->firstItem() ?? 0) + $loop->index }}</td>
                <td class="px-6 py-4 font-semibold text-slate-900">{{ $program->title }}</td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center gap-1.5 rounded-admin-control bg-slate-100 px-2 py-1 font-mono text-xs text-slate-600">
                        <span class="material-symbols-outlined material-symbol text-base">{{ $program->icon }}</span>
                        {{ $program->icon }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    @if ($program->is_active)
                        <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Active</span>
                    @else
                        <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">Hidden</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <x-admin.data-table-actions
                        :edit-href="route('admin.coaching-programs.edit', $program)"
                        :delete-action="route('admin.coaching-programs.destroy', $program)"
                        delete-confirm="Delete this program?"
                    />
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-slate-500">No programs match your search.</td>
            </tr>
        @endforelse
    </x-admin.data-table>
@endsection
