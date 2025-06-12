@extends('admin.layouts')
@section('title', 'Chi tiết Tin tức')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.news.index') }}">Tin tức</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết Tin tức</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chi tiết Tin tức: {{ $news->title }}</h2>
        </div>
        <div class="col-auto ms-auto">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-phoenix-primary">
                    <span class="fas fa-edit me-2"></span>Sửa
                </a>
                <form action="{{ route('admin.news.destroy', $news) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-phoenix-danger"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa tin tức này?')">
                        <span class="fas fa-trash me-2"></span>Xóa
                    </button>
                </form>
                <a href="{{ route('admin.news.index') }}" class="btn btn-phoenix-secondary">
                    <span class="fas fa-arrow-left me-2"></span>Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="newsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="news-info-tab" data-bs-toggle="tab"
                        data-bs-target="#news-info" type="button" role="tab" aria-controls="news-info"
                        aria-selected="true">Thông tin cơ bản</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="news-comments-tab" data-bs-toggle="tab"
                        data-bs-target="#news-comments" type="button" role="tab" aria-controls="news-comments"
                        aria-selected="false">Bình luận</button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="newsTabsContent">
                <!-- Tab Thông tin cơ bản -->
                <div class="tab-pane fade show active" id="news-info" role="tabpanel" aria-labelledby="news-info-tab">
                    <div class="mt-4 mb-4">
                        <h5>Ảnh đại diện</h5>
                        @if ($news->image)
                            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}"
                                class="img-fluid rounded-3 border" style="max-height: 400px; width: auto;">
                        @else
                            <span class="text-muted">Không có hình ảnh</span>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 200px;">Tiêu đề</th>
                                    <td>{{ $news->title }}</td>
                                </tr>
                                <tr>
                                    <th>Nội dung chi tiết</th>
                                    <td>{!! $news->content !!}</td>
                                </tr>
                                <tr>
                                    <th>Đường dẫn URL</th>
                                    <td>
                                        <code>{{ $news->slug }}</code>
                                        <small class="text-muted d-block mt-1">URL:
                                            {{ url('news/' . $news->slug) }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Danh mục</th>
                                    <td>{{ $news->category ? $news->category->name : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Tác giả</th>
                                    <td>{{ $news->author ? $news->author->name : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Tóm tắt</th>
                                    <td>{{ $news->summary }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái</th>
                                    <td>
                                        <span class="badge badge-phoenix fs-10 {{ $news->is_active ? 'badge-phoenix-success' : 'badge-phoenix-danger' }}">
                                            {{ $news->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ngày xuất bản</th>
                                    <td>{{ $news->published_at ? $news->published_at->format('d/m/Y H:i') : 'Chưa xuất bản' }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày tạo</th>
                                    <td>{{ $news->created_at ? $news->created_at->format('d/m/Y H:i') : '' }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày cập nhật</th>
                                    <td>{{ $news->updated_at ? $news->updated_at->format('d/m/Y H:i') : '' }}</td>
                                </tr>
                                <tr>
                                    <th>Lượt xem</th>
                                    <td>{{ $news->views }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Tab Bình luận -->
                <div class="tab-pane fade" id="news-comments" role="tabpanel" aria-labelledby="news-comments-tab">
                    <div class="mt-3">
                        <h5 class="mb-4">Bình luận</h5>
                        @if ($comments->count() > 0)
                            <div class="comments-list">
                                @foreach ($comments as $comment)
                                    <div class="comment-item d-flex align-items-start p-3 mb-3 bg-light rounded shadow-sm">
                                        <div class="me-3">
                                            <div class="avatar rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width:48px; height:48px; font-size:1.3rem;">
                                                {{ $comment->user ? mb_substr($comment->user->name, 0, 1) : 'A' }}
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-semibold">{{ $comment->user ? $comment->user->name : 'Ẩn danh' }}</span>
                                                <span class="text-muted" style="font-size: 13px;">
                                                    {{ $comment->created_at->format('d/m/Y H:i') }}
                                                </span>
                                            </div>
                                            <div class="comment-content px-2 py-1 bg-white rounded border">
                                                {{ $comment->content }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info text-center mb-0">
                                Chưa có bình luận nào cho tin tức này.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .comments-list {
        width: 100%;
        max-width: 800px;
        margin-left: 0;
        margin-right: auto;
        padding-left: 0;
    }
    .comment-item {
        margin-left: 0;
        margin-right: 0;
        border-left: 4px solid #6a89cc;
        background: #f8fafc;
    }
    .comment-item:not(:last-child) {
        border-bottom: 1px solid #e3e3e3;
    }
    .comments-list .avatar {
        font-weight: bold;
        background: linear-gradient(135deg, #6a89cc 0%, #b8e994 100%);
        box-shadow: 0 2px 8px rgba(106,137,204,0.08);
    }
    .comment-content {
        font-size: 1rem;
        color: #333;
        word-break: break-word;
    }
</style>

@endsection
