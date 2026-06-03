<?php

namespace Database\Factories;

use App\Models\LinkPost;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LinkPost>
 */
class LinkPostFactory extends Factory
{
    protected $model = LinkPost::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image_url' => 'https://picsum.photos/seed/'.fake()->unique()->numberBetween(1, 9999).'/400/400',
            'image_alt' => fake()->sentence(3),
            'instagram_url' => fake()->optional()->url(),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
