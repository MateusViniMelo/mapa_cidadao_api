<?php

namespace Tests\Feature\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthControllerFTest extends TestCase
{
    use RefreshDatabase;

    public function teste_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email'    => 'test@example.com',
            'password' => bcrypt('P@ssword123'),
        ]);

        $response = $this->postJson('api/user/login', [
            'email'    => 'test@example.com',
            'password' => 'P@ssword123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'user' => ['id', 'name', 'email', 'created_at', 'updated_at', 'date_birth'],
            'token',
        ]);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        User::factory()->create([
            'email'    => 'test@example.com',
            'password' => bcrypt('P@ssword123'),
        ]);

        $response = $this->postJson('api/user/login', [
            'email'    => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Credenciais inválidas']);
    }

    public function test_returns_the_authenticated_user_with_me_endpoint()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->getJson('api/user/me');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'user' => [
                'id',
                'email',
                'name',
                'date_birth',
            ],
            'token',
        ]);

        $response->assertJsonFragment(
            [
                'id'         => $user->id,
                'email'      => $user->email,
                'name'       => $user->name,
                'date_birth' => $user->date_birth,
            ]
        );
    }

    public function test_user_not_authenticated_can_be_me_endpoint()
    {

        $response = $this->getJson('api/user/me');

        $response->assertStatus(401);

    }

    public function test_logs_out_the_authenticated_user()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson('api/user/logout');

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Logout realizado com sucesso']);
    }

    public function test_user_not_authenticated_can_be_logout()
    {

        $response = $this->postJson('api/user/logout');

        $response->assertStatus(401);

    }
}
