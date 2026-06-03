<?php

namespace App\Support;

use App\Models\Appointment;
use Illuminate\Support\Carbon;

class AppointmentCalendar
{
    /**
     * @return array<string, mixed>
     */
    public static function toEvent(Appointment $appointment): array
    {
        $title = $appointment->name;

        if ($appointment->coachingProgram) {
            $title .= ' — '.$appointment->coachingProgram->title;
        }

        $event = [
            'id' => (string) $appointment->id,
            'title' => $title,
            'url' => route('admin.appointments.show', $appointment),
            'backgroundColor' => $appointment->status->calendarColor(),
            'borderColor' => $appointment->status->calendarBorderColor(),
            'extendedProps' => [
                'status' => $appointment->status->label(),
                'email' => $appointment->email,
                'location' => $appointment->location?->name,
                'hasPreferredDate' => $appointment->preferred_date !== null,
            ],
        ];

        if ($appointment->preferred_date) {
            return [
                ...$event,
                ...self::timingFromPreferred($appointment),
            ];
        }

        return [
            ...$event,
            'start' => $appointment->created_at->toDateString(),
            'allDay' => true,
            'title' => $title.' (no preferred date)',
        ];
    }

    /**
     * @return array{start: string, end?: string, allDay: bool}
     */
    private static function timingFromPreferred(Appointment $appointment): array
    {
        if (blank($appointment->preferred_time)) {
            return [
                'start' => $appointment->preferred_date->toDateString(),
                'allDay' => true,
            ];
        }

        $start = Carbon::parse($appointment->preferred_date->toDateString().' '.$appointment->preferred_time);

        return [
            'start' => $start->toIso8601String(),
            'end' => $start->copy()->addHour()->toIso8601String(),
            'allDay' => false,
        ];
    }
}
