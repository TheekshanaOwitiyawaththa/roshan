@extends('layouts.admin')

@section('title', 'Appointment — '.$appointment->name)

@section('content')
    <div class="mb-6">
        <x-admin.button :href="route('admin.appointments.index')" variant="secondary">
            <span class="material-symbols-outlined material-symbol text-lg">arrow_back</span>
            Back to appointments
        </x-admin.button>
    </div>

    <x-admin.page-header title="Appointment details" description="Review and update this booking request." />

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="space-y-6 xl:col-span-2">
            <x-admin.panel title="Client information" :subtitle="'Submitted '.$appointment->created_at->format('M j, Y \a\t g:i A')">
                <div class="mb-4 flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">{{ $appointment->name }}</h3>
                        <p class="text-slate-500">{{ $appointment->email }}</p>
                        @if ($appointment->phone)
                            <p class="text-slate-500">{{ $appointment->phone }}</p>
                        @endif
                    </div>
                    <x-admin.status-badge :status="$appointment->status" />
                </div>
                <dl class="grid grid-cols-1 gap-4 border-t border-slate-100 pt-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold tracking-wide text-slate-400 uppercase">Coaching program</dt>
                        <dd class="mt-1 font-medium text-slate-900">{{ $appointment->coachingProgram?->title ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold tracking-wide text-slate-400 uppercase">Location</dt>
                        <dd class="mt-1 font-medium text-slate-900">{{ $appointment->location?->name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold tracking-wide text-slate-400 uppercase">Preferred date</dt>
                        <dd class="mt-1 font-medium text-slate-900">{{ $appointment->preferred_date?->format('l, F j, Y') ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold tracking-wide text-slate-400 uppercase">Preferred time</dt>
                        <dd class="mt-1 font-medium text-slate-900">{{ $appointment->preferred_time ?? '—' }}</dd>
                    </div>
                </dl>
                @if ($appointment->message)
                    <div class="mt-6 border-t border-slate-100 pt-4">
                        <h4 class="text-xs font-semibold tracking-wide text-slate-400 uppercase">Message</h4>
                        <p class="mt-2 whitespace-pre-wrap text-slate-700">{{ $appointment->message }}</p>
                    </div>
                @endif
            </x-admin.panel>
        </div>

        <div class="space-y-6">
            <x-admin.panel title="Update appointment">
                <form method="POST" action="{{ route('admin.appointments.update', $appointment) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="status" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Status</label>
                        <select id="status" name="status" required class="admin-input">
                            @foreach ($statuses as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $appointment->status->value) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="preferred_date" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Preferred date</label>
                        <input id="preferred_date" name="preferred_date" type="date" value="{{ old('preferred_date', $appointment->preferred_date?->format('Y-m-d')) }}" class="admin-input">
                    </div>
                    <div>
                        <label for="preferred_time" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Preferred time</label>
                        <input id="preferred_time" name="preferred_time" type="text" value="{{ old('preferred_time', $appointment->preferred_time) }}" class="admin-input">
                    </div>
                    <div>
                        <label for="admin_notes" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Admin notes</label>
                        <textarea id="admin_notes" name="admin_notes" rows="4" class="admin-input">{{ old('admin_notes', $appointment->admin_notes) }}</textarea>
                    </div>
                    <x-admin.button type="submit" variant="primary" class="w-full">Save changes</x-admin.button>
                </form>
            </x-admin.panel>

            <form method="POST" action="{{ route('admin.appointments.destroy', $appointment) }}" onsubmit="return confirm('Delete this appointment permanently?')">
                @csrf
                @method('DELETE')
                <x-admin.button type="submit" variant="danger" class="w-full">Delete appointment</x-admin.button>
            </form>
        </div>
    </div>
@endsection
