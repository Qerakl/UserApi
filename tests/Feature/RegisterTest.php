<?php

namespace Tests\Feature\AuthApi;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест успешной регистрации пользователя.
     */
    public function test_successful_registration()
    {
        $response = $this->postJson('/api/register', [
            'gender' => 'male',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'gender' => 'male',
        ]);
    }

    /**
     * Тест валидации на отсутствие обязательных полей.
     */
    public function test_validation_requires_fields()
    {
        $response = $this->postJson('/api/register', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['gender', 'email', 'password', 'password_confirmation']);
    }

    /**
     * Тест валидации некорректного значения поля gender.
     */
    public function test_validation_invalid_gender()
    {
        $response = $this->postJson('/api/register', [
            'gender' => 'invalid',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['gender']);
    }

    /**
     * Тест валидации уникального email.
     */
    public function test_validation_unique_email()
    {

        $this->postJson('/api/register', [
            'gender' => 'male',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response = $this->postJson('/api/register', [
            'gender' => 'male',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
