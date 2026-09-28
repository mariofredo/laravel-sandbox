<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    private function validData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Mario Rossi',
            'email' => 'mario@example.com',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ], $overrides);
    }

    public function test_register_page_renders_with_csrf_field(): void
    {
        $this->get('/register')
            ->assertOk()
            ->assertSee('name="_token"', false);
    }

    public function test_user_can_register(): void
    {
        $this->post('/register', $this->validData())
            ->assertRedirect('/dashboard');

        $user = User::where('email', 'mario@example.com')->first();

        $this->assertNotNull($user);
        $this->assertSame('Mario Rossi', $user->name);
        $this->assertTrue(Hash::check('secret-password', $user->password));
        $this->assertAuthenticatedAs($user);
    }

    public function test_email_is_stored_lowercase(): void
    {
        $this->post('/register', $this->validData(['email' => 'Mario@Example.COM']));

        $this->assertDatabaseHas('users', ['email' => 'mario@example.com']);
    }

    public function test_duplicate_email_is_rejected(): void
    {
        User::factory()->create(['email' => 'mario@example.com']);

        $this->post('/register', $this->validData(['email' => 'Mario@example.com']))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
        $this->assertSame(1, User::count());
    }

    public function test_mismatched_password_confirmation_is_rejected(): void
    {
        $this->post('/register', $this->validData(['password_confirmation' => 'something-else']))
            ->assertSessionHasErrors('password');

        $this->assertGuest();
    }

    public function test_name_with_html_is_escaped_on_dashboard(): void
    {
        $this->post('/register', $this->validData(['name' => '<script>alert(1)</script>']));

        $this->get('/dashboard')
            ->assertOk()
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false);
    }

    public function test_authenticated_user_is_redirected_away_from_register(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/register')
            ->assertRedirect('/dashboard');
    }
}
