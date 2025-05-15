@extends('admin.layouts')

@section('title', 'Gửi email cho khách hàng')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="/admin/products">Products</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('admin.products.support.list') }}">Quản lý hỗ trợ khách hàng</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('admin.products.support.show', $support->id) }}">Chi tiết</a>
</li>
<li class="breadcrumb-item active">Gửi email</li>
@endsection

@section('content')
<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Gửi email cho khách hàng</h2>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.products.support.sendEmail', $support->id) }}">
                @csrf
                <div class="mb-3">
                    <label for="subject" class="form-label"><strong>Tiêu đề</strong></label>
                    <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}">
                    @error('subject') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label"><strong>Nội dung</strong></label>
                    <textarea name="content" id="content" class="form-control" rows="7">{{ old('content') }}</textarea>
                    @error('content') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Gửi email</button>
                <a href="{{ route('admin.products.support.show', $support->id) }}" class="btn btn-secondary ms-2">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection 