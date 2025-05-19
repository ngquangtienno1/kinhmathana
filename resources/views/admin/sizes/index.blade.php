@extends('admin.layouts')
@section('title', 'Size')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Thuộc tính</a>
    </li>
    <li class="breadcrumb-item active">Danh sách size</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Kích thước</h2>
        </div>
    </div>

    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.sizes.index') }}">
                Tất cả <span class="text-body-tertiary fw-semibold">({{ $sizes->total() }})</span>
            </a>
        </li>
    </ul>

    <div class="mb-4 d-flex justify-content-between">
        <div class="search-box">
            <form class="position-relative" action="{{ route('admin.sizes.index') }}" method="GET">
                <input class="form-control search-input search" type="search" name="search" placeholder="Tìm size..."
                    value="{{ request('search') }}" />
                <span class="fas fa-search search-box-icon"></span>
            </form>
        </div>
        <div class="ms-xxl-auto">
            <a href="{{ route('admin.sizes.create') }}" class="btn btn-primary">
                <span class="fas fa-plus me-2"></span>Thêm size mới
            </a>
        </div>
    </div>

    <div class="table-responsive scrollbar">
        <table class="table fs-9 mb-0">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="ps-4">Tên size</th>
                    <th class="ps-4">Mô tả</th>
                    <th class="text-center">Thứ tự</th>
                    <th class="text-end pe-4">Thao tác</th>
                </tr>
            </thead>

            <tbody>
                @forelse($sizes as $size)
                    <tr>
                        <td class="align-middle text-center">{{ $size->id }}</td>
                        <td class="align-middle ps-4">{{ $size->name }}</td>
                        <td class="align-middle ps-4">{{ $size->description }}</td>
                        <td class="align-middle text-center">{{ $size->sort_order }}</td>
                        <td class="align-middle text-end pe-4 btn-reveal-trigger">
                            <div class="btn-reveal-trigger position-static">
                                <button
                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="fas fa-ellipsis-h fs-10"></span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end py-2">
                                    <a class="dropdown-item" href="{{ route('admin.sizes.edit', $size->id) }}">Sửa</a>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('admin.sizes.destroy', $size->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger"
                                            onclick="return confirm('Bạn có chắc muốn xoá size này?')">Xoá</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Chưa có size nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
        <div class="col-auto d-flex">
            <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body">
                Hiển thị {{ $sizes->firstItem() }} đến {{ $sizes->lastItem() }} trong tổng số {{ $sizes->total() }}
                size
            </p>
            <a class="fw-semibold" href="#" data-list-view="*">Xem tất cả<span
                    class="fas fa-angle-right ms-1"></span></a>
        </div>
        <div class="col-auto d-flex">
            {{ $sizes->links() }}
        </div>
    </div>
</div>
@endsection
