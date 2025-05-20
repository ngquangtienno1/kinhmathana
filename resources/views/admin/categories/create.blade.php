@extends('admin.layouts')
@section('title', 'Thêm danh mục')
@section('content')
<h2>Thêm danh mục</h2>
<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Tên danh mục<span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Mô tả<span class="text-danger">*</span></label>
        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
         @error('description')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Danh mục cha</label>
        <select name="parent_id" class="form-control">
            <option value="">-- Không chọn --</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-success">Lưu</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Hủy</a>
</form>
@endsection
