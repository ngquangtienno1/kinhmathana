<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Support\Facades\Log;


class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $today = now()->startOfDay(); // Bắt đầu của ngày hôm nay
        
        $vouchers = Promotion::where('is_active', true)
            ->where('start_date', '<=', now())  // Bắt đầu từ trước hoặc bằng hiện tại
            ->where('end_date', '>=', $today)   // Kết thúc từ hôm nay trở đi (theo ngày)
            // Chỉ hiển thị voucher còn lượt sử dụng
            ->where(function ($q) {
                $q->whereNull('usage_limit')  // Không giới hạn → luôn hiển thị
                  ->orWhereColumn('used_count', '<', 'usage_limit'); // Còn lượt dùng
            })
            ->orderBy('end_date', 'asc')
            ->get();
        
        return view('client.voucher.index', compact('vouchers'));
    }
}
