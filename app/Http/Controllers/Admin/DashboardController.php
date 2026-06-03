<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\CoachingProgram;
use App\Models\Location;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $activePrograms = CoachingProgram::query()->where('is_active', true)->count();
        $activeLocations = Location::query()->where('is_active', true)->count();
        $pendingAppointments = Appointment::query()->where('status', AppointmentStatus::Pending)->count();
        $totalAppointments = Appointment::query()->count();
        $confirmedAppointments = Appointment::query()->where('status', AppointmentStatus::Confirmed)->count();

        $trendLabels = [];
        $trendValues = [];

        for ($daysAgo = 6; $daysAgo >= 0; $daysAgo--) {
            $date = Carbon::today()->subDays($daysAgo);
            $trendLabels[] = $date->format('D');
            $trendValues[] = Appointment::query()->whereDate('created_at', $date)->count();
        }

        $statusBreakdown = collect(AppointmentStatus::cases())->mapWithKeys(function (AppointmentStatus $status) {
            return [
                $status->value => Appointment::query()->where('status', $status)->count(),
            ];
        });

        $breakdownLabels = $statusBreakdown->keys()->map(fn (string $value) => AppointmentStatus::from($value)->label())->values()->all();
        $breakdownValues = $statusBreakdown->values()->all();
        $breakdownColors = ['#d97706', '#01261f', '#94a3b8', '#43655c'];

        return view('admin.dashboard', [
            'stats' => [
                'active_programs' => $activePrograms,
                'total_programs' => CoachingProgram::query()->count(),
                'active_locations' => $activeLocations,
                'total_locations' => Location::query()->count(),
                'pending_appointments' => $pendingAppointments,
                'confirmed_appointments' => $confirmedAppointments,
                'total_appointments' => $totalAppointments,
            ],
            'trendLabels' => $trendLabels,
            'trendValues' => $trendValues,
            'breakdownLabels' => $breakdownLabels,
            'breakdownValues' => $breakdownValues,
            'breakdownColors' => $breakdownColors,
            'recentAppointments' => Appointment::query()
                ->with(['coachingProgram', 'location'])
                ->latest()
                ->limit(6)
                ->get(),
        ]);
    }
}
