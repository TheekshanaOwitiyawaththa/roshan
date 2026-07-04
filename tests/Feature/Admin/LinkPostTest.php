<?php

namespace Tests\Feature\Admin;

use App\Models\LinkPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LinkPostTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_guest_cannot_access_link_posts(): void
    {
        $this->get(route('admin.link-posts.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_create_link_post_with_uploaded_image(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->post(route('admin.link-posts.store'), [
                'image' => UploadedFile::fake()->image('golf.jpg', 400, 400),
                'image_alt' => 'Golfer on the green',
                'instagram_url' => 'https://www.instagram.com/p/example',
                'is_active' => '1',
                'sort_order' => 1,
            ])
            ->assertRedirect(route('admin.link-posts.index'))
            ->assertSessionHas('status');

        $post = LinkPost::query()->firstOrFail();

        $this->assertDatabaseHas('link_posts', [
            'image_alt' => 'Golfer on the green',
            'is_active' => true,
        ]);

        Storage::disk('public')->assertExists($post->image_path);
        $this->assertNotNull($post->image_url);
    }

    public function test_admin_can_update_link_post_image(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $post = LinkPost::factory()->create([
            'image_url' => 'https://example.com/original.jpg',
            'image_path' => null,
        ]);

        $this->actingAs($admin)
            ->put(route('admin.link-posts.update', $post), [
                'image' => UploadedFile::fake()->image('updated.jpg', 400, 400),
                'image_alt' => 'Updated alt text',
                'is_active' => '1',
                'sort_order' => 0,
            ])
            ->assertRedirect(route('admin.link-posts.index'));

        $post->refresh();

        $this->assertSame('Updated alt text', $post->image_alt);
        $this->assertNotNull($post->image_path);
        Storage::disk('public')->assertExists($post->image_path);
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
