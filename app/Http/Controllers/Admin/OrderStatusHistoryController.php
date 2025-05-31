<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderStatusHistoryService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderStatusHistoryController extends Controller
{
    protected $orderStatusHistoryService;

    public function __construct(OrderStatusHistoryService $orderStatusHistoryService)
    {
        $this->orderStatusHistoryService = $orderStatusHistoryService;
        // Đã có middleware ở route group, không cần gọi ở đây nữa
    }

    /**
     * Display the status history for an order
     *
     * @param Order $order
     * @return View
     */
    public function show(Order $order): View
    {
        $history = $this->orderStatusHistoryService->getOrderStatusHistory($order);
        
        return view('admin.orders.status-history', [
            'order' => $order,
            'history' => $history
        ]);
    }

    /**
     * Update order status and record the change
     *
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'new_status' => 'required|string',
            'note' => 'nullable|string|max:500'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->new_status;
        
        // Update order status
        $order->update(['status' => $newStatus]);
        
        // Record the status change
        $this->orderStatusHistoryService->recordStatusChange(
            $order,
            $oldStatus,
            $newStatus,
            $request->note
        );

        return redirect()
            ->back()
            ->with('success', 'Trạng thái đơn hàng đã được cập nhật thành công.');
    }

    public function index()
    {
        $histories = \App\Models\OrderStatusHistory::with(['order.user', 'updatedBy'])->orderByDesc('created_at')->paginate(20);
        return view('admin.order_status_histories.index', compact('histories'));
    }
} 