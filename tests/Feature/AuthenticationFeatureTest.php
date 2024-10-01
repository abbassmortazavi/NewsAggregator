<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\VerificationCode\VerificationCodeService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthenticationFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @return void
     */
    public function test_a_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    /**
     * @return void
     */
    public function test_a_user_can_login()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'access_token',
                'token_type',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }

    /**
     * @return void
     */
    public function test_a_user_can_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum')
            ->getJson('/api/logout')
            ->assertOk();
    }

    /**
     * @return void
     */
    public function test_reset_password_successful()
    {
        // Mock the VerificationCodeService
        $verificationCodeServiceMock = $this->mock(VerificationCodeService::class);

        // Define request parameters
        $attributes = [
            'email' => 'test@example.com',
            'password' => 'new-password',
            'password_confirmation' => 'new-password'
        ];

        // Mock the resetPassword method to return true, meaning success
        $verificationCodeServiceMock->shouldReceive('resetPassword')
            ->once()
            ->with(Mockery::on(function ($data) use ($attributes) {
                return $data['email'] === $attributes['email'] && $data['password'] === $attributes['password'];
            }))
            ->andReturn(true);

        // Call the API endpoint
        $response = $this->postJson('/api/password/reset-password', $attributes);

        // Check for a successful response (HTTP 200 OK)
        $response->assertOk()
            ->assertJson([
                'message' => 'Password Reset Successfully!!'
            ]);
    }

    /**
     * @return void
     */
    public function test_reset_password_missing_fields()
    {
        // Missing password and password confirmation
        $attributes = [
            'email' => 'test@example.com'
        ];

        // Call the API endpoint
        $response = $this->postJson('/api/password/reset-password', $attributes);

        // Check for validation errors (HTTP 422 Unprocessable Entity)
        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['password']);
    }

    /**
     * @return void
     */
    public function test_reset_password_invalid_email()
    {
        // Provide invalid email and matching password confirmation
        $attributes = [
            'email' => 'invalid-email@example.com',
            'password' => 'new-password',
            'password_confirmation' => 'new-password'
        ];

        // Mock the service to throw an exception for invalid email
        $this->mock(VerificationCodeService::class)
            ->shouldReceive('resetPassword')
            ->once()
            ->andThrow(new Exception('No query results for model [App\\Models\\User].', Response::HTTP_INTERNAL_SERVER_ERROR));

        // Call the API endpoint
        $response = $this->postJson('/api/password/reset-password', $attributes);

        // Assert the response status and structure
        $response->assertServerError()
            ->assertJson([
                'data' => [
                    'success' => false,
                    'error' => 'No query results for model [App\\Models\\User].'
                ],
                'status' => 500
            ]);
    }
}
