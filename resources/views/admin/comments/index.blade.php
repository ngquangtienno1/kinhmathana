@extends('admin.layouts')
@section('title', 'Quản lý bình luận')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">Bình luận</a></li>
    <li class="breadcrumb-item active">Quản lý bình luận</li>
@endsection


<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Quản lý bình luận</h2>
        </div>
    </div>
</div>

<div id="comments"
    data-list='{"valueNames":["userId","userName","entityType","entityId","content","status","createdAt"],"page":10,"pagination":true}'>
    <div class="mb-4">
<a href="{{ route('admin.comments.badwords.index') }}">Quản lý từ cấm</a>

        <form action="{{ route('admin.comments.index') }}" method="GET"
            class="d-flex flex-nowrap gap-2 align-items-end" style="overflow-x:auto;">
            <input class="form-control w-auto" type="search" name="search" placeholder="Tìm kiếm bình luận"
                value="{{ request('search') }}" style="width: 180px;" />
            <input type="number" name="entity_id" class="form-control w-auto" placeholder="ID đối tượng"
                value="{{ request('entity_id') }}" style="width: 120px;" />
            <input type="date" name="from_date" class="form-control w-auto" value="{{ request('from_date') }}"
                style="width: 140px;" />
            <input type="date" name="to_date" class="form-control w-auto" value="{{ request('to_date') }}"
                style="width: 140px;" />
            <select name="status" class="form-select w-auto" style="width: 130px;">
                <option value="">Trạng thái</option>
                <option value="đã duyệt" {{ request('status') === 'đã duyệt' ? 'selected' : '' }}>Đã duyệt</option>
                <option value="chờ duyệt" {{ request('status') === 'chờ duyệt' ? 'selected' : '' }}>Chờ duyệt</option>
                <option value="spam" {{ request('status') === 'spam' ? 'selected' : '' }}>Spam</option>
                <option value="chặn" {{ request('status') === 'chặn' ? 'selected' : '' }}>Bị chặn</option>
                <option value="trashed" {{ request('status') === 'trashed' ? 'selected' : '' }}>Thùng rác</option>
            </select>
            <select name="entity_type" class="form-select w-auto" style="width: 130px;">
                <option value="">Loại đối tượng</option>
                @foreach ($entityTypes as $type)
                    <option value="{{ $type }}" {{ request('entity_type') === $type ? 'selected' : '' }}>
                        {{ $type }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary" style="min-width: 70px;">Lọc</button>
        </form>
    </div>
    <div
        class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
        <div class="table-responsive scrollbar mx-n1 px-1">
            <table class="table fs-9 mb-0">
                <thead>
                    <tr>
                        <th class="align-middle text-center px-3" style="width:10px;">
                            <div class="form-check mb-0 fs-8">
                                <input class="form-check-input" id="checkbox-bulk-comments-select" type="checkbox"
                                    data-bulk-select='{"body":"comments-table-body"}' />
                            </div>
                        </th>
                        <th class="align-middle text-center px-3" style="width:50px;">ID</th>
                        <th class="align-middle text-center px-3" style="width:100px;">Người dùng</th>
                        <th class="align-middle text-center px-3" style="width:100px;">Loại</th>
                        <th class="align-middle text-center px-3" style="width:110px;">Tên đối tượng</th>
                        <th class="align-middle text-start px-4" style="min-width:300px;">Nội dung</th>
                        <th class="align-middle text-center px-3" style="width:120px;">Trạng thái</th>
                        <th class="align-middle text-center px-3" style="width:120px;">Trạng thái khóa</th>
                        <th class="align-middle text-center px-3 white-space-nowrap" style="width:110px;">Ngày tạo
                        </th>
                        <th class="align-middle text-center px-3" style="width:90px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="list">
                    @forelse ($comments as $comment)
                        <tr>
                            <td class="align-middle text-center px-3">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input comment-checkbox" type="checkbox"
                                        value="{{ $comment->id }}" />
                                </div>
                            </td>
                            <td class="userId align-middle text-center px-3">{{ $comment->id }}</td>
                            <td class="userName align-middle text-center px-3">
                                {{ $comment->user->name ?? 'N/A' }}<br><small>{{ $comment->user->email ?? '' }}</small>
                            </td>
                            <td class="entityType align-middle text-center px-3">{{ $comment->entity_type }}</td>
                            <td class="entityId align-middle text-center px-3">
                                @if ($comment->entity_type === 'product' && $comment->product)
                                    {{ $comment->product->name }}
                                @elseif ($comment->entity_type === 'news' && $comment->news)
                                    {{ $comment->news->title }}
                                @else
                                    {{ $comment->entity_id }}
                                @endif
                            </td>

                            <td class="content align-middle text-start px-4">{{ $comment->content }}</td>
                            <td class="status align-middle text-center px-3">
                                {{-- Hiển thị trạng thái --}}
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
                            </td>
                            <td class="status align-middle text-center px-3">
                                @if ($comment->user && $comment->user->banned_until && now()->lt($comment->user->banned_until))
                                    <span class="badge bg-danger">
                                        User bị khóa còn
                                        {{ now()->diffForHumans($comment->user->banned_until, ['short' => true, 'parts' => 2]) }}
                                    </span>
                                @else
                                    <span class="badge bg-success">User bình thường</span>
                                @endif
                            </td>

                            <td class="createdAt align-middle text-center px-3 white-space-nowrap">
                                {{ $comment->created_at->format('d/m/Y H:i') }}</td>

                            <td class="align-middle text-center px-3 white-space-nowrap pe-0 ps-4 btn-reveal-trigger">
                                <div class="btn-reveal-trigger position-static">
                                    <button
                                        class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                        type="button" data-bs-toggle="dropdown" data-boundary="window"
                                        aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                        <span class="fas fa-ellipsis-h fs-10"></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end py-2">
                                        <a class="dropdown-item"
                                            href="{{ route('admin.comments.show', $comment->id) }}">Xem</a>

                                        <a class="dropdown-item btn-reply-comment" href="#"
                                            data-comment-id="{{ $comment->id }}" data-bs-toggle="modal"
                                            data-bs-target="#replyModal">Trả lời</a>

                                        @if (request('status') === 'trashed' && $comment->trashed())
                                            <form action="{{ route('admin.comments.restore', $comment->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="dropdown-item text-success"
                                                    onclick="return confirm('Khôi phục bình luận này?')">Khôi
                                                    phục</button>
                                            </form>

                                            <form action="{{ route('admin.comments.forceDelete', $comment->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Xóa vĩnh viễn bình luận này?')">Xóa vĩnh
                                                    viễn</button>
                                            </form>
                                        @else
                                            <form
                                                action="{{ route('admin.comments.toggle-visibility', $comment->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="is_hidden"
                                                    value="{{ $comment->is_hidden ? 0 : 1 }}">
                                                <button type="submit" class="dropdown-item">
                                                    {{ $comment->is_hidden ? 'Hiện bình luận' : 'Ẩn bình luận' }}
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.comments.destroy', $comment->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">Xóa</button>
                                            </form>
                                        @endif
                                    </div>

                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Không có bình luận nào.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                <div class="col-auto d-flex">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                    </p>
                    <a class="fw-semibold" href="#" data-list-view="*">Xem tất cả<span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                    <a class="fw-semibold d-none" href="#" data-list-view="less">Xem ít hơn<span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                </div>
                <div class="col-auto d-flex">
                    <button class="page-link" data-list-pagination="prev"><span
                            class="fas fa-chevron-left"></span></button>
                    <ul class="mb-0 pagination"></ul>
                    <button class="page-link pe-0" data-list-pagination="next">
                        <span class="fas fa-chevron-right"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Trả lời bình luận -->
    <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="" id="replyForm">
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Gửi trả lời</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const replyModal = document.getElementById('replyModal');
            const replyForm = document.getElementById('replyForm');

            document.querySelectorAll('.btn-reply-comment').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const commentId = this.getAttribute('data-comment-id');
                    replyForm.action = `/admin/comments/${commentId}/reply`;
                    replyForm.reset();

                    // Hiển thị modal (nếu dùng bootstrap 5)
                    const bsModal = new bootstrap.Modal(replyModal);
                    bsModal.show();
                });
            });
        });
    </script>

@endsection
