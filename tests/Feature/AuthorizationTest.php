<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_have_a_role(): void
    {
        $user = User::factory()->create();

        $role = Role::create([
            'name' => 'STUDENT',
            'display_name' => 'Student',
            'description' => 'Student platform user.',
        ]);

        $user->roles()->attach($role);

        $this->assertTrue($user->hasRole('STUDENT'));
    }

    public function test_user_can_have_a_permission_through_role(): void
    {
        $user = User::factory()->create();

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

        $this->assertTrue($user->hasPermission('view_dashboard'));
    }

    public function test_user_without_permission_is_denied_by_gate(): void
    {
        $user = User::factory()->create();

        $role = Role::create([
            'name' => 'STUDENT',
            'display_name' => 'Student',
            'description' => 'Student platform user.',
        ]);

        $user->roles()->attach($role);

        $this->assertFalse(
            Gate::forUser($user)->allows('view-dashboard')
        );
    }

    public function test_user_with_permission_is_allowed_by_gate(): void
    {
        $user = User::factory()->create();

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

        $this->assertTrue(
            Gate::forUser($user)->allows('view-dashboard')
        );
    }
}