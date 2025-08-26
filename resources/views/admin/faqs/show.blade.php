@extends('admin.layouts')
@section('title', 'Chi tiết FAQ')
@section('content')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.faqs.index') }}">FAQ</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết FAQ</li>
@endsection

<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chi tiết FAQ</h2>
        </div>
        <div class="col-auto ms-auto">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="btn btn-phoenix-primary">
                    <span class="fas fa-edit me-2"></span>Sửas
                </a>
                <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-phoenix-danger"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa FAQ này?')">
                        <span class="fas fa-trash me-2"></span>Xóa
                    </button>
                </form>
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-phoenix-secondary">
                    <span class="fas fa-arrow-left me-2"></span>Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <h5 class="mb-0">Câu hỏi:</h5>
                        <span class="badge bg-{{ $faq->is_active ? 'success' : 'danger' }}">
                            {{ $faq->is_active ? 'Đang hoạt động' : 'Không hoạt động' }}
                        </span>
                    </div>
                    <p class="mb-0">{{ $faq->question }}</p>
                </div>

                <div class="col-12">
                    <h5 class="mb-2">Câu trả lời:</h5>
                    <div class="border rounded p-3 bg-light">
                        {!! $faq->answer !!}
                    </div>
                </div>

                <div class="col-12">
                    <h5 class="mb-2">Thông tin khác:</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 200px;">Danh mục</th>
                                    <td>{{ $faq->category }}</td>
                                </tr>

                                <tr>
                                    <th>Thứ tự sắp xếp</th>
                                    <td>{{ $faq->sort_order }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày tạo</th>
                                    <td>{{ $faq->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Cập nhật lần cuối</th>
                                    <td>{{ $faq->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($faq->images)
                    <div class="col-12">
                        <h5 class="mb-2">Hình ảnh:</h5>
                        <div class="d-flex gap-2 flex-wrap">
                            @php
                                $images = json_decode($faq->images, true);
                            @endphp
                            @if (is_array($images))
                                @foreach ($images as $image)
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $image) }}" alt="FAQ Image"
                                            class="img-thumbnail"
                                            style="max-width: 200px; height: 200px; object-fit: cover;">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
