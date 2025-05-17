@extends('admin.layouts')
@section('title', 'Thùng rác Danh mục')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.categories.index') }}">Danh mục</a>
    </li>
    <li class="breadcrumb-item active">Thùng rác</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Thùng rác Danh mục</h2>
        </div>
        <div class="col-auto ms-auto">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-phoenix-secondary">
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
                            <th class="align-middle text-center" style="width:40px;">ID</th>
                            <th class="align-middle">Tên danh mục</th>
                            <th class="align-middle">Mô tả</th>
                            <th class="align-middle">Danh mục cha</th>
                            <th class="align-middle text-center">Ngày xóa</th>
                            <th class="align-middle text-center" style="width:120px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $category->name }}</td>
                                <td class="align-middle">{{ Str::limit($category->description, 50) }}</td>
                                <td class="align-middle">{{ optional($category->parent)->name ?? '-' }}</td>
                                <td class="align-middle text-center text-muted">
                                    {{ $category->deleted_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="align-middle text-center btn-reveal-trigger">
                                    <div class="btn-reveal-trigger position-static">
                                        <button
                                            class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="fas fa-ellipsis-h fs-10"></span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <form action="{{ route('admin.categories.restore', $category->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="dropdown-item">Khôi phục</button>
                                            </form>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.categories.forceDelete', $category->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn danh mục này không?')">
                                                    Xóa vĩnh viễn
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Không có danh mục nào trong thùng rác.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
