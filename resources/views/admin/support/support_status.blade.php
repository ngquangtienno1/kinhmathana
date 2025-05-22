@extends('admin.layouts')

@section('title', 'Support Status')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="{{ route('admin.support.index') }}">Support</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('admin.support.list') }}">Quản lý hỗ trợ khách hàng</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('admin.support.show', $support->id) }}">Chi tiết</a>
</li>
<li class="breadcrumb-item active">Cập nhật trạng thái</li>
@endsection

@section('content')
<div class="mb-9" style="max-width:500px; margin:auto;">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Cập nhật trạng thái hỗ trợ khách hàng</h2>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.support.updateStatus', $support->id) }}">
                @csrf
                <div class="mb-3">
                    <label for="status" class="form-label"><strong>Trạng thái</strong></label>
                    <select name="status" id="status" class="form-select">
                        <option value="chưa giải quyết" {{ $support->status == 'chưa giải quyết' ? 'selected' : '' }}>Chưa giải quyết</option>
                        <option value="đang xử lý" {{ $support->status == 'đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
                        <option value="đã giải quyết" {{ $support->status == 'đã giải quyết' ? 'selected' : '' }}>Đã giải quyết</option>
                    </select>
                    @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Lưu trạng thái</button>
                <a href="{{ route('admin.support.show', $support->id) }}" class="btn btn-secondary ms-2">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection 