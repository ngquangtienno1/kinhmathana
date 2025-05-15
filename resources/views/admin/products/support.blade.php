@extends('admin.layouts')

@section('title', 'Hỗ trợ khách hàng')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="/admin/products">Products</a>
</li>
<li class="breadcrumb-item active">Hỗ trợ khách hàng</li>
@endsection

@section('content')
<div class="container">
    <h2>Hỗ trợ khách hàng</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('admin.products.support') }}">
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
@endsection 