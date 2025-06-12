<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = $this->faker->randomElement(['male', 'female']);
        $status = $this->faker->randomElement(['active', 'inactive', 'pending']);

        return [
            'name' => $this->faker->name($gender),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // Mật khẩu mặc định là 'password'
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'date_birth' => $this->faker->dateTimeBetween('-50 years', '-18 years'),
            'gender' => $gender,
            'status_user' => $status,
            'avatar' => null,
            'role_id' => $this->faker->numberBetween(1, 3), // Giả sử có 3 role (1: Admin, 2: Nhân viên, 3: Khách hàng)
            'email_verified_at' => $this->faker->optional(0.8)->dateTimeThisYear(),
            'phone_verified_at' => $this->faker->optional(0.7)->dateTimeThisYear(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}