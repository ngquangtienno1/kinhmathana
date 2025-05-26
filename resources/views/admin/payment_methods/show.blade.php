@extends('admin.layouts')

@section('title', 'Chi tiết phương thức thanh toán')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.payment_methods.index') }}">Phương thức thanh toán</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết phương thức</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chi tiết phương thức thanh toán</h2>
        </div>
        <div class="col-auto ms-auto">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.payment_methods.edit', $paymentMethod->id) }}" class="btn btn-phoenix-primary">
                    <span class="fas fa-edit me-2"></span>Sửa
                </a>
                <form action="{{ route('admin.payment_methods.destroy', $paymentMethod->id) }}" method="POST"
                    class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-phoenix-danger"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa phương thức này?')">
                        <span class="fas fa-trash me-2"></span>Xóa
                    </button>
                </form>
                <a href="{{ route('admin.payment_methods.index') }}" class="btn btn-phoenix-secondary">
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
                        <h4 class="mb-3">Biểu tượng</h4>
                        <div class="border rounded-3 p-3" style="width:100px; height:100px; overflow:hidden;">
                            @if ($paymentMethod->logo_url)
                                <img src="{{ asset('storage/' . $paymentMethod->logo_url) }}"
                                    alt="{{ $paymentMethod->name }}"
                                    style="width:100%; height:100%; object-fit:contain; display:block;" />
                            @else
                                <span class="text-muted">Không có biểu tượng</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-4">
                        <h4 class="mb-3">Thông tin cơ bản</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px;">Tên phương thức</th>
                                        <td>{{ $paymentMethod->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mô tả</th>
                                        <td>{{ $paymentMethod->description ?? 'Không có mô tả' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái</th>
                                        <td>
                                            <span
                                                class="badge badge-phoenix fs-10 {{ $paymentMethod->is_active ? 'badge-phoenix-success' : 'badge-phoenix-danger' }}">
                                                {{ $paymentMethod->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ngày tạo</th>
                                        <td>{{ $paymentMethod->created_at ? $paymentMethod->created_at->format('d/m/Y H:i') : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ngày cập nhật</th>
                                        <td>{{ $paymentMethod->updated_at ? $paymentMethod->updated_at->format('d/m/Y H:i') : '' }}
                                        </td>
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
