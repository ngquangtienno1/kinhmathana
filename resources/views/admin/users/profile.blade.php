@extends('admin.layouts')

@section('title', 'Thông tin người dùng')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.users.index') }}">Người dùng</a>
    </li>
    <li class="breadcrumb-item active">Thông tin người dùng</li>
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row g-4">
            <!-- Left Column: Avatar and Basic Info -->
            <div class="col-lg-4 col-md-12">
                <div class="card h-100 bg-body-emphasis shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="avatar-wrapper mb-4">
                            <img src="{{ $user->avatar ? asset($user->avatar) : asset('v1/assets/img/team/72x72/57.webp') }}"
                                alt="{{ $user->name }}"
                                class="rounded-circle img-fluid border border-3 border-body-emphasis"
                                style="width: 180px; height: 180px; object-fit: cover;">
                        </div>
                        <button type="button" class="btn btn-phoenix-primary btn-sm mb-4" data-bs-toggle="modal"
                            data-bs-target="#avatarModal">
                            <span class="fas fa-camera me-1"></span> Thay đổi ảnh
                        </button>
                        <div class="text-start px-3">
                            <h5 class="text-body-emphasis mb-3"><span class="fas fa-info-circle me-2"></span>Thông tin cơ
                                bản</h5>
                            <div class="mb-2">
                                <span class="text-body-secondary">Vai trò:</span>
                                <span class="fw-semibold text-body">{{ $user->role->name ?? 'Chưa phân quyền' }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-body-secondary">Trạng thái:</span>
                                <span
                                    class="badge badge-phoenix fs-10 ms-2 {{ $user->status_user == 'active' ? 'badge-phoenix-success' : ($user->status_user == 'inactive' ? 'badge-phoenix-warning' : 'badge-phoenix-danger') }}">
                                    {{ $user->status_user == 'active' ? 'Hoạt động' : ($user->status_user == 'inactive' ? 'Không hoạt động' : 'Bị khóa') }}
                                </span>
                            </div>
                            <div class="mb-2">
                                <span class="text-body-secondary">Ngày tạo:</span>
                                <span class="fw-semibold text-body">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Personal Info -->
            <div class="col-lg-8 col-md-12">
                <div class="card h-100 bg-body-emphasis shadow-sm border-0">
                    <div class="card-header d-flex justify-content-between align-items-center bg-body-emphasis border-0">
                        <h5 class="card-title text-body-emphasis mb-0"><span class="fas fa-user me-2"></span>Thông tin cá
                            nhân</h5>
                        <div>
                        @if ($user->role_id != 3 && !(auth()->user()->role_id == 2 && $user->role_id == 1))
                                <button type="button" class="btn btn-phoenix-primary btn-sm me-2" data-bs-toggle="modal"
                                data-bs-target="#editProfileModal">
                                <i class="fas fa-edit me-1"></i> Chỉnh sửa
                            </button>
                                <button type="button" class="btn btn-phoenix-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#changePasswordModal">
                                    <i class="fas fa-key me-1"></i> Đổi mật khẩu
                                </button>
                        @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-card shadow-sm">
                                    <div class="info-icon">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="form-label text-muted">Họ và tên</label>
                                        <p class="fw-bold mb-0">{{ $user->name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card shadow-sm">
                                    <div class="info-icon">
                                        <i class="fas fa-envelope text-primary"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="form-label text-muted">Email</label>
                                        <p class="fw-bold mb-0">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card shadow-sm">
                                    <div class="info-icon">
                                        <i class="fas fa-phone text-primary"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="form-label text-muted">Số điện thoại</label>
                                        <p class="fw-bold mb-0">{{ $user->phone ?? 'Chưa cập nhật' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card shadow-sm">
                                    <div class="info-icon">
                                        <i class="fas fa-calendar text-primary"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="form-label text-muted">Ngày sinh</label>
                                        <p class="fw-bold mb-0">
                                            {{ $user->date_birth ? date('d/m/Y', strtotime($user->date_birth)) : 'Chưa cập nhật' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card shadow-sm">
                                    <div class="info-icon">
                                        <i class="fas fa-venus-mars text-primary"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="form-label text-muted">Giới tính</label>
                                        <p class="fw-bold mb-0">
                                            @if ($user->gender == 'male')
                                                Nam
                                            @elseif($user->gender == 'female')
                                                Nữ
                                            @elseif($user->gender == 'other')
                                                Khác
                                            @else
                                                Chưa cập nhật
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card shadow-sm">
                                    <div class="info-icon">
                                        <i class="fas fa-map-marker-alt text-primary"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="form-label text-muted">Địa chỉ</label>
                                        <p class="fw-bold mb-0">{{ $user->address ?? 'Chưa cập nhật' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Avatar Modal -->
    <div class="modal fade" id="avatarModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.users.updateProfile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Thay đổi ảnh đại diện</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="mb-4">
                            <img src="{{ $user->avatar ? asset($user->avatar) : asset('v1/assets/img/team/72x72/57.webp') }}"
                                alt="Avatar Preview" class="rounded-circle img-fluid mb-3"
                                style="width: 150px; height: 150px; object-fit: cover;" id="avatarPreview">
                        </div>
                        <div class="mb-3">
                            <label for="avatar-file" class="form-label">Chọn ảnh mới</label>
                            <input type="file" class="form-control" id="avatar-file" name="avatar"
                                accept="image/*">
                            @error('avatar')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-phoenix-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-phoenix-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.users.updateProfile') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Chỉnh sửa thông tin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label"><span class="fas fa-user me-1"></span>Họ và
                                    tên</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label"><span
                                        class="fas fa-envelope me-1"></span>Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label"><span class="fas fa-phone me-1"></span>Số điện
                                    thoại</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="date_birth" class="form-label"><span class="fas fa-calendar me-1"></span>Ngày
                                    sinh</label>
                                <input type="date" class="form-control @error('date_birth') is-invalid @enderror"
                                    id="date_birth" name="date_birth"
                                    value="{{ old('date_birth', $user->date_birth ? \Carbon\Carbon::parse($user->date_birth)->format('Y-m-d') : '') }}">
                                @error('date_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="gender" class="form-label"><span class="fas fa-venus-mars me-1"></span>Giới
                                    tính</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender"
                                    name="gender">
                                    <option value="">Chọn giới tính</option>
                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>
                                        Nam</option>
                                    <option value="female"
                                        {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
                                    <option value="other"
                                        {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Khác</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="address" class="form-label"><span
                                        class="fas fa-map-marker-alt me-1"></span>Địa chỉ</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address" value="{{ old('address', $user->address) }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-phoenix-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-phoenix-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.users.updatePassword') }}" method="POST" id="changePasswordForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Đổi mật khẩu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">
                                <span class="fas fa-lock me-1"></span>Mật khẩu hiện tại
                            </label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3" id="newPasswordFields" style="display: none;">
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <span class="fas fa-lock me-1"></span>Mật khẩu mới
                                </label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">
                                    <span class="fas fa-lock me-1"></span>Xác nhận mật khẩu mới
                                </label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-phoenix-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-phoenix-primary" id="verifyCurrentPassword">Xác nhận</button>
                        <button type="submit" class="btn btn-phoenix-primary" id="submitNewPassword" style="display: none;">Lưu mật khẩu mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(135deg, #ffffff, #f1f4f9);
            border-bottom: 1px solid #e0e6ed;
            padding: 1.5rem;
        }

        .avatar-wrapper img {
            border: 4px solid #ffffff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .avatar-wrapper:hover img {
            transform: scale(1.05);
        }

        .btn-phoenix-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
            color: white;
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-phoenix-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
            color: white;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 0.75rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-label {
            font-weight: 500;
            color: #444;
            margin-bottom: 0.5rem;
        }

        /* Improved Personal Info Card */
        .info-card {
            display: flex;
            align-items: center;
            background-color: #fff;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .info-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .info-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(45deg, #e6f0ff, #d1e4ff);
            border-radius: 8px;
            margin-right: 1rem;
        }

        .info-icon i {
            font-size: 1.25rem;
            color: #007bff;
        }

        .info-content {
            flex: 1;
        }

        .info-content .form-label {
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
            display: block;
        }

        .info-content p {
            font-size: 1rem;
            color: #333;
            margin-bottom: 0;
        }

        .info-card .info-content {
            padding-left: 0.5rem;
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-size: 0.85rem;
        }

        .modal-content {
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
        }

        .modal.show .modal-dialog {
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .avatar-wrapper img {
                width: 120px;
                height: 120px;
            }

            .card {
                margin-bottom: 1.5rem;
            }

            .info-card {
                padding: 0.75rem;
            }

            .info-icon {
                width: 32px;
                height: 32px;
            }

            .info-icon i {
                font-size: 1rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Preview avatar before upload
        document.getElementById('avatar-file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // Handle password change
        document.getElementById('verifyCurrentPassword').addEventListener('click', function() {
            const currentPassword = document.getElementById('current_password').value;
            const currentPasswordInput = document.getElementById('current_password');

            // Xóa thông báo lỗi cũ nếu có
            currentPasswordInput.classList.remove('is-invalid');
            const oldFeedback = currentPasswordInput.parentNode.querySelector('.invalid-feedback');
            if (oldFeedback) {
                oldFeedback.remove();
            }

            // Gửi request kiểm tra mật khẩu hiện tại
            fetch('{{ route("admin.users.verifyPassword") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    current_password: currentPassword
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hiển thị form nhập mật khẩu mới
                    document.getElementById('newPasswordFields').style.display = 'block';
                    currentPasswordInput.readOnly = true;
                    document.getElementById('verifyCurrentPassword').style.display = 'none';
                    document.getElementById('submitNewPassword').style.display = 'block';
                } else {
                    // Hiển thị lỗi
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback d-block';
                    feedback.textContent = 'Mật khẩu hiện tại không đúng';
                    currentPasswordInput.classList.add('is-invalid');
                    currentPasswordInput.parentNode.appendChild(feedback);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        // Reset form when modal is closed
        document.getElementById('changePasswordModal').addEventListener('hidden.bs.modal', function () {
            const form = document.getElementById('changePasswordForm');
            const currentPasswordInput = document.getElementById('current_password');

            form.reset();
            document.getElementById('newPasswordFields').style.display = 'none';
            currentPasswordInput.readOnly = false;
            document.getElementById('verifyCurrentPassword').style.display = 'block';
            document.getElementById('submitNewPassword').style.display = 'none';

            // Xóa tất cả thông báo lỗi
            currentPasswordInput.classList.remove('is-invalid');
            const feedbacks = form.querySelectorAll('.invalid-feedback');
            feedbacks.forEach(feedback => feedback.remove());
        });
    </script>
@endpush
