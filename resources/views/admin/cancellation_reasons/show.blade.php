@extends('admin.layouts')

@section('title', 'Chi tiết lý do hủy')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.cancellation_reasons.index') }}">Lý do hủy</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết lý do hủy</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chi tiết lý do hủy</h2>
        </div>
        <div class="col-auto ms-auto">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.cancellation_reasons.edit', $cancellationReason->id) }}"
                    class="btn btn-phoenix-primary">
                    <span class="fas fa-edit me-2"></span>Sửa
                </a>
                <form action="{{ route('admin.cancellation_reasons.destroy', $cancellationReason->id) }}" method="POST"
                    class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-phoenix-danger"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa lý do hủy này?')">
                        <span class="fas fa-trash me-2"></span>Xóa
                    </button>
                </form>
                <a href="{{ route('admin.cancellation_reasons.index') }}" class="btn btn-phoenix-secondary">
                    <span class="fas fa-arrow-left me-2"></span>Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12">
                    <div class="mb-4">
                        <h4 class="mb-3">Thông tin cơ bản</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px;">ID</th>
                                        <td>{{ $cancellationReason->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Lý do hủy</th>
                                        <td>{{ $cancellationReason->reason }}</td>
                                    </tr>
                                    <tr>
                                        <th>Loại</th>
                                        <td>
                                            <span
                                                class="badge badge-phoenix fs-10 {{ $cancellationReason->type === 'customer' ? 'badge-phoenix-info' : 'badge-phoenix-warning' }}">
                                                {{ $cancellationReason->type === 'customer' ? 'Khách hàng' : 'Admin' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái</th>
                                        <td>
                                            <span
                                                class="badge badge-phoenix fs-10 {{ $cancellationReason->is_active ? 'badge-phoenix-success' : 'badge-phoenix-danger' }}">
                                                {{ $cancellationReason->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ngày tạo</th>
                                        <td>{{ $cancellationReason->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày cập nhật</th>
                                        <td>{{ $cancellationReason->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
