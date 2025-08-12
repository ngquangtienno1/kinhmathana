@extends('admin.layouts')

@section('title', 'Trang chủ')


@section('content')
@section('breadcrumbs')
    <li class="breadcrumb-item active">Trang chủ</li>
@endsection
<div class="pb-5">
    <div class="row g-4">
        <style>
            /* Container chung cho biểu đồ */
            .chart-container {
                position: relative;
                width: 100%;
                height: 500px;
                /* Chiều cao cố định để chart không dài vô tận */
                background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
                border-radius: 12px;
                padding: 25px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
                border: 1px solid rgba(56, 116, 255, 0.1);
                margin: 10px 0;
            }

            /* Hiệu ứng hover cho chart container */
            .chart-container:hover {
                box-shadow: 0 8px 30px rgba(56, 116, 255, 0.15);
                border-color: rgba(56, 116, 255, 0.2);
                transform: translateY(-2px);
                transition: all 0.3s ease;
            }

            /* Cải thiện giao diện form lọc */
            #revenue-filter-form {
                background: #f8f9fa;
                padding: 15px;
                border-radius: 8px;
                border: 1px solid #e9ecef;
            }

            #custom-date-range {
                background: #f8f9fa;
                padding: 15px;
                border-radius: 8px;
                border: 1px solid #e9ecef;
                margin-top: 10px;
            }

            /* CSS cho date picker inline */
            #custom-date-range-inline {
                transition: all 0.3s ease;
            }

            #custom-date-range-inline input[type="date"] {
                font-size: 0.875rem;
                padding: 0.375rem 0.75rem;
                border: 1px solid #dee2e6;
                border-radius: 0.375rem;
                background-color: #fff;
            }

            #custom-date-range-inline input[type="date"]:focus {
                border-color: #3874ff;
                box-shadow: 0 0 0 0.2rem rgba(56, 116, 255, 0.25);
            }

            /* Thông tin chi tiết */
            .bg-light {
                background-color: #f8f9fa !important;
                border: 1px solid #e9ecef;
                transition: all 0.3s ease;
            }

            .bg-light:hover {
                background-color: #e9ecef !important;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            /* Responsive cho mobile */
            @media (max-width: 768px) {
                .chart-container {
                    height: 400px;
                    padding: 15px;
                }

                #revenue-filter-form {
                    flex-direction: column;
                    gap: 10px;
                }

                #custom-date-range-inline {
                    flex-direction: column;
                    gap: 8px;
                }

                #custom-date-range-inline input[type="date"] {
                    width: 100% !important;
                }
            }

            /* Tối ưu cho tablet */
            @media (min-width: 769px) and (max-width: 1024px) {
                .chart-container {
                    height: 450px;
                    padding: 20px;
                }
            }
        </style>

        <div class="col-12 col-xxl-6">
            <div class="mb-8">
                <h2 class="mb-2">Bảng điều khiển bán hàng</h2>
                <h5 class="text-body-tertiary fw-semibold">Tình hình kinh doanh của bạn hiện tại</h5>
            </div>
            <div class="row align-items-center g-4">
                <div class="col-12 col-md-auto">
                    <div class="d-flex align-items-center">
                        <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                            <span class="fa-solid fa-square fa-stack-2x dark__text-opacity-50 text-success-light"
                                data-fa-transform="down-4 rotate--10 left-4"></span>
                            <span class="fa-solid fa-circle fa-stack-2x stack-circle text-stats-circle-success"
                                data-fa-transform="up-4 right-3 grow-2"></span>
                            <span class="fa-stack-1x fa-solid fa-star text-success"
                                data-fa-transform="shrink-2 up-8 right-6"></span>
                        </span>
                        <div class="ms-3">
                            <h4 class="mb-0">{{ number_format($pendingOrders) }} đơn mới</h4>
                            <p class="text-body-secondary fs-9 mb-0">Chờ xử lý</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-auto">
                    <div class="d-flex align-items-center">
                        <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                            <span class="fa-solid fa-square fa-stack-2x dark__text-opacity-50 text-warning-light"
                                data-fa-transform="down-4 rotate--10 left-4"></span>
                            <span class="fa-solid fa-circle fa-stack-2x stack-circle text-stats-circle-warning"
                                data-fa-transform="up-4 right-3 grow-2"></span>
                            <span class="fa-stack-1x fa-solid fa-pause text-warning"
                                data-fa-transform="shrink-2 up-8 right-6"></span>
                        </span>
                        <div class="ms-3">
                            <h4 class="mb-0">{{ number_format($cancelledOrders) }} đơn</h4>
                            <p class="text-body-secondary fs-9 mb-0">Đã huỷ</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-auto">
                    <div class="d-flex align-items-center">
                        <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                            <span class="fa-solid fa-square fa-stack-2x dark__text-opacity-50 text-danger-light"
                                data-fa-transform="down-4 rotate--10 left-4"></span>
                            <span class="fa-solid fa-circle fa-stack-2x stack-circle text-stats-circle-danger"
                                data-fa-transform="up-4 right-3 grow-2"></span>
                            <span class="fa-stack-1x fa-solid fa-xmark text-danger"
                                data-fa-transform="shrink-2 up-8 right-6"></span>
                        </span>
                        <div class="ms-3">
                            <h4 class="mb-0">{{ number_format($outOfStockProducts) }} sản phẩm</h4>
                            <p class="text-body-secondary fs-9 mb-0">Hết hàng</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="bg-body-secondary mb-6 mt-4" />

            <div class="row flex-between-center mb-4 g-3">
                <div class="col-auto">
                    <h3>Tổng doanh thu</h3>
                    <p class="text-body-tertiary lh-sm mb-0">Tổng tiền đã nhận từ tất cả các kênh</p>
                </div>
                <div class="col-auto">
                    <form id="revenue-filter-form" method="GET" class="d-flex gap-2 align-items-center">
                        <select class="form-select form-select-sm" id="quick-range" name="quick_range"
                            style="min-width: 120px;">
                            <option value="today" {{ request('quick_range') == 'today' ? 'selected' : '' }}>Hôm nay
                            </option>
                            <option value="this_week" {{ request('quick_range') == 'this_week' ? 'selected' : '' }}>Tuần
                                này</option>
                            <option value="this_month" {{ request('quick_range') == 'this_month' ? 'selected' : '' }}>
                                Tháng này</option>
                            <option value="this_year" {{ request('quick_range') == 'this_year' ? 'selected' : '' }}>Năm
                                nay</option>
                            <option value="custom" {{ request('quick_range') == 'custom' ? 'selected' : '' }}>Tùy chọn
                            </option>
                        </select>

                        <!-- Date range picker - chỉ hiển thị khi chọn "Tùy chọn" -->
                        <div id="custom-date-range-inline" class="d-flex gap-2 align-items-center"
                            style="display: none !important;">
                            <input type="date" class="form-control form-control-sm" name="date_from"
                                value="{{ request('date_from') }}" id="date-from" style="width: 120px;">
                            <span class="text-body-tertiary">-</span>
                            <input type="date" class="form-control form-control-sm" name="date_to"
                                value="{{ request('date_to') }}" id="date-to" style="width: 120px;">
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
                    </form>
                </div>
            </div>

            <div class="echart-total-sales-chart">
                <!-- FIX: Bọc canvas trong container có height cố định -->
                <div class="chart-container">
                    <!-- Thông tin tổng doanh thu được di chuyển vào trong card -->
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h2 class="text-primary mb-0">{{ number_format($totalRevenue) }} đ</h2>
                            <small class="text-body-tertiary">
                                @if (request('quick_range') == 'today')
                                    Hôm nay ({{ \Carbon\Carbon::now()->format('d/m/Y') }})
                                @elseif(request('quick_range') == 'this_week')
                                    Tuần này ({{ \Carbon\Carbon::now()->startOfWeek()->format('d/m/Y') }} -
                                    {{ \Carbon\Carbon::now()->endOfWeek()->format('d/m/Y') }})
                                @elseif(request('quick_range') == 'this_month')
                                    Tháng này ({{ \Carbon\Carbon::now()->startOfMonth()->format('d/m/Y') }} -
                                    {{ \Carbon\Carbon::now()->endOfMonth()->format('d/m/Y') }})
                                @elseif(request('quick_range') == 'this_year')
                                    Năm {{ \Carbon\Carbon::now()->year }}
                                @elseif(request('quick_range') == 'custom' && request('date_from') && request('date_to'))
                                    {{ \Carbon\Carbon::parse(request('date_from'))->format('d/m/Y') }} -
                                    {{ \Carbon\Carbon::parse(request('date_to'))->format('d/m/Y') }}
                                @else
                                    Tháng này ({{ \Carbon\Carbon::now()->startOfMonth()->format('d/m/Y') }} -
                                    {{ \Carbon\Carbon::now()->endOfMonth()->format('d/m/Y') }})
                                @endif
                            </small>
                        </div>
                        <div class="d-flex align-items-center">
                            <span
                                class="badge badge-phoenix badge-phoenix-{{ $revenueGrowthType == 'positive' ? 'success' : 'danger' }} rounded-pill fs-9 me-2">
                                <span
                                    class="badge-label">{{ $revenueGrowth >= 0 ? '+' : '' }}{{ $revenueGrowth }}%</span>
                            </span>
                            <small class="text-body-tertiary">So với kỳ trước</small>
                        </div>
                    </div>

                    <canvas id="revenueComboChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-xxl-6">
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">Tổng số đơn hàng<span
                                            class="badge badge-phoenix badge-phoenix-warning rounded-pill fs-9 ms-2"><span
                                                class="badge-label">-6.8%</span></span></h5>
                                    <h6 class="text-body-tertiary">{{ $filterTimeLabel }}</h6>
                                </div>
                                <h4>{{ number_format($totalOrders) }}</h4>
                            </div>
                            <div class="d-flex justify-content-center px-4 py-6">
                                <div class="echart-total-orders" style="height:200px;width:100%"></div>
                            </div>
                            <div class="mt-2">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bullet-item bg-primary me-2"></div>
                                    <h6 class="text-body fw-semibold flex-1 mb-0">Đã hoàn thành</h6>
                                    <h6 class="text-body fw-semibold mb-0">{{ $completedOrders }} đơn</h6>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="bullet-item bg-primary-subtle me-2"></div>
                                    <h6 class="text-body fw-semibold flex-1 mb-0">Đã huỷ</h6>
                                    <h6 class="text-body fw-semibold mb-0">{{ $cancelledOrders }} đơn</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">Khách hàng mới<span
                                            class="badge badge-phoenix badge-phoenix-warning rounded-pill fs-9 ms-2">
                                            <span class="badge-label">+26.5%</span></span></h5>
                                    <h6 class="text-body-tertiary">{{ $filterTimeLabel }}</h6>
                                </div>
                                <h4>{{ number_format($newCustomers) }}</h4>
                            </div>
                            <div class="pb-0 pt-4">
                                <div class="echarts-new-customers" style="height:250px;width:100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">Thống kê sản phẩm nổi bật<span
                                            class="badge badge-phoenix badge-phoenix-success rounded-pill fs-9 ms-2">
                                            <span class="badge-label">+12.3%</span></span></h5>
                                    <h6 class="text-body-tertiary">{{ $filterTimeLabel }}</h6>
                                </div>
                                <h4 class="text-success">📈</h4>
                            </div>
                            <div class="d-flex justify-content-center px-4 py-6">
                                <div class="echart-top-products" style="height:200px;width:100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">Thống kê đánh giá & tương tác<span
                                            class="badge badge-phoenix badge-phoenix-info rounded-pill fs-9 ms-2">
                                            <span class="badge-label">+8.7%</span></span></h5>
                                    <h6 class="text-body-tertiary">{{ $filterTimeLabel }}</h6>
                                </div>
                                <h4 class="text-info">
                                    {{ $averageRating ? number_format($averageRating, 1) : '0.0' }}/5.0</h4>
                            </div>
                            <div class="d-flex justify-content-center px-4 py-6">
                                <div class="echarts-reviews-chart" style="height:200px;width:100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis pt-7 border-y">
    <div data-list='{"valueNames":["product","customer","rating","review","time"],"page":6}'>
        <div class="row align-items-end justify-content-between pb-5 g-3">
            <div class="col-auto">
                <h3>Đánh giá mới nhất</h3>
                <p class="text-body-tertiary lh-sm mb-0">Các đánh giá mới nhất từ khách hàng</p>
            </div>
        </div>
        <div class="table-responsive mx-n1 px-1 scrollbar">
            <table class="table fs-9 mb-0 border-top border-translucent">
                <thead>
                    <tr>
                        <th class="white-space-nowrap fs-9 ps-0 align-middle">
                            <div class="form-check mb-0 fs-8"><input class="form-check-input"
                                    id="checkbox-bulk-reviews-select" type="checkbox"
                                    data-bulk-select='{"body":"table-latest-review-body"}' /></div>
                        </th>
                        <th class="sort white-space-nowrap align-middle" scope="col"></th>
                        <th class="sort white-space-nowrap align-middle" scope="col" style="min-width:360px;"
                            data-sort="product">SẢN PHẨM</th>
                        <th class="sort align-middle" scope="col" data-sort="customer" style="min-width:200px;">
                            KHÁCH HÀNG</th>
                        <th class="sort align-middle" scope="col" data-sort="rating" style="min-width:110px;">
                            ĐÁNH GIÁ</th>
                        <th class="sort align-middle" scope="col" style="max-width:350px;" data-sort="review">
                            NHẬN XÉT</th>
                    </tr>
                </thead>
                <tbody class="list" id="table-latest-review-body">
                    @forelse($latestReviews as $review)
                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                            <td class="fs-9 align-middle ps-0">
                                <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox"
                                        data-bulk-select-row='{"product":"{{ $review->product->name ?? 'N/A' }}","productImage":"{{ $review->product->image ?? '' }}","customer":{"name":"{{ $review->user->name ?? 'N/A' }}","avatar":"{{ $review->user->avatar ?? '' }}"},"rating":"{{ $review->rating }}","review":"{{ $review->comment ?? 'N/A' }}","status":{"title":"Approved","badge":"success","icon":"check"},"time":"{{ $review->created_at->diffForHumans() }}"}' />
                                </div>
                            </td>
                            <td class="align-middle product white-space-nowrap py-0">
                                @php
                                    // Lấy thông tin variation từ order item
                                    $variation = null;
                                    $variationImage = null;
                                    if ($review->order && $review->order->items) {
                                        foreach ($review->order->items as $item) {
                                            if ($item->product_id == $review->product_id && $item->variation) {
                                                $variation = $item->variation;
                                                $variationImage = $variation->images->first();
                                                break;
                                            }
                                        }
                                    }

                                    // Lấy ảnh sản phẩm hoặc variation
                                    $productImage = '';
                                    if ($variationImage) {
                                        $productImage = asset('storage/' . $variationImage->image_path);
                                    } elseif (
                                        $review->product &&
                                        $review->product->images &&
                                        $review->product->images->count() > 0
                                    ) {
                                        $productImage = asset(
                                            'storage/' . $review->product->images->first()->image_path,
                                        );
                                    }
                                @endphp
                                <a class="d-block rounded-2 border border-translucent"
                                    href="{{ $review->product ? route('admin.products.show', $review->product->id) : '#' }}">
                                    <img src="{{ $productImage }}" alt="{{ $review->product->name ?? 'N/A' }}"
                                        width="53" style="object-fit: cover; height: 53px;" />
                                </a>
                            </td>
                            <td class="align-middle product white-space-nowrap">
                                <a class="fw-semibold"
                                    href="{{ $review->product ? route('admin.products.show', $review->product->id) : '#' }}">{{ $review->product->name ?? 'N/A' }}</a>
                                @if ($variation)
                                    <div class="fs-10 text-body-tertiary mt-1">
                                        @php
                                            $variantDetails = [];
                                            if ($variation->color) {
                                                $variantDetails[] = 'Màu sắc: ' . $variation->color->name;
                                            }
                                            if ($variation->size) {
                                                $variantDetails[] = 'Kích thước: ' . $variation->size->name;
                                            }
                                            if ($variation->spherical) {
                                                $variantDetails[] = 'Độ cận: ' . $variation->spherical->name;
                                            }
                                            if ($variation->cylindrical) {
                                                $variantDetails[] = 'Độ loạn: ' . $variation->cylindrical->name;
                                            }
                                        @endphp
                                        @if (!empty($variantDetails))
                                            <div class="text-muted">
                                                {{ implode(' | ', $variantDetails) }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="align-middle customer white-space-nowrap">
                                <a class="d-flex align-items-center text-body" href="#!">
                                    @if ($review->user && $review->user->avatar)
                                        <div class="avatar avatar-l">
                                            <img class="rounded-circle" src="{{ asset($review->user->avatar) }}"
                                                alt="{{ $review->user->name }}" />
                                        </div>
                                    @endif
                                    <h6
                                        class="mb-0 {{ $review->user && $review->user->avatar ? 'ms-3' : '' }} text-body">
                                        {{ $review->user->name ?? 'N/A' }}</h6>
                                </a>
                            </td>
                            <td class="align-middle rating white-space-nowrap fs-10">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->rating)
                                        <span class="fa fa-star text-warning"></span>
                                    @else
                                        <span class="fa-regular fa-star text-warning-light"
                                            data-bs-theme="light"></span>
                                    @endif
                                @endfor
                            </td>
                            <td class="align-middle review" style="min-width:350px;">
                                <p class="fs-9 fw-semibold text-body-highlight mb-0">{{ $review->content ?? 'N/A' }}
                                </p>
                                @if ($review->images && $review->images->count() > 0)
                                    <div class="mt-2">
                                        @foreach ($review->images->take(3) as $image)
                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                alt="Review image" class="rounded me-1"
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                        @endforeach
                                        @if ($review->images->count() > 3)
                                            <span class="badge badge-phoenix badge-phoenix-secondary fs-10">
                                                +{{ $review->images->count() - 3 }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <p class="text-muted mb-0">Không có đánh giá nào</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="row align-items-center py-1">
            <div class="pagination d-none"></div>
            <div class="col d-flex fs-9">
                <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                </p><a class="fw-semibold" href="#!" data-list-view="*">Xem tất cả<span
                        class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a
                    class="fw-semibold d-none" href="#!" data-list-view="less">Xem ít hơn</a>
            </div>
            <div class="col-auto d-flex">
                <button class="btn btn-link px-1 me-1" type="button" title="Previous"
                    data-list-pagination="prev"><span class="fas fa-chevron-left me-2"></span>Trước</button><button
                    class="btn btn-link px-1 ms-1" type="button" title="Next"
                    data-list-pagination="next">Sau<span class="fas fa-chevron-right ms-2"></span></button>
            </div>
        </div>
    </div>
</div>
<div class="row gx-6">
    <div class="col-12 col-xl-6">
        <div data-list='{"valueNames":["product","sold","revenue","rating"],"page":5}'>
            <div class="mb-5 mt-7">
                <h3>Sản phẩm có lượt bán cao nhất</h3>
                <p class="text-body-tertiary">Các sản phẩm được khách hàng mua nhiều nhất</p>
            </div>
            <div class="table-responsive scrollbar">
                <table class="table fs-10 mb-0">
                    <thead>
                        <tr>
                            <th class="sort border-top border-translucent ps-0 align-middle" scope="col"
                                data-sort="product" style="width:40%">SẢN PHẨM</th>
                            <th class="sort border-top border-translucent align-middle" scope="col"
                                data-sort="sold" style="width:20%">ĐÃ BÁN</th>
                            <th class="sort border-top border-translucent text-end align-middle" scope="col"
                                data-sort="revenue" style="width:25%">DOANH THU</th>
                            <th class="sort border-top border-translucent text-end pe-0 align-middle" scope="col"
                                data-sort="rating" style="width:15%">ĐÁNH GIÁ</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-top-products">
                        @forelse($topProducts as $index => $product)
                            <tr>
                                <td class="white-space-nowrap ps-0 product" style="width:40%">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('admin.products.show', $product->id) }}">
                                            <div class="d-flex align-items-center">
                                                @php
                                                    // Lấy ảnh sản phẩm hoặc ảnh đầu tiên từ variations
                                                    $productImage = '';
                                                    if ($product->images && $product->images->count() > 0) {
                                                        $productImage = asset(
                                                            'storage/' . $product->images->first()->image_path,
                                                        );
                                                    } elseif (
                                                        $product->variations &&
                                                        $product->variations->count() > 0
                                                    ) {
                                                        $firstVariation = $product->variations->first();
                                                        if (
                                                            $firstVariation->images &&
                                                            $firstVariation->images->count() > 0
                                                        ) {
                                                            $productImage = asset(
                                                                'storage/' .
                                                                    $firstVariation->images->first()->image_path,
                                                            );
                                                        }
                                                    }
                                                    if (!$productImage) {
                                                        $productImage = asset('assets/img/products/placeholder.png');
                                                    }
                                                @endphp
                                                <img src="{{ $productImage }}" alt="{{ $product->name }}"
                                                    width="50" height="50" class="rounded me-3"
                                                    style="object-fit: cover;" />
                                                <div>
                                                    <p class="mb-0 text-primary fw-bold fs-9">{{ $product->name }}</p>
                                                    @php
                                                        // Lấy thông tin biến thể đã bán nhiều nhất
                                                        $topVariations = collect();
                                                        if ($product->orderItems) {
                                                            $variationSales = $product->orderItems
                                                                ->where('variation_id', '!=', null)
                                                                ->groupBy('variation_id')
                                                                ->map(function ($items) {
                                                                    return [
                                                                        'variation' => $items->first()->variation,
                                                                        'quantity' => $items->sum('quantity'),
                                                                    ];
                                                                })
                                                                ->sortByDesc('quantity')
                                                                ->take(2);
                                                            $topVariations = $variationSales;
                                                        }
                                                    @endphp
                                                    @if ($topVariations->count() > 0)
                                                        <div class="mt-1">
                                                            @foreach ($topVariations as $topVar)
                                                                @if ($topVar['variation'])
                                                                    <div class="mb-1">
                                                                        <span
                                                                            class="badge badge-phoenix badge-phoenix-info fs-10">
                                                                            @php
                                                                                $variantDetails = [];
                                                                                if ($topVar['variation']->color) {
                                                                                    $variantDetails[] =
                                                                                        $topVar[
                                                                                            'variation'
                                                                                        ]->color->name;
                                                                                }
                                                                                if ($topVar['variation']->size) {
                                                                                    $variantDetails[] =
                                                                                        $topVar[
                                                                                            'variation'
                                                                                        ]->size->name;
                                                                                }
                                                                                if ($topVar['variation']->spherical) {
                                                                                    $variantDetails[] =
                                                                                        $topVar[
                                                                                            'variation'
                                                                                        ]->spherical->name;
                                                                                }
                                                                                if ($topVar['variation']->cylindrical) {
                                                                                    $variantDetails[] =
                                                                                        $topVar[
                                                                                            'variation'
                                                                                        ]->cylindrical->name;
                                                                                }
                                                                            @endphp
                                                                            {{ implode(' | ', $variantDetails) }}
                                                                            ({{ $topVar['quantity'] }})
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </td>
                                <td class="align-middle sold" style="width:20%">
                                    @php
                                        // Tính số lượng đã bán từ order items thực tế
                                        $totalSold = 0;
                                        if ($product->orderItems) {
                                            $totalSold = $product->orderItems->sum('quantity');
                                        }
                                    @endphp
                                    <h6 class="mb-0">{{ number_format($totalSold) }}<span
                                            class="text-body-tertiary fw-semibold ms-2">sản phẩm</span></h6>
                                </td>
                                <td class="align-middle text-end revenue" style="width:25%">
                                    @php
                                        $totalRevenue = 0;
                                        if ($product->orderItems) {
                                            $totalRevenue = $product->orderItems->sum(function ($item) {
                                                return $item->quantity * $item->price;
                                            });
                                        }
                                    @endphp
                                    <h6 class="mb-0">{{ number_format($totalRevenue) }}<span
                                            class="text-body-tertiary fw-semibold ms-2">VNĐ</span></h6>
                                </td>
                                <td class="align-middle text-end pe-0 rating" style="width:15%">
                                    <div class="d-flex align-items-center justify-content-end">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= ($product->reviews->avg('rating') ?? 0))
                                                <span class="fa fa-star text-warning fs-10"></span>
                                            @else
                                                <span class="fa-regular fa-star text-warning-light fs-10"></span>
                                            @endif
                                        @endfor
                                        <span
                                            class="ms-1 fs-10">{{ number_format($product->reviews->avg('rating') ?? 0, 1) }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <p class="text-muted mb-0">Không có dữ liệu sản phẩm bán chạy</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-6">
        <div class="mb-5 mt-7">
            <h3>Phân bố doanh thu theo danh mục</h3>
            <p class="text-body-tertiary">Tỷ lệ doanh thu từ các danh mục sản phẩm</p>
        </div>
        <div class="echart-category-revenue" style="height: 400px;"></div>
    </div>
</div>
<div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis pt-6 pb-9 border-top">
    <div class="row g-6">
        <div class="col-12 col-xl-6">
            <div class="me-xl-4">
                <div>
                    <h3>Top khách hàng mua hàng nhiều nhất</h3>
                    <p class="mb-1 text-body-tertiary">Những khách hàng có tổng giá trị đơn hàng cao nhất</p>
                </div>
                <div class="table-responsive scrollbar" style="height:300px;">
                    <table class="table fs-10 mb-0">
                        <thead>
                            <tr>
                                <th class="sort border-top border-translucent ps-0 align-middle" scope="col"
                                    style="width:40%">KHÁCH HÀNG</th>
                                <th class="sort border-top border-translucent align-middle" scope="col"
                                    style="width:30%">SỐ ĐƠN HÀNG</th>
                                <th class="sort border-top border-translucent text-end pe-0 align-middle"
                                    scope="col" style="width:30%">TỔNG CHI TIÊU</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @forelse($topCustomers as $customer)
                                <tr>
                                    <td class="white-space-nowrap ps-0" style="width:40%">
                                        <div class="d-flex align-items-center">
                                            @if ($customer->avatar)
                                                <div class="avatar avatar-l me-3">
                                                    <img class="rounded-circle" src="{{ asset($customer->avatar) }}"
                                                        alt="{{ $customer->name }}" />
                                                </div>
                                            @endif
                                            <div>
                                                <p class="mb-0 text-primary fw-bold fs-9">{{ $customer->name }}</p>
                                                <p class="mb-0 text-body-tertiary fs-10">{{ $customer->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle" style="width:30%">
                                        <h6 class="mb-0">{{ number_format($customer->total_orders) }}<span
                                                class="text-body-tertiary fw-semibold ms-2">đơn</span></h6>
                                    </td>
                                    <td class="align-middle text-end pe-0" style="width:30%">
                                        <h6 class="mb-0">{{ number_format($customer->total_spent) }}<span
                                                class="text-body-tertiary fw-semibold ms-2">VNĐ</span></h6>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">
                                        <p class="text-muted mb-0">Không có dữ liệu khách hàng</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-6">
            <div>
                <h3>Thống kê đơn hàng theo trạng thái</h3>
                <p class="mb-1 text-body-tertiary">Phân bố đơn hàng theo các trạng thái khác nhau</p>
            </div>
            <div class="echart-order-status" style="height:300px;"></div>
        </div>
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Biểu đồ thống kê đơn hàng theo trạng thái
    function initOrderStatusChart() {
        var orderStatusContainer = document.querySelector('.echart-order-status');

        if (orderStatusContainer && typeof Chart !== 'undefined') {
            // Xóa nội dung cũ
            orderStatusContainer.innerHTML = '';

            // Tạo canvas element
            var canvas = document.createElement('canvas');
            canvas.style.width = '100%';
            canvas.style.height = '100%';
            orderStatusContainer.appendChild(canvas);

            var orderStatusCanvas = orderStatusContainer.querySelector('canvas');

            // Destroy chart cũ nếu có
            if (window.orderStatusChart) {
                window.orderStatusChart.destroy();
            }

            // Dữ liệu cho biểu đồ
            var orderStatusData = {
                labels: {!! json_encode($orderStatusLabelsArray) !!},
                datasets: [{
                    label: 'Số lượng đơn hàng',
                    data: {!! json_encode($orderStatusValues) !!},
                    backgroundColor: {!! json_encode($orderStatusColors) !!},
                    borderColor: {!! json_encode($orderStatusColors) !!},
                    borderWidth: 1,
                    borderRadius: 4,
                    maxBarThickness: 30
                }]
            };

            window.orderStatusChart = new Chart(orderStatusCanvas, {
                type: 'bar',
                data: orderStatusData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(18, 38, 63, 0.95)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#3874ff',
                            borderWidth: 2,
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.x + ' đơn hàng';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            },
                            ticks: {
                                color: '#666',
                                fontSize: 10,
                                font: {
                                    weight: '500'
                                }
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#666',
                                fontSize: 10,
                                font: {
                                    weight: '500'
                                }
                            }
                        }
                    }
                }
            });
        }
    }

    // Chạy ngay lập tức và đợi DOM ready
    function initCharts() {
        // Biểu đồ Tổng số đơn hàng (bar chart)
        var orderChartContainer = document.querySelector('.echart-total-orders');

        if (orderChartContainer && typeof Chart !== 'undefined') {
            // Xóa nội dung cũ
            orderChartContainer.innerHTML = '';

            // Tạo canvas element
            var canvas = document.createElement('canvas');
            canvas.style.width = '100%';
            canvas.style.height = '100%';
            orderChartContainer.appendChild(canvas);

            var orderCanvas = orderChartContainer.querySelector('canvas');

            // Destroy chart cũ nếu có
            if (window.orderChart) {
                window.orderChart.destroy();
            }

            window.orderChart = new Chart(orderCanvas, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($orderLabels) !!},
                    datasets: [{
                        label: 'Đã hoàn thành',
                        data: {!! json_encode($completedOrderData) !!},
                        backgroundColor: '#3874FF',
                        borderColor: '#3874FF',
                        borderWidth: 1,
                        borderRadius: 4,
                        maxBarThickness: 20
                    }, {
                        label: 'Đã hủy',
                        data: {!! json_encode($cancelledOrderData) !!},
                        backgroundColor: '#E0E8FF',
                        borderColor: '#E0E8FF',
                        borderWidth: 1,
                        borderRadius: 4,
                        maxBarThickness: 20
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 15,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#12263f',
                            bodyColor: '#12263f',
                            borderColor: '#e9ecef',
                            borderWidth: 1,
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' đơn';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            },
                            ticks: {
                                color: '#888',
                                fontSize: 10
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#888',
                                fontSize: 10,
                                maxTicksLimit: 7
                            }
                        }
                    }
                }
            });

        } else {
            console.error('Cannot initialize order chart - Container or Chart.js not available');
        }

        // Biểu đồ Khách hàng mới (line chart)
        var customerChartContainer = document.querySelector('.echarts-new-customers');

        if (customerChartContainer && typeof Chart !== 'undefined') {
            // Xóa nội dung cũ
            customerChartContainer.innerHTML = '';

            // Tạo canvas element
            var canvas = document.createElement('canvas');
            canvas.style.width = '100%';
            canvas.style.height = '100%';
            customerChartContainer.appendChild(canvas);

            var customerCanvas = customerChartContainer.querySelector('canvas');

            // Destroy chart cũ nếu có
            if (window.customerChart) {
                window.customerChart.destroy();
            }

            window.customerChart = new Chart(customerCanvas, {
                type: 'line',
                data: {
                    labels: {!! json_encode($customerLabels) !!},
                    datasets: [{
                        label: 'Khách hàng mới',
                        data: {!! json_encode($customerData) !!},
                        borderColor: '#3874ff',
                        backgroundColor: 'rgba(56, 116, 255, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 4,
                        pointBackgroundColor: '#3874ff',
                        pointBorderColor: '#fff',
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#12263f',
                            bodyColor: '#12263f',
                            borderColor: '#e9ecef',
                            borderWidth: 1,
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' khách';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            },
                            ticks: {
                                color: '#888',
                                fontSize: 10
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#888',
                                fontSize: 10,
                                maxTicksLimit: 7
                            }
                        }
                    }
                }
            });

        }
    }

    // Xử lý form lọc doanh thu
    function initRevenueFilter() {
        const quickRange = document.getElementById('quick-range');
        const customDateRange = document.getElementById('custom-date-range-inline');
        const dateFrom = document.getElementById('date-from');
        const dateTo = document.getElementById('date-to');

        if (!quickRange || !customDateRange || !dateFrom || !dateTo) {
            return;
        }

        // Ẩn date picker mặc định
        customDateRange.style.setProperty('display', 'none', 'important');

        // Xử lý khi thay đổi dropdown
        quickRange.addEventListener('change', function() {
            if (this.value === 'custom') {
                customDateRange.style.setProperty('display', 'flex', 'important');
                // Tự động điền ngày hiện tại nếu chưa có
                if (!dateFrom.value) {
                    dateFrom.value = new Date().toISOString().split('T')[0];
                }
                if (!dateTo.value) {
                    dateTo.value = new Date().toISOString().split('T')[0];
                }
                dateFrom.focus();
            } else {
                customDateRange.style.setProperty('display', 'none', 'important');
            }
        });

        // Kiểm tra khi page load - nếu đã chọn custom thì hiển thị date picker
        if (quickRange.value === 'custom') {
            customDateRange.style.setProperty('display', 'flex', 'important');
            // Tự động điền ngày hiện tại nếu chưa có
            if (!dateFrom.value) {
                dateFrom.value = new Date().toISOString().split('T')[0];
            }
            if (!dateTo.value) {
                dateTo.value = new Date().toISOString().split('T')[0];
            }
        }
    }

    // Khởi tạo biểu đồ combo chart doanh thu
    function initRevenueComboChart() {
        const revenueChartContainer = document.getElementById('revenueComboChart');
        if (!revenueChartContainer) {
            return;
        }

        // Destroy chart cũ nếu có
        if (window.revenueComboChart && typeof window.revenueComboChart.destroy === 'function') {
            window.revenueComboChart.destroy();
        }

        // Dữ liệu từ controller
        const comboChartData = {!! json_encode($comboChartData) !!};

        // Xử lý dữ liệu doanh thu - chuyển về triệu VNĐ
        const revenueData = (comboChartData.revenue || []).map(value => {
            return Math.round(value / 1000000 * 100) / 100; // Chuyển về triệu VNĐ, làm tròn 2 chữ số thập phân
        });
        const revenueLabels = comboChartData.labels || [];
        const orderCounts = comboChartData.orders || [];
        const pendingOrders = comboChartData.pendingOrders || [];
        const shippingOrders = comboChartData.shippingOrders || [];
        const deliveredOrders = comboChartData.deliveredOrders || [];

        // Kiểm tra dữ liệu trước khi tạo chart
        if (!revenueData.length || !revenueLabels.length) {
            return;
        }

        // Tìm giá trị lớn nhất để giới hạn trục Y
        const maxRevenue = Math.max(...revenueData);
        const maxOrders = Math.max(...orderCounts);
        const maxPending = Math.max(...pendingOrders);
        const maxShipping = Math.max(...shippingOrders);
        const maxDelivered = Math.max(...deliveredOrders);

        // Giới hạn trục Y doanh thu (tối đa 120% giá trị lớn nhất)
        const yAxisMax = Math.ceil(maxRevenue * 1.2);
        // Giới hạn trục Y số đơn hàng (tối đa 120% giá trị lớn nhất)
        const y1AxisMax = Math.ceil(Math.max(maxOrders, maxPending, maxShipping, maxDelivered) * 1.2);

        window.revenueComboChart = new Chart(revenueChartContainer, {
            type: 'bar',
            data: {
                labels: revenueLabels,
                datasets: [{
                        label: 'Đơn chờ xác nhận',
                        data: pendingOrders,
                        backgroundColor: 'rgba(255, 193, 7, 0.9)',
                        borderColor: '#ffc107',
                        borderWidth: 1,
                        borderRadius: 6,
                        barThickness: 18,
                        maxBarThickness: 22,
                        order: 4,
                        yAxisID: 'y1',
                        hoverBackgroundColor: 'rgba(255, 193, 7, 1)',
                        hoverBorderColor: '#e0a800'
                    },
                    {
                        label: 'Đơn đang giao',
                        data: shippingOrders,
                        backgroundColor: 'rgba(23, 162, 184, 0.9)',
                        borderColor: '#17a2b8',
                        borderWidth: 1,
                        borderRadius: 6,
                        barThickness: 18,
                        maxBarThickness: 22,
                        order: 3,
                        yAxisID: 'y1',
                        hoverBackgroundColor: 'rgba(23, 162, 184, 1)',
                        hoverBorderColor: '#138496'
                    },
                    {
                        label: 'Đơn đã giao',
                        data: deliveredOrders,
                        backgroundColor: 'rgba(40, 167, 69, 0.9)',
                        borderColor: '#28a745',
                        borderWidth: 1,
                        borderRadius: 6,
                        barThickness: 18,
                        maxBarThickness: 22,
                        order: 2,
                        yAxisID: 'y1',
                        hoverBackgroundColor: 'rgba(40, 167, 69, 1)',
                        hoverBorderColor: '#1e7e34'
                    },
                    {
                        label: 'Doanh thu (triệu VNĐ)',
                        data: revenueData,
                        backgroundColor: 'rgba(56, 116, 255, 0.9)',
                        borderColor: '#3874ff',
                        borderWidth: 1,
                        borderRadius: 6,
                        barThickness: 18,
                        maxBarThickness: 22,
                        order: 5,
                        yAxisID: 'y',
                        hoverBackgroundColor: 'rgba(56, 116, 255, 1)',
                        hoverBorderColor: '#2d5bb8'
                    },
                    {
                        label: 'Tổng đơn hàng',
                        data: orderCounts,
                        type: 'line',
                        borderColor: '#ff6b6b',
                        backgroundColor: 'rgba(255, 107, 107, 0.15)',
                        borderWidth: 4,
                        fill: true,
                        tension: 0.3,
                        pointRadius: 6,
                        pointBackgroundColor: '#ff6b6b',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#ff5252',
                        pointHoverBorderColor: '#fff',
                        order: 1,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                categoryPercentage: 0.8,
                barPercentage: 0.9,
                animation: {
                    duration: 1200,
                    easing: 'easeOutQuart',
                    onProgress: function(animation) {
                        if (animation.currentStep === animation.numSteps) {
                            // Thêm hiệu ứng glow sau khi animation hoàn thành
                            const canvas = revenueChartContainer;
                            const ctx = canvas.getContext('2d');
                            ctx.shadowColor = 'rgba(56, 116, 255, 0.3)';
                            ctx.shadowBlur = 10;
                        }
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                elements: {
                    point: {
                        hoverRadius: 8,
                        hitRadius: 10
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 25,
                            font: {
                                size: 13,
                                weight: '600'
                            },
                            color: '#12263f',
                            boxWidth: 20,
                            boxHeight: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(18, 38, 63, 0.95)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#3874ff',
                        borderWidth: 2,
                        padding: 18,
                        cornerRadius: 10,
                        bodySpacing: 8,
                        titleFont: {
                            size: 14,
                            weight: '600'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            title: function(tooltipItems) {
                                return '📅 ' + tooltipItems[0].label;
                            },
                            label: function(context) {
                                let label = context.dataset.label || '';
                                let value = context.parsed.y;

                                if (context.dataset.label === 'Doanh thu (triệu VNĐ)') {
                                    return '💰 ' + label + ': ' + value.toLocaleString('vi-VN') +
                                        ' triệu VNĐ';
                                } else if (context.dataset.label === 'Tổng đơn hàng') {
                                    return '📦 ' + label + ': ' + value + ' đơn';
                                } else {
                                    return '📋 ' + label + ': ' + value + ' đơn';
                                }
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: true,
                            color: 'rgba(0,0,0,0.02)',
                            drawBorder: false,
                            lineWidth: 1
                        },
                        ticks: {
                            color: '#666',
                            fontSize: 11,
                            maxTicksLimit: 12,
                            maxRotation: 45,
                            font: {
                                weight: '500'
                            }
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        beginAtZero: true,
                        max: yAxisMax,
                        title: {
                            display: true,
                            text: 'Doanh thu (triệu VNĐ)',
                            color: '#555',
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.04)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#666',
                            fontSize: 11,
                            stepSize: Math.ceil(yAxisMax / 5),
                            font: {
                                weight: '500'
                            },
                            callback: function(value) {
                                return value.toLocaleString('vi-VN') + 'M';
                            }
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        max: y1AxisMax,
                        title: {
                            display: true,
                            text: 'Số đơn hàng',
                            color: '#555',
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        },
                        grid: {
                            drawOnChartArea: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#666',
                            fontSize: 11,
                            stepSize: Math.ceil(y1AxisMax / 5),
                            font: {
                                weight: '500'
                            }
                        }
                    }
                }
            }
        });

    }

    // === BIỂU ĐỒ CHO CARD 1: THỐNG KÊ SẢN PHẨM NỔI BẬT ===
    function initTopProductsChart() {
        var topProductsContainer = document.querySelector('.echart-top-products');

        if (topProductsContainer && typeof Chart !== 'undefined') {
            // Xóa nội dung cũ
            topProductsContainer.innerHTML = '';

            // Tạo canvas element
            var canvas = document.createElement('canvas');
            canvas.style.width = '100%';
            canvas.style.height = '100%';
            topProductsContainer.appendChild(canvas);

            var topProductsCanvas = topProductsContainer.querySelector('canvas');
            // Destroy chart cũ nếu có
            if (window.topProductsChart) {
                window.topProductsChart.destroy();
            }

            // Dữ liệu thực từ controller
            var topProductsData = {
                labels: {!! json_encode($topViewedProducts->pluck('name')->toArray()) !!},
                datasets: [{
                    label: 'Lượt xem',
                    data: {!! json_encode($topViewedProducts->pluck('views')->toArray()) !!},
                    backgroundColor: [
                        'rgba(56, 116, 255, 0.9)', // Màu xanh chính của dashboard
                        'rgba(23, 162, 184, 0.9)', // Màu xanh nhạt
                        'rgba(255, 193, 7, 0.9)', // Màu vàng
                        'rgba(220, 53, 69, 0.9)', // Màu đỏ
                        'rgba(108, 117, 125, 0.9)' // Màu xám
                    ],
                    borderColor: [
                        '#3874ff', // Màu xanh chính của dashboard
                        '#17a2b8', // Màu xanh nhạt
                        '#ffc107', // Màu vàng
                        '#dc3545', // Màu đỏ
                        '#6c757d' // Màu xám
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                    maxBarThickness: 18,
                    borderSkipped: false
                }]
            };

            // Xử lý trường hợp không có dữ liệu
            if (topProductsData.labels.length === 0) {
                topProductsData.labels = ['Không có dữ liệu'];
                topProductsData.datasets[0].data = [0];
            }

            window.topProductsChart = new Chart(topProductsCanvas, {
                type: 'bar',
                data: topProductsData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(18, 38, 63, 0.95)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#3874ff',
                            borderWidth: 2,
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                title: function(tooltipItems) {
                                    return tooltipItems[0].label;
                                },
                                label: function(context) {
                                    return 'Lượt xem: ' + context.parsed.y;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.03)',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#666',
                                fontSize: 10,
                                font: {
                                    weight: '500'
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#666',
                                fontSize: 9,
                                maxTicksLimit: 5,
                                maxRotation: 45,
                                font: {
                                    weight: '500'
                                }
                            }
                        }
                    }
                }
            });

        }
    }

    // === BIỂU ĐỒ CHO CARD 2: THỐNG KÊ ĐÁNH GIÁ & TƯƠNG TÁC ===
    function initReviewsChart() {
        var reviewsContainer = document.querySelector('.echarts-reviews-chart');

        if (reviewsContainer && typeof Chart !== 'undefined') {
            // Xóa nội dung cũ
            reviewsContainer.innerHTML = '';

            // Tạo canvas element
            var canvas = document.createElement('canvas');
            canvas.style.width = '100%';
            canvas.style.height = '100%';
            reviewsContainer.appendChild(canvas);

            var reviewsCanvas = reviewsContainer.querySelector('canvas');

            // Destroy chart cũ nếu có
            if (window.reviewsChart) {
                window.reviewsChart.destroy();
            }

            // Dữ liệu mẫu cho biểu đồ (có thể thay thế bằng dữ liệu thực từ controller)
            var reviewsData = {
                labels: ['1★', '2★', '3★', '4★', '5★'],
                datasets: [{
                    label: 'Số lượng đánh giá',
                    data: [
                        {{ $ratingDistribution[1] ?? 0 }},
                        {{ $ratingDistribution[2] ?? 0 }},
                        {{ $ratingDistribution[3] ?? 0 }},
                        {{ $ratingDistribution[4] ?? 0 }},
                        {{ $ratingDistribution[5] ?? 0 }}
                    ],
                    backgroundColor: [
                        'rgba(220, 53, 69, 0.8)', // Màu đỏ
                        'rgba(255, 193, 7, 0.8)', // Màu vàng
                        'rgba(23, 162, 184, 0.8)', // Màu xanh nhạt
                        'rgba(40, 167, 69, 0.8)', // Màu xanh lá
                        'rgba(56, 116, 255, 0.8)' // Màu xanh chính của dashboard
                    ],
                    borderColor: [
                        '#dc3545', // Màu đỏ
                        '#ffc107', // Màu vàng
                        '#17a2b8', // Màu xanh nhạt
                        '#28a745', // Màu xanh lá
                        '#3874ff' // Màu xanh chính của dashboard
                    ],
                    borderWidth: 1,
                    borderRadius: 8,
                    maxBarThickness: 20
                }]
            };

            // Xử lý trường hợp không có dữ liệu
            var totalReviews = reviewsData.datasets[0].data.reduce((a, b) => a + b, 0);
            if (totalReviews === 0) {
                reviewsData.datasets[0].data = [0, 0, 0, 0, 0];
            }

            window.reviewsChart = new Chart(reviewsCanvas, {
                type: 'bar',
                data: reviewsData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(18, 38, 63, 0.95)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#3874ff',
                            borderWidth: 2,
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                title: function(tooltipItems) {
                                    return tooltipItems[0].label;
                                },
                                label: function(context) {
                                    return 'Số lượng: ' + context.parsed.y + ' đánh giá';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.03)',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#666',
                                fontSize: 10,
                                font: {
                                    weight: '500'
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#666',
                                fontSize: 10,
                                font: {
                                    weight: '500'
                                }
                            }
                        }
                    }
                }
            });

        }
    }

    // Biểu đồ phân bố doanh thu theo danh mục
    function initCategoryRevenueChart() {
        var categoryRevenueContainer = document.querySelector('.echart-category-revenue');

        if (categoryRevenueContainer && typeof Chart !== 'undefined') {
            // Xóa nội dung cũ
            categoryRevenueContainer.innerHTML = '';

            // Tạo canvas element
            var canvas = document.createElement('canvas');
            canvas.style.width = '100%';
            canvas.style.height = '100%';
            categoryRevenueContainer.appendChild(canvas);

            var categoryRevenueCanvas = categoryRevenueContainer.querySelector('canvas');

            // Destroy chart cũ nếu có
            if (window.categoryRevenueChart) {
                window.categoryRevenueChart.destroy();
            }

            // Dữ liệu cho biểu đồ
            var categoryRevenueData = {
                labels: {!! json_encode($categoryRevenueLabels) !!},
                datasets: [{
                    data: {!! json_encode($categoryRevenueValues) !!},
                    backgroundColor: {!! json_encode($categoryRevenueColors) !!},
                    borderColor: {!! json_encode($categoryRevenueColors) !!},
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            };

            window.categoryRevenueChart = new Chart(categoryRevenueCanvas, {
                type: 'doughnut',
                data: categoryRevenueData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    size: 10,
                                    weight: '500'
                                },
                                color: '#666'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(18, 38, 63, 0.95)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#3874ff',
                            borderWidth: 2,
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    var label = context.label || '';
                                    var value = parseFloat(context.parsed) || 0;
                                    var total = context.dataset.data.reduce((a, b) => parseFloat(a || 0) +
                                        parseFloat(b || 0), 0);

                                    // Đảm bảo total không phải NaN và > 0
                                    if (isNaN(total) || total <= 0) {
                                        total = 1; // Tránh chia cho 0
                                    }

                                    var percentage = ((value / total) * 100).toFixed(1);

                                    // Format số tiền
                                    var formattedValue = new Intl.NumberFormat('vi-VN').format(Math.round(
                                        value));

                                    return label + ': ' + formattedValue + ' VNĐ (' + percentage + '%)';
                                }
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
        }
    }

    // Chạy ngay khi DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initCharts, 500);
            setTimeout(initRevenueComboChart, 600);
            setTimeout(initTopProductsChart, 700);
            setTimeout(initReviewsChart, 800);
            setTimeout(initCategoryRevenueChart, 900); // Add this line
            setTimeout(initOrderStatusChart, 1000); // Add this line
            initRevenueFilter();
        });
    } else {
        setTimeout(initCharts, 500);
        setTimeout(initRevenueComboChart, 600);
        setTimeout(initTopProductsChart, 700);
        setTimeout(initReviewsChart, 800);
        setTimeout(initCategoryRevenueChart, 900); // Add this line
        setTimeout(initOrderStatusChart, 1000); // Add this line
        initRevenueFilter();
    }

    // Backup: Chạy sau khi load hoàn toàn
    window.addEventListener('load', function() {
        setTimeout(initCharts, 1000);
        setTimeout(initRevenueComboChart, 1100);
        setTimeout(initTopProductsChart, 1200);
        setTimeout(initReviewsChart, 1300);
        setTimeout(initCategoryRevenueChart, 1400); // Add this line
        setTimeout(initOrderStatusChart, 1500); // Add this line
        initRevenueFilter();
    });
</script>
