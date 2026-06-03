<?php

namespace Tests\Feature;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\CoachingProgram;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentBookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_submit_appointment_request(): void
    {
        $program = CoachingProgram::factory()->create();
        $location = Location::factory()->create();

        $this->post(route('appointments.store'), [
            'name' => 'Jane Golfer',
            'email' => 'jane@example.com',
            'phone' => '0400000000',
            'coaching_program_id' => $program->id,
            'location_id' => $location->id,
            'preferred_date' => now()->addDay()->format('Y-m-d'),
            'preferred_time' => '10:00',
            'message' => 'Looking forward to improving my short game.',
        ])
            ->assertRedirect(route('home').'#booking')
            ->assertSessionHas('booking_success');

        $appointment = Appointment::query()->first();

        $this->assertNotNull($appointment);
        $this->assertSame('Jane Golfer', $appointment->name);
        $this->assertSame(AppointmentStatus::Pending, $appointment->status);
    }

    public function test_appointment_requires_valid_email(): void
    {
        $this->post(route('appointments.store'), [
            'name' => 'Jane Golfer',
            'email' => 'not-an-email',
        ])
            ->assertSessionHasErrors('email');
    }

    public function test_home_page_includes_booking_modal(): void
    {
        CoachingProgram::factory()->create();
        Location::factory()->create();

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('id="booking-modal"', false)
            ->assertSee('data-booking-open', false);
    }
}
