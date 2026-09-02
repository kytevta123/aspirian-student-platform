<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class RolePermissionFoundationTest extends TestCase
{
    use RefreshDatabase;

    public function test_core_roles_can_be_seeded(): void
    {
        $this->seed(\Database\Seeders\RoleSeeder::class);

        $this->assertDatabaseCount('roles', 7);

        $this->assertDatabaseHas('roles', [
            'name' => 'STUDENT',
        ]);

        $this->assertDatabaseHas('roles', [
            'name' => 'TEACHER',
        ]);

        $this->assertDatabaseHas('roles', [
            'name' => 'PARENT',
        ]);

        $this->assertDatabaseHas('roles', [
            'name' => 'SCHOOL_ADMIN',
        ]);

        $this->assertDatabaseHas('roles', [
            'name' => 'PLATFORM_ADMIN',
        ]);

        $this->assertDatabaseHas('roles', [
            'name' => 'CONTENT_EDITOR',
        ]);

        $this->assertDatabaseHas('roles', [
            'name' => 'REVIEWER',
        ]);
    }

    public function test_user_can_be_assigned_a_role(): void
    {
        $user = User::factory()->create();

        $role = Role::create([
            'name' => 'STUDENT',
            'display_name' => 'Student',
            'description' => 'Student platform user.',
        ]);

        $userRole = UserRole::create([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        $this->assertDatabaseHas('user_roles', [
            'id' => $userRole->id,
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        $this->assertTrue(
            $user->roles()->whereKey($role->id)->exists()
        );

        $this->assertTrue(
            $role->users()->whereKey($user->id)->exists()
        );
    }

    public function test_role_can_be_assigned_a_permission(): void
    {
        $role = Role::create([
            'name' => 'PLATFORM_ADMIN',
            'display_name' => 'Platform Admin',
            'description' => 'Platform administrator.',
        ]);

        $permission = Permission::create([
            'name' => 'platform.test',
            'display_name' => 'Platform Test Permission',
            'description' => 'Temporary test permission.',
        ]);

        $rolePermission = RolePermission::create([
            'role_id' => $role->id,
            'permission_id' => $permission->id,
        ]);

        $this->assertDatabaseHas('role_permissions', [
            'id' => $rolePermission->id,
            'role_id' => $role->id,
            'permission_id' => $permission->id,
        ]);

        $this->assertTrue(
            $role->permissions()->whereKey($permission->id)->exists()
        );

        $this->assertTrue(
            $permission->roles()->whereKey($role->id)->exists()
        );
    }

    public function test_duplicate_user_role_assignment_is_prevented(): void
    {
        $user = User::factory()->create();

        $role = Role::create([
            'name' => 'STUDENT',
            'display_name' => 'Student',
        ]);

        UserRole::create([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        $this->expectException(QueryException::class);

        UserRole::create([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);
    }

    public function test_duplicate_role_permission_assignment_is_prevented(): void
    {
        $role = Role::create([
            'name' => 'PLATFORM_ADMIN',
            'display_name' => 'Platform Admin',
        ]);

        $permission = Permission::create([
            'name' => 'platform.test',
            'display_name' => 'Platform Test Permission',
        ]);

        RolePermission::create([
            'role_id' => $role->id,
            'permission_id' => $permission->id,
        ]);

        $this->expectException(QueryException::class);

        RolePermission::create([
            'role_id' => $role->id,
            'permission_id' => $permission->id,
        ]);
    }

    public function test_user_role_foreign_keys_are_enforced(): void
    {
        $this->expectException(QueryException::class);

        DB::table('user_roles')->insert([
            'user_id' => 999999999,
            'role_id' => 999999999,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function test_role_permission_foreign_keys_are_enforced(): void
    {
        $this->expectException(QueryException::class);

        DB::table('role_permissions')->insert([
            'role_id' => 999999999,
            'permission_id' => 999999999,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}