@extends('client.layouts.app')
@section('title', 'Đơn hàng của tôi')
@section('content')
    <div
        class="qodef-page-title qodef-m qodef-title--breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
        <div class="qodef-m-inner">
            <div class="qodef-m-content qodef-content-grid">
                <h1 class="qodef-m-title entry-title">Chi tiết đơn hàng</h1>
                <div itemprop="breadcrumb" class="qodef-breadcrumbs">
                    <a itemprop="url" class="qodef-breadcrumbs-link" href="/">
                        <span itemprop="title">Trang chủ</span>
                    </a>
                    <span class="qodef-breadcrumbs-separator"></span>
                    <span itemprop="title" class="qodef-breadcrumbs-current">Chi tiết đơn hàng</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-4" style="max-width: 1000px; margin: 0 auto;">
        {{-- Thanh trạng thái đơn hàng giống admin --}}
        @php
            $steps = [
                ['label' => 'Chờ xác nhận', 'key' => 'pending', 'icon' => 'fa-file-alt'],
                ['label' => 'Đã xác nhận', 'key' => 'confirmed', 'icon' => 'fa-money-check-alt'],
                ['label' => 'Đang chuẩn bị', 'key' => 'awaiting_pickup', 'icon' => 'fa-truck-loading'],
                ['label' => 'Đang giao', 'key' => 'shipping', 'icon' => 'fa-shipping-fast'],
                ['label' => 'Đã giao hàng', 'key' => 'delivered', 'icon' => 'fa-box-open'],
                ['label' => 'Hoàn thành', 'key' => 'completed', 'icon' => 'fa-star'],
            ];
            $currentOrderStatus = $order->status;
            $currentIndex = collect($steps)->search(fn($step) => $step['key'] === $currentOrderStatus);
            if ($currentIndex === false) {
                $currentIndex = 0;
            }
        @endphp
        <div class="order-progress-bar mb-4">
            <div class="order-progress-steps d-flex align-items-center">
                @foreach ($steps as $i => $step)
                    <div class="order-step text-center flex-fill {{ $i <= $currentIndex ? 'completed' : '' }}">
                        <div class="order-step-circle mx-auto mb-1">
                            @if ($i < $currentIndex || ($i == $currentIndex && $step['key'] === 'completed'))
                                <span class="fa fa-check"></span>
                            @else
                                <span class="fa {{ $step['icon'] }}"></span>
                            @endif
                        </div>
                        <div class="order-step-label">{{ $step['label'] }}</div>
                    </div>
                    @if ($i < count($steps) - 1)
                        <div
                            class="order-step-line flex-grow-1
                            {{ $i < $currentIndex ? 'completed' : '' }}
                            {{ $i === $currentIndex && $currentIndex < count($steps) - 1 ? 'animated' : '' }}
                        ">
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <style>
            .order-progress-bar {
                margin-bottom: 32px;
            }

            .order-progress-steps {
                display: flex;
                align-items: center;
            }

            .order-step {
                text-align: center;
                flex: 1;
            }

            .order-step-circle {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background: #eee;
                margin: 0 auto;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 18px;
                color: #bbb;
            }

            .order-step.completed .order-step-circle {
                background: #0d6efd;
                color: #fff;
            }

            .order-step-label {
                font-size: 14px;
                margin-top: 4px;
                color: #888;
            }

            .order-step.completed .order-step-label {
                color: #0d6efd;
                font-weight: bold;
            }

            .order-step-line {
                height: 4px;
                background: #eee;
                flex: 1;
                margin: 0 2px;
                border-radius: 2px;
                position: relative;
                overflow: hidden;
            }

            .order-step-line.completed {
                background: #0d6efd;
            }

            .order-step-line.animated {
                background: #0d6efd;
            }

            .order-step-line.animated::after {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                bottom: 0;
                width: 100%;
                background: linear-gradient(90deg, #0d6efd 0%, #fff 50%, #0d6efd 100%);
                background-size: 200% 100%;
                animation: progress-bar-stripes 1.2s linear infinite;
                opacity: 0.5;
            }

            @keyframes progress-bar-stripes {
                0% {
                    background-position: 200% 0;
                }

                100% {
                    background-position: -200% 0;
                }
            }

            .order-progress-note {
                font-size: 14px;
                color: #666;
                text-align: center;
            }
        </style>

        {{-- Header: Mã đơn hàng, trạng thái, nút thao tác --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="mb-1">Mã Đơn Hàng: <strong>#{{ $order->order_number ?? $order->id }}</strong></h5>
                <small class="text-muted">Ngày tạo:
                    {{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '' }}</small>
            </div>
            <span class="status-label status-{{ $order->status }} text-capitalize">
                {{ $order->status_label }}
            </span>
        </div>

        @php
            $statusLabels = [
                'pending' => 'Chờ xác nhận',
                'confirmed' => 'Đã xác nhận',
                'awaiting_pickup' => 'Đang chuẩn bị',
                'shipping' => 'Đang giao',
                'delivered' => 'Đã giao hàng',
                'completed' => 'Hoàn thành',
                'cancelled_by_customer' => 'Khách hủy đơn',
                'cancelled_by_admin' => 'Admin hủy đơn',
                'delivery_failed' => 'Giao thất bại',
            ];
        @endphp
        <div class="card mb-4">
            <div class="card-body row">
                <!-- Địa chỉ nhận hàng -->
                <div class="col-md-6 mb-3 mb-md-0">
                    <h6 class="fw-bold mb-2">Địa chỉ nhận hàng</h6>
                    <div><b>Họ và tên:</b> {{ $order->receiver_name }}</div>
                    <div><b>Số điện thoại:</b> {{ $order->receiver_phone }}</div>
                    <div><b>Địa chỉ giao hàng:</b> {{ $order->shipping_address }}</div>
                </div>
                <!-- Lịch sử trạng thái dạng timeline -->
                <div class="col-md-6">
                    <h6 class="fw-bold mb-2">Lịch sử trạng thái</h6>
                    <ul class="order-timeline list-unstyled mb-0">
                        @foreach ($order->statusHistories->sortByDesc('created_at') as $i => $history)
                            <li class="d-flex align-items-start mb-3">
                                <span class="timeline-dot {{ $i == 0 ? 'active' : '' }}">
                                    <i class="fa fa-check-circle"></i>
                                </span>
                                <div class="ms-2">
                                    <div class="fw-bold {{ $i == 0 ? 'text-success' : 'text-muted' }}">
                                        {{ $statusLabels[$history->new_status] ?? $history->new_status }}
                                    </div>
                                    <div class="small text-muted">{{ $history->created_at->format('H:i d/m/Y') }}</div>
                                    @if ($history->note)
                                        <div class="small text-muted">{{ $history->note }}</div>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <style>
            .order-timeline {
                border-left: 2px solid #eee;
                margin-left: 10px;
                padding-left: 15px;
            }

            .order-timeline .timeline-dot {
                width: 18px;
                height: 18px;
                border-radius: 50%;
                background: #eee;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #bbb;
                margin-right: 6px;
                margin-top: 2px;
                font-size: 16px;
            }

            .order-timeline .timeline-dot.active {
                background: #4caf50;
                color: #fff;
            }
        </style>

        {{-- Sản phẩm trong đơn hàng --}}
        <div class="card mb-4">
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">Ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                            @if ($order->status == 'completed')
                                <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>
                                    @php
                                        $product = $item->variation
                                            ? $item->variation->product
                                            : $item->product ?? null;
                                        if ($item->variation && $item->variation->images->count()) {
                                            $featuredImage =
                                                $item->variation->images->where('is_featured', true)->first() ??
                                                $item->variation->images->first();
                                        } else {
                                            $featuredImage =
                                                $product && isset($product->images)
                                                    ? $product->images->where('is_featured', true)->first() ??
                                                        $product->images->first()
                                                    : null;
                                        }
                                        $imagePath = $featuredImage
                                            ? asset('storage/' . $featuredImage->image_path)
                                            : asset('/assets/img/products/1.png');
                                    @endphp
                                    <img src="{{ $imagePath }}" alt=""
                                        style="width:60px; height:60px; object-fit:cover; border-radius:4px;">
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $item->product_name }}</div>
                                    @php
                                        $options = $item->product_options
                                            ? json_decode($item->product_options, true)
                                            : [];
                                        $optionTexts = [];
                                        if (!empty($options)) {
                                            if (array_key_exists('color', $options)) {
                                                $optionTexts[] = trim($options['color']);
                                            }
                                            if (array_key_exists('size', $options)) {
                                                $optionTexts[] = trim($options['size']);
                                            }
                                            if (array_key_exists('spherical', $options)) {
                                                $optionTexts[] = trim($options['spherical']);
                                            }
                                            if (array_key_exists('cylindrical', $options)) {
                                                $optionTexts[] = trim($options['cylindrical']);
                                            }
                                        }
                                        // Loại bỏ giá trị rỗng/null
                                        $optionTexts = array_filter($optionTexts, function ($v) {
                                            return $v !== null && $v !== '' && $v !== '-';
                                        });
                                        $variantText = !empty($optionTexts)
                                            ? implode(' - ', $optionTexts)
                                            : $item->variation_name ?? '';
                                    @endphp
                                    @if (!empty($optionTexts))
                                        <div class="text-muted small">Phân loại:
                                            {{ str_replace(' - ', ' | ', implode(' - ', $optionTexts)) }}</div>
                                    @elseif ($item->variation_name)
                                        <div class="text-muted small">Phân loại: {{ $item->variation_name }}</div>
                                    @endif
                                </td>
                                <td>{{ number_format($item->price, 0, ',', '.') }}₫</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-danger fw-bold">
                                    {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫</td>
                                @if ($order->status == 'completed')
                                    <td>
                                        @php
                                            $reviewed = \App\Models\Review::where('user_id', auth()->id())
                                                ->where('product_id', $item->product_id)
                                                ->where('order_id', $order->id)
                                                ->exists();
                                        @endphp
                                        @if (!$reviewed)
                                            <button type="button" class="btn btn-sm btn-outline-primary btn-review"
                                                data-item-id="{{ $item->id }}"
                                                data-product-name="{{ $item->product_name }}"
                                                data-product-img="{{ $item->product->images->first() ? asset('storage/' . $item->product->images->first()->image_path) : '/assets/img/products/1.png' }}"
                                                data-product-options='@json($item->product_options)'
                                                data-product-variant="{{ $variantText }}"
                                                data-order-id="{{ $order->id }}"
                                                data-review-url="{{ route('client.orders.review.submit', [$order->id, $item->id]) }}">Đánh
                                                giá</button>
                                        @else
                                            <span class="text-success">Đã đánh giá</span>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tổng kết đơn hàng --}}
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <span>Tạm tính:</span>
                    <span>{{ number_format($order->subtotal, 0, ',', '.') }}₫</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Phí vận chuyển:</span>
                    <span>{{ number_format($order->shipping_fee, 0, ',', '.') }}₫</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Khuyến mại:</span>
                    <span class="text-danger">-{{ number_format($order->promotion_amount, 0, ',', '.') }}₫</span>
                </div>
                <div class="d-flex justify-content-between border-top pt-2 mt-2 fw-bold fs-5">
                    <span>Thành tiền:</span>
                    <span class="text-danger">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
                </div>
                @if (
                    $order->status !== 'cancelled_by_customer' &&
                        $order->status !== 'cancelled_by_admin' &&
                        $order->status !== 'completed')
                    <div class="alert alert-warning mt-3" role="alert">
                        Vui lòng thanh toán <span
                            class="text-danger fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span> khi
                        nhận hàng.
                    </div>
                    <div class="mt-2">
                        <b>Phương thức thanh toán:</b>
                        <span>
                            {{ $order->paymentMethod->name ?? 'Không xác định' }}
                        </span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Nút thao tác --}}
        <div class="d-flex gap-2 justify-content-end mb-4">
            @if ($order->status == 'delivered')
                <form action="{{ route('client.orders.confirm-received', $order->id) }}" method="POST"
                    onsubmit="return confirm('Bạn xác nhận đã nhận hàng?')" style="display:inline;">
                    @csrf @method('PATCH')
                    <button class="btn btn-success">Đã Nhận Hàng</button>
                </form>
            @endif

            {{-- Ẩn nút Đánh giá tổng đơn hàng ở dưới cùng --}}
            {{--
            @if ($order->status == 'completed')
                <a href="{{ route('client.orders.review', $order->id) }}" class="btn btn-outline-primary">Đánh giá</a>
            @else
                <a href="{{ route('client.orders.review', $order->id) }}" class="btn btn-outline-primary">Yêu Cầu Trả Hàng/Hoàn Tiền</a>
            @endif
            --}}

            <a href="#" class="btn btn-outline-secondary">Liên Hệ Người Bán</a>
        </div>
        <div class="d-flex justify-content-end">
            <a href="{{ route('client.orders.index') }}" class="btn btn-outline-dark">
                ← Quay lại danh sách
            </a>
        </div>
    </div>
    <!-- Modal Đánh Giá Sản Phẩm -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="review-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewModalLabel">Đánh giá sản phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 d-flex align-items-start gap-3">
                            <img id="modal-product-img" src="" alt=""
                                style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd;">
                            <div class="flex-grow-1">
                                <div class="fw-bold" id="modal-product-name"></div>
                                <div class="text-muted small mt-1" id="modal-product-options"></div>
                            </div>
                        </div>
                        <div class="border p-3 rounded-0" style="background: #fff;">
                            <h6 class="fw-semibold mb-3">Đánh giá sản phẩm</h6>
                            <div class="mb-3">
                                <label class="form-label">Chất lượng sản phẩm</label>
                                <div id="star-rating" class="mb-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="star fs-3" data-value="{{ $i }}">&#9733;</span>
                                    @endfor
                                    <input type="hidden" name="rating" id="rating" value="5">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Nội dung đánh giá</label>
                                <textarea name="content" id="content" class="form-control rounded-0" rows="4" maxlength="1000"
                                    oninput="updateCharCount()" required></textarea>
                                <div class="text-end small text-muted mt-1"><span id="char-count">0</span>/1000 ký tự
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="images" class="form-label">Thêm hình ảnh (tối đa 5 ảnh)</label>
                                <input type="file" name="images[]" id="images" class="form-control rounded-0"
                                    multiple accept="image/*" onchange="previewImages()">
                                <div class="d-flex flex-wrap mt-2 gap-2" id="image-preview"></div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-dark">Gửi đánh giá</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Chọn Lý Do Huỷ Đơn Hàng (Đồng bộ giao diện) -->
    <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="font-family: inherit; color: #222; border-radius: 10px;">
                <form id="cancel-order-form" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="cancelOrderModalLabel" style="font-family: inherit;">CHỌN LÝ
                            DO HUỶ ĐƠN HÀNG</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="cancellation_reason_id" class="form-label fw-semibold" style="color: #222;">Lý do
                                huỷ <span class="text-danger">*</span></label>
                            <select class="form-select" name="cancellation_reason_id" id="cancellation_reason_id"
                                required style="font-family: inherit; color: #222; border-radius: 6px;">
                                <option value="">-- Chọn lý do huỷ --</option>
                                <!-- Lý do sẽ được render động bằng JS hoặc blade -->
                                <option value="other">-- Khác (Nhập lý do mới) --</option>
                            </select>
                        </div>
                        <div class="mb-3" id="other-reason-group" style="display:none;">
                            <label for="other_reason" class="form-label">Lý do khác</label>
                            <input type="text" class="form-control" name="other_reason" id="other_reason"
                                maxlength="255" style="font-family: inherit; border-radius: 6px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            style="border-radius: 6px;">Đóng</button>
                        <button type="submit" class="btn btn-dark" style="border-radius: 6px;">Xác nhận huỷ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Thêm Bootstrap JS nếu chưa có -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* ===== STYLE CHO HỆ THỐNG ĐÁNH GIÁ SAO ===== */
        .star {
            color: #ccc;                    /* Màu sao mặc định (xám) */
            cursor: pointer;                /* Con trỏ chuột pointer khi hover */
            transition: color 0.2s;         /* Hiệu ứng chuyển màu mượt mà */
        }

        /* ===== STYLE CHO SAO ĐƯỢC CHỌN VÀ HOVER ===== */
        .star.selected,                     /* Sao đã được chọn */
        .star:hover,                        /* Hover vào sao */
        .star:hover~.star {                 /* Các sao phía sau khi hover (hiệu ứng fill) */
            color: #f39c12;                 /* Màu vàng cam */
        }

        /* ===== STYLE CHO PREVIEW HÌNH ẢNH ===== */
        #image-preview img {
            width: 60px;                    /* Chiều rộng ảnh preview */
            height: 60px;                   /* Chiều cao ảnh preview */
            object-fit: cover;              /* Cắt ảnh vừa khít container */
            border: 1px solid #ccc;         /* Viền xám */
        }

        /* ===== STYLE CHO CONTAINER SAO ===== */
        #star-rating {
            font-size: 0;                   /* Ẩn khoảng trắng giữa các sao */
        }

        #star-rating .star {
            font-size: 2rem;                /* Kích thước sao lớn */
        }
        .status-label {
        font-weight: 700;
        font-size: 15px;
        border-radius: 4px;
        padding: 4px 16px;
        display: inline-block;
        border: 1px solid transparent;
        margin-bottom: 2px;
    }
        .status-label.status-completed,
    .status-label.status-confirmed,
    .status-label.status-pending,
    .status-label.status-awaiting_pickup,
    .status-label.status-shipping,
    .status-label.status-delivered {
        background: #e6f9ed;
        color: #219150;
        border: 1px solid #219150;
        box-shadow: 0 1px 4px rgba(33, 145, 80, 0.08);
    }

    .status-label.status-cancelled_by_customer,
    .status-label.status-cancelled_by_admin,
    .status-label.status-delivery_failed {
        background: #ffeaea;
        color: #e53935;
        border: 1px solid #e53935;
        box-shadow: 0 1px 4px rgba(229, 57, 53, 0.08);
    }
    </style>
    <script>
        // ===== XỬ LÝ MODAL ĐÁNH GIÁ SẢN PHẨM =====
        document.addEventListener('DOMContentLoaded', function() {

            // ===== XỬ LÝ SỰ KIỆN CLICK NÚT "ĐÁNH GIÁ" =====
            document.querySelectorAll('.btn-review').forEach(function(btn) {
                btn.addEventListener('click', function() {

                    // ===== LẤY DỮ LIỆU TỪ DATA ATTRIBUTES CỦA BUTTON =====
                    let itemId = this.getAttribute('data-item-id');           // ID của item trong đơn hàng
                    let productName = this.getAttribute('data-product-name'); // Tên sản phẩm
                    let productImg = this.getAttribute('data-product-img');   // URL ảnh sản phẩm
                    let productOptions = this.getAttribute('data-product-options'); // JSON options (màu, size...)
                    let productVariant = this.getAttribute('data-product-variant'); // Text phân loại
                    let orderId = this.getAttribute('data-order-id');         // ID đơn hàng

                    // ===== XỬ LÝ THÔNG TIN PHÂN LOẠI SẢN PHẨM =====
                    let opts = productOptions ? JSON.parse(productOptions) : {}; // Parse JSON options
                    let optionsText = productVariant ? ('Phân loại: ' + productVariant.replace(
                        / - /g, ' | ')) : ''; // Format text phân loại (thay - bằng |)

                    // ===== CẬP NHẬT THÔNG TIN SẢN PHẨM TRONG MODAL =====
                    document.getElementById('modal-product-name').innerText = productName;     // Hiển thị tên SP
                    document.getElementById('modal-product-img').src = productImg;             // Hiển thị ảnh SP
                    document.getElementById('modal-product-options').innerText = optionsText;  // Hiển thị phân loại

                    // ===== THIẾT LẬP FORM ACTION =====
                    document.getElementById('review-form').action = btn.getAttribute('data-review-url'); // Set URL submit

                    // ===== KHỞI TẠO ĐÁNH GIÁ SAO MẶC ĐỊNH (5 SAO) =====
                    document.getElementById('rating').value = 5; // Set giá trị ẩn
                    document.querySelectorAll('#star-rating .star').forEach(function(s, idx) {
                        s.classList.toggle('selected', idx < 5); // Highlight 5 sao đầu tiên
                    });

                    // ===== RESET FORM VỀ TRẠNG THÁI BAN ĐẦU =====
                    document.getElementById('content').value = '';           // Xóa nội dung đánh giá
                    document.getElementById('char-count').innerText = 0;     // Reset đếm ký tự
                    document.getElementById('images').value = '';            // Xóa file ảnh đã chọn
                    document.getElementById('image-preview').innerHTML = ''; // Xóa preview ảnh

                    // ===== HIỂN THỊ MODAL =====
                    var reviewModal = new bootstrap.Modal(document.getElementById('reviewModal'));
                    reviewModal.show();
                });
            });

            // ===== XỬ LÝ SỰ KIỆN CLICK VÀO SAO ĐÁNH GIÁ =====
            document.querySelectorAll('#star-rating .star').forEach(function(star) {
                star.addEventListener('click', function() {
                    let value = this.getAttribute('data-value'); // Lấy giá trị sao (1-5)
                    document.getElementById('rating').value = value; // Cập nhật giá trị ẩn

                    // ===== CẬP NHẬT HIỂN THỊ SAO =====
                    document.querySelectorAll('#star-rating .star').forEach(function(s, idx) {
                        s.classList.toggle('selected', idx < value); // Highlight sao từ 1 đến value
                    });
                });
            });
        });

        // ===== XỬ LÝ ĐẾM KÝ TỰ TRONG TEXTAREA =====
        function updateCharCount() {
            document.getElementById('char-count').innerText = document.getElementById('content').value.length; // Cập nhật số ký tự đã nhập
        }

        // ===== XỬ LÝ PREVIEW HÌNH ẢNH TRƯỚC KHI UPLOAD =====
        function previewImages() {
            let preview = document.getElementById('image-preview'); // Lấy container hiển thị preview
            preview.innerHTML = ''; // Xóa preview cũ
            let files = document.getElementById('images').files; // Lấy danh sách file đã chọn

            // ===== XỬ LÝ TỪNG FILE ẢNH (TỐI ĐA 5 ẢNH) =====
            for (let i = 0; i < files.length && i < 5; i++) {
                let reader = new FileReader(); // Tạo FileReader để đọc file
                reader.onload = function(e) {
                    let img = document.createElement('img'); // Tạo element img
                    img.src = e.target.result; // Set source từ kết quả đọc file
                    preview.appendChild(img); // Thêm vào container preview
                }
                reader.readAsDataURL(files[i]); // Đọc file dưới dạng Data URL
            }
        }


    </script>
    <script>
        // ===== XỬ LÝ MODAL HỦY ĐƠN HÀNG =====
        document.addEventListener('DOMContentLoaded', function() {
            var select = document.getElementById('cancellation_reason_id'); // Lấy select box lý do hủy
            if (select) {
                select.addEventListener('change', function() {
                    // ===== HIỂN THỊ/ẨN Ô NHẬP LÝ DO KHÁC =====
                    document.getElementById('other-reason-group').style.display = this.value === 'other' ?
                        'block' : 'none'; // Hiển thị nếu chọn "Khác", ẩn nếu chọn lý do khác
                });
            }
        });
    </script>
@endsection
