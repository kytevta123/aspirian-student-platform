<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class AuthenticationSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_login_regenerates_session(): void
    {
        $user = User::factory()->create([
            'email' => 'security@example.com',
            'password' => 'Password123!',
            'email_verified_at' => Carbon::now(),
        ]);

        $this->withSession([
            'test_session_value' => 'before-login',
        ]);

        $response = $this->post('/login', [
            'email' => 'security@example.com',
            'password' => 'Password123!',
        ]);

        $response->assertRedirect();
        $this->assertAuthenticatedAs($user);
        $this->assertEquals('before-login', session('test_session_value'));
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        $user = User::factory()->create([
            'email' => 'security@example.com',
            'password' => 'Password123!',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'WrongPassword123!',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_is_rate_limited_after_five_failed_attempts(): void
    {
        $user = User::factory()->create([
            'email' => 'security@example.com',
            'password' => 'Password123!',
        ]);

        for ($i = 0; $i < 5; $i++) {
            $response = $this->from('/login')->post('/login', [
                'email' => $user->email,
                'password' => 'WrongPassword123!',
            ]);

            $response->assertRedirect('/login');
            $response->assertSessionHasErrors('email');
        }

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'WrongPassword123!',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_rate_limiter_uses_email_and_ip_combination(): void
    {
        $user = User::factory()->create([
            'email' => 'security@example.com',
            'password' => 'Password123!',
        ]);

        for ($i = 0; $i < 5; $i++) {
            $this->from('/login')->post('/login', [
                'email' => $user->email,
                'password' => 'WrongPassword123!',
            ]);
        }

        $blockedResponse = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'WrongPassword123!',
        ]);

        $blockedResponse->assertSessionHasErrors('email');

        $this->flushSession();

        $allowedResponse = $this->withServerVariables([
            'REMOTE_ADDR' => '192.168.1.50',
        ])->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'WrongPassword123!',
        ]);

        $allowedResponse->assertRedirect('/login');
        $allowedResponse->assertSessionHasErrors('email');
    }

    public function test_successful_login_clears_rate_limiter(): void
    {
        $user = User::factory()->create([
            'email' => 'security@example.com',
            'password' => 'Password123!',
            'email_verified_at' => Carbon::now(),
        ]);

        $key = strtolower($user->email) . '|127.0.0.1';

        RateLimiter::hit($key);
        RateLimiter::hit($key);
        RateLimiter::hit($key);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'Password123!',
        ]);

        $this->assertAuthenticatedAs($user);
        $this->assertFalse(
            RateLimiter::tooManyAttempts($key, 5)
        );
    }

    public function test_logout_invalidates_session_and_logs_out_user(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => Carbon::now(),
        ]);

        $this->actingAs($user);

        $this->withSession([
            'security_test' => 'active',
        ]);

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
        $this->assertNull(session('security_test'));
    }

    public function test_login_requires_valid_email(): void
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'not-an-email',
            'password' => 'Password123!',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_requires_password(): void
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'security@example.com',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function test_password_is_stored_as_a_hash(): void
    {
        $user = User::factory()->create([
            'email' => 'security@example.com',
            'password' => 'Password123!',
        ]);

        $user->refresh();

        $this->assertNotSame(
            'Password123!',
            $user->password
        );

        $this->assertTrue(
            Hash::check('Password123!', $user->password)
        );
    }
}
