<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    // Hiển thị trang thông tin tài khoản
    public function index()
    {
        $user = Auth::user();
        // Có thể lấy thêm các thông tin liên quan như đơn hàng, địa chỉ, v.v. ở đây
        return view('client.users.index', compact('user'));
    }
}
