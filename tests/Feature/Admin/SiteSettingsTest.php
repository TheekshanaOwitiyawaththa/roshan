<?php

namespace Tests\Feature\Admin;

use App\Mail\AppointmentReceivedMail;
use App\Mail\NewAppointmentMail;
use App\Models\CoachingProgram;
use App\Models\Location;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SiteSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_settings(): void
    {
        $this->get(route('admin.settings.edit'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_update_settings(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->put(route('admin.settings.update'), [
                'instagram_profile_url' => 'https://www.instagram.com/roshan_golf',
                'appointment_notification_email' => 'bookings@roshan.test',
            ])
            ->assertRedirect(route('admin.settings.edit'))
            ->assertSessionHas('status');

        $settings = SiteSetting::current();

        $this->assertSame('https://www.instagram.com/roshan_golf', $settings->instagram_profile_url);
        $this->assertSame('bookings@roshan.test', $settings->appointment_notification_email);
    }

    public function test_appointment_sends_notification_email_when_configured(): void
    {
        Mail::fake();

        SiteSetting::query()->create([
            'instagram_profile_url' => 'https://www.instagram.com/test',
            'appointment_notification_email' => 'notify@roshan.test',
        ]);

        $program = CoachingProgram::factory()->create();
        $location = Location::factory()->create();

        $this->post(route('appointments.store'), [
            'name' => 'Jane Golfer',
            'email' => 'jane@example.com',
            'coaching_program_id' => $program->id,
            'location_id' => $location->id,
        ])->assertRedirect();

        Mail::assertSent(NewAppointmentMail::class, function (NewAppointmentMail $mail): bool {
            return $mail->hasTo('notify@roshan.test');
        });

        Mail::assertSent(AppointmentReceivedMail::class, function (AppointmentReceivedMail $mail): bool {
            return $mail->hasTo('jane@example.com');
        });
    }
}
