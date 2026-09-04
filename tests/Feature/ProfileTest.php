<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_profile(): void
    {
        $response = $this->get('/profile');

        $response->assertRedirect('/login');
    }

    public function test_unverified_user_cannot_access_profile(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)
            ->get('/profile');

        $response->assertRedirect('/verify-email');
    }

    public function test_verified_user_can_view_profile(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => Carbon::now(),
        ]);

        $response = $this->actingAs($user)
            ->get('/profile');

        $response->assertOk();
        $response->assertSee('My Profile');
        $response->assertSee($user->name);
        $response->assertSee($user->email);
    }

    public function test_verified_user_can_update_profile_name(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => Carbon::now(),
        ]);

        $response = $this->actingAs($user)
            ->put('/profile', [
                'name' => 'Updated Student',
            ]);

        $response->assertRedirect('/profile');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Student',
        ]);
    }

    public function test_profile_update_requires_name(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => Carbon::now(),
        ]);

        $response = $this->actingAs($user)
            ->put('/profile', [
                'name' => '',
            ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_profile_displays_user_role(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => Carbon::now(),
        ]);

        $role = Role::create([
            'name' => 'STUDENT',
            'display_name' => 'Student',
            'description' => 'Student platform user.',
        ]);

        $user->roles()->attach($role);

        $response = $this->actingAs($user)
            ->get('/profile');

        $response->assertOk();
        $response->assertSee('Student');
    }
}