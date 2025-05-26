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
            <h2 class="mb-0">Chi tiết Tin tức</h2>
        </div>
        <div class="col-auto ms-auto">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-phoenix-primary">
                    <span class="fas fa-edit me-2"></span>Sửa
                </a>
                <form action="{{ route('admin.news.destroy', $news->id) }}" method="POST" class="d-inline">
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
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12">
                    <div class="mb-4">
                        <h4 class="mb-3">Hình ảnh</h4>
                        <div>
                            @if ($news->image)
                                <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}"
                                    class="img-fluid rounded-3 border" style="max-height: 400px; width: auto;">
                            @else
                                <span class="text-muted">Không có hình ảnh</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-4">
                        <h4 class="mb-3">Thông tin cơ bản</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px;">Tiêu đề</th>
                                        <td>{{ $news->title }}</td>
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
                                        <th>Nội dung</th>
                                        <td>{!! $news->content !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái</th>
                                        <td>
                                            <span
                                                class="badge badge-phoenix fs-10 {{ $news->is_active ? 'badge-phoenix-success' : 'badge-phoenix-danger' }}">
                                                {{ $news->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ngày tạo</th>
                                        <td>{{ $news->created_at ? $news->created_at->format('d/m/Y H:i') : '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày cập nhật</th>
                                        <td>{{ $news->updated_at ? $news->updated_at->format('d/m/Y H:i') : '' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
