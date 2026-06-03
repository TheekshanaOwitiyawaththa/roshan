<?php

namespace Tests\Feature\Admin;

use App\Models\LinkPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_link_posts(): void
    {
        $this->get(route('admin.link-posts.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_create_link_post(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->post(route('admin.link-posts.store'), [
                'image_url' => 'https://example.com/golf.jpg',
                'image_alt' => 'Golfer on the green',
                'instagram_url' => 'https://www.instagram.com/p/example',
                'is_active' => '1',
                'sort_order' => 1,
            ])
            ->assertRedirect(route('admin.link-posts.index'))
            ->assertSessionHas('status');

        $this->assertDatabaseHas('link_posts', [
            'image_alt' => 'Golfer on the green',
            'is_active' => true,
        ]);
    }

    public function test_homepage_shows_active_link_posts(): void
    {
        LinkPost::factory()->create([
            'image_alt' => 'Sunset on the course',
            'is_active' => true,
        ]);

        LinkPost::factory()->create([
            'image_alt' => 'Hidden gallery item',
            'is_active' => false,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Sunset on the course')
            ->assertDontSee('Hidden gallery item');
    }
}
