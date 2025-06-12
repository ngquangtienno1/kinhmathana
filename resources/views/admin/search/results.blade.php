@extends('admin.layouts')
@section('title', 'Kết quả tìm kiếm: ' . $query)

@section('content')
    <div class="mb-9">
        <div class="row g-3 mb-4">
            <div class="col-auto">
                <h2 class="mb-0">Kết quả tìm kiếm: "{{ $query }}"</h2>
            </div>
        </div>

        <div class="row g-3">
            @if ($products->isNotEmpty())
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-box me-2"></i>
                                Sản phẩm ({{ $products->total() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive scrollbar">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Mô tả</th>
                                            <th>SKU</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ Str::limit(strip_tags($product->description_short), 100) }}</td>
                                                <td>{{ $product->variations->pluck('sku')->implode(', ') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $products->appends(['q' => $query])->links() }}
                        </div>
                    </div>
                </div>
            @endif

            @if ($news->isNotEmpty())
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-newspaper me-2"></i>
                                Tin tức ({{ $news->total() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive scrollbar">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tiêu đề</th>
                                            <th>Nội dung</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($news as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ Str::limit(strip_tags($item->content), 100) }}</td>
                                                <td>
                                                    <a href="{{ route('admin.news.edit', $item->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $news->appends(['q' => $query])->links() }}
                        </div>
                    </div>
                </div>
            @endif

            @if ($orders->isNotEmpty())
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-shopping-cart me-2"></i>
                                Đơn hàng ({{ $orders->total() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive scrollbar">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Mã đơn</th>
                                            <th>Khách hàng</th>
                                            <th>Email</th>
                                            <th>Số điện thoại</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order->order_number }}</td>
                                                <td>{{ $order->customer_name }}</td>
                                                <td>{{ $order->customer_email }}</td>
                                                <td>{{ $order->customer_phone }}</td>
                                                <td>
                                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $orders->appends(['q' => $query])->links() }}
                        </div>
                    </div>
                </div>
            @endif

            @if ($comments->isNotEmpty())
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-comment me-2"></i>
                                Bình luận ({{ $comments->total() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive scrollbar">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nội dung</th>
                                            <th>Người bình luận</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($comments as $comment)
                                            <tr>
                                                <td>{{ $comment->id }}</td>
                                                <td>{{ Str::limit(strip_tags($comment->content), 100) }}</td>
                                                <td>{{ $comment->user ? $comment->user->name : 'Khách' }}</td>
                                                <td>
                                                    <a href="{{ route('admin.comments.index') }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $comments->appends(['q' => $query])->links() }}
                        </div>
                    </div>
                </div>
            @endif

            @if ($categories->isNotEmpty())
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-folder me-2"></i>
                                Danh mục ({{ $categories->total() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive scrollbar">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên danh mục</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td>{{ $category->id }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>
                                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $categories->appends(['q' => $query])->links() }}
                        </div>
                    </div>
                </div>
            @endif

            @if ($promotions->isNotEmpty())
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-tag me-2"></i>
                                Khuyến mãi ({{ $promotions->total() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive scrollbar">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên khuyến mãi</th>
                                            <th>Mã</th>
                                            <th>Giảm giá</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($promotions as $promotion)
                                            <tr>
                                                <td>{{ $promotion->id }}</td>
                                                <td>{{ $promotion->name }}</td>
                                                <td>{{ $promotion->code }}</td>
                                                <td>{{ $promotion->discount }}%</td>
                                                <td>
                                                    <a href="{{ route('admin.promotions.edit', $promotion->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $promotions->appends(['q' => $query])->links() }}
                        </div>
                    </div>
                </div>
            @endif

            @if (
                $products->isEmpty() &&
                    $news->isEmpty() &&
                    $orders->isEmpty() &&
                    $comments->isEmpty() &&
                    $categories->isEmpty() &&
                    $promotions->isEmpty())
                <div class="col-12">
                    <div class="alert alert-info">
                        Không tìm thấy kết quả nào cho từ khóa "{{ $query }}"
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
