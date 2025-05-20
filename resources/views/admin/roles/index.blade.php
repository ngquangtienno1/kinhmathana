@extends('admin.layouts')
@section('title', 'Quản lý vai trò')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Cài đặt</a>
    </li>
    <li class="breadcrumb-item active">Vai trò</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Quản lý vai trò</h2>
        </div>
    </div>


    <div class="mb-4">
        <div class="d-flex flex-wrap gap-3">
            <div class="search-box">
                <form class="position-relative" action="{{ route('admin.roles.index') }}" method="GET">
                    <input class="form-control search-input search" type="search" name="search"
                        placeholder="Tìm kiếm vai trò" value="{{ request('search') }}" />
                    <span class="fas fa-search search-box-icon"></span>
                </form>
            </div>
            <div class="ms-xxl-auto">
                @if (auth()->user()->hasPermission('edit-users'))
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                        <span class="fas fa-plus me-2"></span>Thêm vai trò
                    </a>
                @endif
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
                                <input class="form-check-input" id="checkbox-bulk-roles-select" type="checkbox"
                                    data-bulk-select='{"body":"roles-table-body"}' />
                            </div>
                        </th>
                        <th class="sort white-space-nowrap" scope="col" data-sort="id">ID</th>
                        <th class="sort white-space-nowrap" scope="col" data-sort="name">Tên vai trò</th>
                        <th class="sort white-space-nowrap" scope="col" data-sort="description">Mô tả</th>
                        <th class="sort white-space-nowrap" scope="col" data-sort="permissions">Quyền hạn</th>
                        <th class="text-end" scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="list" id="roles-table-body">
                    @forelse($roles as $role)
                        <tr class="position-static">
                            <td class="fs-9 align-middle">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" type="checkbox"
                                        data-bulk-select-row='{"name":"{{ $role->name }}","description":"{{ $role->description }}"}' />
                                </div>
                            </td>
                            <td class="id align-middle">{{ $role->id }}</td>
                            <td class="name align-middle">{{ $role->name }}</td>
                            <td class="description align-middle">{{ $role->description }}</td>
                            <td class="permissions align-middle">
                                @foreach ($role->permissions as $permission)
                                    <span class="badge bg-info">{{ $permission->name }}</span>
                                @endforeach
                            </td>
                            <td class="align-middle white-space-nowrap text-end pe-0 ps-4 btn-reveal-trigger">
                                @if (auth()->user()->hasPermission('them-vai-tro'))
                                    <div class="btn-reveal-trigger position-static">
                                        <button
                                            class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                            type="button" data-bs-toggle="dropdown" data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                            <span class="fas fa-ellipsis-h fs-10"></span>
                                        </button>
                                        @if (auth()->user()->hasPermission('sua-vai-tro'))
                                            <div class="dropdown-menu dropdown-menu-end py-2">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.roles.edit', $role) }}">Sửa</a>
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa vai trò này?')">Xóa</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @endif
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
                    Hiển thị {{ $roles->firstItem() ?? 0 }} đến {{ $roles->lastItem() ?? 0 }} của
                    {{ $roles->total() }}
                    kết quả
                </p>
            </div>
            <div class="col-auto d-flex">
                <nav aria-label="Page navigation">
                    {{ $roles->appends(request()->query())->links('pagination::bootstrap-4') }}
                </nav>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function deleteRole(id) {
            if (confirm('Bạn có chắc chắn muốn xóa?')) {
                fetch(`/admin/roles/${id}`, {
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
