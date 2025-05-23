<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::with('user');

        // Tìm kiếm
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Lọc theo khoảng ngày đăng ký
        if ($request->has('date_from') && $request->has('date_to')) {
            $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }

        // Lọc theo số đơn hàng
        if ($request->has('min_orders')) {
            $query->where('total_orders', '>=', $request->min_orders);
        }

        // Lọc theo tổng chi tiêu
        if ($request->has('min_spent')) {
            $query->where('total_spent', '>=', $request->min_spent);
        }

        // Lọc theo loại khách hàng
        if ($request->has('customer_type')) {
            $query->where('customer_type', $request->customer_type);
        }

        $customers = $query->latest()->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        $customer->load(['orders' => function ($query) {
            $query->latest()->take(5);
        }, 'user']);

        // Lấy sản phẩm hay mua
        $frequentProducts = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('orders.user_id', $customer->user_id)
            ->select('products.name', DB::raw('count(*) as total'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        return view('admin.customers.show', compact('customer', 'frequentProducts'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'default_address' => 'nullable|string',
            'customer_type' => 'required|in:new,regular,vip,potential'
        ]);

        $customer->update($validated);

        return redirect()->back()->with('success', 'Cập nhật thông tin khách hàng thành công');
    }

    public function updateType(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'customer_type' => 'required|in:new,regular,vip,potential'
        ]);

        $customer->update($validated);

        return redirect()->back()->with('success', 'Cập nhật loại khách hàng thành công');
    }
}