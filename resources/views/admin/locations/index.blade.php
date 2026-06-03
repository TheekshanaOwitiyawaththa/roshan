@extends('layouts.admin')

@section('title', 'Locations')

@section('content')
    <x-admin.data-table
        title="Locations"
        description="Search and manage Perth coaching locations on the public website."
        :paginator="$locations"
        :search="$search"
        :per-page="$perPage"
        :form-action="route('admin.locations.index')"
        :create-href="route('admin.locations.create')"
        create-label="Add location"
        min-width="800px"
    >
        <x-slot:head>
            <tr>
                <th class="px-6 py-3 font-medium">#</th>
                <th class="px-6 py-3 font-medium">Name</th>
                <th class="px-6 py-3 font-medium">Address</th>
                <th class="px-6 py-3 font-medium">Status</th>
                <th class="px-6 py-3 text-right font-medium">Actions</th>
            </tr>
        </x-slot:head>

        @forelse ($locations as $location)
            <tr class="transition-colors hover:bg-slate-50/80">
                <td class="px-6 py-4 text-slate-500">{{ ($locations->firstItem() ?? 0) + $loop->index }}</td>
                <td class="px-6 py-4 font-semibold text-slate-900">{{ $location->name }}</td>
                <td class="max-w-xs truncate px-6 py-4 text-slate-600">{{ $location->address }}</td>
                <td class="px-6 py-4">
                    @if ($location->is_active)
                        <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Active</span>
                    @else
                        <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">Hidden</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <x-admin.data-table-actions
                        :edit-href="route('admin.locations.edit', $location)"
                        :delete-action="route('admin.locations.destroy', $location)"
                        delete-confirm="Delete this location?"
                    />
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-slate-500">No locations match your search.</td>
            </tr>
        @endforelse
    </x-admin.data-table>
@endsection
