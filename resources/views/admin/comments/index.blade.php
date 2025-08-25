@extends('admin.layouts')

@section('title', 'Quản lý bình luận')

@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.comments.index') }}">Bình luận</a></li>
    <li class="breadcrumb-item active">Quản lý bình luận</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0"> Danh sách Bình luận</h2>
        </div>
    </div>
    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
        <li class="nav-item"><a class="nav-link{{ request('status') ? '' : ' active' }}" aria-current="page"
                href="{{ route('admin.comments.index') }}"><span>Tất cả </span><span
                    class="text-body-tertiary fw-semibold">({{ $totalCount }})</span></a></li>
        <li class="nav-item"><a class="nav-link{{ request('status') == 'đã duyệt' ? ' active' : '' }}"
                href="?status=đã duyệt"><span>Đã duyệt </span><span
                    class="text-body-tertiary fw-semibold">({{ $approvedCount }})</span></a></li>
        <li class="nav-item"><a class="nav-link{{ request('status') == 'chờ duyệt' ? ' active' : '' }}"
                href="?status=chờ duyệt"><span>Chờ duyệt </span><span
                    class="text-body-tertiary fw-semibold">({{ $pendingCount }})</span></a></li>
        <li class="nav-item"><a class="nav-link{{ request('status') == 'spam' ? ' active' : '' }}"
                href="?status=spam"><span>Spam </span><span
                    class="text-body-tertiary fw-semibold">({{ $spamCount }})</span></a></li>
        <li class="nav-item"><a class="nav-link{{ request('status') == 'chặn' ? ' active' : '' }}"
                href="?status=chặn"><span>Bị chặn </span><span
                    class="text-body-tertiary fw-semibold">({{ $blockedCount }})</span></a></li>
        <li class="nav-item"><a class="nav-link{{ request('status') == 'trashed' ? ' active' : '' }}"
                href="?status=trashed"><span>Thùng rác </span><span
                    class="text-body-tertiary fw-semibold">({{ $deletedCount }})</span></a></li>
    </ul>
    <div id="comments"
        data-list='{"valueNames":["userId","userName","entityType","entityId","content","status","createdAt"],"page":10,"pagination":true}'>
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-3">
                <div class="search-box">
                    <form class="position-relative" action="{{ route('admin.comments.index') }}" method="GET">
                        <input class="form-control search-input search" type="search" name="search"
                            placeholder="Tìm kiếm bình luận" value="{{ request('search') }}" aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>
                    </form>
                </div>
                <div class="ms-xxl-auto">
                    <button id="bulk-delete-btn" class="btn btn-danger me-2" style="display: none;">
                        <span class="fas fa-trash me-2"></span>Xóa mềm
                    </button>
                    <form action="{{ route('admin.comments.scan_badwords') }}" method="POST" class="d-inline me-2">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <span class="fas fa-search me-2"></span>Quét bình luận
                        </button>
                    </form>
                    <a href="{{ route('admin.comments.badwords.index') }}" class="btn btn-primary">
                        <span class="fas fa-plus me-2"></span>Quản lý từ cấm
                    </a>
                </div>
            </div>
        </div>
        <div
            class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
            <div class="table-responsive scrollbar mx-n1 px-1">
                <table class="table fs-9 mb-0">
                    <thead>
                        <tr>
                            <th class="white-space-nowrap fs-9 align-middle ps-0" style="max-width:20px; width:18px;">
                                <div class="form-check mb-0 fs-8">
                                    <input class="form-check-input" id="checkbox-bulk-comments-select" type="checkbox"
                                        data-bulk-select='{"body":"comments-table-body"}' />
                                </div>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:80px;">
                                <a href="{{ route('admin.comments.index', ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}"
                                    class="text-body" style="text-decoration:none;">
                                    ID
                                    @if (request('sort') === 'id')
                                        <i
                                            class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:150px;"
                                data-sort="userName">NGƯỜI DÙNG</th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:100px;"
                                data-sort="entityType">LOẠI</th>
                            <th class="sort white-space-nowrap align-middle ps-4" scope="col" style="width:200px;"
                                data-sort="entityId">TÊN ĐỐI TƯỢNG</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="content"
                                style="min-width:300px;">NỘI DUNG</th>
                            <th class="sort align-middle ps-4" scope="col" data-sort="status" style="width:120px;">
                                TRẠNG THÁI</th>
                            <th class="sort align-middle ps-4" scope="col" style="width:120px;">TRẠNG THÁI KHÓA
                            </th>
                            <th class="sort align-middle ps-4" scope="col" style="width:100px;">HIỂN THỊ</th>

                            <th class="sort align-middle ps-4" scope="col" data-sort="createdAt"
                                style="width:150px;">NGÀY TẠO</th>
                            <th class="sort text-end align-middle pe-0 ps-4" scope="col" style="width:100px;">
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list" id="comments-table-body">
                        @forelse ($comments as $comment)
                            <tr class="position-static">
                                <td class="fs-9 align-middle">
                                    <div class="form-check mb-0 fs-8">
                                        <input class="form-check-input comment-checkbox" type="checkbox"
                                            value="{{ $comment->id }}" />
                                    </div>
                                </td>
                                <td class="userId align-middle ps-4">
                                    <span class="text-body-tertiary">{{ $comment->id }}</span>
                                </td>
                                <td class="userName align-middle ps-4">
                                    <span class="fw-semibold">{{ $comment->user->name ?? 'N/A' }}</span><br>
                                    <small class="text-body-tertiary">{{ $comment->user->email ?? '' }}</small>
                                </td>
                                <td class="entityType align-middle ps-4">
                                    <span class="text-body-tertiary">{{ class_basename($comment->entity_type) }}</span>
                                </td>
                                <td class="entityId align-middle ps-4">
                                    @if ($comment->entity_type === 'product' && $comment->product)
                                        <a class="fw-semibold line-clamp-3 mb-0"
                                            href="#">{{ $comment->product->name }}</a>
                                    @elseif ($comment->entity_type === 'news' && $comment->news)
                                        <a class="fw-semibold line-clamp-3 mb-0"
                                            href="#">{{ $comment->news->title }}</a>
                                   
                                    @endif
                                </td>
                                <td class="content align-middle ps-4">
                                    <span class="text-body-tertiary">{{ Str::limit($comment->content, 50) }}</span>
                                </td>
                                <td class="status align-middle ps-4">
                                    @if ($comment->trashed())
                                        <span class="badge badge-phoenix fs-10 badge-phoenix-secondary">Đã xóa</span>
                                    @else
                                        @switch($comment->status)
                                            @case('đã duyệt')
                                                <span class="badge badge-phoenix fs-10 badge-phoenix-success">Đã duyệt</span>
                                            @break

                                            @case('chờ duyệt')
                                                <span class="badge badge-phoenix fs-10 badge-phoenix-warning text-dark">Chờ
                                                    duyệt</span>
                                            @break

                                            @case('spam')
                                                <span class="badge badge-phoenix fs-10 badge-phoenix-danger">Spam</span>
                                            @break

                                            @case('chặn')
                                                <span class="badge badge-phoenix fs-10 badge-phoenix-dark">Bị chặn</span>
                                            @break

                                            @default
                                                <span class="badge badge-phoenix fs-10 badge-phoenix-secondary">Không rõ</span>
                                        @endswitch
                                    @endif
                                </td>
                                <td class="status align-middle ps-4">
                                    @if ($comment->user && $comment->user->banned_until && now()->lt($comment->user->banned_until))
                                        <span class="badge badge-phoenix fs-10 badge-phoenix-danger">
                                            User bị khóa còn
                                            {{ now()->diffForHumans($comment->user->banned_until, ['short' => true, 'parts' => 2]) }}
                                        </span>
                                    @else
                                        <span class="badge badge-phoenix fs-10 badge-phoenix-success">User bình
                                            thường</span>
                                    @endif
                                </td>
                                <td class="align-middle ps-4">
                                    @if ($comment->is_hidden)
                                        <span class="badge badge-phoenix fs-10 badge-phoenix-secondary">Đã ẩn</span>
                                    @else
                                        <span class="badge badge-phoenix fs-10 badge-phoenix-success">Đang hiển
                                            thị</span>
                                    @endif
                                </td>

                                <td class="createdAt align-middle white-space-nowrap text-body-tertiary ps-4">
                                    {{ $comment->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="align-middle white-space-nowrap text-end pe-0 ps-4 btn-reveal-trigger">
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
                                                        onclick="return confirm('Xóa vĩnh viễn bình luận này?')">Xóa
                                                        vĩnh viễn</button>
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
                                    <td colspan="10" class="text-center py-4">Không có bình luận nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                    <div class="col-auto d-flex">
                        <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p>
                        <a class="fw-semibold" href="#!" data-list-view="*">Xem tất cả<span
                                class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                        <a class="fw-semibold d-none" href="#!" data-list-view="less">Xem ít hơn<span
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

        <form id="bulk-delete-form" action="" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
            <input type="hidden" name="ids" id="bulk-delete-ids">
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const bulkCheckbox = document.getElementById('checkbox-bulk-comments-select');
                const itemCheckboxes = document.querySelectorAll('.comment-checkbox');
                const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
                const bulkDeleteForm = document.getElementById('bulk-delete-form');
                const bulkDeleteIds = document.getElementById('bulk-delete-ids');
                const replyModal = document.getElementById('replyModal');
                const replyForm = document.getElementById('replyForm');

                function updateBulkDeleteBtn() {
                    let checkedCount = 0;
                    itemCheckboxes.forEach(function(checkbox) {
                        if (checkbox.checked) checkedCount++;
                    });
                    if (checkedCount > 0) {
                        bulkDeleteBtn.style.display = '';
                    } else {
                        bulkDeleteBtn.style.display = 'none';
                    }
                }

                if (bulkCheckbox) {
                    bulkCheckbox.addEventListener('change', function() {
                        itemCheckboxes.forEach(function(checkbox) {
                            checkbox.checked = bulkCheckbox.checked;
                        });
                        updateBulkDeleteBtn();
                    });
                }
                itemCheckboxes.forEach(function(checkbox) {
                    checkbox.addEventListener('change', function() {
                        updateBulkDeleteBtn();
                    });
                });
                updateBulkDeleteBtn(); // Initial state

                // Xử lý submit xóa mềm
                bulkDeleteBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const checkedIds = Array.from(itemCheckboxes)
                        .filter(cb => cb.checked)
                        .map(cb => cb.value);
                    if (checkedIds.length === 0) return;
                    if (!confirm('Bạn có chắc chắn muốn xóa mềm các bình luận đã chọn?')) return;
                    bulkDeleteIds.value = checkedIds.join(',');
                    bulkDeleteForm.submit();
                });

                // Xử lý trả lời bình luận
                document.querySelectorAll('.btn-reply-comment').forEach(button => {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();
                        const commentId = this.getAttribute('data-comment-id');
                        replyForm.action = `/admin/comments/${commentId}/reply`;
                        replyForm.reset();

                        const bsModal = new bootstrap.Modal(replyModal);
                        bsModal.show();
                    });
                });
            });
        </script>

    @endsection
