@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    @php
        $hiddenPrograms = $stats['total_programs'] - $stats['active_programs'];
    @endphp

    <x-admin.page-header
        title="Dashboard"
        :description="'Welcome back, '.auth()->user()->name.'! Coaching programs, locations, and bookings at a glance.'"
    />

    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-admin.stat-card
            label="Coaching programs"
            :value="$stats['active_programs'].' / '.$stats['total_programs']"
            hint="{{ $hiddenPrograms > 0 ? $hiddenPrograms.' hidden on site' : 'All programs visible' }}"
            :hint-color="$hiddenPrograms > 0 ? 'text-amber-600' : 'text-primary'"
            icon="school"
            icon-bg="bg-primary/10"
            icon-color="text-primary"
            :href="route('admin.coaching-programs.index')"
        />
        <x-admin.stat-card
            label="Perth locations"
            :value="$stats['active_locations'].' / '.$stats['total_locations']"
            hint="Active coaching venues"
            hint-color="text-primary"
            icon="location_on"
            icon-bg="bg-primary-fixed/50"
            icon-color="text-primary-container"
            :href="route('admin.locations.index')"
        />
        <x-admin.stat-card
            label="Pending appointments"
            :value="(string) $stats['pending_appointments']"
            hint="{{ $stats['pending_appointments'] > 0 ? 'Awaiting your review' : 'All caught up' }}"
            :hint-color="$stats['pending_appointments'] > 0 ? 'text-amber-600' : 'text-primary'"
            icon="pending_actions"
            icon-bg="bg-secondary-container/60"
            icon-color="text-secondary"
            :href="route('admin.appointments.index', ['status' => 'pending'])"
        />
        <x-admin.stat-card
            label="Total bookings"
            :value="(string) $stats['total_appointments']"
            hint="{{ $stats['confirmed_appointments'] }} confirmed"
            hint-color="text-slate-500"
            icon="event_available"
            icon-bg="bg-surface-container"
            icon-color="text-surface-tint"
            :href="route('admin.appointments.index')"
        />
    </div>

    <div class="mb-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
        <x-admin.panel
            class="xl:col-span-2"
            title="Booking requests"
            subtitle="Daily submissions — lesson requests (last 7 days)"
        >
            <div class="mb-4 flex flex-wrap items-center gap-4 text-xs font-medium text-slate-600">
                <span class="inline-flex items-center gap-2">
                    <span class="size-2.5 rounded-full bg-primary"></span>
                    Booking requests
                </span>
            </div>
            <div class="h-56 sm:h-64">
                <canvas
                    data-chart="line"
                    data-labels='@json($trendLabels)'
                    data-values='@json($trendValues)'
                ></canvas>
            </div>
            <div class="mt-5 flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">
                    <span class="font-semibold text-slate-700">7-day total</span>
                    {{ array_sum($trendValues) }} requests
                </p>
                <x-admin.button :href="route('admin.appointments.index')" variant="primary">
                    View appointments
                </x-admin.button>
            </div>
        </x-admin.panel>

        <x-admin.panel title="Appointment status" subtitle="Breakdown of all booking requests">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center">
                <div class="relative mx-auto h-44 w-44 shrink-0 sm:mx-0">
                    <canvas
                        data-chart="doughnut"
                        data-labels='@json($breakdownLabels)'
                        data-values='@json($breakdownValues)'
                        data-colors='@json($breakdownColors)'
                    ></canvas>
                    <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center text-center">
                        <span class="text-2xl font-bold text-slate-900">{{ $stats['total_appointments'] }}</span>
                        <span class="text-[11px] font-medium tracking-wide text-slate-500 uppercase">Bookings</span>
                    </div>
                </div>
                <ul class="min-w-0 flex-1 space-y-2.5">
                    @foreach ($breakdownLabels as $index => $label)
                        <li class="flex items-center justify-between gap-2 text-sm">
                            <span class="flex min-w-0 items-center gap-2 text-slate-600">
                                <span class="size-2.5 shrink-0 rounded-full" style="background: {{ $breakdownColors[$index] }}"></span>
                                <span class="truncate">{{ $label }}</span>
                            </span>
                            <span class="shrink-0 font-semibold text-slate-900">
                                @if ($stats['total_appointments'] > 0)
                                    {{ number_format(($breakdownValues[$index] / $stats['total_appointments']) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
            @if ($stats['total_appointments'] > 0 && ($confirmed = $breakdownValues[array_search('Confirmed', $breakdownLabels)] ?? 0) > 0)
                <p class="mt-5 border-t border-slate-100 pt-4 text-sm font-medium text-primary">
                    {{ number_format(($confirmed / $stats['total_appointments']) * 100, 1) }}% confirmed
                </p>
            @endif
        </x-admin.panel>
    </div>

    <x-admin.panel title="Recent appointments" subtitle="Latest booking requests from the website">
        <x-slot:actions>
            <x-admin.button :href="route('admin.appointments.index')" variant="secondary">View all</x-admin.button>
        </x-slot:actions>

        <div class="-mx-6 overflow-x-auto">
            <table class="w-full min-w-[640px] text-left text-sm">
                <thead class="border-y border-slate-100 bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-6 py-3 font-medium">Client</th>
                        <th class="px-6 py-3 font-medium">Program</th>
                        <th class="px-6 py-3 font-medium">Preferred</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($recentAppointments as $appointment)
                        <tr class="transition-colors hover:bg-slate-50/80">
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.appointments.show', $appointment) }}" class="font-semibold text-primary hover:underline">
                                    {{ $appointment->name }}
                                </a>
                                <div class="text-slate-500">{{ $appointment->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $appointment->coachingProgram?->title ?? '—' }}</td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $appointment->preferred_date?->format('M j, Y') ?? '—' }}
                                @if ($appointment->preferred_time)
                                    <div class="text-xs text-slate-400">{{ $appointment->preferred_time }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <x-admin.status-badge :status="$appointment->status" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">No appointments yet. Bookings from the website will appear here.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-admin.panel>
@endsection
