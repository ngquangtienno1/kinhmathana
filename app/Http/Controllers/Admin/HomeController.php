<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\Comment;
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
        $cancelledOrders = (clone $orderQuery)->whereIn('status', ['cancelled_by_admin', 'cancelled_by_customer'])->count();
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
        $customerData = [];
        $customerLabels = [];
        $orderData = [];
        $orderLabels = [];
        $revenueComparisonData = []; // Dữ liệu so sánh với kỳ trước
        $pendingOrderData = []; // Đơn hàng chờ xác nhận
        $shippingOrderData = []; // Đơn hàng đang giao
        $deliveredOrderData = []; // Đơn hàng đã giao
        $completedOrderData = []; // Đơn hàng hoàn thành
        $cancelledOrderData = []; // Đơn hàng đã hủy
        $period = Carbon::parse($dateFrom)->diffInDays(Carbon::parse($dateTo));

        if ($period <= 31) {
            // Theo ngày
            $dates = [];
            for ($date = Carbon::parse($dateFrom); $date->lte(Carbon::parse($dateTo)); $date->addDay()) {
                $dates[] = $date->format('Y-m-d');
            }

            foreach ($dates as $date) {
                $revenueLabels[] = Carbon::parse($date)->format('d/m');

                // Doanh thu theo ngày - tính từ tất cả đơn hàng (trừ đơn đã hủy)
                $dailyRevenue = Order::whereDate('created_at', $date)
                    ->whereNotIn('status', ['cancelled_by_admin', 'cancelled_by_customer'])
                    ->sum('total_amount');
                $revenueData[] = $dailyRevenue;

                // So sánh với ngày tương ứng kỳ trước (7 ngày trước)
                $previousDate = Carbon::parse($date)->subDays(7)->format('Y-m-d');
                $previousRevenue = Order::whereDate('created_at', $previousDate)
                    ->whereNotIn('status', ['cancelled_by_admin', 'cancelled_by_customer'])
                    ->sum('total_amount');
                $revenueComparisonData[] = $previousRevenue;

                // Khách hàng mới theo ngày
                $customerLabels[] = Carbon::parse($date)->format('d/m');
                $customerData[] = User::where('role_id', 3)
                    ->whereDate('created_at', $date)
                    ->count();

                // Đơn hàng theo ngày
                $orderLabels[] = Carbon::parse($date)->format('d/m');
                $orderData[] = Order::whereDate('created_at', $date)->count();

                // Đơn hàng chờ xác nhận
                $pendingOrderData[] = Order::whereDate('created_at', $date)
                    ->where('status', 'pending')
                    ->count();

                // Đơn hàng đang giao
                $shippingOrderData[] = Order::whereDate('created_at', $date)
                    ->where('status', 'shipping')
                    ->count();

                // Đơn hàng đã giao
                $deliveredOrderData[] = Order::whereDate('created_at', $date)
                    ->where('status', 'delivered')
                    ->count();

                // Đơn hàng hoàn thành
                $completedOrderData[] = Order::whereDate('created_at', $date)
                    ->where('status', 'delivered')
                    ->count();

                // Đơn hàng đã hủy
                $cancelledOrderData[] = Order::whereDate('created_at', $date)
                    ->whereIn('status', ['cancelled_by_admin', 'cancelled_by_customer'])
                    ->count();
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

                // Doanh thu theo tháng - tính từ tất cả đơn hàng (trừ đơn đã hủy)
                $monthlyRevenue = Order::whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2))
                    ->whereNotIn('status', ['cancelled_by_admin', 'cancelled_by_customer'])
                    ->sum('total_amount');
                $revenueData[] = $monthlyRevenue;

                // So sánh với tháng tương ứng kỳ trước (12 tháng trước)
                $previousMonth = Carbon::parse($month)->subMonths(12)->format('Y-m');
                $previousRevenue = Order::whereYear('created_at', substr($previousMonth, 0, 4))
                    ->whereMonth('created_at', substr($previousMonth, 5, 2))
                    ->whereNotIn('status', ['cancelled_by_admin', 'cancelled_by_customer'])
                    ->sum('total_amount');
                $revenueComparisonData[] = $previousRevenue;

                // Khách hàng mới theo tháng
                $customerLabels[] = Carbon::parse($month)->format('m/Y');
                $customerData[] = User::where('role_id', 3)
                    ->whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2))
                    ->count();

                // Đơn hàng theo tháng
                $orderLabels[] = Carbon::parse($month)->format('m/Y');
                $orderData[] = Order::whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2))
                    ->count();

                // Đơn hàng chờ xác nhận theo tháng
                $pendingOrderData[] = Order::whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2))
                    ->where('status', 'pending')
                    ->count();

                // Đơn hàng đang giao theo tháng
                $shippingOrderData[] = Order::whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2))
                    ->where('status', 'shipping')
                    ->count();

                // Đơn hàng đã giao theo tháng
                $deliveredOrderData[] = Order::whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2))
                    ->where('status', 'delivered')
                    ->count();

                // Đơn hàng hoàn thành theo tháng
                $completedOrderData[] = Order::whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2))
                    ->where('status', 'delivered')
                    ->count();

                // Đơn hàng đã hủy theo tháng
                $cancelledOrderData[] = Order::whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2))
                    ->whereIn('status', ['cancelled_by_admin', 'cancelled_by_customer'])
                    ->count();
            }
        }

        // Tổng doanh thu - tính từ tất cả đơn hàng (trừ đơn đã hủy)
        $totalRevenue = (clone $orderQuery)->whereNotIn('status', ['cancelled_by_admin', 'cancelled_by_customer'])->sum('total_amount');

        // Tính toán tăng trưởng doanh thu
        $currentPeriodRevenue = array_sum($revenueData);
        $previousPeriodRevenue = array_sum($revenueComparisonData);
        $revenueGrowth = $previousPeriodRevenue > 0 ?
            round((($currentPeriodRevenue - $previousPeriodRevenue) / $previousPeriodRevenue) * 100, 2) : 0;
        $revenueGrowthType = $revenueGrowth >= 0 ? 'positive' : 'negative';

        // Dữ liệu cho biểu đồ combo chart
        $comboChartData = [
            'labels' => $revenueLabels,
            'revenue' => $revenueData,
            'comparison' => $revenueComparisonData,
            'orders' => $orderData,
            'customers' => $customerData,
            'pendingOrders' => $pendingOrderData,
            'shippingOrders' => $shippingOrderData,
            'deliveredOrders' => $deliveredOrderData,
            'completedOrders' => $completedOrderData,
            'cancelledOrders' => $cancelledOrderData
        ];

        // Tỷ lệ chuyển đổi đơn hàng
        $conversionRate = $totalOrders > 0 ? round($completedOrders / $totalOrders * 100, 2) : 0;

        $reviewChartLabels = [];
        $reviewChartData = [];
        if ($period <= 31) {
            // Theo ngày
            $dates = [];
            for ($date = Carbon::parse($dateFrom); $date->lte(Carbon::parse($dateTo)); $date->addDay()) {
                $dates[] = $date->format('Y-m-d');
            }
            foreach ($dates as $date) {
                $reviewChartLabels[] = Carbon::parse($date)->format('d/m');
                $reviewChartData[] = Review::whereDate('created_at', $date)->count();
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
                $reviewChartLabels[] = Carbon::parse($month)->format('m/Y');
                $reviewChartData[] = Review::whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2))
                    ->count();
            }
        }

        // Đơn hàng đang giao
        $shippingOrders = (clone $orderQuery)->where('status', 'shipping')->count();

        // Thống kê tỷ lệ đơn hàng theo trạng thái
        $completedPercentage = $totalOrders > 0 ? round($completedOrders / $totalOrders * 100, 1) : 0;
        $cancelledPercentage = $totalOrders > 0 ? round($cancelledOrders / $totalOrders * 100, 1) : 0;
        $pendingPercentage = $totalOrders > 0 ? round($pendingOrders / $totalOrders * 100, 1) : 0;
        $shippingPercentage = $totalOrders > 0 ? round($shippingOrders / $totalOrders * 100, 1) : 0;

        // Sản phẩm sắp hết hàng (tồn kho < 5, nhưng > 0)
        $lowStockProducts = Product::where('stock_quantity', '>', 0)->where('stock_quantity', '<', 5)->count();
        // Sản phẩm khuyến mãi
        $promotionProducts = Product::whereNotNull('sale_price')->where('sale_price', '>', 0)->count();
        // Sản phẩm mới (theo bộ lọc ngày tháng)
        $newProductsThisMonth = Product::when($request->filled('quick_range') || $request->filled('date_from'), function ($query) use ($request) {
            if ($request->quick_range === 'today') {
                $query->whereDate('created_at', now()->toDateString());
            } elseif ($request->quick_range === 'this_week') {
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($request->quick_range === 'this_month') {
                $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
            } elseif ($request->quick_range === 'this_year') {
                $query->whereYear('created_at', now()->year);
            } elseif ($request->filled('date_from') && $request->filled('date_to')) {
                $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
            }
        })->count();
        // Khách hàng mua nhiều nhất (top 1)
        $topCustomer = User::where('role_id', 3)
            ->withCount(['orders as total_orders' => function ($q) {
                $q->where('status', 'delivered');
            }])
            ->orderByDesc('total_orders')->first();
        $topCustomerName = $topCustomer ? $topCustomer->name : 'N/A';
        // Khách hàng chưa từng mua
        $neverOrderedCustomers = User::where('role_id', 3)->doesntHave('orders')->count();
        // Sản phẩm được đánh giá nhiều nhất
        $mostReviewedProduct = Product::withCount('reviews')->orderByDesc('reviews_count')->first();
        $mostReviewedProductName = $mostReviewedProduct ? $mostReviewedProduct->name : 'N/A';
        $mostReviewedProductCount = $mostReviewedProduct ? $mostReviewedProduct->reviews_count : 0;

        // === THỐNG KÊ CHO CARD 1: SẢN PHẨM NỔI BẬT ===
        // Top 5 sản phẩm có nhiều lượt xem nhất (theo bộ lọc ngày tháng)
        $topViewedProducts = Product::select('products.name', 'products.views')
            ->when($request->filled('quick_range') || $request->filled('date_from'), function ($query) use ($request) {
                if ($request->quick_range === 'today') {
                    $query->whereDate('created_at', now()->toDateString());
                } elseif ($request->quick_range === 'this_week') {
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                } elseif ($request->quick_range === 'this_year') {
                    $query->whereYear('created_at', now()->year);
                } elseif ($request->filled('date_from') && $request->filled('date_to')) {
                    $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
                }
            })
            ->orderByDesc('views')
            ->limit(5)
            ->get();
        $topViewedProductName = $topViewedProducts->first() ? $topViewedProducts->first()->name : 'N/A';



        // === THỐNG KÊ CHO CARD 2: ĐÁNH GIÁ & TƯƠNG TÁC ===
        // Đánh giá trung bình (theo bộ lọc ngày tháng)
        $recentReviews = Review::when($request->filled('quick_range') || $request->filled('date_from'), function ($query) use ($request) {
            if ($request->quick_range === 'today') {
                $query->whereDate('created_at', now()->toDateString());
            } elseif ($request->quick_range === 'this_week') {
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($request->quick_range === 'this_month') {
                $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
            } elseif ($request->quick_range === 'this_year') {
                $query->whereYear('created_at', now()->year);
            } elseif ($request->filled('date_from') && $request->filled('date_to')) {
                $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
            }
        });
        $averageRating = $recentReviews->count() > 0 ? round($recentReviews->avg('rating'), 1) : 0;

        // Phân bố đánh giá theo sao (theo bộ lọc ngày tháng)
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDistribution[$i] = Review::where('rating', $i)
                ->when($request->filled('quick_range') || $request->filled('date_from'), function ($query) use ($request) {
                    if ($request->quick_range === 'today') {
                        $query->whereDate('created_at', now()->toDateString());
                    } elseif ($request->quick_range === 'this_week') {
                        $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    } elseif ($request->quick_range === 'this_month') {
                        $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
                    } elseif ($request->quick_range === 'this_year') {
                        $query->whereYear('created_at', now()->year);
                    } elseif ($request->filled('date_from') && $request->filled('date_to')) {
                        $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
                    }
                })
                ->count();
        }


        // Số lượng bình luận mới (theo bộ lọc ngày tháng)
        $newCommentsThisWeek = \App\Models\Comment::when($request->filled('quick_range') || $request->filled('date_from'), function ($query) use ($request) {
            if ($request->quick_range === 'today') {
                $query->whereDate('created_at', now()->toDateString());
            } elseif ($request->quick_range === 'this_week') {
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($request->quick_range === 'this_month') {
                $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
            } elseif ($request->quick_range === 'this_year') {
                $query->whereYear('created_at', now()->year);
            } elseif ($request->filled('date_from') && $request->filled('date_to')) {
                $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
            }
        })->count();
        // Tổng số biến thể
        $totalVariations = \App\Models\Variation::count();
        // Biến thể sắp hết hàng
        $lowStockVariations = \App\Models\Variation::where('stock_quantity', '>', 0)->where('stock_quantity', '<', 5)->count();
        // Số thương hiệu
        $totalBrands = \App\Models\Brand::count();
        // Số danh mục
        $totalCategories = \App\Models\Category::count();

        // Tạo label cho khoảng thời gian đang được lọc
        $filterTimeLabel = '';
        if ($request->filled('quick_range')) {
            switch ($request->quick_range) {
                case 'today':
                    $filterTimeLabel = 'Hôm nay';
                    break;
                case 'this_week':
                    $filterTimeLabel = 'Tuần này';
                    break;
                case 'this_month':
                    $filterTimeLabel = 'Tháng này';
                    break;
                case 'this_year':
                    $filterTimeLabel = 'Năm nay';
                    break;
            }
        } elseif ($request->filled('date_from') && $request->filled('date_to')) {
            $filterTimeLabel = 'Khoảng tùy chọn';
        } else {
            $filterTimeLabel = 'Tất cả thời gian';
        }

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
            'customerLabels',
            'customerData',
            'orderLabels',
            'orderData',
            'conversionRate',
            'reviewChartLabels',
            'reviewChartData',
            'shippingOrders',
            'lowStockProducts',
            'promotionProducts',
            'newProductsThisMonth',
            'topCustomerName',
            'neverOrderedCustomers',
            'newCommentsThisWeek',
            'totalVariations',
            'lowStockVariations',
            'totalBrands',
            'totalCategories',
            'completedPercentage',
            'cancelledPercentage',
            'pendingPercentage',
            'shippingPercentage',
            'comboChartData',
            'revenueGrowth',
            'revenueGrowthType',

            // === DỮ LIỆU CHO BIỂU ĐỒ ĐƠN HÀNG ===
            'completedOrderData',
            'cancelledOrderData',
            // === DỮ LIỆU CHO BIỂU ĐỒ SẢN PHẨM & ĐÁNH GIÁ ===
            'topViewedProducts',
            'ratingDistribution',
            // === LABEL CHO BỘ LỌC THỜI GIAN ===
            'filterTimeLabel'
        ));
    }
}
