@extends('admin.layouts')

@section('title', 'Chi tiết thương hiệu')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Thương hiệu</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết thương hiệu</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chi tiết thương hiệu</h2>
        </div>
        <div class="col-auto ms-auto">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-phoenix-primary">
                    <span class="fas fa-edit me-2"></span>Sửa
                </a>
                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-phoenix-danger"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa thương hiệu này?')">
                        <span class="fas fa-trash me-2"></span>Xóa
                    </button>
                </form>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-phoenix-secondary">
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
                        <h4 class="mb-3">Hình ảnh</h4>
                        <div class="border rounded-3 p-3">
                            @if ($brand->image)
                                <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}"
                                    class="img-fluid rounded-3" style="max-height: 400px; width: auto;">
                            @else
                                <p class="mb-0 text-muted">Không có hình ảnh</p>
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
                                        <th style="width: 200px;">Tên thương hiệu</th>
                                        <td>{{ $brand->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mô tả</th>
                                        <td>{{ $brand->description ?? 'Không có mô tả' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái</th>
                                        <td>
                                            <span
                                                class="badge badge-phoenix fs-10 {{ $brand->is_active ? 'badge-phoenix-success' : 'badge-phoenix-danger' }}">
                                                {{ $brand->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ngày tạo</th>
                                        <td>{{ $brand->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày cập nhật</th>
                                        <td>{{ $brand->updated_at->format('d/m/Y H:i') }}</td>
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
