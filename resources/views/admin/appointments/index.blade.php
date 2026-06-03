@extends('layouts.admin')

@section('title', 'Appointments')

@section('content')
    <x-admin.data-table
        title="Appointments"
        description="Search, filter by status, and manage lesson booking requests from the website."
        :paginator="$appointments"
        :search="$search"
        :per-page="$perPage"
        :form-action="route('admin.appointments.index')"
        min-width="960px"
    >
        <x-slot:filters>
            <select
                name="status"
                class="admin-input min-w-[10rem] lg:w-44"
                aria-label="Filter by status"
                data-admin-data-table-filter
            >
                <option value="">All statuses</option>
                @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}" @selected($filters['status'] === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </x-slot:filters>

        <x-slot:head>
            <tr>
                <th class="px-6 py-3 font-medium">#</th>
                <th class="px-6 py-3 font-medium">Client</th>
                <th class="px-6 py-3 font-medium">Program</th>
                <th class="px-6 py-3 font-medium">Location</th>
                <th class="px-6 py-3 font-medium">Preferred</th>
                <th class="px-6 py-3 font-medium">Status</th>
                <th class="px-6 py-3 font-medium">Submitted</th>
            </tr>
        </x-slot:head>

        @forelse ($appointments as $appointment)
            <tr class="transition-colors hover:bg-slate-50/80">
                <td class="px-6 py-4 text-slate-500">{{ ($appointments->firstItem() ?? 0) + $loop->index }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.appointments.show', $appointment) }}" class="font-semibold text-primary hover:underline">
                        {{ $appointment->name }}
                    </a>
                    <div class="text-slate-500">{{ $appointment->email }}</div>
                </td>
                <td class="px-6 py-4 text-slate-600">{{ $appointment->coachingProgram?->title ?? '—' }}</td>
                <td class="px-6 py-4 text-slate-600">{{ $appointment->location?->name ?? '—' }}</td>
                <td class="px-6 py-4 text-slate-600">
                    {{ $appointment->preferred_date?->format('M j, Y') ?? '—' }}
                    @if ($appointment->preferred_time)
                        <div class="text-xs text-slate-400">{{ $appointment->preferred_time }}</div>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <x-admin.status-badge :status="$appointment->status" />
                </td>
                <td class="px-6 py-4 text-slate-500">{{ $appointment->created_at->format('M j, Y g:i A') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center text-slate-500">No appointments match your filters.</td>
            </tr>
        @endforelse
    </x-admin.data-table>
@endsection
