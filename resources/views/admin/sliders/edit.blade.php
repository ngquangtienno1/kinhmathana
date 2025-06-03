@extends('admin.layouts')
@section('title', 'Sửa Slider')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.sliders.index') }}">Slider</a>
    </li>
    <li class="breadcrumb-item active">Sửa Slider</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Sửa Slider</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label" for="title">Tiêu đề <span class="text-danger">*</span></label>
                        <input class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                            type="text" value="{{ old('title', $slider->title) }}" required />
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="description">Mô tả</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="3">{{ old('description', $slider->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</dicv>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label" for="url">Đường dẫn URL</label>
                            <input class="form-control @error('url') is-invalid @enderror" id="url" name="url"
                                type="url" value="{{ old('url', $slider->url) }}"
                                placeholder="https://example.com" />
                            @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label" for="image">Hình ảnh</label>
                            <input class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" type="file" accept="image/*" />
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($slider->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $slider->image) }}" alt="Current image"
                                        class="img-thumbnail" style="max-height: 200px;">
                                    <p class="text-muted mt-1">Hình ảnh hiện tại</p>
                                </div>
                            @endif
                        </div>

                        <div class="col-12">
                            <label class="form-label" for="sort_order">Thứ tự sắp xếp</label>
                            <input class="form-control @error('sort_order') is-invalid @enderror" id="sort_order"
                                name="sort_order" type="number"
                                value="{{ old('sort_order', $slider->sort_order) }}" />
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="start_date">Ngày bắt đầu</label>
                            <input class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                                name="start_date" type="datetime-local"
                                value="{{ old('start_date', $slider->start_date ? $slider->start_date->format('Y-m-d\TH:i') : '') }}" />
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="end_date">Ngày kết thúc</label>
                            <input class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                                name="end_date" type="datetime-local"
                                value="{{ old('end_date', $slider->end_date ? $slider->end_date->format('Y-m-d\TH:i') : '') }}" />
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" id="is_active" name="is_active" type="checkbox"
                                    value="1" {{ old('is_active', $slider->is_active) ? 'checked' : '' }} />
                                <label class="form-check-label" for="is_active">Hoạt động</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary" type="submit">Cập nhật</button>
                                <a href="{{ route('admin.sliders.index') }}" class="btn btn-light">Hủy</a>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>

@endsection
