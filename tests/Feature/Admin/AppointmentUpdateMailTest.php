<?php

namespace Tests\Feature\Admin;

use App\Enums\AppointmentStatus;
use App\Mail\AppointmentUpdatedMail;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AppointmentUpdateMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_update_sends_email_to_customer(): void
    {
        Mail::fake();

        $admin = User::factory()->create(['is_admin' => true]);
        $appointment = Appointment::factory()->create([
            'email' => 'customer@example.com',
            'status' => AppointmentStatus::Pending,
        ]);

        $this->actingAs($admin)
            ->put(route('admin.appointments.update', $appointment), [
                'status' => AppointmentStatus::Confirmed->value,
                'admin_notes' => 'See you at the range.',
            ])
            ->assertRedirect(route('admin.appointments.show', $appointment));

        Mail::assertSent(AppointmentUpdatedMail::class, function (AppointmentUpdatedMail $mail): bool {
            return $mail->hasTo('customer@example.com')
                && $mail->appointment->status === AppointmentStatus::Confirmed;
        });
    }
}
