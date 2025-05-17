<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::factory()->create();
        $quantity = $this->faker->numberBetween(1, 5);
        $price = $this->faker->numberBetween(50000, 2000000);
        $subtotal = $price * $quantity;
        $discountAmount = $this->faker->boolean(30) ? $subtotal * $this->faker->randomFloat(2, 0.05, 0.2) : 0;

        return [
            'order_id' => Order::factory(),
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_sku' => $product->sku,
            'price' => $price,
            'quantity' => $quantity,
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'product_options' => $this->faker->boolean(40) ? [
                'color' => $this->faker->randomElement(['Đen', 'Trắng', 'Xám', 'Xanh', 'Đỏ']),
                'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL', 'XXL']),
            ] : null,
            'note' => $this->faker->boolean(20) ? $this->faker->sentence() : null,
        ];
    }
}
