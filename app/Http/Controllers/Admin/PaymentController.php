<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
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

        $payments = $query->orderBy('created_at', 'desc')->get();

        $tatca = Payment::count();
        $dathanhtoan = Payment::where('status', 'đã hoàn thành')->count();
        $dangchothanhtoan = Payment::where('status', 'đang chờ thanh toán')->count();
        $huy = Payment::where('status', 'đã hủy')->count();
        $thatbai = Payment::where('status', 'thất bại')->count();


        return view('admin.payments.index', compact('payments', 'tatca', 'dathanhtoan', 'dangchothanhtoan', 'huy', 'thatbai'));
    }



    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        $payment = Payment::with('order.payments', 'user')->find($id);
        if (!$payment) {
            abort(404);
        }
        return view('admin.payments.show', compact('payment'));
    }




    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


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
            'status' => 'required|in:đã hoàn thành,đã hủy,thất bại,đang chờ thanh toán',
        ]);

        $payment = Payment::findOrFail($id);

        $currentStatus = $payment->status;
        $newStatus = $request->status;

        // Danh sách các trạng thái hợp lệ cho từng trạng thái hiện tại
        $statusTransitions = [
            'đang chờ thanh toán' => ['đã hoàn thành', 'thất bại', 'đã hủy'],
            'thất bại' => ['đã hủy'],
            'đã hoàn thành' => [],
            'đã hủy' => [],
        ];

        // Kiểm tra key tồn tại trước khi truy cập
        if (!array_key_exists($currentStatus, $statusTransitions)) {
            return back()->with('error', 'Trạng thái hiện tại không hợp lệ.');
        }

        // Nếu trạng thái không thay đổi thì thôi
        if ($currentStatus === $newStatus) {
            return back()->with('info', 'Trạng thái không có thay đổi.');
        }

        // Kiểm tra xem có được phép chuyển trạng thái không
        if (!in_array($newStatus, $statusTransitions[$currentStatus])) {
            return back()->with('error', 'Không thể chuyển trạng thái từ "' . $currentStatus . '" sang "' . $newStatus . '".');
        }

        // Cập nhật trạng thái
        $payment->status = $newStatus;
        $payment->save();

        return back()->with('success', 'Trạng thái thanh toán đã được cập nhật.');
    }


    // public function printInvoice($id)
    // {
    //     $payment = Payment::findOrFail($id);

    //     // Xuất PDF hóa đơn, hoặc redirect đến trang chi tiết
    //     return view('admin.payments.invoice', compact('payment'));
    // }
}