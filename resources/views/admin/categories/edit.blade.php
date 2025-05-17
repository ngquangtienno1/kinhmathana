@extends('admin.layouts')
@section('title', 'Sửa danh mục')
@section('content')
<h2>Cập nhật danh mục</h2>
<form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Tên danh mục</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}">
        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Mô tả</label>
        <textarea name="description" class="form-control">{{ old('description', $category->description) }}</textarea>
          @error('description')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Danh mục cha</label>
        <select name="parent_id" class="form-control">
            <option value="">-- Không chọn --</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-success">Cập nhật</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Hủy</a>
</form>
@endsection
