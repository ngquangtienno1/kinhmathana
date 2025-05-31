@extends('admin.layouts')
@section('title', 'Sửa Tin Tức')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.news.index') }}">Tin tức</a>
    </li>
    <li class="breadcrumb-item active">Sửa Tin Tức</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Sửa Tin Tức</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label" for="category_id">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                            name="category_id" required>
                            <option value="">Chọn danh mục</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="title">Tiêu đề <span class="text-danger">*</span></label>
                        <input class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                            type="text" value="{{ old('title', $news->title) }}" required />
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="summary">Tóm tắt <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('summary') is-invalid @enderror" id="summary" name="summary" rows="3"
                            required>{{ old('summary', $news->summary) }}</textarea>
                        @error('summary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="content">Nội dung <span class="text-danger">*</span></label>
                        <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="8">{{ old('content', $news->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="image">Hình ảnh</label>
                        <input class="form-control @error('image') is-invalid @enderror" id="image" name="image"
                            type="file" accept="image/*" />
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($news->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $news->image) }}" alt="Current image"
                                    class="img-thumbnail" style="max-height: 200px;">
                                <p class="text-muted mt-1">Hình ảnh hiện tại</p>
                            </div>
                        @endif
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="published_at">Ngày xuất bản</label>
                        <input class="form-control @error('published_at') is-invalid @enderror" id="published_at"
                            name="published_at" type="datetime-local"
                            value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}" />
                        @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="is_active" name="is_active" type="checkbox"
                                value="1" {{ old('is_active', $news->is_active) ? 'checked' : '' }} />
                            <label class="form-check-label" for="is_active">Hoạt động</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" type="submit">Cập nhật</button>
                            <a href="{{ route('admin.news.index') }}" class="btn btn-light">Hủy</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush

@endsection
