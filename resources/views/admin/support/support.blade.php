@extends('admin.layouts')

@section('title', 'Support Form')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="{{ route('admin.support.list') }}">Support</a>
</li>
<li class="breadcrumb-item active">Gửi yêu cầu hỗ trợ</li>
@endsection

@section('content')
<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Gửi yêu cầu hỗ trợ khách hàng</h2>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-5">
            <form method="POST" action="{{ route('admin.support.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Họ tên</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Nội dung hỗ trợ</label>
                    <textarea name="message" id="message" class="form-control" rows="5">{{ old('message') }}</textarea>
                    @error('message') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
            </form>
        </div>
    </div>
</div>
@endsection 