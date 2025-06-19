@extends('admin.layouts')
@section('title', 'Chỉnh sửa vai trò')
@section('content')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="#">Cài đặt</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('admin.roles.index') }}">Vai trò</a>
</li>
<li class="breadcrumb-item active">Chỉnh sửa</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chỉnh sửa vai trò</h2>
        </div>
    </div>

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-0">
        <div class="col-lg-8">
            <div class="card mb-5">
                <div class="card-body">
                    <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="form-label" for="name">Tên vai trò <span class="text-danger">*</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                type="text" value="{{ old('name', $role->name) }}" required />
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="description">Mô tả <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="3"
                                required>{{ old('description', $role->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <input type="checkbox" id="select-all-permissions">
                            <label for="select-all-permissions" style="font-weight: bold;">Chọn tất cả quyền</label>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Quyền hạn <span class="text-danger">*</span></label>
                            <div class="row g-3">
                                @foreach($permissions as $group => $perms)
                                <div class="mb-2">
                                    <input type="checkbox" class="select-group"
                                        data-group="{{ Str::slug($group ?: 'khac') }}"
                                        id="select-group-{{ Str::slug($group ?: 'khac') }}">
                                    <strong>{{ $group ?: 'Khác' }}</strong>
                                    <label for="select-group-{{ Str::slug($group ?: 'khac') }}"
                                        style="font-weight: normal; cursor:pointer;"></label>
                                </div>
                                <div class="row g-3 mb-3">
                                    @foreach($perms as $permission)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input group-{{ Str::slug($group ?: 'khac') }}"
                                                type="checkbox" id="permission_{{ $permission->id }}"
                                                name="permissions[]" value="{{ $permission->id }}" {{
                                                in_array($permission->id, old('permissions', $rolePermissions ?? [])) ?
                                            'checked' : '' }}>
                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                            @error('permissions')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" type="submit">Cập nhật</button>
                            <a class="btn btn-phoenix-secondary" href="{{ route('admin.roles.index') }}">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('select-all-permissions');
        const checkboxes = document.querySelectorAll('input[name="permissions[]"]');

        selectAll.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
        });

        // Nếu tất cả quyền đã được chọn, tự động check "Chọn tất cả"
        function updateSelectAll() {
            selectAll.checked = Array.from(checkboxes).every(cb => cb.checked);
        }
        checkboxes.forEach(cb => cb.addEventListener('change', updateSelectAll));
        updateSelectAll();

        document.querySelectorAll('.select-group').forEach(function(groupCheckbox) {
            groupCheckbox.addEventListener('change', function() {
                let group = this.getAttribute('data-group');
                let checked = this.checked;
                document.querySelectorAll('.group-' + group).forEach(function(cb) {
                    cb.checked = checked;
                });
            });
        });

        document.querySelectorAll('[class^="group-"]').forEach(function(cb) {
            cb.addEventListener('change', function() {
                let classes = Array.from(cb.classList).filter(c => c.startsWith('group-'));
                classes.forEach(function(groupClass) {
                    let group = groupClass.replace('group-', '');
                    let all = document.querySelectorAll('.' + groupClass);
                    let allChecked = Array.from(all).every(x => x.checked);
                    let groupCheckbox = document.querySelector('#select-group-' + group);
                    if (groupCheckbox) groupCheckbox.checked = allChecked;
                });
            });
        });

        // --- ĐOẠN MỚI: cập nhật trạng thái "Chọn tất cả" cho từng nhóm khi load trang ---
        document.querySelectorAll('.select-group').forEach(function(groupCheckbox) {
            let group = groupCheckbox.getAttribute('data-group');
            let all = document.querySelectorAll('.group-' + group);
            let allChecked = Array.from(all).length > 0 && Array.from(all).every(x => x.checked);
            groupCheckbox.checked = allChecked;
        });
    });
</script>
@endsection