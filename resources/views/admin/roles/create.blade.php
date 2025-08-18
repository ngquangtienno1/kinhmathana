@extends('admin.layouts')
@section('title', 'Thêm vai trò mới')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.roles.index') }}">Quản lý vai trò</a>
    </li>
    <li class="breadcrumb-item active">Thêm vai trò mới</li>
@endsection

@section('content')
    <div class="container-fluid px-0">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1 fw-bold">Thêm vai trò mới</h2>
                        <p class="text-muted mb-0">Tạo vai trò và phân quyền cho hệ thống</p>
                    </div>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Main Content -->
        <div class="row g-4">
            <!-- Left Column - Basic Info -->
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-light border-bottom">
                        <h5 class="mb-0 text-dark">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Thông tin cơ bản
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.roles.store') }}" method="POST" id="roleForm">
                            @csrf

                            <!-- Role Name -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold" for="name">
                                    Tên vai trò <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user-tag"></i>
                                    </span>
                                    <input class="form-control @error('name') is-invalid @enderror" id="name"
                                        name="name" type="text" value="{{ old('name') }}"
                                        placeholder="Nhập tên vai trò..." required />
                                </div>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-lightbulb text-warning me-1"></i>
                                    Tên vai trò sẽ hiển thị trong hệ thống
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold" for="description">
                                    Mô tả <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="4" placeholder="Mô tả chức năng và quyền hạn của vai trò này..." required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle text-info me-1"></i>
                                    Mô tả chi tiết giúp hiểu rõ chức năng của vai trò
                                </div>
                            </div>

                            <!-- Summary Card -->
                            <div class="card bg-light border-0">
                                <div class="card-body p-3">
                                    <div class="row text-center mb-3">
                                        <div class="col-6">
                                            <div class="border-end">
                                                <h6 class="mb-1 text-primary" id="roleNameDisplay">-</h6>
                                                <small class="text-muted">Tên vai trò</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <h6 class="mb-1 text-success" id="permissionCountDisplay">0</h6>
                                            <small class="text-muted">Quyền được chọn</small>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="button" id="saveRoleBtn" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Lưu vai trò
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column - Permissions -->
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-light border-bottom">
                        <h5 class="mb-0 text-dark">
                            <i class="fas fa-shield-alt text-success me-2"></i>
                            Phân quyền
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Control Buttons -->
                        <div class="row mb-3">
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-primary btn-sm w-100" id="selectAll">
                                    <i class="fas fa-check-square me-1"></i>Chọn tất cả
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100" id="deselectAll">
                                    <i class="fas fa-square me-1"></i>Bỏ chọn tất cả
                                </button>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">Tiến độ chọn quyền</small>
                                <small class="text-muted" id="permissionProgress">0%</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" id="permissionProgressBar" role="progressbar"
                                    style="width: 0%"></div>
                            </div>
                        </div>

                        <!-- Permissions Container -->
                        <div class="permissions-container" style="max-height: 400px; overflow-y: auto;">
                            @foreach ($permissions as $group => $perms)
                                <div class="permission-group mb-3">
                                    <div class="d-flex align-items-center mb-2 p-2 bg-light rounded">
                                        <div class="form-check mb-0">
                                            <input type="checkbox" class="form-check-input group-selector"
                                                data-group="{{ Str::slug($group ?: 'khac') }}"
                                                id="group-{{ Str::slug($group ?: 'khac') }}">
                                            <label class="form-check-label fw-semibold mb-0"
                                                for="group-{{ Str::slug($group ?: 'khac') }}">
                                                {{ $group ?: 'Quyền khác' }}
                                            </label>
                                        </div>
                                        <span class="badge bg-primary ms-auto"
                                            id="count-{{ Str::slug($group ?: 'khac') }}">0</span>
                                    </div>

                                    <div class="permission-items ps-3">
                                        @foreach ($perms as $permission)
                                            <div class="form-check mb-2">
                                                <input
                                                    class="form-check-input permission-checkbox group-{{ Str::slug($group ?: 'khac') }}"
                                                    type="checkbox" id="permission_{{ $permission->id }}"
                                                    name="permissions[]" value="{{ $permission->id }}"
                                                    {{ in_array($permission->id, old('permissions', $rolePermissions ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @error('permissions')
                            <div class="alert alert-danger border-0 mt-3">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>


    </div>

    <style>
        .permissions-container::-webkit-scrollbar {
            width: 6px;
        }

        .permissions-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .permissions-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .permissions-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .permission-group {
            border-left: 3px solid #e9ecef;
            padding-left: 15px;
            transition: all 0.3s ease;
        }

        .permission-group:hover {
            border-left-color: #198754;
        }

        .form-check-input:checked {
            background-color: #198754;
            border-color: #198754;
        }

        .progress-bar {
            transition: width 0.3s ease;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .card-header {
            border-bottom: none;
        }

        .permission-items {
            border-left: 2px solid #f8f9fa;
            margin-left: 10px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('roleForm');
            const nameInput = document.getElementById('name');
            const descriptionInput = document.getElementById('description');
            const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
            const groupSelectors = document.querySelectorAll('.group-selector');
            const selectAllBtn = document.getElementById('selectAll');
            const deselectAllBtn = document.getElementById('deselectAll');
            const progressBar = document.getElementById('permissionProgressBar');
            const permissionProgress = document.getElementById('permissionProgress');
            const permissionCount = document.getElementById('permissionCountDisplay');
            const roleName = document.getElementById('roleName');
            const roleNameDisplay = document.getElementById('roleNameDisplay');
            const permissionSummary = document.getElementById('permissionSummary');

            // Update summary
            function updateSummary() {
                const name = nameInput.value || '-';
                const checkedCount = document.querySelectorAll('.permission-checkbox:checked').length;
                const totalCount = permissionCheckboxes.length;

                // Update all role name displays
                if (roleName) roleName.textContent = name;
                if (roleNameDisplay) roleNameDisplay.textContent = name;

                // Update all permission count displays
                if (permissionSummary) permissionSummary.textContent = `${checkedCount}/${totalCount}`;
                if (permissionCount) permissionCount.textContent = checkedCount;

                // Update progress bar
                const percentage = totalCount > 0 ? Math.round((checkedCount / totalCount) * 100) : 0;
                if (progressBar) progressBar.style.width = percentage + '%';
                if (permissionProgress) permissionProgress.textContent = percentage + '%';

                // Update group counts
                groupSelectors.forEach(selector => {
                    const group = selector.getAttribute('data-group');
                    const checkedGroupCount = document.querySelectorAll(`.group-${group}:checked`).length;
                    const countElement = document.getElementById(`count-${group}`);
                    if (countElement) {
                        countElement.textContent = checkedGroupCount;
                    }
                });
            }

            // Group selector functionality
            groupSelectors.forEach(selector => {
                selector.addEventListener('change', function() {
                    const group = this.getAttribute('data-group');
                    const groupCheckboxes = document.querySelectorAll(`.group-${group}`);
                    const checked = this.checked;

                    groupCheckboxes.forEach(cb => {
                        cb.checked = checked;
                    });

                    updateSummary();
                });
            });

            // Individual checkbox functionality
            permissionCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSummary();

                    // Update group selector state
                    const classes = Array.from(this.classList).filter(c => c.startsWith('group-'));
                    classes.forEach(className => {
                        const group = className.replace('group-', '');
                        const groupCheckboxes = document.querySelectorAll(`.${className}`);
                        const allChecked = Array.from(groupCheckboxes).every(x => x
                            .checked);
                        const groupSelector = document.querySelector(
                            `[data-group="${group}"]`);
                        if (groupSelector) {
                            groupSelector.checked = allChecked;
                            groupSelector.indeterminate = !allChecked && Array.from(
                                groupCheckboxes).some(x => x.checked);
                        }
                    });
                });
            });

            // Select all functionality
            selectAllBtn.addEventListener('click', function() {
                permissionCheckboxes.forEach(cb => cb.checked = true);
                groupSelectors.forEach(selector => selector.checked = true);
                updateSummary();

                // Debug: kiểm tra số lượng checkbox đã chọn
                console.log('Đã chọn:', document.querySelectorAll('.permission-checkbox:checked').length,
                    'quyền');
            });

            deselectAllBtn.addEventListener('click', function() {
                permissionCheckboxes.forEach(cb => cb.checked = false);
                groupSelectors.forEach(selector => {
                    selector.checked = false;
                    selector.indeterminate = false;
                });
                updateSummary();
            });

            // Name input change
            nameInput.addEventListener('input', updateSummary);

            // Initial update
            updateSummary();

            // Save button functionality
            const saveRoleBtn = document.getElementById('saveRoleBtn');
            saveRoleBtn.addEventListener('click', function() {
                // Đảm bảo cập nhật summary trước khi kiểm tra
                updateSummary();

                const checkedPermissions = document.querySelectorAll('.permission-checkbox:checked');
                console.log('Save button click - Số quyền đã chọn:', checkedPermissions.length);

                if (checkedPermissions.length === 0) {
                    alert('Vui lòng chọn ít nhất một quyền cho vai trò này!');
                    return false;
                }

                // Debug: kiểm tra form data
                const formData = new FormData(form);
                console.log('Form data permissions:', formData.getAll('permissions[]'));
                console.log('Form data name:', formData.get('name'));
                console.log('Form data description:', formData.get('description'));

                // Kiểm tra nếu form data permissions rỗng
                const permissionsData = formData.getAll('permissions[]');
                if (permissionsData.length === 0) {
                    console.log('ERROR: Form không có dữ liệu permissions!');

                    // Thử cách khác: tạo form data thủ công
                    const manualFormData = new FormData();
                    manualFormData.append('_token', formData.get('_token'));
                    manualFormData.append('name', formData.get('name'));
                    manualFormData.append('description', formData.get('description'));

                    // Thêm tất cả permissions đã chọn
                    checkedPermissions.forEach(checkbox => {
                        manualFormData.append('permissions[]', checkbox.value);
                    });

                    console.log('Manual form data permissions:', manualFormData.getAll('permissions[]'));

                    // Submit bằng fetch
                    fetch(form.action, {
                        method: 'POST',
                        body: manualFormData
                    }).then(response => {
                        if (response.redirected) {
                            window.location.href = response.url;
                        } else {
                            window.location.reload();
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra khi gửi form!');
                    });

                    return false;
                }

                // Submit form
                form.submit();
            });
        });

        function resetForm() {
            if (confirm('Bạn có chắc muốn làm mới form? Tất cả dữ liệu sẽ bị mất.')) {
                document.getElementById('roleForm').reset();
                document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
                document.querySelectorAll('.group-selector').forEach(selector => {
                    selector.checked = false;
                    selector.indeterminate = false;
                });
                document.getElementById('name').dispatchEvent(new Event('input'));
            }
        }
    </script>
@endsection
