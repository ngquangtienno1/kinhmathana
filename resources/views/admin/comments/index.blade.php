@extends('admin.layouts')
@section('title', 'Quản lý bình luận')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">Bình luận</a></li>
    <li class="breadcrumb-item active">Quản lý bình luận</li>
@endsection

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="mb-9">
    <div id="commentSummary"
        data-list='{"valueNames":["userId","userName","entityType","entityId","content","createdAt","action"],"page":10,"pagination":true}'>
        <div class="row mb-4 gx-6 gy-3 align-items-center">
            <div class="col-auto">
                <h2 class="mb-0">Quản lý bình luận</h2>
            </div>
        </div>

        <div class="row g-3 justify-content-between align-items-end mb-4">
            <div class="col-12 col-sm-auto">
                <div class="search-box me-3">
                    <form method="GET" action="{{ route('admin.comments.index') }}" class="position-relative">
                        <input value="{{ request('search') }}" class="form-control search-input search" name="search"
                            type="search" placeholder="Tìm kiếm theo nội dung, tên, email, ID đối tượng"
                            aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>
                    </form>
                </div>
            </div>


            <div class="col-12 col-sm-auto d-flex flex-wrap gap-2">
                <div>
                    <form method="GET" action="{{ route('admin.comments.index') }}">
                        <select class="form-select" name="entity_type" onchange="this.form.submit()">
                            <option value="">Tất cả loại</option>
                            <option value="news" {{ request('entity_type') == 'news' ? 'selected' : '' }}>Bài viết
                            </option>
                            <option value="product" {{ request('entity_type') == 'product' ? 'selected' : '' }}>Sản phẩm
                            </option>
                        </select>
                    </form>
                </div>


                @if (request('entity_type') == 'news' && count($news))
                    <div>
                        <form method="GET" action="{{ route('admin.comments.index') }}">
                            <select class="form-select" name="news_id" onchange="this.form.submit()">
                                <option value="">Tất cả bài viết</option>
                                @foreach ($news as $id => $title)
                                    <option value="{{ $id }}"
                                        {{ request('news_id') == $id ? 'selected' : '' }}>{{ $title }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                @endif

                @if (request('entity_type') == 'product' && count($products))
                    <div>
                        <form method="GET" action="{{ route('admin.comments.index') }}">
                            <select class="form-select" name="product_id" onchange="this.form.submit()">
                                <option value="">Tất cả sản phẩm</option>
                                @foreach ($products as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ request('product_id') == $id ? 'selected' : '' }}>{{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                @endif

                <div>
                    <form method="GET" action="{{ route('admin.comments.index') }}">
                        <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}"
                            onchange="this.form.submit()" placeholder="Từ ngày">
                    </form>
                </div>
                <div>
                    <form method="GET" action="{{ route('admin.comments.index') }}">
                        <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}"
                            onchange="this.form.submit()" placeholder="Đến ngày">
                    </form>
                </div>
            </div>
        </div>
        <div class="mb-3 d-flex gap-2">
            <a href="{{ route('admin.comments.index', array_merge(request()->all(), ['status' => null])) }}"
                class="btn btn-outline-primary {{ is_null(request('status')) ? 'active' : '' }}">
                Tất cả bình luận
            </a>
            <a href="{{ route('admin.comments.index', array_merge(request()->all(), ['status' => 'active'])) }}"
                class="btn btn-outline-success {{ request('status') === 'active' ? 'active' : '' }}">
                Bình luận đang hoạt động
            </a>
            <a href="{{ route('admin.comments.index', array_merge(request()->all(), ['status' => 'trashed'])) }}"
                class="btn btn-outline-warning {{ request('status') === 'trashed' ? 'active' : '' }}">
                Bình luận đã xóa mềm
            </a>
        </div>

        <div class="table-responsive scrollbar">
            <table class="table fs-9 mb-0 border-top border-translucent">
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 15%;">Người dùng</th>
                        <th style="width: 10%;">Loại</th>
                        <th style="width: 10%;">ID Đối tượng</th>
                        <th style="width: 30%;">Nội dung</th>
                        <th style="width: 10%;">Trạng thái</th>
                        <th style="width: 10%;">Ngày tạo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($comments as $comment)
                        <tr>
                            <td>{{ $comment->id }}</td>
                            <td>{{ $comment->user->name ?? 'N/A' }} <br>
                                <small>{{ $comment->user->email ?? '' }}</small>
                            </td>
                            <td>{{ $comment->entity_type }}</td>
                            <td>{{ $comment->entity_id }}</td>
                            <td>{{ $comment->content }}</td>
                            <td>
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
                            </td>

                            <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                            <td class="align-middle text-end white-space-nowrap pe-0 action">
                                <div class="btn-reveal-trigger position-static">
                                    <button
                                        class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" data-bs-reference="parent">
                                        <span class="fas fa-ellipsis-h fs-10"></span>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-end py-2">

                                        <a class="dropdown-item"
                                            href="{{ route('admin.comments.show', $comment->id) }}">
                                            <i class="fa-solid fa-eye me-2"></i> Xem chi tiết
                                        </a>
                                        <!-- Thay đổi trạng thái -->
                                        <li>
                                            <form action="{{ route('admin.comments.updateStatus', $comment->id) }}"
                                                method="POST" class="px-2">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" class="form-select form-select-sm"
                                                    onchange="this.form.submit()">
                                                    <option disabled selected>Chọn trạng thái</option>
                                                    <option value="đã duyệt"
                                                        {{ $comment->status === 'đã duyệt' ? 'selected' : '' }}>Đã
                                                        duyệt</option>
                                                    <option value="chờ duyệt"
                                                        {{ $comment->status === 'chờ duyệt' ? 'selected' : '' }}>Chờ
                                                        duyệt</option>
                                                    <option value="spam"
                                                        {{ $comment->status === 'spam' ? 'selected' : '' }}>Spam
                                                    </option>
                                                    <option value="chặn"
                                                        {{ $comment->status === 'chặn' ? 'selected' : '' }}>Bị chặn
                                                    </option>
                                                </select>
                                            </form>
                                        </li>
                                        <div class="dropdown-divider"></div>
                                        @if ($status === 'trashed')
                                            <form action="{{ route('admin.comments.restore', $comment->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm"
                                                    onclick="return confirm('Khôi phục bình luận này?')">Khôi
                                                    phục</button>
                                            </form>

                                            <form action="{{ route('admin.comments.forceDelete', $comment->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Xóa vĩnh viễn bình luận này?')">Xóa vĩnh
                                                    viễn</button>
                                            </form>
                                        @else
                                            <!-- Nút xóa mềm khi bình luận chưa xóa -->
                                            <form action="{{ route('admin.comments.destroy', $comment->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Xóa bình luận này?')">Xóa</button>
                                            </form>
                                        @endif

                                        @if ($comment->trashed())
                                            <button class="btn btn-sm btn-secondary" disabled>Đã xóa mềm</button>
                                        @else
                                            <form
                                                action="{{ route('admin.comments.toggleVisibility', $comment->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="is_hidden"
                                                    value="{{ $comment->is_hidden ? 0 : 1 }}">
                                                <button type="submit"
                                                    class="btn btn-sm {{ $comment->is_hidden ? 'btn-secondary' : 'btn-success' }}">
                                                    {{ $comment->is_hidden ? 'Hiện' : 'Ẩn' }}
                                                </button>
                                            </form>
                                        @endif




                                    </div>
                                </div>
                            </td>



                        </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Không có bình luận nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $comments->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

@endsection
