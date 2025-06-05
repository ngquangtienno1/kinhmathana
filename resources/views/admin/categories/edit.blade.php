@extends('admin.layouts')
@section('title', 'Sửa danh mục')
@section('content')
<h2>Sửa danh mục</h2>
<form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Tên danh mục<span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}">
        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Slug<span class="text-danger"></span></label>
        <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug) }}">
        @error('slug')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Mô tả<span class="text-danger">*</span></label>
        <textarea name="description" class="form-control">{{ old('description', $category->description) }}</textarea>
        @error('description')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Danh mục cha</label>
        <select name="parent_id" class="form-control">
            <option value="">-- Không chọn --</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Trạng thái hoạt động</label>
        </div>
    </div>
    <button type="submit" class="btn btn-success">Lưu</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Hủy</a>
</form>
@endsection
