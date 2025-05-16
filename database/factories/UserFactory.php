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
        return [
            'name' => $this->faker->name(), // Tên người dùng
            'address' => $this->faker->address(), // Địa chỉ
            'phone' => $this->faker->phoneNumber(), // Số điện thoại
            'email' => $this->faker->unique()->safeEmail(), // Email duy nhất
            'password' => bcrypt('password'), // Mật khẩu mặc định
            'date_birth' => $this->faker->date('Y-m-d', '-18 years'), // Ngày sinh (ít nhất 18 tuổi)
            'gender' => $this->faker->randomElement(['male', 'female', 'other']), // Giới tính
            'status_user' => $this->faker->randomElement(['active', 'inactive', 'banned']), // Trạng thái người dùng
            'avatar_id' => null, // Không có avatar mặc định
            'role_id' => Role::where('name', 'User')->first()->id, // Mặc định là role User
            'email_verified_at' => $this->faker->optional()->dateTime(), // Thời gian xác thực email
            'phone_verified_at' => $this->faker->optional()->dateTime(), // Thời gian xác thực số điện thoại
            'remember_token' => Str::random(10), // Token nhớ đăng nhập
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
