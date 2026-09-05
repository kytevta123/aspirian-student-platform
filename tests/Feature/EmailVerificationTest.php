<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_sends_verification_email(): void
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'Test Student',
            'email' => 'student@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect(route('verification.notice'));

        $user = User::where('email', 'student@example.com')->first();

        $this->assertNotNull($user);
        $this->assertNull($user->email_verified_at);

        Notification::assertSentTo(
            $user,
            VerifyEmail::class
        );
    }

    public function test_unverified_user_can_access_verification_notice(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)
            ->get(route('verification.notice'));

        $response->assertOk();
        $response->assertViewIs('auth.verify-email');
    }

    public function test_guest_cannot_access_verification_notice(): void
    {
        $response = $this->get(route('verification.notice'));

        $response->assertRedirect(route('login.form'));
    }

    public function test_valid_signed_verification_link_verifies_email(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        $response = $this->actingAs($user)->get($url);

        $response->assertRedirect('/');

        $user->refresh();

        $this->assertTrue($user->hasVerifiedEmail());
        $this->assertNotNull($user->email_verified_at);
    }

    public function test_invalid_signature_is_rejected(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $user->getKey(),
                'hash' => 'invalid-hash',
            ]
        );

        $response = $this->actingAs($user)->get($url);

        $response->assertForbidden();

        $user->refresh();

        $this->assertNull($user->email_verified_at);
    }

    public function test_expired_verification_link_is_rejected(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->subMinutes(10),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        $response = $this->actingAs($user)->get($url);

        $response->assertForbidden();

        $user->refresh();

        $this->assertNull($user->email_verified_at);
    }

    public function test_verification_link_for_different_user_is_rejected(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $differentUser = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $differentUser->getKey(),
                'hash' => sha1($differentUser->getEmailForVerification()),
            ]
        );

        $response = $this->actingAs($user)->get($url);

        $response->assertForbidden();

        $user->refresh();
        $differentUser->refresh();

        $this->assertNull($user->email_verified_at);
        $this->assertNull($differentUser->email_verified_at);
    }

    public function test_already_verified_user_is_not_verified_again(): void
    {
        $verifiedAt = Carbon::now()->subHour();

        $user = User::factory()->create([
            'email_verified_at' => $verifiedAt,
        ]);

        $url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        $response = $this->actingAs($user)->get($url);

        $response->assertRedirect('/');

        $user->refresh();

        $this->assertEquals(
            $verifiedAt->timestamp,
            $user->email_verified_at->timestamp
        );
    }

    public function test_unverified_user_can_resend_verification_email(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)
            ->post(route('verification.send'));

        $response->assertRedirect();

        $response->assertSessionHas(
            'status',
            'A new verification link has been sent to your email address.'
        );

        Notification::assertSentTo(
            $user,
            VerifyEmail::class
        );
    }

    public function test_verified_user_cannot_resend_verification_email(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email_verified_at' => Carbon::now(),
        ]);

        $response = $this->actingAs($user)
            ->post(route('verification.send'));

        $response->assertRedirect('/');

        Notification::assertNothingSent();
    }

    public function test_guest_cannot_resend_verification_email(): void
    {
        Notification::fake();

        $response = $this->post(route('verification.send'));

        $response->assertRedirect(route('login.form'));

        Notification::assertNothingSent();
    }

    public function test_verification_resend_is_rate_limited(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        for ($i = 0; $i < 6; $i++) {
            $this->actingAs($user)
                ->post(route('verification.send'))
                ->assertRedirect();
        }

        $this->actingAs($user)
            ->post(route('verification.send'))
            ->assertStatus(429);
    }

    public function test_verified_user_can_access_protected_dashboard(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => Carbon::now(),
        ]);

        $role = Role::where('name', 'student')->first();

        if (! $role) {
            $role = Role::create([
                'name' => 'student',
                'display_name' => 'Student',
            ]);
        }

        $permission = Permission::where('name', 'view_dashboard')->first();

        if (! $permission) {
            $permission = Permission::create([
                'name' => 'view_dashboard',
                'display_name' => 'View Dashboard',
            ]);
        }

        $role->permissions()->syncWithoutDetaching([$permission->id]);

        $user->roles()->syncWithoutDetaching([$role->id]);

        $response = $this->actingAs($user)
            ->get('/dashboard');

        $response->assertOk();
    }

    public function test_unverified_user_cannot_access_protected_dashboard(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)
            ->get('/dashboard');

        $response->assertRedirect(route('verification.notice'));
    }
}