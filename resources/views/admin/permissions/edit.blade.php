@extends('admin.layouts')

@section('title', 'Chỉnh sửa quyền')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="#">Cài đặt</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.permissions.index') }}">Quyền</a>
    </li>
    <li class="breadcrumb-item active">Chỉnh sửa</li>
@endsection

@section('content')
    <div class="mb-9">
        <div class="row g-3 mb-4">
            <div class="col-auto">
                <h2 class="mb-0">Chỉnh sửa quyền</h2>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên quyền <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $permission->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                            name="slug" value="{{ old('slug', $permission->slug) }}" readonly>
                        <small class="text-muted">Slug sẽ được tự động tạo từ tên quyền</small>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="3">{{ old('description', $permission->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="group_permissions">Nhóm quyền</label>
                        <input class="form-control @error('group_permissions') is-invalid @enderror" id="group_permissions" name="group_permissions"
                            type="text" value="{{ old('group_permissions', $permission->group_permissions ?? '') }}" />
                        @error('group_permissions')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-phoenix-secondary">Hủy</a>
                        <button type="submit" class="btn btn-phoenix-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('name').addEventListener('input', function() {
                let slug = this.value
                    .toLowerCase()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .replace(/[đĐ]/g, 'd')
                    .replace(/([^0-9a-z-\s])/g, '')
                    .replace(/(\s+)/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-+|-+$/g, '');
                document.getElementById('slug').value = slug;
            });
        </script>
    @endpush
@endsection
