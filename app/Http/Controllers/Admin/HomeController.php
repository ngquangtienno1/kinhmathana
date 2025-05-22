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

class HomeController extends Controller
{
    public function index()
    {
        // Thống kê đơn hàng
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();

        // Thống kê sản phẩm
        $totalProducts = Product::count();
        $outOfStockProducts = 0; // Tạm thời set là 0 vì không có cột stock

        // Thống kê doanh thu
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $monthlyRevenue = Order::where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_amount');

        // Thống kê khách hàng
        $totalCustomers = User::count(); // Đếm tất cả users
        $newCustomers = User::whereMonth('created_at', Carbon::now()->month)
            ->count(); // Đếm users mới trong tháng

        // Thống kê đánh giá
        $totalReviews = Review::count();
        $averageRating = Review::avg('rating');

        // Lấy 6 đánh giá mới nhất, kèm user và product
        $latestReviews = Review::with(['user', 'product'])
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        // Thống kê theo khu vực
        $revenueByRegion = Order::where('status', 'completed')
            ->select('shipping_address', DB::raw('SUM(total_amount) as total_revenue'))
            ->groupBy('shipping_address')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get();

        // Thống kê đơn hàng theo thời gian
        $ordersByTime = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total_orders'),
            DB::raw('SUM(total_amount) as total_revenue')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->get();

        return view('admin.index', compact(
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalProducts',
            'outOfStockProducts',
            'totalRevenue',
            'monthlyRevenue',
            'totalCustomers',
            'newCustomers',
            'totalReviews',
            'averageRating',
            'revenueByRegion',
            'ordersByTime',
            'latestReviews'
        ));
    }
}
