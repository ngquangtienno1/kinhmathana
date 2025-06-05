@extends('admin.layouts')

@section('title', 'Chi tiết đánh giá')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.reviews.index') }}">Đánh giá</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết đánh giá</li>
@endsection

@section('content')
<div class="mb-9">
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Chi tiết đánh giá</h2>
        </div>
        <div class="col-auto ms-auto">
            <div class="d-flex gap-2">
                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-phoenix-danger"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')">
                        <span class="fas fa-trash me-2"></span>Xóa
                    </button>
                </form>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-phoenix-secondary">
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
                        <h4 class="mb-3">Thông tin sản phẩm</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px;">Sản phẩm</th>
                                        <td>
                                            <a href="{{ route('admin.products.show', $review->product_id) }}" class="text-decoration-none">
                                                {{ $review->product->name }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Đánh giá</th>
                                        <td>
                                            <div class="text-warning d-flex align-items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="fas fa-star me-1"></i>
                                                    @else
                                                        <i class="far fa-star me-1"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nội dung đánh giá</th>
                                        <td>{!! nl2br(e($review->content)) !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-4">
                        <h4 class="mb-3">Thông tin người đánh giá</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px;">Tên người dùng</th>
                                        <td>{{ $review->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $review->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Số điện thoại</th>
                                        <td>{{ $review->user->phone }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-4">
                        <h4 class="mb-3">Thông tin đơn hàng</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px;">Mã đơn hàng</th>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $review->order_id) }}" class="text-decoration-none">
                                                #{{ $review->order->order_number }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái đơn hàng</th>
                                        <td>
                                            <span class="badge badge-phoenix fs-10 badge-phoenix-success">
                                                {{ $review->order->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ngày đặt hàng</th>
                                        <td>{{ $review->order->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày đánh giá</th>
                                        <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Admin Reply Section --}}
                <div class="col-12">
                    <div class="mb-4">
                        <h4 class="mb-3">Trả lời đánh giá</h4>

                        @if($review->reply)
                            <div class="alert alert-secondary" role="alert">
                                <strong>Admin đã trả lời:</strong>
                                <p>{!! nl2br(e($review->reply)) !!}</p>
                            </div>
                        @endif

                        <form action="{{ route('admin.reviews.reply', $review->id) }}" method="POST">
                            @csrf
                            @method('PUT') {{-- Or PATCH --}}
                            <div class="mb-3">
                                <label for="adminReply" class="form-label">Nội dung trả lời:</label>
                                <textarea class="form-control" id="adminReply" name="reply" rows="3">{{ old('reply', $review->reply) }}</textarea>
                                @error('reply')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi trả lời</button>
                        </form>
                    </div>
                </div>
                {{-- End Admin Reply Section --}}

            </div>
        </div>
    </div>
</div>
@endsection 