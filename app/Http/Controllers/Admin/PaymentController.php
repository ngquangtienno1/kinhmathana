<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['order', 'paymentMethod']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('transaction_code', 'like', "%$search%");
        }
        if ($request->has('status') && in_array($request->status, ['đã hoàn thành', 'đang chờ thanh toán', 'đã hủy', 'thất bại'])) {
            $query->where('status', $request->status);
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        $tatca = Payment::count();
        $dathanhtoan = Payment::where('status', 'đã hoàn thành')->count();
        $dangchothanhtoan = Payment::where('status', 'đang chờ thanh toán')->count();
        $huy = Payment::where('status', 'đã hủy')->count();
        $thatbai = Payment::where('status', 'thất bại')->count();

        // dd($tatca, $dathanhtoan, $dangchothanhtoan, $huy, $thatbai);


        return view('admin.payments.index', compact('payments', 'tatca', 'dathanhtoan', 'dangchothanhtoan', 'huy', 'thatbai'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
        $payment = Payment::with(['order', 'paymentMethod'])->findOrFail($payment->id); // Sử dụng findOrFail để trả về 404 nếu không tìm thấy

        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Payment $payment, $id)
    {
        //
        // Kiểm tra trạng thái của thanh toán
        if ($payment->status == 'đã hủy' || $payment->status == 'thất bại') {
            $payment->delete();

            // Chuyển hướng với thông báo thành công
            return redirect()->route('admin.payments.index')->with('success', 'Thanh toán đã được xóa thành công.');
        } else {
            // Chuyển hướng với thông báo lỗi nếu trạng thái không hợp lệ
            return redirect()->route('admin.payments.index')->with('error', 'Chỉ có thể xóa thanh toán có trạng thái "đã hủy" hoặc "thất bại".');
        }
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:đã hoàn thành,đã hủy',
        ]);

        $payment = Payment::findOrFail($id);

        if ($payment->status !== 'đang chờ thanh toán') {
            return back()->with('error', 'Chỉ có thể cập nhật trạng thái khi đơn đang chờ thanh toán.');
        }

        $payment->status = $request->status;
        $payment->save();

        return back()->with('success', 'Trạng thái thanh toán đã được cập nhật.');
    }

    public function printInvoice($id)
    {
        $payment = Payment::findOrFail($id);

        // Xuất PDF hóa đơn, hoặc redirect đến trang chi tiết
        return view('admin.payments.invoice', compact('payment'));
    }
}