<?php

namespace Tests\Feature\Admin;

use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_guest_cannot_access_locations(): void
    {
        $this->get(route('admin.locations.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_create_location_with_uploaded_image(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->post(route('admin.locations.store'), [
                'name' => 'Lake Karrinyup Country Club',
                'address' => '123 Golf Drive, Perth WA',
                'map_url' => 'https://maps.google.com/example',
                'image' => UploadedFile::fake()->image('course.jpg', 800, 400),
                'image_alt' => 'Lake Karrinyup fairway',
                'is_active' => '1',
                'sort_order' => 1,
            ])
            ->assertRedirect(route('admin.locations.index'))
            ->assertSessionHas('status');

        $location = Location::query()->firstOrFail();

        $this->assertDatabaseHas('locations', [
            'name' => 'Lake Karrinyup Country Club',
            'image_alt' => 'Lake Karrinyup fairway',
        ]);

        Storage::disk('public')->assertExists($location->image_path);
        $this->assertNotNull($location->image_url);
    }

    public function test_homepage_shows_active_locations_with_uploaded_image(): void
    {
        $location = Location::factory()->create([
            'name' => 'Joondalup Resort',
            'is_active' => true,
        ]);

        $location->update([
            'image_path' => UploadedFile::fake()->image('joondalup.jpg')->store('locations', 'public'),
            'image_url' => null,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Joondalup Resort')
            ->assertSee(Storage::disk('public')->url($location->fresh()->image_path), false);
    }
}
