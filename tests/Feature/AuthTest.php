<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_login_page()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Login');
    }

    /** @test */
    public function user_can_view_register_page()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Register');
    }

    /** @test */
    public function user_can_register()
    {
        // Use a valid email format that passes DNS validation
        $response = $this->post('/register', [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@gmail.com', // Use gmail.com which has valid DNS
            'password' => 'password123',
        ]);

        $response->assertRedirect();
        
        // Verify user was created
        $this->assertDatabaseHas('users', [
            'email' => 'test@gmail.com',
            'username' => 'testuser',
            'name' => 'Test User',
        ]);
    }

    /** @test */
    public function registration_requires_all_fields()
    {
        $response = $this->post('/register', []);
        $response->assertSessionHasErrors(['name', 'username', 'email', 'password']);
    }

    /** @test */
    public function registration_requires_unique_email()
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'existing@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function registration_requires_unique_username()
    {
        User::factory()->create(['username' => 'existinguser']);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'username' => 'existinguser',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['username']);
    }

    /** @test */
    public function registration_requires_minimum_password_length()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => '1234', // kurang dari 5 karakter
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function user_can_login_with_email()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'login' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_can_login_with_username()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'login' => 'testuser',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_cannot_login_with_wrong_password()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'login' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHas('LoginError');
        $this->assertGuest();
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        $response = $this->post('/login', [
            'login' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHas('LoginError');
        $this->assertGuest();
    }

    /** @test */
    public function login_requires_credentials()
    {
        $response = $this->post('/login', []);
        $response->assertSessionHasErrors(['login', 'password']);
    }

    /** @test */
    public function authenticated_user_cannot_access_login_page()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get('/login');
        // Middleware guest redirect authenticated user
        $response->assertRedirect();
    }

    /** @test */
    public function authenticated_user_cannot_access_register_page()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get('/register');
        // Middleware guest redirect authenticated user
        $response->assertRedirect();
    }

    /** @test */
    public function user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }

    /** @test */
    public function last_login_at_is_updated_on_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'last_login_at' => null,
        ]);

        $this->post('/login', [
            'login' => 'test@example.com',
            'password' => 'password123',
        ]);

        $user->refresh();
        $this->assertNotNull($user->last_login_at);
    }
}

