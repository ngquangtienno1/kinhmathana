@extends('admin.layouts')
@section('title', 'Colors')
@section('content')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="#">Thuộc tính</a>
</li>
<li class="breadcrumb-item active">Danh sách màu sắc</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Màu sắc</h2>
        </div>
    </div>

    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.colors.index') }}">
                Tất cả <span class="text-body-tertiary fw-semibold">({{ $colors->count() }})</span>
            </a>
        </li>
    </ul>

    <div id="colors" data-list='{"valueNames":["name","hex_code","sort_order"],"page":15,"pagination":true}'>
        <div class="mb-4 d-flex justify-content-between">
            <div class="search-box">
                <form class="position-relative" action="{{ route('admin.colors.index') }}" method="GET">
                    <input class="form-control search-input search" type="search" name="search"
                        placeholder="Tìm màu sắc..." value="{{ request('search') }}" />
                    <span class="fas fa-search search-box-icon"></span>
                </form>
            </div>
            <div class="ms-xxl-auto">
                <a href="{{ route('admin.colors.create') }}" class="btn btn-primary">
                    <span class="fas fa-plus me-2"></span>Thêm màu sắc
                </a>
            </div>
        </div>

        <div class="table-responsive scrollbar">
            <table class="table fs-9 mb-0">
                <thead>
                    <tr>
                        <th class="white-space-nowrap fs-9 align-middle ps-0" style="max-width:20px; width:18px;">
                            <div class="form-check mb-0 fs-8">
                                <input class="form-check-input" id="checkbox-bulk-colors-select" type="checkbox"
                                    data-bulk-select='{"body":"colors-table-body"}' />
                            </div>
                        </th>
                        <th>ID</th>
                        <th>Tên màu</th>
                        <th>Mã HEX</th>
                        <th>Hình ảnh</th>
                        <th>Thứ tự</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody id="colors-table-body">
                    @forelse ($colors as $color)
                        <tr>
                            <td class="align-middle">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input color-checkbox" type="checkbox"
                                        value="{{ $color->id }}" />
                                </div>
                            </td>
                            <td class="align-middle">{{ $color->id }}</td>
                            <td class="align-middle">{{ $color->name }}</td>
                            <td class="align-middle">
                                <span class="badge" style="background-color: {{ $color->hex_code }};">
                                    {{ $color->hex_code }}
                                </span>
                            </td>
                            <td class="align-middle">
                                @if ($color->image_url)
                                    <img src="{{ $color->image_url }}" alt="Color Image" width="40">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="align-middle">{{ $color->sort_order }}</td>
                            <td class="align-middle text-end btn-reveal-trigger">
                                <div class="btn-reveal-trigger position-static">
                                    <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="fas fa-ellipsis-h fs-10"></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end py-2">
                                        <a class="dropdown-item" href="{{ route('admin.colors.edit', $color->id) }}">Sửa</a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('admin.colors.destroy', $color->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa màu này?')">Xóa</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Chưa có màu nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

      <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                <div class="col-auto d-flex">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body">
                        Hiển thị {{ $colors->firstItem() }} đến {{ $colors->lastItem() }} trong tổng số {{ $colors->total() }} mục
                    </p>
                    <a class="fw-semibold" href="#" data-list-view="*">Xem tất cả<span class="fas fa-angle-right ms-1"></span></a>
                </div>

            </div>

    </div>
</div>

@endsection
