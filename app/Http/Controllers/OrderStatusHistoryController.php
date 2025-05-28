<?php

namespace App\Http\Controllers;

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
        
        return view('orders.status-history', [
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
} 