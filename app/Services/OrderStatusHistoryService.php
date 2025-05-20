<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Support\Facades\Auth;

class OrderStatusHistoryService
{
    /**
     * Record a new status change in the order history
     *
     * @param Order $order
     * @param string $oldStatus
     * @param string $newStatus
     * @param string|null $note
     * @return OrderStatusHistory
     */
    public function recordStatusChange(Order $order, string $oldStatus, string $newStatus, ?string $note = null): OrderStatusHistory
    {
        return OrderStatusHistory::create([
            'order_id' => $order->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'note' => $note,
            'updated_by' => Auth::id()
        ]);
    }

    /**
     * Get status history for an order
     *
     * @param Order $order
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOrderStatusHistory(Order $order)
    {
        return OrderStatusHistory::with('updatedBy')
            ->where('order_id', $order->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }
} 