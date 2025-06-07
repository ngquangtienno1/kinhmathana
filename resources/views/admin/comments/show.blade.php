@extends('admin.layouts')
@section('title', 'Chi tiết bình luận #' . $comment->id)

@php
    $current = $comment->status;
    $statusLabels = [
        'chờ duyệt' => 'Chờ duyệt',
        'đã duyệt' => 'Đã duyệt',
        'spam' => 'Spam',
        'chặn' => 'Bị chặn',
    ];
    $statusTransitions = [
        'chờ duyệt' => ['đã duyệt'],
        'đã duyệt' => [],
        'spam' => [],
        'chặn' => [],
    ];
    $canUpdate = isset($statusTransitions[$current]) && count($statusTransitions[$current]) > 0;
@endphp

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.comments.index') }}">Bình luận</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết bình luận #{{ $comment->id }}</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chi tiết bình luận #{{ $comment->id }}</h2>
        </div>
        <div class="col-auto ms-auto">
            <div class="d-flex gap-2">
                @if (!$comment->trashed())
                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-phoenix-danger"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
                            <span class="fas fa-trash me-2"></span>Xóa bình luận
                        </button>
                    </form>
                @endif
                <a href="{{ route('admin.comments.index') }}" class="btn btn-phoenix-secondary">
                    <span class="fas fa-arrow-left me-2"></span>Quay lại
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-1">
                        <h5 class="mb-0">Thông tin người dùng</h5>
                    </div>
                    @if ($comment->user && $comment->user->banned_until && now()->lt($comment->user->banned_until))
                        <span class="badge badge-phoenix fs-10 badge-phoenix-danger">
                            User bị khóa còn
                            {{ now()->diffForHumans($comment->user->banned_until, ['short' => true, 'parts' => 2]) }}
                        </span>
                    @endif
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar avatar-xl me-2">
                        <div class="avatar-name rounded-circle">
                            <span>{{ substr($comment->user->name ?? 'N/A', 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h5 class="mb-0">{{ $comment->user->name ?? 'N/A' }}</h5>
                        <p class="text-body-tertiary mb-0">{{ $comment->user->email ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="mb-3">Thông tin bình luận</h5>
                <div class="mb-2">
                    <span class="text-body-tertiary">Loại:</span>
                    <span class="fw-semibold ms-2">{{ $comment->entity_type }}</span>
                </div>
                <div class="mb-2">
                    <span class="text-body-tertiary">Đối tượng:</span>
                    <span class="fw-semibold ms-2">
                        @if ($comment->entity_type === 'product' && $comment->product)
                            {{ $comment->product->name }}
                        @elseif ($comment->entity_type === 'news' && $comment->news)
                            {{ $comment->news->title }}
                        @else
                            {{ $comment->entity_id }}
                        @endif
                    </span>
                </div>
                <div class="mb-2">
                    <span class="text-body-tertiary">Ngày tạo:</span>
                    <span class="fw-semibold ms-2">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="mb-3">Nội dung bình luận</h5>
        <div class="p-3 bg-body-tertiary rounded">
            <p class="mb-0">{{ $comment->content }}</p>
        </div>
    </div>
</div>

@if (!$comment->trashed())
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="mb-3">Cập nhật trạng thái</h5>
            <form action="{{ route('admin.comments.updateStatus', $comment->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select name="status" id="status" class="form-select" {{ !$canUpdate ? 'disabled' : '' }}>
                        <option value="{{ $current }}" selected>{{ $statusLabels[$current] ?? $current }}
                        </option>
                        @foreach ($statusTransitions[$current] as $next)
                            @if ($next !== $current)
                                <option value="{{ $next }}">{{ $statusLabels[$next] ?? $next }}</option>
                            @endif
                        @endforeach
                    </select>
                    @if (!$canUpdate)
                        <div class="text-danger mt-2">
                            <small>Trạng thái <strong>{{ $statusLabels[$current] ?? $current }}</strong> không thể cập
                                nhật nữa.</small>
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-phoenix-primary w-100" {{ !$canUpdate ? 'disabled' : '' }}>
                    <span class="fas fa-save me-2"></span>Cập nhật trạng thái
                </button>
            </form>
        </div>
    </div>
@endif

<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Câu trả lời</h5>
            <button class="btn btn-phoenix-primary btn-sm" data-bs-toggle="modal" data-bs-target="#replyModal">
                <span class="fas fa-reply me-2"></span>Trả lời
            </button>
        </div>

        @forelse ($comment->replies as $reply)
            <div class="border-bottom border-translucent py-3">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar avatar-xl me-2">
                        <div class="avatar-name rounded-circle">
                            <span>{{ substr($reply->user->name ?? 'Admin', 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h6 class="mb-0">{{ $reply->user->name ?? 'Admin' }}</h6>
                        <p class="text-body-tertiary fs-9 mb-0">{{ $reply->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                <p class="mb-0 ps-5">{{ $reply->content }}</p>
            </div>
        @empty
            <div class="text-center py-4">
                <p class="text-body-tertiary mb-0">Chưa có câu trả lời nào.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Modal Trả lời bình luận -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.comments.reply', $comment->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="replyModalLabel">Trả lời bình luận</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="replyContent" class="form-label">Nội dung trả lời</label>
                        <textarea class="form-control" id="replyContent" name="reply_content" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-phoenix-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-phoenix-primary">Gửi trả lời</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
