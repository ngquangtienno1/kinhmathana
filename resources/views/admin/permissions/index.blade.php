@extends('admin.layouts')

@section('title', 'Quản lý quyền')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Cài đặt</a>
    </li>
    <li class="breadcrumb-item active">Quyền</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Quản lý quyền</h2>
        </div>
    </div>

    <div class="mb-4">
        <div class="d-flex flex-wrap gap-3">
            <div class="search-box">
                <form class="position-relative" action="{{ route('admin.permissions.index') }}" method="GET">
                    <input class="form-control search-input search" type="search" name="search"
                        placeholder="Tìm kiếm theo tên, slug hoặc mô tả" value="{{ request('search') }}" />
                    <span class="fas fa-search search-box-icon"></span>
                    @if (request('search'))
                        <a href="{{ route('admin.permissions.index') }}"
                            class="btn btn-link position-absolute end-0 top-50 translate-middle-y p-0 me-2">
                            <span class="fas fa-times"></span>
                        </a>
                    @endif
                </form>
            </div>
            <div class="ms-xxl-auto">
                <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
                    <span class="fas fa-plus me-2"></span>Thêm quyền
                </a>
            </div>
        </div>
    </div>

    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent">
        <div class="table-responsive scrollbar mx-n1 px-1">
            <table class="table fs-9 mb-0">
                <thead>
                    <tr>
                        <th class="white-space-nowrap fs-9 align-middle ps-0" style="width:20px;">
                            <div class="form-check mb-0 fs-8">
                                <input class="form-check-input" id="checkbox-bulk-permissions-select" type="checkbox"
                                    data-bulk-select='{"body":"permissions-table-body"}' />
                            </div>
                        </th>
                        <th class="sort white-space-nowrap" scope="col" data-sort="id">ID</th>
                        <th class="sort white-space-nowrap" scope="col" data-sort="name">Tên quyền</th>
                        <th class="sort white-space-nowrap" scope="col" data-sort="slug">Slug</th>
                        <th class="sort white-space-nowrap" scope="col" data-sort="description">Mô tả</th>
                        <th class="text-end" scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="list" id="permissions-table-body">
                    @forelse($permissions as $permission)
                        <tr class="position-static">
                            <td class="fs-9 align-middle">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" type="checkbox"
                                        data-bulk-select-row='{"name":"{{ $permission->name }}","slug":"{{ $permission->slug }}"}' />
                                </div>
                            </td>
                            <td class="id align-middle">{{ $permission->id }}</td>
                            <td class="name align-middle">{{ $permission->name }}</td>
                            <td class="slug align-middle">{{ $permission->slug }}</td>
                            <td class="description align-middle">{{ $permission->description }}</td>
                            <td class="align-middle white-space-nowrap text-end pe-0 ps-4 btn-reveal-trigger">
                                <div class="btn-reveal-trigger position-static">
                                    <button
                                        class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                        type="button" data-bs-toggle="dropdown" data-boundary="window"
                                        aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                        <span class="fas fa-ellipsis-h fs-10"></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end py-2">
                                        <a class="dropdown-item"
                                            href="{{ route('admin.permissions.edit', $permission) }}">Sửa</a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('admin.permissions.destroy', $permission) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa quyền này?')">Xóa</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Không có dữ liệu</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
            <div class="col-auto d-flex">
                <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body">
                    Hiển thị {{ $permissions->firstItem() ?? 0 }} đến {{ $permissions->lastItem() ?? 0 }} của
                    {{ $permissions->total() }} kết quả
                </p>
            </div>
            <div class="col-auto d-flex">
                <nav aria-label="Page navigation">
                    {{ $permissions->appends(request()->query())->links('pagination::bootstrap-4') }}
                </nav>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function deletePermission(id) {
            if (confirm('Bạn có chắc chắn muốn xóa?')) {
                fetch(`/admin/permissions/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            window.showToast('error', 'Có lỗi xảy ra');
                        }
                    });
            }
        }
    </script>
@endpush

@endsection
