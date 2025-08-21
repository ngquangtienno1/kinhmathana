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
use App\Models\Category;

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
                $dateFrom = Carbon::today()->startOfDay()->format('Y-m-d');
                $dateTo = Carbon::today()->endOfDay()->format('Y-m-d');
                break;
            case 'this_week':
                $dateFrom = Carbon::now()->startOfWeek()->format('Y-m-d');
                $dateTo = Carbon::now()->endOfWeek()->format('Y-m-d');
                break;
            case 'this_month':
                $dateFrom = Carbon::now()->startOfMonth()->format('Y-m-d');
                $dateTo = Carbon::now()->endOfMonth()->format('Y-m-d');
                break;
            case 'this_year':
                $dateFrom = Carbon::now()->startOfYear()->format('Y-m-d');
                $dateTo = Carbon::now()->endOfYear()->format('Y-m-d');
                break;
            case 'custom':
                // Giữ nguyên $dateFrom, $dateTo do user nhập
                break;
            default:
                $dateFrom = Carbon::now()->startOfMonth()->format('Y-m-d');
                $dateTo = Carbon::now()->endOfMonth()->format('Y-m-d');
        }

        // Thống kê đơn hàng
        $orderQuery = Order::query();
        if ($dateFrom) {
            $orderQuery->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $orderQuery->whereDate('created_at', '<=', $dateTo);
        }

        $totalOrders = (clone $orderQuery)->count();
        $pendingOrders = (clone $orderQuery)->whereIn('status', ['pending', 'awaiting_payment'])->count();
        $completedOrders = (clone $orderQuery)->whereIn('status', ['delivered', 'completed'])->count();
        $cancelledOrders = (clone $orderQuery)->whereIn('status', ['cancelled_by_admin', 'cancelled_by_customer'])->count();

        // Thống kê sản phẩm
        $totalProducts = Product::count();
        $totalStock = Product::sum('quantity');
        $outOfStockProducts = Product::where('quantity', '<=', 0)->count();

        // Thống kê khách hàng
        $userQuery = User::where('role_id', 3);
        if ($dateFrom) $userQuery->whereDate('created_at', '>=', $dateFrom);
        if ($dateTo) $userQuery->whereDate('created_at', '<=', $dateTo);

        $newCustomers = (clone $userQuery)->count();

        // Thống kê đánh giá
        $reviewQuery = Review::query()->where('is_hidden', false);
        if ($dateFrom) $reviewQuery->whereDate('created_at', '>=', $dateFrom);
        if ($dateTo) $reviewQuery->whereDate('created_at', '<=', $dateTo);

        $averageRating = round((clone $reviewQuery)->avg('rating'), 1);

        // Đánh giá mới nhất (7 ngày gần đây)
        $latestReviews = Review::where('is_hidden', false)
            ->where('created_at', '>=', now()->subDays(7))
            ->with(['user', 'product', 'images', 'order.items.variation.color', 'order.items.variation.size', 'order.items.variation.spherical', 'order.items.variation.cylindrical', 'order.items.variation.images'])
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        // Top sản phẩm bán chạy nhất
        $topProducts = Product::select('products.*', DB::raw('SUM(order_items.quantity) as sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereNotIn('orders.status', ['cancelled_by_admin', 'cancelled_by_customer'])
            ->when($dateFrom, function ($query) use ($dateFrom) {
                return $query->whereDate('orders.created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                return $query->whereDate('orders.created_at', '<=', $dateTo);
            })
            ->with([
                'categories',
                // Chỉ lấy đánh giá chưa bị ẩn
                'reviews' => function ($q) {
                    $q->where('is_hidden', false);
                },
                'variations.images',
                'images',
                'orderItems.variation.color',
                'orderItems.variation.size',
                'orderItems.variation.spherical',
                'orderItems.variation.cylindrical'
            ])
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
        $pendingOrderData = [];
        $shippingOrderData = [];
        $deliveredOrderData = [];
        $completedOrderData = [];
        $cancelledOrderData = [];

        $period = Carbon::parse($dateFrom)->diffInDays(Carbon::parse($dateTo));

        if ($period <= 31) {
            // Theo ngày
            for ($date = Carbon::parse($dateFrom); $date->lte(Carbon::parse($dateTo)); $date->addDay()) {
                $dateStr = $date->format('Y-m-d');
                $revenueLabels[] = $date->format('d/m');
                $customerLabels[] = $date->format('d/m');
                $orderLabels[] = $date->format('d/m');

                // Doanh thu theo ngày
                $dailyRevenue = Order::whereDate('created_at', $dateStr)
                    ->whereNotIn('status', ['cancelled_by_admin', 'cancelled_by_customer'])
                    ->sum('total_amount');
                $revenueData[] = $dailyRevenue;

                // Khách hàng mới theo ngày
                $customerData[] = User::where('role_id', 3)
                    ->whereDate('created_at', $dateStr)
                    ->count();

                // Đơn hàng theo ngày
                $orderData[] = Order::whereDate('created_at', $dateStr)->count();
                $pendingOrderData[] = Order::whereDate('created_at', $dateStr)->where('status', 'pending')->count();
                $shippingOrderData[] = Order::whereDate('created_at', $dateStr)->where('status', 'shipping')->count();
                $deliveredOrderData[] = Order::whereDate('created_at', $dateStr)->whereIn('status', ['delivered', 'completed'])->count();
                $completedOrderData[] = Order::whereDate('created_at', $dateStr)->whereIn('status', ['delivered', 'completed'])->count();
                $cancelledOrderData[] = Order::whereDate('created_at', $dateStr)->whereIn('status', ['cancelled_by_admin', 'cancelled_by_customer'])->count();
            }
        } else {
            // Theo tháng
            $start = Carbon::parse($dateFrom)->startOfMonth();
            $end = Carbon::parse($dateTo)->startOfMonth();
            while ($start->lte($end)) {
                $month = $start->format('Y-m');
                $revenueLabels[] = $start->format('m/Y');
                $customerLabels[] = $start->format('m/Y');
                $orderLabels[] = $start->format('m/Y');

                // Doanh thu theo tháng
                $monthlyRevenue = Order::whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2))
                    ->whereNotIn('status', ['cancelled_by_admin', 'cancelled_by_customer'])
                    ->sum('total_amount');
                $revenueData[] = $monthlyRevenue;

                // Khách hàng mới theo tháng
                $customerData[] = User::where('role_id', 3)
                    ->whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2))
                    ->count();

                // Đơn hàng theo tháng
                $orderData[] = Order::whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2))
                    ->count();
                $pendingOrderData[] = Order::whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2))
                    ->where('status', 'pending')
                    ->count();
                $shippingOrderData[] = Order::whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2))
                    ->where('status', 'shipping')
                    ->count();
                $deliveredOrderData[] = Order::whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2))
                    ->whereIn('status', ['delivered', 'completed'])
                    ->count();
                $completedOrderData[] = Order::whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2))
                    ->whereIn('status', ['delivered', 'completed'])
                    ->count();
                $cancelledOrderData[] = Order::whereYear('created_at', substr($month, 0, 4))
                    ->whereMonth('created_at', substr($month, 5, 2))
                    ->whereIn('status', ['cancelled_by_admin', 'cancelled_by_customer'])
                    ->count();

                $start->addMonth();
            }
        }

        // Tổng doanh thu
        $totalRevenue = (clone $orderQuery)->whereNotIn('status', ['cancelled_by_admin', 'cancelled_by_customer'])->sum('total_amount');

        // Tính toán tăng trưởng doanh thu
        $currentPeriodRevenue = array_sum($revenueData);
        $revenueGrowth = 0;
        $revenueGrowthType = 'positive';

        // Dữ liệu cho biểu đồ combo chart
        $comboChartData = [
            'labels' => $revenueLabels,
            'revenue' => $revenueData,
            'orders' => $orderData,
            'customers' => $customerData,
            'pendingOrders' => $pendingOrderData,
            'shippingOrders' => $shippingOrderData,
            'deliveredOrders' => $deliveredOrderData,
            'completedOrders' => $completedOrderData,
            'cancelledOrders' => $cancelledOrderData
        ];

        // Top sản phẩm có nhiều lượt xem nhất
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

        // Phân bố đánh giá theo sao
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDistribution[$i] = Review::where('rating', $i)
                ->where('is_hidden', false)
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

        // Dữ liệu cho biểu đồ phân bố doanh thu theo danh mục
        $categoryRevenueData = Category::select('categories.*', DB::raw('COALESCE(SUM(order_items.quantity * order_items.price), 0) as total_revenue'))
            ->join('category_product', 'categories.id', '=', 'category_product.category_id')
            ->join('products', 'category_product.product_id', '=', 'products.id')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereNotIn('orders.status', ['cancelled_by_admin', 'cancelled_by_customer'])
            ->when($dateFrom, function ($query) use ($dateFrom) {
                return $query->whereDate('orders.created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                return $query->whereDate('orders.created_at', '<=', $dateTo);
            })
            ->groupBy('categories.id', 'categories.name')
            ->having('total_revenue', '>', 0)
            ->orderByDesc('total_revenue')
            ->get();

        $categoryRevenueLabels = $categoryRevenueData->pluck('name')->toArray();
        $categoryRevenueValues = $categoryRevenueData->pluck('total_revenue')->toArray();
        $categoryRevenueColors = [
            '#3874FF',
            '#00D27A',
            '#F5803E',
            '#E63757',
            '#845EF7',
            '#339AF0',
            '#51CF66',
            '#FFD43B',
            '#FF6B6B',
            '#4ECDC4'
        ];

        // Top khách hàng mua hàng nhiều nhất
        $topCustomers = User::select('users.*', DB::raw('COUNT(DISTINCT orders.id) as total_orders'), DB::raw('SUM(orders.total_amount) as total_spent'))
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('users.role_id', 3)
            ->whereNotIn('orders.status', ['cancelled_by_admin', 'cancelled_by_customer'])
            ->when($dateFrom, function ($query) use ($dateFrom) {
                return $query->whereDate('orders.created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                return $query->whereDate('orders.created_at', '<=', $dateTo);
            })
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();

        // Thống kê đơn hàng theo trạng thái
        $orderStatusStats = Order::select('status', DB::raw('COUNT(*) as count'))
            ->when($dateFrom, function ($query) use ($dateFrom) {
                return $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                return $query->whereDate('created_at', '<=', $dateTo);
            })
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $orderStatusLabels = [
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'awaiting_pickup' => 'Chờ lấy hàng',
            'shipping' => 'Đang giao',
            'delivered' => 'Đã giao hàng',
            'completed' => 'Đã hoàn thành',
            'cancelled_by_customer' => 'Khách hủy đơn',
            'cancelled_by_admin' => 'Admin hủy đơn',
            'delivery_failed' => 'Giao thất bại'
        ];

        $orderStatusColors = [
            '#6c757d',
            '#007bff',
            '#17a2b8',
            '#ffc107',
            '#28a745',
            '#20c997',
            '#dc3545',
            '#fd7e14',
            '#e83e8c'
        ];

        $orderStatusValues = [];
        $orderStatusLabelsArray = [];

        foreach ($orderStatusLabels as $status => $label) {
            $count = $orderStatusStats->get($status)?->count ?? 0;
            $orderStatusValues[] = $count;
            $orderStatusLabelsArray[] = $label;
        }

        // Label cho khoảng thời gian đang được lọc
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
            // === THỐNG KÊ CƠ BẢN ===
            'totalOrders',           // Tổng số đơn hàng
            'pendingOrders',         // Đơn hàng chờ xử lý
            'completedOrders',       // Đơn hàng đã hoàn thành
            'cancelledOrders',       // Đơn hàng đã hủy
            'outOfStockProducts',    // Sản phẩm hết hàng
            'totalRevenue',          // Tổng doanh thu
            'newCustomers',          // Khách hàng mới
            'averageRating',         // Đánh giá trung bình

            // === DỮ LIỆU DANH SÁCH ===
            'latestReviews',         // Đánh giá mới nhất (7 ngày)
            'topProducts',           // Top sản phẩm bán chạy

            // === DỮ LIỆU BIỂU ĐỒ ===
            'revenueLabels',         // Labels cho biểu đồ doanh thu
            'revenueData',           // Dữ liệu doanh thu
            'customerLabels',        // Labels cho biểu đồ khách hàng
            'customerData',          // Dữ liệu khách hàng
            'orderLabels',           // Labels cho biểu đồ đơn hàng
            'orderData',             // Dữ liệu đơn hàng
            'completedOrderData',    // Dữ liệu đơn hàng hoàn thành
            'cancelledOrderData',    // Dữ liệu đơn hàng hủy

            // === BIỂU ĐỒ COMBO CHART ===
            'comboChartData',        // Dữ liệu cho biểu đồ combo
            'revenueGrowth',         // Tăng trưởng doanh thu
            'revenueGrowthType',     // Loại tăng trưởng (positive/negative)

            // === BIỂU ĐỒ SẢN PHẨM & ĐÁNH GIÁ ===
            'topViewedProducts',     // Sản phẩm có nhiều lượt xem
            'ratingDistribution',    // Phân bố đánh giá theo sao

            // === LABEL & THÔNG TIN ===
            'filterTimeLabel',       // Label cho khoảng thời gian

            // === BIỂU ĐỒ PHÂN BỐ DOANH THU THEO DANH MỤC ===
            'categoryRevenueLabels', // Labels danh mục
            'categoryRevenueValues', // Giá trị doanh thu theo danh mục
            'categoryRevenueColors', // Màu sắc cho biểu đồ

            // === TOP KHÁCH HÀNG ===
            'topCustomers',          // Top khách hàng mua nhiều nhất

            // === THỐNG KÊ ĐƠN HÀNG THEO TRẠNG THÁI ===
            'orderStatusLabelsArray', // Labels trạng thái đơn hàng
            'orderStatusValues',      // Số lượng đơn hàng theo trạng thái
            'orderStatusColors'       // Màu sắc cho biểu đồ trạng thái
        ));
    }
}
