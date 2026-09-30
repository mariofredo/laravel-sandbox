<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordToggleTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_password_field_has_one_toggle(): void
    {
        $html = $this->get('/login')->assertOk()->getContent();

        $this->assertSame(1, substr_count($html, 'aria-label="Show password"'));
    }

    public function test_register_password_fields_have_two_toggles(): void
    {
        $html = $this->get('/register')->assertOk()->getContent();

        $this->assertSame(2, substr_count($html, 'aria-label="Show password"'));
    }

    public function test_toggle_buttons_do_not_submit_the_form(): void
    {
        $html = $this->get('/register')->assertOk()->getContent();

        $this->assertSame(2, preg_match_all('/<button\s+type="button"[^>]*aria-label="Show password"/', $html));
    }

    public function test_password_inputs_are_hidden_by_default(): void
    {
        $html = $this->get('/register')->assertOk()->getContent();

        $this->assertSame(2, substr_count($html, 'type="password"'));
    }
}
