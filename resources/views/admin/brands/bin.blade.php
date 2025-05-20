@extends('admin.layouts')

@section('title', 'Thùng rác thương hiệu')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.brands.index') }}">Thương hiệu</a>
    </li>
    <li class="breadcrumb-item active">Thùng rác</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Thùng rác thương hiệu</h2>
        </div>
        <div class="col-auto ms-auto">
            <a href="{{ route('admin.brands.index') }}" class="btn btn-phoenix-secondary">
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
                            <th class="align-middle text-center" style="width:40px;">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" id="checkbox-bulk-brands-select" type="checkbox"
                                        data-bulk-select='{"body":"brands-table-body"}' />
                                </div>
                            </th>
                            <th class="align-middle text-center" style="width:70px;">ẢNH</th>
                            <th class="align-middle text-center" style="width:220px;">TÊN THƯƠNG HIỆU</th>
                            <th class="align-middle text-center" style="width:250px;">MÔ TẢ</th>
                            <th class="align-middle text-center" style="width:150px;">NGÀY XÓA</th>
                            <th class="align-middle text-center" style="width:120px;"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="brands-table-body">
                        @forelse($brands as $brand)
                            <tr class="position-static">
                                <td class="fs-9 align-middle">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input brand-checkbox" type="checkbox"
                                            value="{{ $brand->id }}" />
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <a class="d-block border border-translucent rounded-2" href="#">
                                        @if ($brand->image)
                                            <img src="{{ asset('storage/' . $brand->image) }}" alt=""
                                                width="48" style="object-fit:cover; border-radius:4px;">
                                        @else
                                            <span class="text-muted">Không có ảnh</span>
                                        @endif
                                    </a>
                                </td>
                                <td class="align-middle text-center">
                                    <a class="fw-semibold line-clamp-3 mb-0" href="#">{{ $brand->name }}</a>
                                </td>
                                <td class="align-middle text-center">
                                    <span
                                        class="text-body-tertiary">{{ Str::limit($brand->description, 80) ?: 'Không có mô tả' }}</span>
                                </td>
                                <td class="align-middle text-center text-body-tertiary">
                                    {{ $brand->deleted_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="align-middle text-center btn-reveal-trigger">
                                    <div class="btn-reveal-trigger position-static">
                                        <button
                                            class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                            type="button" data-bs-toggle="dropdown" data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                            <span class="fas fa-ellipsis-h fs-10"></span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <form action="{{ route('admin.brands.restore', $brand->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="dropdown-item">Khôi phục</button>
                                            </form>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.brands.forceDelete', $brand->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn thương hiệu này?')">Xóa
                                                    vĩnh viễn</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Không có thương hiệu nào trong thùng rác
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $brands->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
