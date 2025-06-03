@extends('admin.layouts')
@section('title', 'Order Status History')
@section('content')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="{{ route('admin.orders.index') }}">Orders</a>
</li>
<li class="breadcrumb-item active">Lịch sử cập nhật trạng thái đơn hàng #{{ $order->id }}</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
             <h2 class="mb-0">Lịch sử cập nhật trạng thái đơn hàng #{{ $order->id }}</h2>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Cập nhật trạng thái</h5>
        </div>
        <div class="card-body p-4">
             <!-- Form cập nhật trạng thái -->
            <form action="{{ route('admin.orders.status.update', $order) }}" method="POST" class="row g-3 align-items-end">
                @csrf
                @method('PATCH')
                <div class="col-md-4">
                    <label for="new_status" class="form-label">Trạng thái mới</label>
                    <select name="new_status" id="new_status" class="form-select" required>
                        <option value="">Chọn trạng thái mới</option>
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đang giao hàng</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã giao hàng</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="note" class="form-label">Ghi chú</label>
                    <input type="text" name="note" id="note" class="form-control" placeholder="Nhập ghi chú (nếu có)">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm mt-3">
         <div class="card-header">
             <h5 class="mb-0">Lịch sử cập nhật</h5>
         </div>
         <div class="card-body p-4">
            <!-- Bảng lịch sử -->
            <div class="table-responsive scrollbar">
                <table class="table table-bordered align-middle fs-9 mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Thời gian</th>
                            <th>Trạng thái cũ</th>
                            <th>Trạng thái mới</th>
                            <th>Ghi chú</th>
                            <th>Cập nhật bởi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history as $record)
                        <tr>
                            <td>{{ $record->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $record->old_status }}</span>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $record->new_status }}</span>
                            </td>
                            <td>{{ $record->note ?? 'Không có' }}</td>
                            <td>{{ $record->updatedBy->name }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Chưa có lịch sử cập nhật</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
         </div>
    </div>

    <div class="mt-3 text-end">
         <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary ms-2">Quay lại danh sách đơn hàng</a>
    </div>

</div>
@endsection 