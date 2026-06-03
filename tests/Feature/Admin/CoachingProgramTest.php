<?php

namespace Tests\Feature\Admin;

use App\Models\CoachingProgram;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoachingProgramTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_programs(): void
    {
        $this->get(route('admin.coaching-programs.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_non_admin_cannot_access_admin_programs(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)
            ->get(route('admin.coaching-programs.index'))
            ->assertForbidden();
    }

    public function test_admin_can_create_coaching_program(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->post(route('admin.coaching-programs.store'), [
                'icon' => 'person',
                'title' => 'Elite Lessons',
                'description' => 'One-on-one coaching.',
                'is_active' => '1',
                'sort_order' => 1,
            ])
            ->assertRedirect(route('admin.coaching-programs.index'))
            ->assertSessionHas('status');

        $this->assertDatabaseHas('coaching_programs', [
            'title' => 'Elite Lessons',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_update_coaching_program(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $program = CoachingProgram::factory()->create();

        $this->actingAs($admin)
            ->put(route('admin.coaching-programs.update', $program), [
                'icon' => 'map',
                'title' => 'Updated Title',
                'description' => 'Updated description.',
                'is_active' => '1',
                'sort_order' => 2,
            ])
            ->assertRedirect(route('admin.coaching-programs.index'));

        $this->assertSame('Updated Title', $program->fresh()->title);
    }

    public function test_admin_cannot_save_invalid_icon(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->post(route('admin.coaching-programs.store'), [
                'icon' => 'not_a_real_icon',
                'title' => 'Invalid Icon Program',
                'description' => 'Should fail validation.',
                'is_active' => '1',
                'sort_order' => 0,
            ])
            ->assertSessionHasErrors('icon');
    }

    public function test_admin_can_search_and_paginate_coaching_programs(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        CoachingProgram::factory()->create(['title' => 'Alpha Program']);
        CoachingProgram::factory()->create(['title' => 'Beta Program']);

        $this->actingAs($admin)
            ->get(route('admin.coaching-programs.index', ['q' => 'Alpha', 'per_page' => 5]))
            ->assertOk()
            ->assertSee('Alpha Program')
            ->assertDontSee('Beta Program');
    }

    public function test_admin_can_export_coaching_programs_csv(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        CoachingProgram::factory()->create(['title' => 'Export Me']);

        $response = $this->actingAs($admin)
            ->get(route('admin.coaching-programs.index', ['export' => 'csv']));

        $response
            ->assertOk()
            ->assertHeader('content-type', 'text/csv; charset=UTF-8');

        $this->assertStringContainsString('Export Me', $response->streamedContent());
    }
}
