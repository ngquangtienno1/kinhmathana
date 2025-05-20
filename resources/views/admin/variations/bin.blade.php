@extends('admin.layouts')
@section('title', 'Thùng rác Biến thể sản phẩm')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.variations.index') }}">Biến thể</a>
    </li>
    <li class="breadcrumb-item active">Thùng rác</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Thùng rác Biến thể sản phẩm</h2>
        </div>
        <div class="col-auto ms-auto">
            <a href="{{ route('admin.variations.index') }}" class="btn btn-phoenix-secondary">
                <span class="fas fa-arrow-left me-2"></span>Quay lại
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive scrollbar">
                <table class="table fs-9 mb-0">
                    <thead>
                        <tr>
                            <th class="align-middle text-center">ID</th>
                            <th class="align-middle text-center">Tên biến thể</th>
                            <th class="align-middle text-center">SKU</th>
                            <th class="align-middle text-center">Giá gốc</th>
                            <th class="align-middle text-center">Giá nhập</th>
                            <th class="align-middle text-center">Giá bán</th>
                            <th class="align-middle text-center">Sản phẩm cha</th>
                            <th class="align-middle text-center">Ngày xóa</th>
                            <th class="align-middle text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($trashed as $variation)
                            <tr>
                                <td class="align-middle text-center">{{ $variation->id }}</td>
                                <td class="align-middle text-center">{{ $variation->name }}</td>
                                <td class="align-middle text-center">{{ $variation->sku }}</td>
                                <td class="align-middle text-end">{{ number_format($variation->price, 0, ',', '.') }}đ</td>
                                <td class="align-middle text-end">{{ number_format($variation->import_price, 0, ',', '.') }}đ</td>
                                <td class="align-middle text-end">{{ number_format($variation->sale_price, 0, ',', '.') }}đ</td>
                                <td class="align-middle text-center">{{ optional($variation->product)->name ?? '-' }}</td>
                                <td class="align-middle text-center text-body-tertiary">
                                    {{ $variation->deleted_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-reveal-trigger position-static">
                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="fas fa-ellipsis-h fs-10"></span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <form action="{{ route('admin.variations.restore', $variation->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="dropdown-item">Khôi phục</button>
                                            </form>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.variations.forceDelete', $variation->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn biến thể này?')">
                                                    Xóa vĩnh viễn
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">Không có biến thể nào trong thùng rác</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $trashed->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
