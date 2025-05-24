@extends('admin.layouts')

@section('title', 'Sửa Bình luận')

@section('content')
    <h2>Sửa Bình luận #{{ $comment->id }} - Người dùng: {{ $comment->user->name }}</h2>

    <form action="{{ route('admin.comments.update', $comment->id) }}" method="POST">
        @csrf
        @method('PUT')



        <div class="col-12">
            <div class="form-check form-switch">
                <input type="hidden" name="is_hidden" value="0">
                <input class="form-check-input" id="is_hidden" name="is_hidden" type="checkbox" value="1"
                    {{ old('is_hidden', $comment->is_hidden) ? 'checked' : '' }} />
                <label class="form-check-label" for="is_hidden">Ẩn bình luận</label>
            </div>
        </div>


        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
@endsection
