@extends('admin.layouts')
@section('title', 'Thanh Toán')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Thanh Toán</a>
    </li>
    <li class="breadcrumb-item active">Quản lý thanh toán</li>
@endsection

<div class="mb-9">
    <div id="paymentSummary"
        data-list='{"valueNames":["paymentId","customerName","amount","status","paymentDate","action"],"page":6,"pagination":true}'>
        <div class="row mb-4 gx-6 gy-3 align-items-center">
            <div class="col-auto">
                <h2 class="mb-0">Quản lý thanh toán</h2>
            </div>
            {{-- <div class="col-auto">
                <a class="btn btn-primary px-5" href="{{ route('admin.payments.create') }}"><i
                        class="fa-solid fa-plus me-2"></i>Thêm thanh toán mới</a>
            </div> --}}
        </div>

        <div class="row g-3 justify-content-between align-items-end mb-4">
            <div class="col-12 col-sm-auto">
                <ul class="nav nav-links mx-n2">
                    <li class="nav-item">
                        <a class="nav-link px-2 py-1 {{ request('status') == null ? 'active' : '' }}"
                            href="{{ route('admin.payments.index') }}">
                            <span>Tất cả</span>
                            <span class="text-body-tertiary fw-semibold">({{ $tatca }})</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2 py-1 {{ request('status') == 'đã hoàn thành' ? 'active' : '' }}"
                            href="{{ route('admin.payments.index', ['status' => 'đã hoàn thành']) }}">
                            <span>Đã thanh toán</span>
                            <span class="text-body-tertiary fw-semibold">({{ $dathanhtoan }})</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2 py-1 {{ request('status') == 'đang chờ thanh toán' ? 'active' : '' }}"
                            href="{{ route('admin.payments.index', ['status' => 'đang chờ thanh toán']) }}">
                            <span>Đang chờ thanh toán</span>
                            <span class="text-body-tertiary fw-semibold">({{ $dangchothanhtoan }})</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2 py-1 {{ request('status') == 'đã hủy' ? 'active' : '' }}"
                            href="{{ route('admin.payments.index', ['status' => 'đã hủy']) }}">
                            <span>Đã hủy</span>
                            <span class="text-body-tertiary fw-semibold">({{ $huy }})</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2 py-1 {{ request('status') == 'thất bại' ? 'active' : '' }}"
                            href="{{ route('admin.payments.index', ['status' => 'thất bại']) }}">
                            <span>Thất bại</span>
                            <span class="text-body-tertiary fw-semibold">({{ $thatbai }})</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-sm-auto">
                <div class="d-flex align-items-center">
                    <div class="search-box me-3">
                        <form method="GET" action="{{ route('admin.payments.index') }}" class="position-relative">
                            <input value="{{ request('search') }}" class="form-control search-input search"
                                name="search" type="search" placeholder="Tìm kiếm theo mã thanh toán"
                                aria-label="Search" />
                            <span class="fas fa-search search-box-icon"></span>
                        </form>

                    </div>


                </div>
            </div>
        </div>

        <div class="table-responsive scrollbar">
            <table class="table fs-9 mb-0 border-top border-translucent">
                <thead>
                    <tr>
                        <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="paymentId"
                            style="width:20%;">ID</th>
                        <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="paymentId"
                            style="width:20%;">MÃ THANH TOÁN</th>
                        <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="paymentId"
                            style="width:20%;">ĐƠN HÀNG ID</th>

                        <th class="sort align-middle ps-3" scope="col" data-sort="amount" style="width:15%;">SỐ TIỀN
                        </th>
                        <th class="sort align-middle ps-3" scope="col" data-sort="status" style="width:15%;">TRẠNG
                            THÁI</th>
                        <th class="sort align-middle ps-3" scope="col" data-sort="paymentDate" style="width:15%;">
                            NGÀY THANH TOÁN</th>
                        <th class="sort align-middle ps-3" scope="col" data-sort="paymentDate" style="width:15%;">
                            PHƯƠNG THỨC THANH TOÁN</th>
                        <th class="sort align-middle text-end" scope="col" style="width:10%;"></th>
                    </tr>
                </thead>
                <tbody class="list" id="payment-list-table-body">
                    @foreach ($payments as $payment)
                        <tr>
                            <td class="align-middle time white-space-nowrap ps-0 paymentId py-4"><a class="fw-bold fs-8"
                                    href="#">{{ $payment->id }}</a></td>
                            <td class="align-middle time white-space-nowrap ps-0 paymentId py-4"><a class="fw-bold fs-8"
                                    href="#">{{ $payment->transaction_code }}</a></td>
                            <td>{{ $payment->order_id }}</td>
                            {{-- <td>
                                @if ($payment->order)
                                    <a
                                        href="{{  $payment->order->id }}">{{ $payment->order->code }}</a>
                                @else
                                    Không có
                                @endif
                            </td> --}}
                            <td class="align-middle white-space-nowrap amount ps-3 py-4">
                                {{ number_format($payment->amount, 0, ',', '.') }} VND</td>
                            <td
                                class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary">
                                <span
                                    class="badge badge-{{ $payment->status == 'đã hoàn thành'
                                        ? 'badge badge-phoenix fs-10 badge-phoenix-success'
                                        : ($payment->status == 'đang chờ thanh toán'
                                            ? 'badge badge-phoenix fs-10 badge-phoenix-success'
                                            : ($payment->status == 'đã hủy'
                                                ? 'badge badge-phoenix fs-10 badge-phoenix-secondary'
                                                : ($payment->status == 'thất bại'
                                                    ? 'badge badge-phoenix fs-10 badge-phoenix-danger'
                                                    : ''))) }}"
                                    style="font-size: 20px;">
                                    {{ $payment->status }}
                                </span>
                            </td>

                            <td class="align-middle white-space-nowrap paymentDate ps-3 py-4">
                                <p class="mb-0 fs-9 text-body">{{ $payment->formatted_payment_date }}</p>
                            </td>
                            <td class="align-middle white-space-nowrap ps-3 py-4">
                                {{ $payment->paymentMethod->name ?? 'Không xác định' }}
                            </td>

                            <td class="align-middle text-end white-space-nowrap pe-0 action">
                                <div class="btn-reveal-trigger position-static">
                                    <button
                                        class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" data-bs-reference="parent"><span
                                            class="fas fa-ellipsis-h fs-10"></span></button>
                                    <div class="dropdown-menu dropdown-menu-end py-2">
                                        <a class="dropdown-item"
                                            href="{{ route('admin.payments.show', $payment->id) }}">Xem chi tiết</a>

                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('admin.payments.updateStatus', $payment->id) }}"
                                            method="POST" class="d-inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="đã hoàn thành">
                                            <button type="submit" class="dropdown-item text-success">
                                                <i class="fa-solid fa-check me-2"></i> Đánh dấu hoàn thành
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.payments.updateStatus', $payment->id) }}"
                                            method="POST" class="d-inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="đã hủy">
                                            <button type="submit" class="dropdown-item text-secondary">
                                                <i class="fa-solid fa-ban me-2"></i> Hủy thanh toán
                                            </button>
                                        </form>



                                        <div class="dropdown-divider"></div>

                                        <a class="dropdown-item text-info"
                                            href="{{ route('admin.payments.invoice', $payment->id) }}">
                                            <i class="fa-solid fa-file-invoice me-2"></i> In hóa đơn
                                        </a>
                                        <form action="{{ route('admin.payments.destroy', $payment->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa thanh toán này?')">
                                                <i class="fa-solid fa-trash"></i> Xóa
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $payments->links('pagination::bootstrap-5') }}
    </div>

</div>


@endsection
