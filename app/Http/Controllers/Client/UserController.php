<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Customer;

class UserController extends Controller
{
    // Hiển thị trang thông tin tài khoản
    public function index()
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        $totalOrders = $customer ? $customer->total_orders : 0;
        $totalSpent = $customer ? $customer->total_spent : 0;
        $customerType = $customer ? $customer->customer_type : null;
        // Lấy danh sách đơn hàng của user, mới nhất trước
        $orders = $user->orders()->withCount('items')->orderByDesc('created_at')->get();
        return view('client.users.index', compact('user', 'customer', 'totalOrders', 'totalSpent', 'customerType', 'orders'));
    }
}
