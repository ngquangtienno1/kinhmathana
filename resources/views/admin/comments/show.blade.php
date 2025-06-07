@extends('admin.layouts')
@section('title', 'Chi tiết bình luận #' . $comment->id)

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.comments.index') }}">Bình luận</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết bình luận #{{ $comment->id }}</li>
@endsection

<div class="mb-9">
    <h2 class="mb-0">Bình luận #{{ $comment->id }}</h2>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5>Thông tin người dùng</h5>
        <p><strong>Tên:</strong> {{ $comment->user->name ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ $comment->user->email ?? 'N/A' }}</p>

        <h5>Nội dung bình luận</h5>
        <p>{{ $comment->content }}</p>

        <h5>Trạng thái bình luận</h5>
        @php
            $statusLabels = [
                'chờ duyệt' => 'Chờ duyệt',
                'đã duyệt' => 'Đã duyệt',
            ];
            $statusColors = [
                'chờ duyệt' => 'warning',
                'đã duyệt' => 'success',
            ];
            $current = $comment->status;
            // Định nghĩa trạng thái có thể chuyển tới
            $statusTransitions = [
                'chờ duyệt' => ['đã duyệt'],
                'đã duyệt' => [],
            ];
            $canUpdate = isset($statusTransitions[$current]) && count($statusTransitions[$current]) > 0;
        @endphp

        <span
            class="badge bg-{{ $statusColors[$current] ?? 'secondary' }}">{{ $statusLabels[$current] ?? $current }}</span>
    </div>
</div>

@php
    $current = $comment->status;

    $statusLabels = [
        'chờ duyệt' => 'Chờ duyệt',
        'đã duyệt' => 'Đã duyệt',
        'spam' => 'Spam',
        'chặn' => 'Bị chặn',
    ];

    // Chỉ cho phép cập nhật khi trạng thái hiện tại là "chờ duyệt"
    $statusTransitions = [
        'chờ duyệt' => ['đã duyệt'],  // Chỉ chuyển từ chờ duyệt sang đã duyệt
        'đã duyệt' => [],             // Đã duyệt là trạng thái cuối, không đổi
        'spam' => [],                // Không đổi
        'chặn' => [],                // Không đổi
    ];

    $canUpdate = isset($statusTransitions[$current]) && count($statusTransitions[$current]) > 0;
@endphp


@if (!$comment->trashed())
    <div class="card">
        <div class="card-body">
            <h5>Cập nhật trạng thái bình luận</h5>
            <form action="{{ route('admin.comments.updateStatus', $comment->id) }}" method="POST">
                @csrf
                @method('PATCH')

                {{-- Hiển thị thông báo nếu không thể cập nhật --}}

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
                        <small class="text-danger">Trạng thái
                            <strong>{{ $statusLabels[$current] ?? $current }}</strong> không thể cập nhật nữa.</small>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary w-100" {{ !$canUpdate ? 'disabled' : '' }}>
                    Cập nhật trạng thái
                </button>
            </form>
        </div>
    </div>
@endif


{{-- Phần trả lời bình luận --}}
<div class="card mt-4">
    <div class="card-body">
        <h5>Câu trả lời</h5>
        @forelse ($comment->replies as $reply)
            <div class="mb-3 p-3 border rounded">
                <p><strong>{{ $reply->user->name ?? 'Admin' }}</strong> <small
                        class="text-muted">{{ $reply->created_at->format('d/m/Y H:i') }}</small></p>
                <p>{{ $reply->content }}</p>
            </div>
        @empty
            <p>Chưa có câu trả lời nào.</p>
        @endforelse
    </div>
</div>

<a href="{{ route('admin.comments.index') }}" class="btn btn-secondary mt-4">Quay lại danh sách bình luận</a>

@endsection
