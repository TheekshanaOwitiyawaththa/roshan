@extends('layouts.admin')

@section('title', 'Calendar')

@section('content')
    <x-admin.page-header
        title="Calendar"
        description="View all appointment requests by preferred date or submission date."
    />

    <x-admin.panel class="!p-0">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-6 py-4">
            <div class="flex flex-wrap gap-3 text-xs font-medium text-slate-600">
                <span class="inline-flex items-center gap-1.5">
                    <span class="size-2.5 rounded-full bg-amber-600"></span> Pending
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <span class="size-2.5 rounded-full bg-primary"></span> Confirmed
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <span class="size-2.5 rounded-full bg-emerald-600"></span> Completed
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <span class="size-2.5 rounded-full bg-rose-600"></span> Cancelled
                </span>
            </div>
            <a href="{{ route('admin.appointments.index') }}" class="text-sm font-semibold text-primary hover:underline">
                View appointments table
            </a>
        </div>

        <div class="p-4 sm:p-6">
            <div
                id="admin-calendar"
                class="admin-calendar min-h-[650px]"
                data-events-url="{{ route('admin.calendar.events') }}"
            ></div>
        </div>
    </x-admin.panel>
@endsection

@push('admin-head')
    @vite(['resources/js/admin-calendar.js'])
@endpush
