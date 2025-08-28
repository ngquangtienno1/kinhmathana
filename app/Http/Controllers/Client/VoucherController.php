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
        $now = now();

        $vouchers = Promotion::where('is_active', true)
            // Chỉ hiển thị khi đã tới thời điểm bắt đầu
            ->where('start_date', '<=', $now)
            // Và chưa quá thời điểm kết thúc
            ->where('end_date', '>=', $now)
            // Chỉ hiển thị voucher còn lượt sử dụng
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                  ->orWhereColumn('used_count', '<', 'usage_limit');
            })
            ->orderBy('end_date', 'asc')
            ->get();

        return view('client.voucher.index', compact('vouchers'));
    }
}
