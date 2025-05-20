<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy danh sách đơn hàng đã hoàn thành
        $completedOrders = Order::where('status', 'completed')->get();
        
        foreach ($completedOrders as $order) {
            // Lấy các sản phẩm trong đơn hàng
            $orderItems = $order->items;
            
            foreach ($orderItems as $item) {
                // Random để quyết định có tạo review cho sản phẩm này không (70% có)
                if (rand(1, 100) <= 70) {
                    // Tạo review cho sản phẩm
                    Review::create([
                        'user_id' => $order->user_id,
                        'product_id' => $item->product_id,
                        'order_id' => $order->id,
                        'rating' => rand(3, 5), // Random rating từ 3-5 sao
                        'content' => $this->getRandomReviewContent(),
                    ]);
                }
            }
        }
    }

    private function getRandomReviewContent(): string
    {
        $contents = [
            "Sản phẩm rất tốt, đóng gói cẩn thận, giao hàng nhanh. Tôi rất hài lòng với chất lượng.",
            "Mắt kính đẹp, đeo vừa vặn, chất lượng tốt. Sẽ ủng hộ shop dài dài.",
            "Kính rất phù hợp với khuôn mặt, chất lượng tốt, giá cả hợp lý.",
            "Shop tư vấn nhiệt tình, sản phẩm đúng như mô tả. Rất hài lòng.",
            "Đóng gói cẩn thận, giao hàng nhanh, kính đẹp như hình.",
            "Chất lượng kính tốt, đeo rất thoải mái, thiết kế đẹp.",
            "Mắt kính rất phù hợp với nhu cầu của tôi, giá cả hợp lý.",
            "Sản phẩm chất lượng cao, dịch vụ tốt, sẽ giới thiệu cho bạn bè.",
            "Kính rất thời trang, chất lượng tốt, đáng đồng tiền.",
            "Shop phục vụ chu đáo, sản phẩm chất lượng, rất đáng mua.",
            "Mắt kính đẹp, chống nắng tốt, đeo rất thoải mái.",
            "Rất hài lòng với sản phẩm, giao hàng nhanh, đóng gói cẩn thận.",
            "Kính đẹp, chất lượng tốt, giá cả phải chăng.",
            "Shop tư vấn nhiệt tình, sản phẩm đúng như quảng cáo.",
            "Chất lượng sản phẩm tuyệt vời, sẽ ủng hộ shop lần sau."
        ];

        return $contents[array_rand($contents)];
    }
}
