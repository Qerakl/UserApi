<?php

namespace Tests\Feature\AuthApi;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест успешного получения данных авторизованного пользователя.
     */
    public function test_profile_with_authorized_user()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($user);

        $response = $this->post('/api/profile');

        $response->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'email' => 'test@example.com',
                'gender' => $user->gender,
            ]);
    }

    /**
     * Тест доступа к методу без авторизации.
     */
    public function test_profile_without_authorization()
    {
        $response = $this->post('/api/profile');

        $response->assertStatus(302);
    }
}
