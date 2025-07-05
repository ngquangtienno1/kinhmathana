<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;

class AccountOrderController extends Controller
{
    public function index()
    {
        /** @var User|null $user */
        $user = Auth::user();

        // Định nghĩa các biến thời gian trước
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $lastYear = $currentYear - 1;

        if (!$user) {
            // Nếu không có user, tạo dữ liệu mẫu để test
            $totalOrders = 0;
            $totalSpent = 0;
            $orderStats = [
                'pending' => 0,
                'confirmed' => 0,
                'shipping' => 0,
                'delivered' => 0,
                'completed' => 0,
                'cancelled' => 0,
            ];

            $monthlyStats = [];
            for ($month = 1; $month <= 12; $month++) {
                $monthlyStats[$month] = [
                    'orders' => 0,
                    'amount' => 0,
                ];
            }

            $lastYearOrders = 0;
            $lastYearSpent = 0;
            $currentMonthOrders = 0;
            $currentMonthSpent = 0;
            $latestOrder = null;
            $customerType = 'new';
            $customerTypeLabel = 'Khách hàng mới';

            return view('client.myorderstats.index', compact(
                'totalOrders',
                'totalSpent',
                'orderStats',
                'monthlyStats',
                'currentYear',
                'currentMonth',
                'lastYear',
                'lastYearOrders',
                'lastYearSpent',
                'currentMonthOrders',
                'currentMonthSpent',
                'latestOrder',
                'customerType',
                'customerTypeLabel'
            ));
        }

        // Lấy thông tin khách hàng
        $customer = $user->customer;

        // Tính toán thống kê tổng quan
        $totalOrders = $user->orders()->count();
        $totalSpent = $user->orders()->sum('total_amount');

        // Thống kê theo trạng thái đơn hàng
        $orderStats = [
            'pending' => $user->orders()->where('status', 'pending')->count(),
            'confirmed' => $user->orders()->where('status', 'confirmed')->count(),
            'shipping' => $user->orders()->where('status', 'shipping')->count(),
            'delivered' => $user->orders()->where('status', 'delivered')->count(),
            'completed' => $user->orders()->where('status', 'completed')->count(),
            'cancelled' => $user->orders()->whereIn('status', ['cancelled_by_customer', 'cancelled_by_admin'])->count(),
        ];

        // Thống kê theo thời gian
        $monthlyStats = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthOrders = $user->orders()
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->get();

            $monthlyStats[$month] = [
                'orders' => $monthOrders->count(),
                'amount' => $monthOrders->sum('total_amount'),
            ];
        }

        // Thống kê năm trước
        $lastYearOrders = $user->orders()->whereYear('created_at', $lastYear)->count();
        $lastYearSpent = $user->orders()->whereYear('created_at', $lastYear)->sum('total_amount');

        // Thống kê tháng hiện tại
        $currentMonthOrders = $user->orders()
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->count();
        $currentMonthSpent = $user->orders()
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->sum('total_amount');

        // Đơn hàng gần đây nhất
        $latestOrder = $user->orders()->latest()->first();

        // Xử lý loại khách hàng
        if ($customer) {
            // Cập nhật loại khách hàng nếu có customer record
            $customer->updateCustomerType();
            $customerType = $customer->customer_type;
            $customerTypeLabel = $this->getCustomerTypeLabel($customerType);
        } else {
            // Tạo customer record nếu chưa có
            $customer = Customer::create([
                'user_id' => $user->id,
                'customer_type' => 'new',
                'total_orders' => $totalOrders,
                'total_spent' => $totalSpent,
                'last_order_at' => $latestOrder ? $latestOrder->created_at : null,
            ]);

            $customerType = $customer->customer_type;
            $customerTypeLabel = $this->getCustomerTypeLabel($customerType);
        }

        return view('client.myorderstats.index', compact(
            'totalOrders',
            'totalSpent',
            'orderStats',
            'monthlyStats',
            'currentYear',
            'currentMonth',
            'lastYear',
            'lastYearOrders',
            'lastYearSpent',
            'currentMonthOrders',
            'currentMonthSpent',
            'latestOrder',
            'customerType',
            'customerTypeLabel'
        ));
    }

    private function getCustomerTypeLabel($type)
    {
        return match ($type) {
            'vip' => 'Khách hàng VIP',
            'regular' => 'Khách hàng thường',
            'potential' => 'Khách hàng tiềm năng',
            'new' => 'Khách hàng mới',
            default => 'Khách hàng thường',
        };
    }
}
