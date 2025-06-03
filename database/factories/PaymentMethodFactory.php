<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentMethod>
 */
class PaymentMethodFactory extends Factory
{
    protected $model = PaymentMethod::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'code' => $this->faker->unique()->word(),
            'description' => $this->faker->paragraph(),
            'logo' => $this->faker->imageUrl(200, 200, 'payment'),
            'api_key' => $this->faker->uuid(),
            'api_secret' => $this->faker->uuid(),
            'api_endpoint' => $this->faker->url(),
            'api_settings' => json_encode([
                'test_mode' => true,
                'currency' => 'VND',
                'timeout' => 30,
            ]),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
            'sort_order' => $this->faker->numberBetween(0, 100),
        ];
    }
}
