<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class VoucherController extends Controller
{
    public function index(Request $request)
    {
        return view('client.voucher.index');
    }
}
