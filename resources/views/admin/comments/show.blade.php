@extends('admin.layouts')
@section('title', 'Quản lý bình luận')
@section('content')

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chi tiết bình luận #{{ $comment->id }}</h2>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5>Thông tin người dùng</h5>
        <p><strong>Tên:</strong> {{ $comment->user->name ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ $comment->user->email ?? 'N/A' }}</p>

        <h5>Nội dung bình luận</h5>
        <p>{{ $comment->content }}</p>

        <h5>Trạng thái</h5>
        <p>
            @if ($comment->trashed())
                <span class="badge bg-secondary">Đã xóa</span>
            @else
                @switch($comment->status)
                    @case('đã duyệt')
                        <span class="badge bg-success">Đã duyệt</span>
                        @break
                    @case('chờ duyệt')
                        <span class="badge bg-warning text-dark">Chờ duyệt</span>
                        @break
                    @case('spam')
                        <span class="badge bg-danger">Spam</span>
                        @break
                    @case('chặn')
                        <span class="badge bg-dark">Bị chặn</span>
                        @break
                    @default
                        <span class="badge bg-secondary">Không rõ</span>
                @endswitch
            @endif
        </p>

        <h5>Ngày tạo</h5>
        <p>{{ $comment->created_at->format('d/m/Y H:i') }}</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5>Câu trả lời</h5>
        @forelse ($comment->replies as $reply)
            <div class="mb-3 p-3 border rounded">
                <p><strong>{{ $reply->user->name ?? 'Admin' }}</strong> <small class="text-muted">{{ $reply->created_at->format('d/m/Y H:i') }}</small></p>
                <p>{{ $reply->content }}</p>
            </div>
        @empty
            <p>Chưa có câu trả lời nào.</p>
        @endforelse
    </div>
</div>

<a href="{{ route('admin.comments.index') }}" class="btn btn-secondary mt-4">Quay lại danh sách bình luận</a>

@endsection

