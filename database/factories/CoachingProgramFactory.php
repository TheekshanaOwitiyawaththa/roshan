<?php

namespace Database\Factories;

use App\Models\CoachingProgram;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CoachingProgram>
 */
class CoachingProgramFactory extends Factory
{
    protected $model = CoachingProgram::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'icon' => fake()->randomElement(['person', 'stadium', 'face', 'sports_golf', 'map', 'videocam']),
            'title' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (): array => ['is_active' => false]);
    }
}
