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
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-5 text-start">
            <div class="mb-3"><strong>Họ tên:</strong> {{ $support->name }}</div>
            <div class="mb-3"><strong>Email:</strong> <a href="mailto:{{ $support->email }}">{{ $support->email }}</a></div>
            <div class="mb-3"><strong>Nội dung:</strong><br>{{ $support->message }}</div>
            <div class="mb-3">
                <strong>Trạng thái:</strong>
                <span class="badge
                    @if($support->status == 'chưa giải quyết') bg-danger
                    @elseif($support->status == 'đang xử lý') bg-warning text-dark
                    @elseif($support->status == 'đã giải quyết') bg-success
                    @else bg-secondary
                    @endif
                ">
                    {{ ucfirst($support->status) }}
                </span>
            </div>
            <div><strong>Thời gian gửi:</strong> {{ $support->created_at->format('d/m/Y H:i') }}</div>
        </div>
    </div>
    <div class="mt-3">
        <a href="{{ route('admin.support.editStatus', $support->id) }}" class="btn btn-warning me-2">
            <i class="fas fa-edit me-1"></i>Sửa trạng thái
        </a>
        <a href="{{ route('admin.support.emailForm', $support->id) }}" class="btn btn-info me-2">
            <i class="fas fa-envelope me-1"></i>Gửi email
        </a>
        <a href="{{ route('admin.support.list') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Quay lại
        </a>
    </div>
</div>
@endsection
