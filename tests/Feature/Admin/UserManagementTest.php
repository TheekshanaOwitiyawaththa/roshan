<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_users(): void
    {
        $this->get(route('admin.users.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_create_user(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->post(route('admin.users.store'), [
                'name' => 'Staff Member',
                'email' => 'staff@roshan.test',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'is_admin' => '0',
            ])
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('status');

        $this->assertDatabaseHas('users', [
            'email' => 'staff@roshan.test',
            'is_admin' => false,
        ]);
    }

    public function test_admin_cannot_delete_themselves(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $admin))
            ->assertSessionHasErrors('user');

        $this->assertModelExists($admin);
    }

    public function test_admin_cannot_delete_last_admin(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $otherAdmin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $otherAdmin))
            ->assertRedirect(route('admin.users.index'));

        $this->actingAs($admin)
            ->put(route('admin.users.update', $admin), [
                'name' => $admin->name,
                'email' => $admin->email,
                'is_admin' => '0',
            ])
            ->assertSessionHasErrors('is_admin');
    }
}
