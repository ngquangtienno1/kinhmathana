@extends('admin.layouts')
@section('title', 'Chỉnh sửa FAQ')
@section('content')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="{{ route('admin.faqs.index') }}">FAQ</a>
</li>
<li class="breadcrumb-item active">Chỉnh sửa</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chỉnh sửa FAQ</h2>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-8">
                <div class="form-group mb-3">
                    <label for="question">Câu hỏi</label>
                    <input type="text" class="form-control" id="question" name="question" value="{{ old('question', $faq->question) }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="answer">Câu trả lời</label>
                    <textarea class="form-control" id="answer" name="answer" rows="5" required>{{ old('answer', $faq->answer) }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="image">Hình ảnh</label>
                    @if($faq->image)
                        <div class="mb-2">
                            <img src="{{ asset($faq->image) }}" alt="{{ $faq->question }}" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    @endif
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <small class="text-muted">Định dạng: jpeg, png, jpg, gif. Kích thước tối đa: 2MB</small>
                </div>
                <div class="form-group mb-3">
                    <label for="category">Danh mục</label>
                    <select class="form-control" id="category" name="category">
                        <option value="">Chọn danh mục</option>
                        <option value="Chung" {{ old('category', $faq->category) == 'Chung' ? 'selected' : '' }}>Chung</option>
                        <option value="Sản phẩm" {{ old('category', $faq->category) == 'Sản phẩm' ? 'selected' : '' }}>Sản phẩm</option>
                        <option value="Vận chuyển" {{ old('category', $faq->category) == 'Vận chuyển' ? 'selected' : '' }}>Vận chuyển</option>
                        <option value="Thanh toán" {{ old('category', $faq->category) == 'Thanh toán' ? 'selected' : '' }}>Thanh toán</option>
                        <option value="Bảo hành" {{ old('category', $faq->category) == 'Bảo hành' ? 'selected' : '' }}>Bảo hành</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="sort_order">Thứ tự hiển thị</label>
                    <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $faq->sort_order) }}" min="0">
                </div>
                <div class="form-check mb-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Kích hoạt</label>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

@endsection
