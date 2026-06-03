@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
    <x-admin.page-header
        title="Settings"
        description="Configure public site links and appointment notification email."
    />

    <form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-2xl space-y-6">
        @csrf
        @method('PUT')

        <x-admin.panel title="Life on the Links" subtitle="Instagram profile used for the Follow button and default gallery links.">
            <div>
                <label for="instagram_profile_url" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Instagram profile URL</label>
                <input
                    id="instagram_profile_url"
                    name="instagram_profile_url"
                    type="url"
                    value="{{ old('instagram_profile_url', $settings->instagram_profile_url) }}"
                    required
                    class="admin-input"
                    placeholder="https://www.instagram.com/yourprofile"
                >
            </div>
        </x-admin.panel>

        <x-admin.panel title="Appointments" subtitle="Receive an email when someone submits a booking request on the website.">
            <div>
                <label for="appointment_notification_email" class="mb-1.5 block text-xs font-semibold tracking-wide text-slate-500 uppercase">Notification email</label>
                <input
                    id="appointment_notification_email"
                    name="appointment_notification_email"
                    type="email"
                    value="{{ old('appointment_notification_email', $settings->appointment_notification_email) }}"
                    class="admin-input"
                    placeholder="coach@example.com"
                >
                <p class="mt-1 text-xs text-slate-500">Leave empty to disable appointment notification emails.</p>
            </div>
        </x-admin.panel>

        <div class="flex gap-3">
            <x-admin.button type="submit" variant="primary">Save settings</x-admin.button>
        </div>
    </form>
@endsection
