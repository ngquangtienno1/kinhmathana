@extends('admin.layouts')
@section('title', 'Hóa đơn thanh toán')

@section('content')
    <div class="container">
        <h2>Hóa đơn thanh toán</h2>
        <p><strong>Mã giao dịch:</strong> {{ $payment->transaction_code }}</p>
        <p><strong>Số tiền:</strong> {{ number_format($payment->amount, 0, ',', '.') }} VND</p>
        <p><strong>Trạng thái:</strong> {{ $payment->status }}</p>
        <p><strong>Ngày thanh toán:</strong> {{ $payment->formatted_payment_date }}</p>
        <p><strong>Phương thức:</strong> {{ $payment->paymentMethod->name ?? 'Không xác định' }}</p>
    </div>
@endsection
