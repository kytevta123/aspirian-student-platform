<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordChangeTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_password_change_page(): void
    {
        $response = $this->get('/profile/password');

        $response->assertRedirect('/login');
    }

    public function test_unverified_user_cannot_access_password_change_page(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)
            ->get('/profile/password');

        $response->assertRedirect('/verify-email');
    }

    public function test_verified_user_can_view_password_change_page(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => Carbon::now(),
        ]);

        $response = $this->actingAs($user)
            ->get('/profile/password');

        $response->assertOk();
        $response->assertSee('Change Password');
        $response->assertSee('Current Password');
        $response->assertSee('New Password');
    }

    public function test_user_can_change_password_with_current_password(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => Carbon::now(),
            'password' => 'OldPassword123!',
        ]);

        $response = $this->actingAs($user)
            ->put('/profile/password', [
                'current_password' => 'OldPassword123!',
                'password' => 'NewPassword123!',
                'password_confirmation' => 'NewPassword123!',
            ]);

        $response->assertRedirect('/profile');

        $user->refresh();

        $this->assertTrue(
            Hash::check('NewPassword123!', $user->password)
        );
    }

    public function test_wrong_current_password_is_rejected(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => Carbon::now(),
            'password' => 'OldPassword123!',
        ]);

        $response = $this->actingAs($user)
            ->put('/profile/password', [
                'current_password' => 'WrongPassword123!',
                'password' => 'NewPassword123!',
                'password_confirmation' => 'NewPassword123!',
            ]);

        $response->assertSessionHasErrors('current_password');

        $user->refresh();

        $this->assertTrue(
            Hash::check('OldPassword123!', $user->password)
        );
    }

    public function test_password_confirmation_is_required(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => Carbon::now(),
            'password' => 'OldPassword123!',
        ]);

        $response = $this->actingAs($user)
            ->put('/profile/password', [
                'current_password' => 'OldPassword123!',
                'password' => 'NewPassword123!',
            ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_password_change_requires_current_password(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => Carbon::now(),
            'password' => 'OldPassword123!',
        ]);

        $response = $this->actingAs($user)
            ->put('/profile/password', [
                'password' => 'NewPassword123!',
                'password_confirmation' => 'NewPassword123!',
            ]);

        $response->assertSessionHasErrors('current_password');
    }
}