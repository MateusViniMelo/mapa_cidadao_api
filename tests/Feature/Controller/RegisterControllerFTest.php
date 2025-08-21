<?php

namespace Tests\Feature\Controller;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterControllerFTest extends TestCase
{
    use RefreshDatabase;

    public function test_registers_a_user_and_returns_token()
    {
        $payload = [
            'name' => 'Anakin Skywalker',
            'email' => 'anakins@gmail.com',
            'password' => 'StrongP@ssword123',
            'date_birth' => '1999-01-01',
            'password_confirmation' => 'StrongP@ssword123',
        ];

        $response = $this->postJson('api/register', $payload);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'user' => [
                'id',
                'name',
                'email',
                'date_birth',
                'created_at',
                'updated_at',
            ],
            'token',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $payload['email'],
            'name' => $payload['name'],
            'date_birth' => Carbon::parse($payload['date_birth'])->format('Y-m-d H:i:s'),
        ]);

        $this->assertTrue(Hash::check('StrongP@ssword123', User::first()['password']));
    }
    public static function invalidPayloads(): array
    {
        return [
            'nome vazio' => [
                [
                    'name' => '',
                    'email' => 'joao@email.com',
                    'password' => 'SenhaForte@123',
                    'password_confirmation' => 'SenhaForte@123',
                    'date_birth' => '2000-01-01',
                ],
            ],
            'email inválido' => [
                [
                    'name' => 'João da Silva',
                    'email' => 'email-invalido',
                    'password' => 'SenhaForte@123',
                    'password_confirmation' => 'SenhaForte@123',
                    'date_birth' => '2000-01-01',
                ],
            ],
            'senhas diferentes' => [
                [
                    'name' => 'João da Silva',
                    'email' => 'joao@email.com',
                    'password' => 'SenhaForte@123',
                    'password_confirmation' => 'SenhaErrada@123',
                    'date_birth' => '2000-01-01',
                ],
            ],
            'senha fraca' => [
                [
                    'name' => 'João da Silva',
                    'email' => 'joao@email.com',
                    'password' => 'senha123',
                    'password_confirmation' => 'senha123',
                    'date_birth' => '2000-01-01',
                ],
            ],
            'data de nascimento futura' => [
                [
                    'name' => 'João da Silva',
                    'email' => 'joao@email.com',
                    'password' => 'SenhaForte@123',
                    'password_confirmation' => 'SenhaForte@123',
                    'date_birth' => now()->addDay()->format('Y-m-d'),
                ],
            ],
            'menor de 18 anos' => [
                [
                    'name' => 'João da Silva',
                    'email' => 'joao@email.com',
                    'password' => 'SenhaForte@123',
                    'password_confirmation' => 'SenhaForte@123',
                    'date_birth' => now()->subYears(17)->format('Y-m-d'),
                ],
            ],
        ];
    }

    /**
     * @dataProvider invalidPayloads
     */
    public function test_user_cannot_register_payload_error(array $payload)
    {

        $response = $this->postJson('api/register', $payload);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('users', [
            'email' => $payload['email'],
            'date_birth' => Carbon::parse($payload['date_birth'])->format('Y-m-d H:i:s'),
        ]);

    }
}
