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
            <h2 class="mb-0">Danh sách màu sắc</h2>
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

        <div
            class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
            <div class="table-responsive scrollbar mx-n1 px-1">
                <table class="table fs-9 mb-0">
                    <thead>
                        <tr>
                            <th class="white-space-nowrap fs-9 align-middle ps-0" style="max-width:20px; width:18px;">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" id="checkbox-bulk-colors-select" type="checkbox"
                                        data-bulk-select='{"body":"colors-table-body"}' />
                                </div>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4">ID</th>
                            <th class="sort align-middle ps-4">Tên màu</th>
                            <th class="sort align-middle ps-4">Mã HEX</th>
                            <th class="sort align-middle ps-4">Hình ảnh</th>
                            <th class="sort align-middle ps-4">Thứ tự</th>
                            <th class="sort text-end align-middle pe-0 ps-4">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="colors-table-body">
                        @forelse ($colors as $color)
                            <tr class="position-static">
                                <td class="align-middle ps-0">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input color-checkbox" type="checkbox"
                                            value="{{ $color->id }}" />
                                    </div>
                                </td>
                                <td class="align-middle ps-4">{{ $color->id }}</td>
                                <td class="align-middle ps-4">{{ $color->name }}</td>
                                <td class="align-middle ps-4">
                                    <span class="badge" style="background-color: {{ $color->hex_code }}; color: #fff;">
                                        {{ $color->hex_code }}
                                    </span>
                                </td>
                                <td class="align-middle ps-4">
                                    @if ($color->image_url)
                                        <img src="{{ $color->image_url }}" alt="Color Image" width="40">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="align-middle ps-4">{{ $color->sort_order }}</td>
                                <td class="align-middle text-end pe-0 ps-4 btn-reveal-trigger">
                                    <div class="btn-reveal-trigger position-static">
                                        <button
                                            class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                            type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <span class="fas fa-ellipsis-h fs-10"></span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.colors.edit', $color->id) }}">Sửa</a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.colors.destroy', $color->id) }}"
                                                method="POST" class="d-inline">
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
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                    </p>
                    <a class="fw-semibold" href="#!" data-list-view="*">Xem tất cả<span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                    <a class="fw-semibold d-none" href="#!" data-list-view="less">Xem ít hơn<span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                </div>
                <div class="col-auto d-flex">
                    <button class="page-link" data-list-pagination="prev"><span
                            class="fas fa-chevron-left"></span></button>
                    <ul class="mb-0 pagination"></ul>
                    <button class="page-link pe-0" data-list-pagination="next">
                        <span class="fas fa-chevron-right"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
