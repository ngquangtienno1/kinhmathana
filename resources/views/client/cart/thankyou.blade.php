@extends('client.layouts.app')
@section('title', 'Cảm ơn bạn đã đặt hàng')
@section('content')
    <div class="thankyou-wrapper"
        style="max-width:600px;margin:40px auto 60px auto;padding:32px 24px;background:#fff;border-radius:10px;box-shadow:0 2px 12px rgba(0,0,0,0.06);text-align:center;">
        <div style="font-size:2.2rem;color:#222;margin-bottom:18px;">
            <i class="fa fa-check-circle" style="color:#222;font-size:3rem;"></i>
        </div>
        <h2 style="font-size:2rem;font-weight:700;margin-bottom:12px;color:#111;">CẢM ƠN BẠN ĐÃ ĐẶT HÀNG!</h2>
        @if (isset($pending) && $pending)
            <p
                style="font-size:1.15rem;margin-bottom:18px;color:#888;font-weight:600;max-width:480px;margin-left:auto;margin-right:auto;word-break:keep-all;">
                Giao dịch của bạn đang được xử lý bởi ngân hàng hoặc cổng thanh toán. Vui lòng kiểm tra lại trạng thái đơn
                hàng sau ít phút hoặc liên hệ hỗ trợ nếu cần thiết.
            </p>
        @else
            <p
                style="font-size:1.15rem;margin-bottom:18px;color:#222;max-width:480px;margin-left:auto;margin-right:auto;word-break:keep-all;">
                Đơn hàng của bạn đã được ghi nhận.<br>Chúng tôi sẽ liên hệ xác nhận và giao hàng trong thời gian sớm nhất.
            </p>
        @endif
        <p style="font-size:1rem;color:#888;margin-bottom:24px;">
            Bạn có thể kiểm tra trạng thái đơn hàng trong mục <a href="{{ route('client.orders.index') }}"
                style="color:#111;font-weight:600;">Đơn hàng của tôi</a> hoặc kiểm tra email xác nhận.
        </p>
        <a href="/" class="checkout-btn"
            style="display:inline-block;padding:12px 32px;background:#111;color:#fff;border-radius:6px;font-size:1.1rem;font-weight:600;text-decoration:none;margin-right:10px;">Về
            trang chủ</a>
        <a href="{{ route('client.orders.index') }}" class="checkout-btn"
            style="display:inline-block;padding:12px 32px;background:#fff;color:#111;border:2px solid #111;border-radius:6px;font-size:1.1rem;font-weight:600;text-decoration:none;">Xem
            đơn hàng</a>
    </div>
@endsection
