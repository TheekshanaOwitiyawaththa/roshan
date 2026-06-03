<?php

namespace Database\Seeders;

use App\Models\CoachingProgram;
use App\Models\LinkPost;
use App\Models\Location;
use Illuminate\Database\Seeder;

class GolfContentSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('golf.services') as $index => $service) {
            CoachingProgram::query()->updateOrCreate(
                ['title' => $service['title']],
                [
                    'icon' => $service['icon'],
                    'description' => $service['description'],
                    'is_active' => true,
                    'sort_order' => $index,
                ],
            );
        }

        foreach (config('golf.locations') as $index => $location) {
            Location::query()->updateOrCreate(
                ['name' => $location['name']],
                [
                    'address' => $location['address'],
                    'map_url' => $location['map_url'],
                    'image_url' => $location['image'],
                    'image_alt' => $location['alt'],
                    'is_active' => true,
                    'sort_order' => $index,
                ],
            );
        }

        foreach (config('golf.instagram_images') as $index => $image) {
            LinkPost::query()->updateOrCreate(
                ['image_alt' => $image['alt']],
                [
                    'image_url' => $image['src'],
                    'instagram_url' => config('golf.instagram_profile_url'),
                    'is_active' => true,
                    'sort_order' => $index,
                ],
            );
        }
    }
}
