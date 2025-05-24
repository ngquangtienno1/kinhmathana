@extends('admin.layouts')
@section('title', 'Sửa yêu cầu hỗ trợ #' . $ticket->id)

@section('content')




    <div class="container">
        <h2>Sửa yêu cầu hỗ trợ #{{ $ticket->id }}</h2>

        {{-- Form cập nhật ticket --}}
        <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Các trường sửa --}}
            <div class="mb-3">
                <label class="form-label">Tiêu đề</label>
                <input type="text" class="form-control" value="{{ $ticket->title }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea class="form-control" rows="5" disabled>{{ $ticket->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Trạng thái</label>
                <select name="status" id="status" class="form-select" required>
                    @php
                        $statuses = ['mới', 'đang xử lý', 'chờ khách', 'đã đóng'];
                    @endphp
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}"
                            {{ old('status', $ticket->status) == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="priority" class="form-label">Ưu tiên</label>
                <select name="priority" id="priority" class="form-select" required>
                    @php
                        $priorities = ['thấp', 'trung bình', 'cao', 'khẩn cấp'];
                    @endphp
                    @foreach ($priorities as $priority)
                        <option value="{{ $priority }}"
                            {{ old('priority', $ticket->priority) == $priority ? 'selected' : '' }}>
                            {{ ucfirst($priority) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="assigned_to" class="form-label">Người xử lý</label>
                <select name="assigned_to" id="assigned_to" class="form-select">
                    <option value="">Chưa gán</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                            {{ old('assigned_to', $ticket->assigned_to) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">Hủy</a>
        </form>

        <hr>

        {{-- Form thêm ghi chú --}}

        <h5 class="mt-4">Ghi chú nội bộ</h5>

        <form action="{{ route('admin.tickets.ticket-notes.store') }}" method="POST" class="mb-4">
            @csrf
            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
            <textarea name="content" class="form-control mb-2" rows="3" placeholder="Thêm ghi chú..."></textarea>
            <button type="submit" class="btn btn-sm btn-primary">Lưu ghi chú</button>
        </form>

        <hr>

        <h4>Lịch sử ghi chú</h4>
        @if ($ticket->notes->count())
            <ul class="list-group">
                @foreach ($ticket->notes as $note)
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div>
                            <strong>{{ $note->user->name ?? 'Người dùng ẩn' }}</strong> -
                            <small>{{ $note->created_at->format('d/m/Y H:i') }}</small>
                            <p>{{ $note->content }}</p>
                        </div>
                        <form action="{{ route('admin.tickets.ticket-notes.delete', $note->id) }}" method="POST"
                            onsubmit="return confirm('Bạn có chắc muốn xóa ghi chú này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Chưa có ghi chú nào.</p>
        @endif

    </div>
@endsection
