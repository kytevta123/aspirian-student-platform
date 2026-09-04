<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AuthorizationMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware(['auth', 'role:STUDENT'])
            ->get('/test-role-middleware', function () {
                return 'Role middleware working.';
            });

        Route::middleware(['auth', 'permission:view_dashboard'])
            ->get('/test-permission-middleware', function () {
                return 'Permission middleware working.';
            });
    }

    public function test_user_with_required_role_can_access_role_protected_route(): void
    {
        $user = User::factory()->create();

        $role = Role::create([
            'name' => 'STUDENT',
            'display_name' => 'Student',
            'description' => 'Student platform user.',
        ]);

        $user->roles()->attach($role);

        $response = $this->actingAs($user)
            ->get('/test-role-middleware');

        $response->assertOk();
    }

    public function test_user_without_required_role_is_denied(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/test-role-middleware');

        $response->assertForbidden();
    }

    public function test_user_with_required_permission_can_access_permission_protected_route(): void
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

        $response = $this->actingAs($user)
            ->get('/test-permission-middleware');

        $response->assertOk();
    }

    public function test_user_without_required_permission_is_denied(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/test-permission-middleware');

        $response->assertForbidden();
    }
}