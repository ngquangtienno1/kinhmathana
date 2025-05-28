@extends('admin.layouts')

@section('title', 'Quản lý từ cấm')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">Bình luận</a></li>
    <li class="breadcrumb-item active">Quản lý từ cấm</li>
@endsection

@section('content')
<div class="mb-4">
    <h2>Quản lý từ cấm</h2>
</div>

<div class="mb-3">
    <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary">
        &laquo; Quay lại danh sách bình luận
    </a>
</div>

<div class="mb-3">
    <form action="{{ route('admin.comments.badwords.store') }}" method="POST" class="d-flex gap-2">
        @csrf
        <input type="text" name="word" class="form-control @error('word') is-invalid @enderror" placeholder="Nhập từ cấm mới" required>
        <button type="submit" class="btn btn-primary">Thêm từ cấm</button>
    </form>
    @error('word')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Từ cấm</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($badWords as $badWord)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $badWord->word }}</td>
                <td>
                    <form action="{{ route('admin.comments.badwords.destroy', $badWord->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa từ cấm này?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Xóa</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">Chưa có từ cấm nào.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
