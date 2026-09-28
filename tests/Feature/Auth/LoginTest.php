<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders_with_csrf_field(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('name="_token"', false);
    }

    public function test_user_can_log_in_with_correct_credentials(): void
    {
        $user = User::factory()->create(['email' => 'mario@example.com']);

        $this->post('/login', [
            'email' => 'mario@example.com',
            'password' => 'password',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_email_is_case_insensitive(): void
    {
        $user = User::factory()->create(['email' => 'mario@example.com']);

        $this->post('/login', [
            'email' => 'Mario@Example.COM',
            'password' => 'password',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
    }

    public function test_wrong_password_fails_and_keeps_email_but_not_password(): void
    {
        User::factory()->create(['email' => 'mario@example.com']);

        $this->from('/login')->post('/login', [
            'email' => 'mario@example.com',
            'password' => 'wrong-password',
        ])
            ->assertRedirect('/login')
            ->assertSessionHasErrors(['email' => 'These credentials do not match our records.'])
            ->assertSessionHasInput('email', 'mario@example.com')
            ->assertSessionMissing('_old_input.password');

        $this->assertGuest();
    }

    public function test_authenticated_user_is_redirected_away_from_login(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/login')
            ->assertRedirect('/dashboard');
    }

    public function test_user_can_log_out(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/logout')
            ->assertRedirect('/');

        $this->assertGuest();
    }

    public function test_logout_via_get_is_not_allowed(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/logout')
            ->assertMethodNotAllowed();

        $this->assertAuthenticatedAs($user);
    }
}
