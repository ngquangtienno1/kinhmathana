@extends('admin.layouts')
@section('title', 'Chi tiết thanh toán')
@section('content')

    @section('breadcrumbs')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.payments.index') }}">Thanh Toán</a>
        </li>
        <li class="breadcrumb-item active">Chi tiết thanh toán #{{ $payment->id }}</li>
    @endsection

    <div class="content px-0 pt-navbar">
        <div class="row g-0">
            <div class="col-12 col-xxl-8 px-0 bg-body">
                <div class="px-4 px-lg-6 pt-6 pb-9">
                    <div class="mb-5">
                        <div class="d-flex justify-content-between">
                            <h2 class="text-body-emphasis fw-bolder mb-2">Chi tiết thanh toán #{{ $payment->id }}</h2>
                            <div class="btn-reveal-trigger">
                                <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal"
                                        type="button" data-bs-toggle="dropdown" data-boundary="window"
                                        aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                    <span class="fas fa-ellipsis-h"></span>
                                </button>

                            </div>
                        </div>
                        <span class="badge badge-phoenix badge-phoenix-{{ $payment->status === 'Đã thanh toán' ? 'success' : ($payment->status === 'Chờ xử lý' ? 'warning' : 'danger') }}">
                            {{ $payment->status }}
                            @if ($payment->status === 'Đang xử lý')
                                <span class="ms-1 uil uil-stopwatch"></span>
                            @elseif ($payment->status === 'Đã thanh toán')
                                <span class="ms-1 uil uil-check-circle"></span>
                            @elseif ($payment->status === 'Đã hủy' || $payment->status === 'Thất bại')
                                <span class="ms-1 uil uil-times-circle"></span>
                            @endif
                        </span>
                    </div>
                    <div class="row gx-0 gx-sm-5 gy-8 mb-8">
                        <div class="col-12 col-xl-5 pe-xl-0">
                            <div class="mb-4 mb-xl-7">
                                <div class="row gx-0 gx-sm-7">
                                    <div class="col-12">
                                        <table class="lh-sm mb-4 mb-sm-0 mb-xl-4">
                                            <tbody>
                                                <tr>
                                                    <td class="py-1 fw-bold">Mã giao dịch:</td>
                                                    <td class="ps-1 py-1">{{ $payment->transaction_code }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="py-1 fw-bold">Đơn hàng:</td>
                                                    {{-- <td class="ps-1 py-1">
                                                        @if ($payment->order)
                                                            <a href="{{ route('admin.orders.show', $payment->order->id) }}">{{ $payment->order->code }}</a>
                                                        @else
                                                            Không có
                                                        @endif
                                                    </td> --}}
                                                </tr>
                                                <tr>
                                                    <td class="py-1 fw-bold">Phương thức thanh toán:</td>
                                                    <td class="ps-1 py-1">{{ $payment->paymentMethod->name ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="py-1 fw-bold">Số tiền:</td>
                                                    <td class="ps-1 py-1">{{ number_format($payment->amount, 0, ',', '.') }} VND</td>
                                                </tr>
                                                <tr>
                                                    <td class="py-1 fw-bold">Trạng thái:</td>
                                                    <td class="ps-1 py-1">{{ $payment->status }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="py-1 fw-bold">Ngày tạo:</td>
                                                    <td class="ps-1 py-1">{{ $payment->created_at }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="py-1 fw-bold">Ngày cập nhật:</td>
                                                    <td class="ps-1 py-1">{{ $payment->updated_at }}</td>
                                                </tr>
                                                {{-- Bạn có thể thêm các thông tin chi tiết khác tại đây --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7">
                            {{-- Bạn có thể thêm các thông tin hoặc biểu đồ bổ sung ở khu vực này nếu cần --}}
                            {{-- Ví dụ: lịch sử trạng thái thanh toán, thông tin người dùng thanh toán, v.v. --}}
                            {{-- <div class="card">
                                <div class="card-header">
                                    Thông tin thêm
                                </div>
                                <div class="card-body">
                                    <p>Đây là nơi bạn có thể hiển thị thêm thông tin chi tiết về thanh toán.</p>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
