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
        <h5 class="mt-5">Đoạn chat hỗ trợ</h5>

        <div class="border rounded p-3 mb-3" style="max-height: 400px; overflow-y: auto; background: #f9f9f9;">
            @foreach ($ticket->messages as $msg)
                <div class="mb-2">
                    <strong>{{ $msg->user->name }}</strong>
                    <small class="text-muted">({{ $msg->created_at->format('d/m/Y H:i') }})</small><br>
                    <div class="p-2 border rounded bg-white">{{ $msg->message }}</div>
                </div>
            @endforeach
        </div>

        <form action="{{ route('admin.tickets.messages.store', $ticket) }}" method="POST">
            @csrf
            <textarea name="message" class="form-control mb-2" rows="3" placeholder="Nhập tin nhắn..."></textarea>
            <button type="submit" class="btn btn-primary btn-sm">Gửi</button>
        </form>

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
