@extends('admin.layouts')
@section('title', 'Độ cận')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.sphericals.index') }}">Độ cận</a>
    </li>
    <li class="breadcrumb-item active">Danh sách Độ cận</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Danh sách độ cận</h2>
        </div>
    </div>

    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.sphericals.index') }}">
                Tất cả <span class="text-body-tertiary fw-semibold">({{ $sphericals->count() }})</span>
            </a>
        </li>
    </ul>

    <div id="sphericals" data-list='{"valueNames":["value","sort_order"],"page":10,"pagination":true}'>
        <div class="mb-4 d-flex justify-content-between">
            <div class="search-box">
                <form class="position-relative" action="{{ route('admin.sphericals.index') }}" method="GET">
                    <input class="form-control search-input search" type="search" name="search"
                        placeholder="Tìm Độ cận..." value="{{ request('search') }}" />
                    <span class="fas fa-search search-box-icon"></span>
                </form>
            </div>
            <div class="ms-xxl-auto">
                <a href="{{ route('admin.sphericals.create') }}" class="btn btn-primary">
                    <span class="fas fa-plus me-2"></span>Thêm Độ cận
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
                                    <input class="form-check-input" id="checkbox-bulk-sphericals-select" type="checkbox"
                                        data-bulk-select='{"body":"sphericals-table-body"}' />
                                </div>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4">ID</th>
                            <th class="sort align-middle ps-4">Giá trị</th>
                            <th class="sort align-middle ps-4">Thứ tự</th>
                            <th class="sort text-end align-middle pe-0 ps-4">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="sphericals-table-body">
                        @forelse ($sphericals as $spherical)
                            <tr class="position-static">
                                <td class="align-middle ps-0">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input spherical-checkbox" type="checkbox"
                                            value="{{ $spherical->id }}" />
                                    </div>
                                </td>
                                <td class="align-middle ps-4">{{ $spherical->id }}</td>
                                <td class="align-middle ps-4">{{ $spherical->name }}</td>
                                <td class="align-middle ps-4">{{ $spherical->sort_order }}</td>
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
                                                href="{{ route('admin.sphericals.edit', $spherical->id) }}">Sửa</a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.sphericals.destroy', $spherical->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa Độ cận này?')">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Chưa có Độ cận nào.</td>
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
