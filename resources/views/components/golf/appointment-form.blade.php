@props([
    'coachingPrograms',
    'locations',
    'selectedProgramId' => null,
    'formId' => 'appointment-form',
])

@php
    $selectedProgramId = old('coaching_program_id', $selectedProgramId);
@endphp

<form
    id="{{ $formId }}"
    method="POST"
    action="{{ route('appointments.store') }}"
    {{ $attributes->class(['space-y-5']) }}
>
    @csrf

    @if ($errors->any())
        <div class="rounded-lg border border-error/40 bg-error/10 px-4 py-3 text-sm text-error">
            <ul class="list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="{{ $formId }}-name" class="mb-1.5 block font-display text-label-sm uppercase text-on-surface-variant">Full name</label>
            <input
                id="{{ $formId }}-name"
                name="name"
                type="text"
                value="{{ old('name') }}"
                required
                class="w-full rounded-lg border border-outline-variant/40 bg-surface px-4 py-3 text-on-surface focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
            >
        </div>
        <div>
            <label for="{{ $formId }}-email" class="mb-1.5 block font-display text-label-sm uppercase text-on-surface-variant">Email</label>
            <input
                id="{{ $formId }}-email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
                class="w-full rounded-lg border border-outline-variant/40 bg-surface px-4 py-3 text-on-surface focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
            >
        </div>
        <div>
            <label for="{{ $formId }}-phone" class="mb-1.5 block font-display text-label-sm uppercase text-on-surface-variant">Phone</label>
            <input
                id="{{ $formId }}-phone"
                name="phone"
                type="tel"
                value="{{ old('phone') }}"
                class="w-full rounded-lg border border-outline-variant/40 bg-surface px-4 py-3 text-on-surface focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
            >
        </div>
        <div>
            <label for="{{ $formId }}-coaching_program_id" class="mb-1.5 block font-display text-label-sm uppercase text-on-surface-variant">Program</label>
            <select
                id="{{ $formId }}-coaching_program_id"
                name="coaching_program_id"
                data-booking-program-select
                class="w-full rounded-lg border border-outline-variant/40 bg-surface px-4 py-3 text-on-surface focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
            >
                <option value="">Select a program</option>
                @foreach ($coachingPrograms as $program)
                    <option value="{{ $program->id }}" @selected((string) $selectedProgramId === (string) $program->id)>{{ $program->title }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="{{ $formId }}-location_id" class="mb-1.5 block font-display text-label-sm uppercase text-on-surface-variant">Location</label>
            <select
                id="{{ $formId }}-location_id"
                name="location_id"
                class="w-full rounded-lg border border-outline-variant/40 bg-surface px-4 py-3 text-on-surface focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
            >
                <option value="">Select a location</option>
                @foreach ($locations as $location)
                    <option value="{{ $location->id }}" @selected(old('location_id') == $location->id)>{{ $location->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="{{ $formId }}-preferred_date" class="mb-1.5 block font-display text-label-sm uppercase text-on-surface-variant">Preferred date</label>
            <input
                id="{{ $formId }}-preferred_date"
                name="preferred_date"
                type="date"
                value="{{ old('preferred_date') }}"
                min="{{ now()->format('Y-m-d') }}"
                class="w-full rounded-lg border border-outline-variant/40 bg-surface px-4 py-3 text-on-surface focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
            >
        </div>
        <div>
            <label for="{{ $formId }}-preferred_time" class="mb-1.5 block font-display text-label-sm uppercase text-on-surface-variant">Preferred time</label>
            <input
                id="{{ $formId }}-preferred_time"
                name="preferred_time"
                type="time"
                value="{{ old('preferred_time') }}"
                class="w-full rounded-lg border border-outline-variant/40 bg-surface px-4 py-3 text-on-surface focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
            >
        </div>
        <div class="sm:col-span-2">
            <label for="{{ $formId }}-message" class="mb-1.5 block font-display text-label-sm uppercase text-on-surface-variant">Message</label>
            <textarea
                id="{{ $formId }}-message"
                name="message"
                rows="4"
                class="w-full rounded-lg border border-outline-variant/40 bg-surface px-4 py-3 text-on-surface focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
            >{{ old('message') }}</textarea>
        </div>
    </div>

    <button
        type="submit"
        class="w-full rounded-full bg-primary py-4 font-display text-label-lg uppercase text-on-primary shadow-lg transition-transform hover:scale-[1.02] active:scale-95"
    >
        Request Appointment
    </button>
</form>
