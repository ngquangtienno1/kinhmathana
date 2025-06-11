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

        $customers = $query->get();

        // Lấy query builder object để truyền cho export (nếu cần filtering)
        $exportQuery = clone $query; // Tạo bản sao để không ảnh hưởng đến query hiển thị

        return view('admin.customers.index', compact('customers', 'exportQuery'));
    }

    public function export(Request $request)

    {
        $query = Customer::with('user');

        // Apply the same search and filter logic as index
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->has('date_from') && $request->has('date_to')) {
            $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }

        if ($request->has('min_orders')) {
            $query->where('total_orders', '>=', $request->min_orders);
        }

        if ($request->has('min_spent')) {
            $query->where('total_spent', '>=', $request->min_spent);
        }

        if ($request->has('customer_type')) {
            $query->where('customer_type', $request->customer_type);
        }

        // Return the Excel file
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\CustomerExport($query), 'khach_hang.xlsx');
    }

    public function show(Customer $customer)
    {
        // Lấy các đơn hàng hợp lệ (chưa xóa mềm)
        $orders = $customer->orders()->latest()->take(5)->get();
        $totalOrders = $customer->orders()->count();

        // Lấy sản phẩm hay mua
        $frequentProducts = \DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('orders.user_id', $customer->user_id)
            ->select('products.name', \DB::raw('count(*) as total'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        return view('admin.customers.show', compact('customer', 'orders', 'totalOrders', 'frequentProducts'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'customer_type' => 'required|in:new,regular,vip,potential'
        ], [
            'customer_type.required' => 'Loại khách hàng là bắt buộc.',
            'customer_type.in' => 'Loại khách hàng không hợp lệ.',
        ]);

        $customer->update([
            'customer_type' => $validated['customer_type'],
        ]);

        return redirect()->back()->with('success', 'Cập nhật loại khách hàng thành công');
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
