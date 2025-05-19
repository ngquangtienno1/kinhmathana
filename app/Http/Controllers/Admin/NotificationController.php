<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Notification types
    const TYPE_ORDER_NEW = 'order_new';
    const TYPE_ORDER_STATUS = 'order_status';
    const TYPE_STOCK_ALERT = 'stock_alert';
    const TYPE_PROMOTION = 'promotion';
    const TYPE_ORDER_CANCELLED = 'order_cancelled';
    const TYPE_MONTHLY_REPORT = 'monthly_report';

    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($notification) {
                return $notification->created_at->format('Y-m-d');
            });

        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Đã đánh dấu thông báo đã đọc');
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->back()->with('success', 'Đã đánh dấu tất cả thông báo đã đọc');
    }

    // Test methods
    public function testNewOrder()
    {
        $this->notifyAdmins(
            self::TYPE_ORDER_NEW,
            'Đơn hàng mới',
            "Đơn hàng #" . rand(1000, 9999) . " vừa được đặt thành công",
            ['order_id' => rand(1000, 9999)]
        );
        return redirect()->back()->with('success', 'Đã gửi thông báo đơn hàng mới');
    }

    public function testOrderStatus()
    {
        $orderId = rand(1000, 9999);
        $statuses = ['Đang xử lý', 'Đang giao hàng', 'Đã giao hàng', 'Đã hủy'];
        $status = $statuses[array_rand($statuses)];

        $this->notifyAdmins(
            self::TYPE_ORDER_STATUS,
            'Cập nhật trạng thái đơn hàng',
            "Đơn hàng #{$orderId} đã chuyển sang trạng thái: {$status}",
            ['order_id' => $orderId, 'status' => $status]
        );
        return redirect()->back()->with('success', 'Đã gửi thông báo cập nhật trạng thái đơn hàng');
    }

    public function testStockAlert()
    {
        $products = [
            ['id' => 1, 'name' => 'Áo thun nam'],
            ['id' => 2, 'name' => 'Quần jean nữ'],
            ['id' => 3, 'name' => 'Giày thể thao'],
        ];
        $product = $products[array_rand($products)];

        $this->notifyAdmins(
            self::TYPE_STOCK_ALERT,
            'Cảnh báo kho',
            "Sản phẩm {$product['name']} đã hết hàng",
            ['product_id' => $product['id'], 'product_name' => $product['name']]
        );
        return redirect()->back()->with('success', 'Đã gửi thông báo cảnh báo kho');
    }

    public function testPromotion()
    {
        $promotions = [
            'Khuyến mãi mùa hè - Giảm đến 50%',
            'Flash sale - Giảm sốc 70%',
            'Mua 1 tặng 1 - Chỉ trong ngày',
        ];
        $promotion = $promotions[array_rand($promotions)];

        $this->notifyAdmins(
            self::TYPE_PROMOTION,
            'Khuyến mãi mới',
            "Khuyến mãi mới: {$promotion}",
            ['promotion_name' => $promotion]
        );
        return redirect()->back()->with('success', 'Đã gửi thông báo khuyến mãi mới');
    }

    public function testOrderCancelled()
    {
        $orderId = rand(1000, 9999);
        $reasons = ['Khách hàng yêu cầu hủy', 'Hết hàng', 'Không liên lạc được'];
        $reason = $reasons[array_rand($reasons)];

        $this->notifyAdmins(
            self::TYPE_ORDER_CANCELLED,
            'Đơn hàng bị hủy',
            "Đơn hàng #{$orderId} đã bị hủy" . ($reason ? " - Lý do: {$reason}" : ''),
            ['order_id' => $orderId, 'reason' => $reason]
        );
        return redirect()->back()->with('success', 'Đã gửi thông báo hủy đơn hàng');
    }

    public function testMonthlyReport()
    {
        $this->notifyAdmins(
            self::TYPE_MONTHLY_REPORT,
            'Báo cáo tháng',
            'Báo cáo doanh số tháng đã được tạo',
            ['report_type' => 'monthly']
        );
        return redirect()->back()->with('success', 'Đã gửi thông báo báo cáo tháng');
    }

    // Helper method to notify admins
    protected function notifyAdmins($type, $title, $content, $data = [])
    {
        // Get admin role ID
        $adminRole = Role::where('name', 'admin')->first();

        if (!$adminRole) {
            return;
        }

        // Get all admin users
        $admins = User::where('role_id', $adminRole->id)->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => $type,
                'title' => $title,
                'content' => $content,
                'data' => $data,
                'is_read' => false
            ]);
        }
    }

    // Methods for real notifications
    public function notifyNewOrder($orderId)
    {
        $this->notifyAdmins(
            self::TYPE_ORDER_NEW,
            'Đơn hàng mới',
            "Đơn hàng #{$orderId} vừa được đặt thành công",
            ['order_id' => $orderId]
        );
    }

    public function notifyOrderStatus($orderId, $status)
    {
        $this->notifyAdmins(
            self::TYPE_ORDER_STATUS,
            'Cập nhật trạng thái đơn hàng',
            "Đơn hàng #{$orderId} đã chuyển sang trạng thái: {$status}",
            ['order_id' => $orderId, 'status' => $status]
        );
    }

    public function notifyStockAlert($productId, $productName)
    {
        $this->notifyAdmins(
            self::TYPE_STOCK_ALERT,
            'Cảnh báo kho',
            "Sản phẩm {$productName} đã hết hàng",
            ['product_id' => $productId, 'product_name' => $productName]
        );
    }

    public function notifyPromotion($promotionName)
    {
        $this->notifyAdmins(
            self::TYPE_PROMOTION,
            'Khuyến mãi mới',
            "Khuyến mãi mới: {$promotionName}",
            ['promotion_name' => $promotionName]
        );
    }

    public function notifyOrderCancelled($orderId, $reason = '')
    {
        $this->notifyAdmins(
            self::TYPE_ORDER_CANCELLED,
            'Đơn hàng bị hủy',
            "Đơn hàng #{$orderId} đã bị hủy" . ($reason ? " - Lý do: {$reason}" : ''),
            ['order_id' => $orderId, 'reason' => $reason]
        );
    }

    public function notifyMonthlyReport()
    {
        $this->notifyAdmins(
            self::TYPE_MONTHLY_REPORT,
            'Báo cáo tháng',
            'Báo cáo doanh số tháng đã được tạo',
            ['report_type' => 'monthly']
        );
    }

    public function getDropdownNotifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($n) {
                return [
                    'id' => $n->id,
                    'title' => $n->title,
                    'content' => $n->content,
                    'is_read' => $n->is_read,
                    'time_ago' => $n->created_at ? $n->created_at->diffForHumans() : '',
                    'avatar' => $n->user && $n->user->avatar ? asset($n->user->avatar) : null,
                ];
            });
        $unreadCount = Notification::where('user_id', Auth::id())->where('is_read', false)->count();
        return response()->json([
            'notifications' => $notifications,
            'unreadCount' => $unreadCount
        ]);
    }
}