@extends('admin.layouts')

@section('title', 'Chi tiết đánh giá #' . $review->id)

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.reviews.index') }}">Đánh giá</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết đánh giá #{{ $review->id }}</li>
@endsection

@section('content')
    <div class="mb-9">
        <div class="row g-3 mb-4">
            <div class="col-auto">
                <h2 class="mb-0">Chi tiết đánh giá #{{ $review->id }}</h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="d-flex gap-2">
                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-phoenix-danger"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')">
                            <span class="fas fa-trash me-2"></span>Xóa đánh giá
                        </button>
                    </form>
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-phoenix-secondary">
                        <span class="fas fa-arrow-left me-2"></span>Quay lại
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-1">
                                <h5 class="mb-0">Thông tin người đánh giá</h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar avatar-xl me-2">
                                <div class="avatar-name rounded-circle">
                                    <span>{{ substr($review->user->name ?? 'N/A', 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h5 class="mb-0">{{ $review->user->name ?? 'N/A' }}</h5>
                                <p class="text-body-tertiary mb-0">{{ $review->user->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="mb-2">
                            <span class="text-body-tertiary">Số điện thoại:</span>
                            <span class="fw-semibold ms-2">{{ $review->user->phone ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="mb-3">Thông tin sản phẩm và đánh giá</h5>
                        <div class="mb-2">
                            <span class="text-body-tertiary">Sản phẩm:</span>
                            <span class="fw-semibold ms-2">
                                <a href="{{ route('admin.products.show', $review->product_id) }}"
                                    class="text-decoration-none">
                                    {{ $review->product->name }}
                                </a>
                            </span>
                        </div>
                        <div class="mb-2 d-flex align-items-center flex-nowrap">
                            <span class="text-body-tertiary text-nowrap">Đánh giá:</span>
                            <span class="fw-semibold ms-2 text-warning d-flex align-items-center flex-nowrap">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->rating)
                                        <i class="fas fa-star me-1"></i>
                                    @else
                                        <i class="far fa-star me-1"></i>
                                    @endif
                                @endfor
                            </span>
                        </div>
                        <div class="mb-2">
                            <span class="text-body-tertiary">Ngày đánh giá:</span>
                            <span class="fw-semibold ms-2">{{ $review->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="mb-3">Nội dung đánh giá</h5>
                <div class="p-3 bg-body-tertiary rounded">
                    <p class="mb-0">{!! nl2br(e($review->content)) !!}</p>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="mb-3">Thông tin đơn hàng</h5>
                <div class="mb-2">
                    <span class="text-body-tertiary">Mã đơn hàng:</span>
                    <span class="fw-semibold ms-2">
                        <a href="{{ route('admin.orders.show', $review->order_id) }}" class="text-decoration-none">
                            #{{ $review->order->order_number }}
                        </a>
                    </span>
                </div>
                @php
                    $orderStatusMap = [
                        'delivered' => ['Đã giao hàng thành công', 'badge-phoenix-success', 'check'],
                        'completed' => ['Đơn hàng đã hoàn tất', 'badge-phoenix-primary', 'award'],
                    ];
                    $status = $review->order->status;
                    $os = $orderStatusMap[$status] ?? null;
                @endphp
                <div class="mb-2">
                    <span class="text-body-tertiary">Trạng thái đơn hàng:</span>
                    <span class="fw-semibold ms-2">
                        @if ($os)
                            <span class="badge badge-phoenix fs-10 {{ $os[1] }}">
                                {{ $os[0] }}
                                <span class="ms-1" data-feather="{{ $os[2] }}"
                                    style="height:12.8px;width:12.8px;"></span>
                            </span>
                        @else
                            <span class="badge badge-phoenix fs-10 badge-phoenix-secondary">
                                Không cho phép đánh giá với trạng thái này
                            </span>
                        @endif
                    </span>
                </div>
                <div class="mb-2">
                    <span class="text-body-tertiary">Ngày đặt hàng:</span>
                    <span class="fw-semibold ms-2">{{ $review->order->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        {{-- Admin Reply Section --}}
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Câu trả lời</h5>
                    <button class="btn btn-phoenix-primary btn-sm" data-bs-toggle="modal" data-bs-target="#replyModal">
                        <span class="fas fa-reply me-2"></span>{{ $review->reply ? 'Sửa' : 'Trả lời' }}
                    </button>
                </div>

                @if ($review->reply)
                    <div class="border-bottom border-translucent py-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar avatar-xl me-2">
                                <div class="avatar-name rounded-circle">
                                    <span>A</span> {{-- Assuming admin for now --}}
                                </div>
                            </div>
                            <div class="flex-1">
                                <h6 class="mb-0">Admin</h6>
                                <p class="text-body-tertiary fs-9 mb-0">
                                    {{ $review->updated_at ? $review->updated_at->format('d/m/Y H:i') : 'N/A' }}</p>
                            </div>
                        </div>
                        <p class="mb-0 ps-5">{!! nl2br(e($review->reply)) !!}</p>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-body-tertiary mb-0">Chưa có câu trả lời nào.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Modal Trả lời đánh giá -->
        <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" action="{{ route('admin.reviews.reply', $review->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="replyModalLabel">Trả lời đánh giá</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="replyContent" class="form-label">Nội dung trả lời:</label>
                                <textarea class="form-control" id="replyContent" name="reply" rows="4" required>{{ old('reply', $review->reply) }}</textarea>
                                @error('reply')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-phoenix-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-phoenix-primary">Gửi trả lời</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
