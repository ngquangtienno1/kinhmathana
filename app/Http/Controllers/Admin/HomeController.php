<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        // Tổng số đơn hàng
        $totalOrders = Order::count();
        // Đơn hàng chờ xử lý
        $pendingOrders = Order::whereIn('status', ['pending', 'awaiting_payment'])->count();
        // Đơn hàng đã hoàn thành
        $completedOrders = Order::where('status', 'delivered')->count();

        // Sản phẩm hết hàng (nếu có cột stock)
        if (Schema::hasColumn('products', 'stock')) {
            $outOfStockProducts = Product::where('stock', '<=', 0)->count();
        } else {
            $outOfStockProducts = 0;
        }

        // Tổng doanh thu (đơn đã giao)
        $totalRevenue = Order::where('status', 'delivered')->sum('total_amount');

        // Doanh thu từng tháng trong năm hiện tại (cho biểu đồ cột)
        $monthlyRevenueData = Order::where('status', 'delivered')
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month')
            ->toArray();
        $monthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyRevenue[] = $monthlyRevenueData[$i] ?? 0;
        }

        // Doanh thu 30 ngày gần nhất (cho biểu đồ đường)
        $dailyRevenueData = Order::where('status', 'delivered')
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('revenue', 'date')
            ->toArray();
        $dates = [];
        $dailyRevenue = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $dates[] = $date;
            $dailyRevenue[] = $dailyRevenueData[$date] ?? 0;
        }

        // Khách hàng mới/tháng
        $newCustomers = User::where('role_id', 3)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        // Tổng khách hàng
        $totalCustomers = User::where('role_id', 3)->count();

        // Đánh giá
        $totalReviews = Review::count();
        $averageRating = round(Review::avg('rating'), 1);

        // 6 đánh giá mới nhất
        $latestReviews = Review::with(['user', 'product'])
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        return view('admin.index', compact(
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'outOfStockProducts',
            'totalRevenue',
            'monthlyRevenue',
            'dates',
            'dailyRevenue',
            'totalCustomers',
            'newCustomers',
            'totalReviews',
            'averageRating',
            'latestReviews'
        ));
    }
}
