<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Http\Requests\StoreAppointmentRequest;
use App\Mail\AppointmentReceivedMail;
use App\Mail\NewAppointmentMail;
use App\Models\Appointment;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function store(StoreAppointmentRequest $request): RedirectResponse
    {
        $appointment = Appointment::query()->create([
            ...$request->validated(),
            'status' => AppointmentStatus::Pending,
        ]);

        Mail::to($appointment->email)->send(new AppointmentReceivedMail($appointment));

        $notificationEmail = SiteSetting::appointmentNotificationEmail();

        if ($notificationEmail !== null) {
            Mail::to($notificationEmail)->send(new NewAppointmentMail($appointment));
        }

        return redirect()
            ->to(route('home').'#booking')
            ->with('booking_success', 'Thank you! Your appointment request has been received. We will contact you shortly.');
    }
}
