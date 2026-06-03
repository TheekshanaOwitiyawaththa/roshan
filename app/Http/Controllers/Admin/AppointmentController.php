<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Admin\Concerns\HandlesAdminDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAppointmentRequest;
use App\Mail\AppointmentUpdatedMail;
use App\Models\Appointment;
use App\Support\AdminCsvExport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AppointmentController extends Controller
{
    use HandlesAdminDataTable;

    public function index(Request $request): View|StreamedResponse
    {
        $status = $request->string('status')->toString();

        $query = Appointment::query()
            ->with(['coachingProgram', 'location'])
            ->when(
                filled($status) && AppointmentStatus::tryFrom($status),
                fn ($query) => $query->where('status', $status),
            )
            ->search($this->searchTerm($request))
            ->latest();

        if ($this->wantsCsvExport($request)) {
            return AdminCsvExport::download(
                $query,
                ['Name', 'Email', 'Phone', 'Program', 'Location', 'Preferred Date', 'Preferred Time', 'Status', 'Message', 'Submitted'],
                fn (Appointment $appointment) => [
                    $appointment->name,
                    $appointment->email,
                    $appointment->phone,
                    $appointment->coachingProgram?->title,
                    $appointment->location?->name,
                    $appointment->preferred_date?->format('Y-m-d'),
                    $appointment->preferred_time,
                    $appointment->status->label(),
                    $appointment->message,
                    $appointment->created_at?->format('Y-m-d H:i'),
                ],
                'appointments.csv',
            );
        }

        $perPage = $this->perPage($request, 15);

        return view('admin.appointments.index', [
            'appointments' => $query->paginate($perPage)->withQueryString(),
            'statuses' => AppointmentStatus::options(),
            'filters' => [
                'status' => $status,
            ],
            'search' => $this->searchTerm($request),
            'perPage' => $perPage,
        ]);
    }

    public function show(Appointment $appointment): View
    {
        $appointment->load(['coachingProgram', 'location']);

        return view('admin.appointments.show', [
            'appointment' => $appointment,
            'statuses' => AppointmentStatus::options(),
        ]);
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment): RedirectResponse
    {
        $appointment->update($request->validated());

        $appointment->refresh()->load(['coachingProgram', 'location']);

        Mail::to($appointment->email)->send(new AppointmentUpdatedMail($appointment));

        return redirect()
            ->route('admin.appointments.show', $appointment)
            ->with('status', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment): RedirectResponse
    {
        $appointment->delete();

        return redirect()
            ->route('admin.appointments.index')
            ->with('status', 'Appointment deleted successfully.');
    }
}
