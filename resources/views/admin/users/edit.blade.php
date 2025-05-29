@extends('admin.layouts')

@section('title', 'Sửa người dùng')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.users.index') }}">Người dùng</a>
    </li>
    <li class="breadcrumb-item active">Sửa người dùng</li>
@endsection

@section('content')
    <div class="mb-9">
        <div class="row g-3 mb-4">
            <div class="col-auto">
                <h2 class="mb-0">Sửa người dùng</h2>
            </div>
        </div>
        <div class="row g-0">
            <div class="col-lg-8 pe-lg-2">
                <div class="card mb-3">
                    <div class="card-body">
                        {{-- Hiển thị thông báo lỗi từ controller --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @php
                            $isAdmin = auth()->user()->role_id == 1;
                            $isStaff = auth()->user()->role_id == 2;
                            $isEditingSelf = auth()->user()->id == $user->id;
                            $isEditingAdmin = $user->role_id == 1;
                            $isEditingStaff = $user->role_id == 2;
                            $isDefaultAdmin = $user->id == 1;
                            $canEdit = true;
                            // Không cho phép chỉnh sửa admin mặc định nếu không phải admin gốc
                            if ($isDefaultAdmin && !$isEditingSelf) {
                                $canEdit = false;
                            }
                        @endphp

                        @if (!$canEdit)
                            <div class="alert alert-danger">Bạn không có quyền chỉnh sửa tài khoản admin mặc định!</div>
                        @else
                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label" for="name">Tên người dùng</label>
                                    <input class="form-control @error('name') is-invalid @enderror" id="name"
                                        name="name" type="text" value="{{ old('name', $user->name) }}" />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="email"
                                        name="email" type="email" value="{{ old('email', $user->email) }}"
                                        @if ($isStaff && ($isEditingAdmin || $isEditingStaff) && !$isEditingSelf) disabled @endif />
                                    @if ($isStaff && ($isEditingAdmin || $isEditingStaff) && !$isEditingSelf)
                                        <div class="form-text text-danger">Bạn không có quyền đổi email của tài khoản này.
                                        </div>
                                    @endif
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="phone">Số điện thoại</label>
                                    <input class="form-control @error('phone') is-invalid @enderror" id="phone"
                                        name="phone" type="text" value="{{ old('phone', $user->phone) }}" />
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="address">Địa chỉ</label>
                                    <input class="form-control @error('address') is-invalid @enderror" id="address"
                                        name="address" type="text" value="{{ old('address', $user->address) }}" />
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="date_birth">Ngày sinh</label>
                                    <input class="form-control @error('date_birth') is-invalid @enderror" id="date_birth"
                                        name="date_birth" type="date"
                                        value="{{ old('date_birth', $user->date_birth ? $user->date_birth->format('Y-m-d') : '') }}" />
                                    @error('date_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="gender">Giới tính</label>
                                    <select class="form-select @error('gender') is-invalid @enderror" id="gender"
                                        name="gender">
                                        <option value="">Chọn giới tính</option>
                                        <option value="male"
                                            {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>
                                            Nam</option>
                                        <option value="female"
                                            {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
                                        <option value="other"
                                            {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>
                                            Khác</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="status_user">Trạng thái</label>
                                    @php
                                        $disableStatus =
                                            ($isStaff && ($isEditingAdmin || $isEditingStaff)) ||
                                            ($isAdmin && $isEditingSelf);
                                    @endphp
                                    <select class="form-select @error('status_user') is-invalid @enderror" id="status_user"
                                        name="status_user" @if ($disableStatus) disabled @endif>
                                        <option value="">Chọn trạng thái</option>
                                        <option value="active"
                                            {{ old('status_user', $user->status_user) == 'active' ? 'selected' : '' }}>Hoạt
                                            động</option>
                                        <option value="inactive"
                                            {{ old('status_user', $user->status_user) == 'inactive' ? 'selected' : '' }}>
                                            Không hoạt động</option>
                                        <option value="blocked"
                                            {{ old('status_user', $user->status_user) == 'blocked' ? 'selected' : '' }}>Bị
                                            chặn</option>
                                    </select>
                                    @if ($disableStatus)
                                        <input type="hidden" name="status_user" value="{{ $user->status_user }}">
                                        <div class="form-text text-danger">
                                            @if ($isStaff && $isEditingAdmin)
                                                Nhân viên không được phép thay đổi trạng thái hoạt động của tài khoản Admin.
                                            @elseif ($isStaff && $isEditingStaff)
                                                Nhân viên không được phép thay đổi trạng thái hoạt động của tài khoản Nhân
                                                viên
                                                khác.
                                            @else
                                                Bạn không thể tự khoá tài khoản của mình.
                                            @endif
                                        </div>
                                    @endif
                                    @error('status_user')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="role_id">Vai trò</label>
                                    @if (!$isAdmin)
                                        <select class="form-select" id="role_id" name="role_id" disabled>
                                            @foreach (\App\Models\Role::all() as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="role_id" value="{{ $user->role_id }}">
                                        <div class="form-text text-danger">Chỉ tài khoản Admin mới có quyền thay đổi vai
                                            trò.
                                        </div>
                                    @else
                                        <select class="form-select @error('role_id') is-invalid @enderror" id="role_id"
                                            name="role_id" @if ($isEditingSelf && $user->role_id == 1) disabled @endif>
                                            <option value="">Chọn vai trò</option>
                                            @foreach (\App\Models\Role::all() as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($isEditingSelf && $user->role_id == 1)
                                            <input type="hidden" name="role_id" value="1">
                                            <div class="form-text text-danger">Bạn không thể tự hạ quyền Admin của mình!
                                            </div>
                                        @endif
                                        @error('role_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="avatar">Ảnh đại diện</label>
                                    @if ($user->avatar)
                                        <div class="mb-2">
                                            <img src="{{ asset($user->avatar) }}" alt="Avatar" class="img-thumbnail"
                                                style="max-width: 200px">
                                        </div>
                                    @endif
                                    <input class="form-control @error('avatar') is-invalid @enderror" id="avatar"
                                        name="avatar" type="file" accept="image/*" />
                                    <div class="form-text">Chọn ảnh mới để thay đổi ảnh đại diện. Định dạng: JPEG, PNG,
                                        JPG,
                                        GIF. Kích thước tối đa: 2MB</div>
                                    @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="password">Mật khẩu mới (để trống nếu không muốn thay
                                        đổi)</label>
                                    <input class="form-control @error('password') is-invalid @enderror" id="password"
                                        name="password" type="password"
                                        @if ($isStaff && ($isEditingAdmin || $isEditingStaff) && !$isEditingSelf) disabled @endif />
                                    @if ($isStaff && ($isEditingAdmin || $isEditingStaff) && !$isEditingSelf)
                                        <div class="form-text text-danger">Bạn không có quyền đổi mật khẩu tài khoản này.
                                        </div>
                                    @endif
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="password_confirmation">Xác nhận mật khẩu mới</label>
                                    <input class="form-control" id="password_confirmation" name="password_confirmation"
                                        type="password" />
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary" type="submit">Cập nhật</button>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Hủy</a>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
