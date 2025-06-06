@extends('admin.layouts')

@section('title', 'Chi tiết liên hệ')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.contacts.index') }}">Liên hệ</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết liên hệ</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chi tiết liên hệ</h2>
        </div>
        <div class="col-auto ms-auto">
            <div class="d-flex gap-2">
                <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-phoenix-danger"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa liên hệ này?')">
                        <span class="fas fa-trash me-2"></span>Xóa
                    </button>
                </form>
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-phoenix-secondary">
                    <span class="fas fa-arrow-left me-2"></span>Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12">
                    <div class="mb-4">
                        <h4 class="mb-3">Thông tin liên hệ</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px;">Họ tên</th>
                                        <td>{{ $contact->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $contact->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Số điện thoại</th>
                                        <td>{{ $contact->phone ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nội dung</th>
                                        <td>{{ $contact->message }}</td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái</th>
                                        <td>
                                            <span
                                                class="badge badge-phoenix fs-10
                                                @switch($contact->status)
                                                    @case('mới')
                                                        badge-phoenix-info
                                                        @break
                                                    @case('đã đọc')
                                                        badge-phoenix-warning
                                                        @break
                                                    @case('đã trả lời')
                                                        badge-phoenix-success
                                                        @break
                                                    @case('đã bỏ qua')
                                                        badge-phoenix-danger
                                                        @break
                                                @endswitch">
                                                {{ $contact->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>IP Address</th>
                                        <td>{{ $contact->ip_address }}</td>
                                    </tr>
                                    <tr>
                                        <th>User Agent</th>
                                        <td>{{ $contact->user_agent }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày tạo</th>
                                        <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    @if ($contact->reply_at)
                                        <tr>
                                            <th>Thời gian trả lời</th>
                                            <td>{{ $contact->reply_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endif
                                    @if ($contact->replied_by)
                                        <tr>
                                            <th>Người trả lời</th>
                                            <td>{{ $contact->replier->name }}</td>
                                        </tr>
                                    @endif
                                    @if ($contact->note)
                                        <tr>
                                            <th>Ghi chú</th>
                                            <td>{{ $contact->note }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
