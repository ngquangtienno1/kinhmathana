@extends('admin.layouts')
@section('title', 'Chi tiết yêu cầu hỗ trợ #' . $ticket->id)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">Chi tiết yêu cầu hỗ trợ</a></li>
    <li class="breadcrumb-item active">Quản lý chi tiết yêu cầu hỗ trợ</li>
@endsection
@section('content')
    <div class="container">

        <h2>Chi tiết yêu cầu hỗ trợ #{{ $ticket->id }}</h2>
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary mb-3">Quay lại</a>

        <div class="mb-3">
            <label class="form-label">Tiêu đề</label>
            <input type="text" class="form-control" value="{{ $ticket->title }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea class="form-control" rows="5" disabled>{{ $ticket->description }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <input type="text" class="form-control" value="{{ ucfirst($ticket->status) }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Ưu tiên</label>
            <input type="text" class="form-control" value="{{ ucfirst($ticket->priority) }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Người xử lý</label>
            <input type="text" class="form-control" value="{{ $ticket->assignedUser->name ?? 'Chưa gán' }}" disabled>
        </div>

        <hr>

        <h4>Lịch sử ghi chú</h4>
        @if ($ticket->notes->count())
            <ul class="list-group">
                @foreach ($ticket->notes as $note)
                    <li class="list-group-item">
                        <strong>{{ $note->user->name ?? 'Người dùng ẩn' }}</strong> -
                        <small>{{ $note->created_at->format('d/m/Y H:i') }}</small>
                        <p>{{ $note->content }}</p>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Chưa có ghi chú nào.</p>
        @endif

    </div>
@endsection
