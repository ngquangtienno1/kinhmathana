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
    public function index(Request $request)
    {
        $quickRange = $request->input('quick_range', 'this_month');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        // Xác định khoảng ngày dựa trên quick_range
        switch ($quickRange) {
            case 'today':
                $dateFrom = $dateTo = now()->toDateString();
                break;
            case 'this_week':
                $dateFrom = now()->startOfWeek()->toDateString();
                $dateTo = now()->endOfWeek()->toDateString();
                break;
            case 'this_month':
                $dateFrom = now()->startOfMonth()->toDateString();
                $dateTo = now()->endOfMonth()->toDateString();
                break;
            case 'this_year':
                $dateFrom = now()->startOfYear()->toDateString();
                $dateTo = now()->endOfYear()->toDateString();
                break;
            case 'custom':
                // Giữ nguyên $dateFrom, $dateTo do user nhập
                break;
            default:
                $dateFrom = now()->startOfMonth()->toDateString();
                $dateTo = now()->endOfMonth()->toDateString();
        }

        // Thống kê đơn hàng
        $orderQuery = Order::query();
        if ($dateFrom) $orderQuery->whereDate('created_at', '>=', $dateFrom);
        if ($dateTo) $orderQuery->whereDate('created_at', '<=', $dateTo);

        $totalOrders = (clone $orderQuery)->count();
        $pendingOrders = (clone $orderQuery)->whereIn('status', ['pending', 'awaiting_payment'])->count();
        $completedOrders = (clone $orderQuery)->where('status', 'delivered')->count();
        $cancelledOrders = (clone $orderQuery)->where('status', 'cancelled')->count();
        $returnedOrders = (clone $orderQuery)->where('status', 'returned')->count();

        // Thống kê sản phẩm
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock_quantity');
        $outOfStockProducts = Product::where('stock_quantity', '<=', 0)->count();

        // Thống kê khách hàng
        $userQuery = User::where('role_id', 3);
        if ($dateFrom) $userQuery->whereDate('created_at', '>=', $dateFrom);
        if ($dateTo) $userQuery->whereDate('created_at', '<=', $dateTo);

        $newCustomers = (clone $userQuery)->count();
        $totalCustomers = User::where('role_id', 3)->count();

        // Thống kê đánh giá (lọc theo thời gian)
        $reviewQuery = Review::query();
        if ($dateFrom) $reviewQuery->whereDate('created_at', '>=', $dateFrom);
        if ($dateTo) $reviewQuery->whereDate('created_at', '<=', $dateTo);

        $totalReviews = (clone $reviewQuery)->count();
        $averageRating = round((clone $reviewQuery)->avg('rating'), 1);

        $latestReviews = (clone $reviewQuery)
            ->with(['user', 'product'])
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        // Top sản phẩm bán chạy nhất (lọc theo thời gian)
        $topProducts = Product::select('products.*', DB::raw('SUM(order_items.quantity) as sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivered')
            ->whereBetween('orders.created_at', [$dateFrom, $dateTo])
            ->groupBy('products.id')
            ->orderByDesc('sold')
            ->limit(5)
            ->get();

        // Biểu đồ doanh thu theo ngày/tháng
        $revenueData = [];
        $revenueLabels = [];
        $period = Carbon::parse($dateFrom)->diffInDays(Carbon::parse($dateTo));
        if ($period <= 31) {
            // Theo ngày
            $dates = [];
            for ($date = Carbon::parse($dateFrom); $date->lte(Carbon::parse($dateTo)); $date->addDay()) {
                $dates[] = $date->format('Y-m-d');
            }
            foreach ($dates as $date) {
                $revenueLabels[] = Carbon::parse($date)->format('d/m');
                $revenueData[] = Order::whereDate('created_at', $date)
                    ->where('status', 'delivered')
                    ->sum('total_amount');
            }
        } else {
            // Theo tháng
            $months = [];
            $start = Carbon::parse($dateFrom)->startOfMonth();
            $end = Carbon::parse($dateTo)->startOfMonth();
            while ($start->lte($end)) {
                $months[] = $start->format('Y-m');
                $start->addMonth();
            }
            foreach ($months as $month) {
                $revenueLabels[] = Carbon::parse($month)->format('m/Y');
                $revenueData[] = Order::whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2))
                    ->where('status', 'delivered')
                    ->sum('total_amount');
            }
        }

        // Tổng doanh thu
        $totalRevenue = (clone $orderQuery)->where('status', 'delivered')->sum('total_amount');

        // Tỷ lệ chuyển đổi đơn hàng
        $conversionRate = $totalOrders > 0 ? round($completedOrders / $totalOrders * 100, 2) : 0;

        return view('admin.index', compact(
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'cancelledOrders',
            'returnedOrders',
            'outOfStockProducts',
            'totalProducts',
            'totalStock',
            'totalRevenue',
            'totalCustomers',
            'newCustomers',
            'totalReviews',
            'averageRating',
            'latestReviews',
            'topProducts',
            'revenueLabels',
            'revenueData',
            'conversionRate'
        ));
    }
}
