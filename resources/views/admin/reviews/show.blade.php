@extends('admin.layouts.app')

@section('title', 'Chi tiết đánh giá')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chi tiết đánh giá</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Thông tin đánh giá</h5>
                            <table class="table">
                                <tr>
                                    <th style="width: 200px;">Sản phẩm:</th>
                                    <td>
                                        <a href="{{ route('admin.products.show', $review->product_id) }}">
                                            {{ $review->product->name }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Người đánh giá:</th>
                                    <td>{{ $review->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $review->user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Số điện thoại:</th>
                                    <td>{{ $review->user->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Đánh giá:</th>
                                    <td>
                                        <div class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Thời gian:</th>
                                    <td>{{ $review->created_at->format('H:i d/m/Y') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Thông tin đơn hàng</h5>
                            <table class="table">
                                <tr>
                                    <th style="width: 200px;">Mã đơn hàng:</th>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $review->order_id) }}">
                                            #{{ $review->order->order_number }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Trạng thái đơn hàng:</th>
                                    <td>
                                        <span class="badge badge-success">
                                            {{ $review->order->status }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ngày đặt hàng:</th>
                                    <td>{{ $review->order->created_at->format('d/m/Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Nội dung đánh giá</h5>
                            <div class="card">
                                <div class="card-body">
                                    {{ $review->content }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Xóa đánh giá
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 