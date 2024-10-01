<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VerificationCode>
 */
class VerificationCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->randomNumber(6, true),
            'user_id' => User::factory(),
            'expired_at' => now()->addMinutes(2),
            'used' => rand(0, 1),
            'created_at' => now(),
        ];
    }
}
