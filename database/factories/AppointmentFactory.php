<?php

namespace Database\Factories;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\CoachingProgram;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'coaching_program_id' => CoachingProgram::factory(),
            'location_id' => Location::factory(),
            'preferred_date' => fake()->dateTimeBetween('+1 day', '+30 days')->format('Y-m-d'),
            'preferred_time' => fake()->randomElement(['09:00', '10:00', '11:00', '14:00', '15:00']),
            'message' => fake()->optional()->sentence(),
            'status' => AppointmentStatus::Pending,
            'admin_notes' => null,
        ];
    }

    public function confirmed(): static
    {
        return $this->state(fn (): array => ['status' => AppointmentStatus::Confirmed]);
    }
}
