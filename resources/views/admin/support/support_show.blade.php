@extends('admin.layouts')

@section('title', 'Support Detail')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.support.index') }}">Support</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.support.list') }}">Quản lý hỗ trợ khách hàng</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết</li>
@endsection

@section('content')
    <div class="mb-9">
        <div class="row g-3 mb-4">
            <div class="col-auto">
                <h2 class="mb-0">Chi tiết hỗ trợ khách hàng</h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editStatusModal">
                        <i class="fas fa-edit me-1"></i>Sửa trạng thái
                    </button>
                    <a href="{{ route('admin.support.emailForm', $support->id) }}" class="btn btn-info">
                        <i class="fas fa-envelope me-1"></i>Gửi email
                    </a>
                    <a href="{{ route('admin.support.list') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Quay lại
                    </a>
                </div>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 200px;">Họ tên</th>
                                <td>{{ $support->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><a href="mailto:{{ $support->user->email }}">{{ $support->user->email }}</a></td>
                            </tr>
                            <tr>
                                <th>Nội dung</th>
                                <td>{{ $support->message }}</td>
                            </tr>
                            <tr>
                                <th>Trạng thái</th>
                                <td>
                                    <span
                                        class="badge badge-phoenix fs-10
                                        @if ($support->status == 'mới') badge-phoenix-danger
                                        @elseif($support->status == 'đang xử lý') badge-phoenix-warning
                                        @elseif($support->status == 'đã xử lý') badge-phoenix-success
                                        @else badge-phoenix-secondary @endif
                                    ">
                                        {{ ucfirst($support->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Thời gian gửi</th>
                                <td>{{ $support->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.support.updateStatus', $support->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editStatusModalLabel">Cập nhật trạng thái hỗ trợ khách hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="status" class="form-label"><strong>Trạng thái</strong></label>
                            <select name="status" id="status" class="form-select">
                                <option value="mới" {{ $support->status == 'mới' ? 'selected' : '' }}>Mới</option>
                                <option value="đang xử lý" {{ $support->status == 'đang xử lý' ? 'selected' : '' }}>Đang xử
                                    lý</option>
                                <option value="đã xử lý" {{ $support->status == 'đã xử lý' ? 'selected' : '' }}>Đã xử lý
                                </option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu trạng thái</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
