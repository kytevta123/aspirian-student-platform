<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_unverified_user_cannot_access_dashboard(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)
            ->get('/dashboard');

        $response->assertRedirect('/verify-email');
    }

    public function test_verified_user_without_dashboard_permission_is_denied(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => Carbon::now(),
        ]);

        $response = $this->actingAs($user)
            ->get('/dashboard');

        $response->assertForbidden();
    }

    public function test_verified_user_with_dashboard_permission_can_access_dashboard(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => Carbon::now(),
        ]);

        $role = Role::create([
            'name' => 'STUDENT',
            'display_name' => 'Student',
            'description' => 'Student platform user.',
        ]);

        $permission = Permission::create([
            'name' => 'view_dashboard',
            'display_name' => 'View Dashboard',
            'description' => 'Access the application dashboard.',
        ]);

        $user->roles()->attach($role);
        $role->permissions()->attach($permission);

        $response = $this->actingAs($user)
            ->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Dashboard');
        $response->assertSee($user->name);
        $response->assertSee($user->email);
        $response->assertSee('Student');
        $response->assertSee('Profile');
        $response->assertSee('Logout');
    }
}