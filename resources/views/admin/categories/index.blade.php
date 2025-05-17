@extends('admin.layouts')
@section('title', 'Danh mục sản phẩm')
@section('content')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="#">Categories</a></li>
<li class="breadcrumb-item active">Danh sách danh mục</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Danh mục</h2>
        </div>
    </div>

    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item">
            <a class="nav-link {{ request('status') == null ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                Tất cả <span class="text-body-tertiary fw-semibold">({{ $categories->total() }})</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('bin') === '1' ? 'active' : '' }}" href="{{ route('admin.categories.bin') }}">
                Thùng rác <span class="text-body-tertiary fw-semibold">({{ $deletedCount }})</span>
            </a>
        </li>
    </ul>

    <div class="d-flex flex-wrap gap-3 mb-4">
        <div class="search-box">
            <form class="position-relative" action="{{ route('admin.categories.index') }}" method="GET">
                <input class="form-control search-input search" type="search" name="search"
                    placeholder="Tìm kiếm danh mục" value="{{ request('search') }}" />
                <span class="fas fa-search search-box-icon"></span>
            </form>
        </div>
        <div class="ms-xxl-auto">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <span class="fas fa-plus me-2"></span>Thêm danh mục
            </a>
        </div>
    </div>

    <div class="table-responsive scrollbar mx-n1 px-1">
        <table class="table fs-9 mb-0">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="ps-4">Tên</th>
                    <th class="ps-4">Mô tả</th>
                    <th class="text-center">Danh mục cha</th>
                    <th class="text-end pe-4">Thao tác</th>
                </tr>
            </thead>

          <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td class="align-middle text-center">
                            {{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}
                        </td>
                        <td class="align-middle ps-4">{{ $category->name }}</td>
                        <td class="align-middle ps-4">{{ Str::limit($category->description, 50) }}</td>
                        <td class="align-middle text-center">{{ optional($category->parent)->name ?? '-' }}</td>
                        <td class="align-middle text-end pe-4 btn-reveal-trigger">
                            <div class="btn-reveal-trigger position-static">
                                <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="fas fa-ellipsis-h fs-10"></span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end py-2">
                                    <a class="dropdown-item" href="{{ route('admin.categories.edit', $category->id) }}">Sửa</a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">Xoá</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Không có danh mục nào.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div class="d-flex justify-content-between py-2">
        <div>
            <p class="mb-0">Hiển thị {{ $categories->firstItem() }} đến {{ $categories->lastItem() }} trong tổng số {{ $categories->total() }} mục</p>
        </div>
        <div>
            {{ $categories->links() }}
        </div>
    </div>
</div>

@endsection
