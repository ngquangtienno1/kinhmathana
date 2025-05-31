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
        <div class="d-flex flex-wrap gap-3">
            <div class="search-box">
                <form action="{{ route('admin.comments.index') }}" method="GET"
                    class="d-flex gap-3 flex-wrap align-items-center">

                    <input class="form-control search-input search" type="search" name="search"
                        placeholder="Tìm kiếm bình luận" value="{{ request('search') }}" />


                    <input type="number" name="entity_id" class="form-control" placeholder="ID đối tượng"
                        value="{{ request('entity_id') }}" />

                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}" />
                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}" />

                    <button type="submit" class="btn btn-primary">Lọc</button>
                </form>

            </div>


            {{-- Dropdown lọc theo trạng thái --}}
            <div class="scrollbar overflow-hidden-y">
                <div class="btn-group position-static" role="group">
                    <div class="btn-group position-static text-nowrap">
                        <button class="btn btn-phoenix-secondary px-7 flex-shrink-0" type="button"
                            data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false"
                            data-bs-reference="parent">
                            Trạng thái
                            <span class="fas fa-angle-down ms-2"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.comments.badwords.index') }}">Quản lý từ
                                    cấm</a></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.comments.scan_badwords') }}"
                                    onclick="return confirm('Bạn có chắc muốn quét bình luận không?')">
                                    Quét bình luận từ cấm
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ !request('status') ? 'active' : '' }}"
                                    href="{{ route('admin.comments.index', array_merge(request()->except(['status', 'page']), ['search' => request('search')])) }}">
                                    Tất cả ({{ $totalCount }})
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request('status') === 'đã duyệt' ? 'active' : '' }}"
                                    href="{{ route('admin.comments.index', array_merge(request()->except(['status', 'page']), ['status' => 'đã duyệt', 'search' => request('search')])) }}">
                                    Đã duyệt ({{ $approvedCount }})
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request('status') === 'chờ duyệt' ? 'active' : '' }}"
                                    href="{{ route('admin.comments.index', array_merge(request()->except(['status', 'page']), ['status' => 'chờ duyệt', 'search' => request('search')])) }}">
                                    Chờ duyệt ({{ $pendingCount }})
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request('status') === 'spam' ? 'active' : '' }}"
                                    href="{{ route('admin.comments.index', array_merge(request()->except(['status', 'page']), ['status' => 'spam', 'search' => request('search')])) }}">
                                    Spam ({{ $spamCount }})
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request('status') === 'chặn' ? 'active' : '' }}"
                                    href="{{ route('admin.comments.index', array_merge(request()->except(['status', 'page']), ['status' => 'chặn', 'search' => request('search')])) }}">
                                    Bị chặn ({{ $blockedCount }})
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request('status') === 'trashed' ? 'active' : '' }}"
                                    href="{{ route('admin.comments.index', array_merge(request()->except(['status', 'page']), ['status' => 'trashed', 'search' => request('search')])) }}">
                                    Thùng rác ({{ $deletedCount }})
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                {{-- Dropdown lọc entity_type --}}
                <div class="btn-group position-static" role="group">
                    <div class="btn-group position-static text-nowrap">
                        <button class="btn btn-phoenix-secondary px-7 flex-shrink-0" type="button"
                            data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false"
                            data-bs-reference="parent">
                            Loại đối tượng
                            <span class="fas fa-angle-down ms-2"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ !request('entity_type') ? 'active' : '' }}"
                                    href="{{ route('admin.comments.index', array_merge(request()->except(['entity_type', 'page']), ['search' => request('search')])) }}">
                                    Tất cả
                                </a></li>
                            @foreach ($entityTypes as $type)
                                <li><a class="dropdown-item {{ request('entity_type') === $type ? 'active' : '' }}"
                                        href="{{ route('admin.comments.index', array_merge(request()->except(['entity_type', 'page']), ['entity_type' => $type, 'search' => request('search')])) }}">
                                        {{ $type }}
                                    </a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="ms-xxl-auto">
                <button id="bulk-delete-btn" class="btn btn-danger me-2" style="display: none;">
                    <span class="fas fa-trash me-2"></span>Xóa mềm
                </button>
            </div>
        </div>
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
                        <th class="align-middle text-center px-3" style="width:110px;">ID Đối tượng</th>
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
                            <td class="entityId align-middle text-center px-3">{{ $comment->entity_id }}</td>
                            <td class="content align-middle text-start px-4">{{ $comment->content }}</td>
                            <td class="status align-middle text-center px-3">
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
                                        <a class="dropdown-item" href="">Xem</a>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.comments.edit', $comment->id) }}">Sửa</a>
                                        <div class="dropdown-divider"></div>


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
                                                method="POST">
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
                                <td colspan="9" class="text-center">Không có bình luận nào.</td>
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

@endsection
