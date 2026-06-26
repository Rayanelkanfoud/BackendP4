<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertDontSee('rolename');
    }

    public function test_new_users_register_as_patient_by_default(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'rolename' => 'patient',
        ]);
    }

    public function test_registration_ignores_submitted_role(): void
    {
        $this->post('/register', [
            'name' => 'Role User',
            'email' => 'role@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'rolename' => 'praktijkmanagement',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'role@example.com',
            'rolename' => 'patient',
        ]);
    }
}
