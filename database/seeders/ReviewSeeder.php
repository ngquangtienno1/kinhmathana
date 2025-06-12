<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy các đơn hàng đã giao thành công hoặc đã hoàn tất
        $orders = Order::whereIn('status', ['delivered', 'completed'])->get();

        foreach ($orders as $order) {
            $productId = $order->items()->first()->product_id ?? null;
            if ($productId) {
                Review::factory()->create([
                    'user_id' => $order->user_id,
                    'product_id' => $productId,
                    'order_id' => $order->id,
                ]);
            }
        }
    }
}
