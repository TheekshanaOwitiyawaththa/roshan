<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Support\AppointmentCalendar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class CalendarController extends Controller
{
    public function index(): View
    {
        return view('admin.calendar.index');
    }

    public function events(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'start' => ['required', 'date'],
            'end' => ['required', 'date', 'after_or_equal:start'],
        ]);

        $start = Carbon::parse($validated['start'])->startOfDay();
        $end = Carbon::parse($validated['end'])->endOfDay();

        $appointments = Appointment::query()
            ->with(['coachingProgram', 'location'])
            ->where(function (Builder $query) use ($start, $end): void {
                $query->whereBetween('preferred_date', [$start->toDateString(), $end->toDateString()])
                    ->orWhere(fn (Builder $query) => $query
                        ->whereNull('preferred_date')
                        ->whereBetween('created_at', [$start, $end]));
            })
            ->orderBy('preferred_date')
            ->orderBy('preferred_time')
            ->get();

        return response()->json(
            $appointments
                ->map(fn (Appointment $appointment) => AppointmentCalendar::toEvent($appointment))
                ->values()
        );
    }
}
