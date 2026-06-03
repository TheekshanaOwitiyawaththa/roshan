<?php

namespace Tests\Feature\Admin;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendarTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_calendar(): void
    {
        $this->get(route('admin.calendar'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_calendar_page(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->withoutVite();

        $this->actingAs($admin)
            ->get(route('admin.calendar'))
            ->assertOk()
            ->assertSee('id="admin-calendar"', false);
    }

    public function test_admin_can_fetch_calendar_events(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $preferredDate = now()->startOfMonth()->addDays(10);

        $appointment = Appointment::factory()->create([
            'name' => 'Calendar Golfer',
            'preferred_date' => $preferredDate->toDateString(),
        ]);

        $start = $preferredDate->copy()->startOfMonth()->toDateString();
        $end = $preferredDate->copy()->endOfMonth()->toDateString();

        $this->actingAs($admin)
            ->getJson(route('admin.calendar.events', ['start' => $start, 'end' => $end]))
            ->assertOk()
            ->assertJsonFragment([
                'id' => (string) $appointment->id,
                'title' => 'Calendar Golfer — '.$appointment->coachingProgram->title,
            ]);
    }
}
