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

                #custom-date-range .col-md-6 {
                    margin-bottom: 10px;
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
                <div class="col-8 col-sm-4">
                    <form id="revenue-filter-form" method="GET" class="d-flex gap-2">
                        <select class="form-select form-select-sm" id="quick-range" name="quick_range">
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
                        <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
                    </form>
                </div>
            </div>

            <!-- Date range picker cho tùy chọn -->
            <div id="custom-date-range" class="row mb-3"
                style="display: {{ request('quick_range') == 'custom' ? 'block' : 'none' }};">
                <div class="col-md-6">
                    <label class="form-label">Từ ngày:</label>
                    <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}"
                        id="date-from">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Đến ngày:</label>
                    <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}"
                        id="date-to">
                </div>
            </div>

            <div class="echart-total-sales-chart">
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
                            <span class="badge-label">{{ $revenueGrowth >= 0 ? '+' : '' }}{{ $revenueGrowth }}%</span>
                        </span>
                        <small class="text-body-tertiary">So với kỳ trước</small>
                    </div>
                </div>

                <!-- FIX: Bọc canvas trong container có height cố định -->
                <div class="chart-container">
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
            <div class="col-12 col-md-auto">
                <div class="row g-2 gy-3">
                    <div class="col-auto flex-1">
                        <div class="search-box">
                            <form class="position-relative"><input
                                    class="form-control search-input search form-control-sm" type="search"
                                    placeholder="Search" aria-label="Search" />
                                <span class="fas fa-search search-box-icon"></span>
                            </form>
                        </div>
                    </div>
                    <div class="col-auto"><button
                            class="btn btn-sm btn-phoenix-secondary bg-body-emphasis bg-body-hover me-2"
                            type="button">All products</button><button
                            class="btn btn-sm btn-phoenix-secondary bg-body-emphasis bg-body-hover action-btn"
                            type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                            aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h"
                                data-fa-transform="shrink-2"></span></button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div>
                </div>
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
                        <th class="sort text-start ps-5 align-middle" scope="col" data-sort="status">TRẠNG THÁI
                        </th>
                        <th class="sort text-end align-middle" scope="col" data-sort="time">THỜI GIAN</th>
                        <th class="sort text-end pe-0 align-middle" scope="col"></th>
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
                                <a class="d-block rounded-2 border border-translucent" href="#!">
                                    <img src="{{ $review->product->image ?? '' }}"
                                        alt="{{ $review->product->name ?? 'N/A' }}" width="53" />
                                </a>
                            </td>
                            <td class="align-middle product white-space-nowrap">
                                <a class="fw-semibold" href="#!">{{ $review->product->name ?? 'N/A' }}</a>
                            </td>
                            <td class="align-middle customer white-space-nowrap">
                                <a class="d-flex align-items-center text-body" href="#!">
                                    @if ($review->user->avatar)
                                        <div class="avatar avatar-l">
                                            <img class="rounded-circle" src="{{ $review->user->avatar }}"
                                                alt="{{ $review->user->name }}" />
                                        </div>
                                    @else
                                        <div class="avatar avatar-l">
                                            <div class="avatar-name rounded-circle">
                                                <span>{{ substr($review->user->name ?? 'N', 0, 1) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    <h6 class="mb-0 ms-3 text-body">{{ $review->user->name ?? 'N/A' }}</h6>
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
                                <p class="fs-9 fw-semibold text-body-highlight mb-0">{{ $review->comment ?? 'N/A' }}
                                </p>
                            </td>
                            <td class="align-middle text-start ps-5 status">
                                <span class="badge badge-phoenix fs-10 badge-phoenix-success">
                                    <span class="badge-label">Approved</span>
                                    <span class="ms-1" data-feather="check"
                                        style="height:12.8px;width:12.8px;"></span>
                                </span>
                            </td>
                            <td class="align-middle text-end time white-space-nowrap">
                                <div class="hover-hide">
                                    <h6 class="text-body-highlight mb-0">{{ $review->created_at->diffForHumans() }}
                                    </h6>
                                </div>
                            </td>
                            <td class="align-middle white-space-nowrap text-end pe-0">
                                <div class="position-relative">
                                    <div class="hover-actions">
                                        <button class="btn btn-sm btn-phoenix-secondary me-1 fs-10">
                                            <span class="fas fa-check"></span>
                                        </button>
                                        <button class="btn btn-sm btn-phoenix-secondary fs-10">
                                            <span class="fas fa-trash"></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="btn-reveal-trigger position-static">
                                    <button
                                        class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                        type="button" data-bs-toggle="dropdown" data-boundary="window"
                                        aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                        <span class="fas fa-ellipsis-h fs-10"></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end py-2">
                                        <a class="dropdown-item" href="#!">View</a>
                                        <a class="dropdown-item" href="#!">Export</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="#!">Remove</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <p class="text-muted mb-0">Không có đánh giá nào</p>
                            </td>
                        </tr>
                    @endforelse
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                        <td class="fs-9 align-middle ps-0">
                            <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox"
                                    data-bulk-select-row='{"product":"Apple MacBook Pro 13 inch-M1-8/256GB-space","productImage":"/products/60x60/3.png","customer":{"name":"Woodrow Burton","avatar":"/team/40x40/58.webp"},"rating":4.5,"review":"It&#39;s a Mac, after all. Once you&#39;ve gone Mac, there&#39;s no going back. My first Mac lasted over nine years, and this is my second.","status":{"title":"Pending","badge":"warning","icon":"clock"},"time":"Just now"}' />
                            </div>
                        </td>
                        <td class="align-middle product white-space-nowrap py-0"><a
                                class="d-block rounded-2 border border-translucent"
                                href="apps/e-commerce/landing/product-details.html"><img src=""
                                    alt="" width="53" /></a>
                        </td>
                        <td class="align-middle product white-space-nowrap"><a class="fw-semibold"
                                href="apps/e-commerce/landing/product-details.html">Apple MacBook Pro 13
                                inch-M1-8/256GB-space</a></td>
                        <td class="align-middle customer white-space-nowrap"><a
                                class="d-flex align-items-center text-body"
                                href="apps/e-commerce/landing/profile.html">
                                <div class="avatar avatar-l"><img class="rounded-circle" src=""
                                        alt="" /></div>
                                <h6 class="mb-0 ms-3 text-body">Woodrow Burton</h6>
                            </a></td>
                        <td class="align-middle rating white-space-nowrap fs-10"><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star-half-alt star-icon text-warning"></span></td>
                        <td class="align-middle review" style="min-width:350px;">
                            <p class="fs-9 fw-semibold text-body-highlight mb-0">It's a Mac, after all. Once
                                you've gone Mac, there's no going back. My first Mac lasted over nine years,
                                and this is my second.</p>
                        </td>
                        <td class="align-middle text-start ps-5 status"><span
                                class="badge badge-phoenix fs-10 badge-phoenix-warning"><span
                                    class="badge-label">Pending</span><span class="ms-1" data-feather="clock"
                                    style="height:12.8px;width:12.8px;"></span></span>
                        </td>
                        <td class="align-middle text-end time white-space-nowrap">
                            <div class="hover-hide">
                                <h6 class="text-body-highlight mb-0">Just now</h6>
                            </div>
                        </td>
                        <td class="align-middle white-space-nowrap text-end pe-0">
                            <div class="position-relative">
                                <div class="hover-actions"><button
                                        class="btn btn-sm btn-phoenix-secondary me-1 fs-10"><span
                                            class="fas fa-check"></span></button><button
                                        class="btn btn-sm btn-phoenix-secondary fs-10"><span
                                            class="fas fa-trash"></span></button></div>
                            </div>
                            <div class="btn-reveal-trigger position-static"><button
                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                        class="fas fa-ellipsis-h fs-10"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item"
                                        href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger"
                                        href="#!">Remove</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                        <td class="fs-9 align-middle ps-0">
                            <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox"
                                    data-bulk-select-row='{"product":"Apple iMac 24\" 4K Retina Display M1 8 Core CPU, 7 Core GPU, 256GB SSD, Green (MJV83ZP/A) 2021","productImage":"/products/60x60/4.png","customer":{"name":"Eric McGee","avatar":"/team/40x40/avatar.webp","avatarPlaceholder":true},"rating":3,"review":"Personally, I like the minimalist style, but I wouldn&#39;t choose it if I were searching for a computer that I would use frequently. It&#39;s not horrible in terms of speed and power, but the","status":{"title":"Pending","badge":"warning","icon":"clock"},"time":"Nov 09, 3:23 AM"}' />
                            </div>
                        </td>
                        <td class="align-middle product white-space-nowrap py-0"><a
                                class="d-block rounded-2 border border-translucent"
                                href="apps/e-commerce/landing/product-details.html"><img src=""
                                    alt="" width="53" /></a>
                        </td>
                        <td class="align-middle product white-space-nowrap"><a class="fw-semibold"
                                href="apps/e-commerce/landing/product-details.html">Apple iMac 24&quot; 4K
                                Retina Display M1 8 Core CPU...</a></td>
                        <td class="align-middle customer white-space-nowrap"><a
                                class="d-flex align-items-center text-body"
                                href="apps/e-commerce/landing/profile.html">
                                <div class="avatar avatar-l"><img class="rounded-circle avatar-placeholder"
                                        src="" alt="" /></div>
                                <h6 class="mb-0 ms-3 text-body">Eric McGee</h6>
                            </a></td>
                        <td class="align-middle rating white-space-nowrap fs-10"><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span><span
                                class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span>
                        </td>
                        <td class="align-middle review" style="min-width:350px;">
                            <p class="fs-9 fw-semibold text-body-highlight mb-0">Personally, I like the
                                minimalist style, but I wouldn't choose it if I were searching for a
                                computer that I would use frequently. It's...<a href='#!'>See more</a></p>
                        </td>
                        <td class="align-middle text-start ps-5 status"><span
                                class="badge badge-phoenix fs-10 badge-phoenix-warning"><span
                                    class="badge-label">Pending</span><span class="ms-1" data-feather="clock"
                                    style="height:12.8px;width:12.8px;"></span></span>
                        </td>
                        <td class="align-middle text-end time white-space-nowrap">
                            <div class="hover-hide">
                                <h6 class="text-body-highlight mb-0">Nov 09, 3:23 AM</h6>
                            </div>
                        </td>
                        <td class="align-middle white-space-nowrap text-end pe-0">
                            <div class="position-relative">
                                <div class="hover-actions"><button
                                        class="btn btn-sm btn-phoenix-secondary me-1 fs-10"><span
                                            class="fas fa-check"></span></button><button
                                        class="btn btn-sm btn-phoenix-secondary fs-10"><span
                                            class="fas fa-trash"></span></button></div>
                            </div>
                            <div class="btn-reveal-trigger position-static"><button
                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                        class="fas fa-ellipsis-h fs-10"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item"
                                        href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger"
                                        href="#!">Remove</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                        <td class="fs-9 align-middle ps-0">
                            <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox"
                                    data-bulk-select-row='{"product":"Razer Kraken v3 x Wired 7.1 Surroung Sound Gaming headset","productImage":"/products/60x60/5.png","customer":{"name":"Kim Carroll","avatar":"/team/40x40/avatar.webp","avatarPlaceholder":true},"rating":4,"review":"It performs exactly as expected. There are three of these in the family.","status":{"title":"Pending","badge":"warning","icon":"clock"},"time":"Nov 09, 2:15 PM"}' />
                            </div>
                        </td>
                        <td class="align-middle product white-space-nowrap py-0"><a
                                class="d-block rounded-2 border border-translucent"
                                href="apps/e-commerce/landing/product-details.html"><img src=""
                                    alt="" width="53" /></a>
                        </td>
                        <td class="align-middle product white-space-nowrap"><a class="fw-semibold"
                                href="apps/e-commerce/landing/product-details.html">Razer Kraken v3 x Wired
                                7.1 Surroung Sound Gam...</a></td>
                        <td class="align-middle customer white-space-nowrap"><a
                                class="d-flex align-items-center text-body"
                                href="apps/e-commerce/landing/profile.html">
                                <div class="avatar avatar-l"><img class="rounded-circle avatar-placeholder"
                                        src="" alt="" /></div>
                                <h6 class="mb-0 ms-3 text-body">Kim Carroll</h6>
                            </a></td>
                        <td class="align-middle rating white-space-nowrap fs-10"><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span>
                        </td>
                        <td class="align-middle review" style="min-width:350px;">
                            <p class="fs-9 fw-semibold text-body-highlight mb-0">It performs exactly as
                                expected. There are three of these in the family.</p>
                        </td>
                        <td class="align-middle text-start ps-5 status"><span
                                class="badge badge-phoenix fs-10 badge-phoenix-warning"><span
                                    class="badge-label">Pending</span><span class="ms-1" data-feather="clock"
                                    style="height:12.8px;width:12.8px;"></span></span>
                        </td>
                        <td class="align-middle text-end time white-space-nowrap">
                            <div class="hover-hide">
                                <h6 class="text-body-highlight mb-0">Nov 09, 2:15 PM</h6>
                            </div>
                        </td>
                        <td class="align-middle white-space-nowrap text-end pe-0">
                            <div class="position-relative">
                                <div class="hover-actions"><button
                                        class="btn btn-sm btn-phoenix-secondary me-1 fs-10"><span
                                            class="fas fa-check"></span></button><button
                                        class="btn btn-sm btn-phoenix-secondary fs-10"><span
                                            class="fas fa-trash"></span></button></div>
                            </div>
                            <div class="btn-reveal-trigger position-static"><button
                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                        class="fas fa-ellipsis-h fs-10"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item"
                                        href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger"
                                        href="#!">Remove</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                        <td class="fs-9 align-middle ps-0">
                            <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox"
                                    data-bulk-select-row='{"product":"PlayStation 5 DualSense Wireless Controller","productImage":"/products/60x60/6.png","customer":{"name":"Barbara Lucas","avatar":"/team/40x40/57.webp"},"rating":4,"review":"The controller is quite comfy for me. Despite its increased size, the controller still fits well in my hands.","status":{"title":"Approved","badge":"success","icon":"check"},"time":"Nov 08, 8:53 AM"}' />
                            </div>
                        </td>
                        <td class="align-middle product white-space-nowrap py-0"><a
                                class="d-block rounded-2 border border-translucent"
                                href="apps/e-commerce/landing/product-details.html"><img src=""
                                    alt="" width="53" /></a>
                        </td>
                        <td class="align-middle product white-space-nowrap"><a class="fw-semibold"
                                href="apps/e-commerce/landing/product-details.html">PlayStation 5 DualSense
                                Wireless Controller</a></td>
                        <td class="align-middle customer white-space-nowrap"><a
                                class="d-flex align-items-center text-body"
                                href="apps/e-commerce/landing/profile.html">
                                <div class="avatar avatar-l"><img class="rounded-circle" src=""
                                        alt="" /></div>
                                <h6 class="mb-0 ms-3 text-body">Barbara Lucas</h6>
                            </a></td>
                        <td class="align-middle rating white-space-nowrap fs-10"><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span>
                        </td>
                        <td class="align-middle review" style="min-width:350px;">
                            <p class="fs-9 fw-semibold text-body-highlight mb-0">The controller is quite
                                comfy for me. Despite its increased size, the controller still fits well in
                                my hands.</p>
                        </td>
                        <td class="align-middle text-start ps-5 status"><span
                                class="badge badge-phoenix fs-10 badge-phoenix-success"><span
                                    class="badge-label">Approved</span><span class="ms-1" data-feather="check"
                                    style="height:12.8px;width:12.8px;"></span></span>
                        </td>
                        <td class="align-middle text-end time white-space-nowrap">
                            <div class="hover-hide">
                                <h6 class="text-body-highlight mb-0">Nov 08, 8:53 AM</h6>
                            </div>
                        </td>
                        <td class="align-middle white-space-nowrap text-end pe-0">
                            <div class="position-relative">
                                <div class="hover-actions"><button
                                        class="btn btn-sm btn-phoenix-secondary me-1 fs-10"><span
                                            class="fas fa-check"></span></button><button
                                        class="btn btn-sm btn-phoenix-secondary fs-10"><span
                                            class="fas fa-trash"></span></button></div>
                            </div>
                            <div class="btn-reveal-trigger position-static"><button
                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                        class="fas fa-ellipsis-h fs-10"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item"
                                        href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger"
                                        href="#!">Remove</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                        <td class="fs-9 align-middle ps-0">
                            <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox"
                                    data-bulk-select-row='{"product":"2021 Apple 12.9-inch iPad Pro (Wi‑Fi, 128GB) - Space Gray","productImage":"/products/60x60/7.png","customer":{"name":"Ansolo Lazinatov","avatar":"/team/40x40/3.webp"},"rating":4.5,"review":"The response time and service I received when contacted the designers were Phenomenal!","status":{"title":"Pending","badge":"warning","icon":"clock"},"time":"Nov 07, 9:00 PM"}' />
                            </div>
                        </td>
                        <td class="align-middle product white-space-nowrap py-0"><a
                                class="d-block rounded-2 border border-translucent"
                                href="apps/e-commerce/landing/product-details.html"><img src=""
                                    alt="" width="53" /></a>
                        </td>
                        <td class="align-middle product white-space-nowrap"><a class="fw-semibold"
                                href="apps/e-commerce/landing/product-details.html">2021 Apple 12.9-inch
                                iPad Pro (Wi‑Fi, 128GB) -...</a></td>
                        <td class="align-middle customer white-space-nowrap"><a
                                class="d-flex align-items-center text-body"
                                href="apps/e-commerce/landing/profile.html">
                                <div class="avatar avatar-l"><img class="rounded-circle" src=""
                                        alt="" /></div>
                                <h6 class="mb-0 ms-3 text-body">Ansolo Lazinatov</h6>
                            </a></td>
                        <td class="align-middle rating white-space-nowrap fs-10"><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star-half-alt star-icon text-warning"></span></td>
                        <td class="align-middle review" style="min-width:350px;">
                            <p class="fs-9 fw-semibold text-body-highlight mb-0">The response time and
                                service I received when contacted the designers were Phenomenal!</p>
                        </td>
                        <td class="align-middle text-start ps-5 status"><span
                                class="badge badge-phoenix fs-10 badge-phoenix-warning"><span
                                    class="badge-label">Pending</span><span class="ms-1" data-feather="clock"
                                    style="height:12.8px;width:12.8px;"></span></span>
                        </td>
                        <td class="align-middle text-end time white-space-nowrap">
                            <div class="hover-hide">
                                <h6 class="text-body-highlight mb-0">Nov 07, 9:00 PM</h6>
                            </div>
                        </td>
                        <td class="align-middle white-space-nowrap text-end pe-0">
                            <div class="position-relative">
                                <div class="hover-actions"><button
                                        class="btn btn-sm btn-phoenix-secondary me-1 fs-10"><span
                                            class="fas fa-check"></span></button><button
                                        class="btn btn-sm btn-phoenix-secondary fs-10"><span
                                            class="fas fa-trash"></span></button></div>
                            </div>
                            <div class="btn-reveal-trigger position-static"><button
                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                        class="fas fa-ellipsis-h fs-10"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item"
                                        href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger"
                                        href="#!">Remove</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                        <td class="fs-9 align-middle ps-0">
                            <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox"
                                    data-bulk-select-row='{"product":"Amazon Basics Matte Black Wired Keyboard - US Layout (QWERTY)","productImage":"/products/60x60/8.png","customer":{"name":"Emma watson","avatar":"/team/40x40/26.webp"},"rating":3,"review":"I have started using this theme in the last week and it has really impressed me very much, the support is second to none.","status":{"title":"Pending","badge":"warning","icon":"clock"},"time":"Nov 07, 11:20 AM"}' />
                            </div>
                        </td>
                        <td class="align-middle product white-space-nowrap py-0"><a
                                class="d-block rounded-2 border border-translucent"
                                href="apps/e-commerce/landing/product-details.html"><img src=""
                                    alt="" width="53" /></a>
                        </td>
                        <td class="align-middle product white-space-nowrap"><a class="fw-semibold"
                                href="apps/e-commerce/landing/product-details.html">Amazon Basics Matte
                                Black Wired Keyboard - US ...</a></td>
                        <td class="align-middle customer white-space-nowrap"><a
                                class="d-flex align-items-center text-body"
                                href="apps/e-commerce/landing/profile.html">
                                <div class="avatar avatar-l"><img class="rounded-circle" src=""
                                        alt="" /></div>
                                <h6 class="mb-0 ms-3 text-body">Emma watson</h6>
                            </a></td>
                        <td class="align-middle rating white-space-nowrap fs-10"><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span><span
                                class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span>
                        </td>
                        <td class="align-middle review" style="min-width:350px;">
                            <p class="fs-9 fw-semibold text-body-highlight mb-0">I have started using this
                                theme in the last week and it has really impressed me very much, the support
                                is second to none.</p>
                        </td>
                        <td class="align-middle text-start ps-5 status"><span
                                class="badge badge-phoenix fs-10 badge-phoenix-warning"><span
                                    class="badge-label">Pending</span><span class="ms-1" data-feather="clock"
                                    style="height:12.8px;width:12.8px;"></span></span>
                        </td>
                        <td class="align-middle text-end time white-space-nowrap">
                            <div class="hover-hide">
                                <h6 class="text-body-highlight mb-0">Nov 07, 11:20 AM</h6>
                            </div>
                        </td>
                        <td class="align-middle white-space-nowrap text-end pe-0">
                            <div class="position-relative">
                                <div class="hover-actions"><button
                                        class="btn btn-sm btn-phoenix-secondary me-1 fs-10"><span
                                            class="fas fa-check"></span></button><button
                                        class="btn btn-sm btn-phoenix-secondary fs-10"><span
                                            class="fas fa-trash"></span></button></div>
                            </div>
                            <div class="btn-reveal-trigger position-static"><button
                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                        class="fas fa-ellipsis-h fs-10"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item"
                                        href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger"
                                        href="#!">Remove</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                        <td class="fs-9 align-middle ps-0">
                            <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox"
                                    data-bulk-select-row='{"product":"Amazon Basics Mesh, Mid-Back, Swivel Office Desk Chair with Armrests, Black","productImage":"/products/60x60/9.png","customer":{"name":"Rowen Atkinson","avatar":"/team/40x40/29.webp"},"rating":5,"review":"The best experience we could hope for. Customer service team is amazing and the quality of their products is unsurpassed. Great theme too!","status":{"title":"Approved","badge":"success","icon":"check"},"time":"Nov 07, 2:00 PM"}' />
                            </div>
                        </td>
                        <td class="align-middle product white-space-nowrap py-0"><a
                                class="d-block rounded-2 border border-translucent"
                                href="apps/e-commerce/landing/product-details.html"><img src=""
                                    alt="" width="53" /></a>
                        </td>
                        <td class="align-middle product white-space-nowrap"><a class="fw-semibold"
                                href="apps/e-commerce/landing/product-details.html">Amazon Basics Mesh,
                                Mid-Back, Swivel Office De...</a></td>
                        <td class="align-middle customer white-space-nowrap"><a
                                class="d-flex align-items-center text-body"
                                href="apps/e-commerce/landing/profile.html">
                                <div class="avatar avatar-l"><img class="rounded-circle" src=""
                                        alt="" /></div>
                                <h6 class="mb-0 ms-3 text-body">Rowen Atkinson</h6>
                            </a></td>
                        <td class="align-middle rating white-space-nowrap fs-10"><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span>
                        </td>
                        <td class="align-middle review" style="min-width:350px;">
                            <p class="fs-9 fw-semibold text-body-highlight mb-0">The best experience we
                                could hope for. Customer service team is amazing and the quality of their
                                products is unsurpassed. Great theme ...<a href='#!'>See more</a></p>
                        </td>
                        <td class="align-middle text-start ps-5 status"><span
                                class="badge badge-phoenix fs-10 badge-phoenix-success"><span
                                    class="badge-label">Approved</span><span class="ms-1" data-feather="check"
                                    style="height:12.8px;width:12.8px;"></span></span>
                        </td>
                        <td class="align-middle text-end time white-space-nowrap">
                            <div class="hover-hide">
                                <h6 class="text-body-highlight mb-0">Nov 07, 2:00 PM</h6>
                            </div>
                        </td>
                        <td class="align-middle white-space-nowrap text-end pe-0">
                            <div class="position-relative">
                                <div class="hover-actions"><button
                                        class="btn btn-sm btn-phoenix-secondary me-1 fs-10"><span
                                            class="fas fa-check"></span></button><button
                                        class="btn btn-sm btn-phoenix-secondary fs-10"><span
                                            class="fas fa-trash"></span></button></div>
                            </div>
                            <div class="btn-reveal-trigger position-static"><button
                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                        class="fas fa-ellipsis-h fs-10"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item"
                                        href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger"
                                        href="#!">Remove</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                        <td class="fs-9 align-middle ps-0">
                            <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox"
                                    data-bulk-select-row='{"product":"Apple Magic Mouse (Wireless, Rechargable) - Silver","productImage":"/products/60x60/10.png","customer":{"name":"Anthony Hopkins","avatar":""},"rating":4,"review":"This template has allowed me to convert my existing web app into a great looking, easy to use UI in less than 2 weeks. Very easy to use and understand and has a wide range of ready to use elements. ","status":{"title":"Approved","badge":"success","icon":"check"},"time":"Nov 06, 8:00 AM"}' />
                            </div>
                        </td>
                        <td class="align-middle product white-space-nowrap py-0"><a
                                class="d-block rounded-2 border border-translucent"
                                href="apps/e-commerce/landing/product-details.html"><img src=""
                                    alt="" width="53" /></a>
                        </td>
                        <td class="align-middle product white-space-nowrap"><a class="fw-semibold"
                                href="apps/e-commerce/landing/product-details.html">Apple Magic Mouse
                                (Wireless, Rechargable) - Si...</a></td>
                        <td class="align-middle customer white-space-nowrap"><a
                                class="d-flex align-items-center text-body"
                                href="apps/e-commerce/landing/profile.html">
                                <div class="avatar avatar-l">
                                    <div class="avatar-name rounded-circle"><span>A</span></div>
                                </div>
                                <h6 class="mb-0 ms-3 text-body">Anthony Hopkins</h6>
                            </a></td>
                        <td class="align-middle rating white-space-nowrap fs-10"><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span>
                        </td>
                        <td class="align-middle review" style="min-width:350px;">
                            <p class="fs-9 fw-semibold text-body-highlight mb-0">This template has allowed
                                me to convert my existing web app into a great looking, easy to use UI in
                                less than 2 weeks. Very easy to us...<a href='#!'>See more</a></p>
                        </td>
                        <td class="align-middle text-start ps-5 status"><span
                                class="badge badge-phoenix fs-10 badge-phoenix-success"><span
                                    class="badge-label">Approved</span><span class="ms-1" data-feather="check"
                                    style="height:12.8px;width:12.8px;"></span></span>
                        </td>
                        <td class="align-middle text-end time white-space-nowrap">
                            <div class="hover-hide">
                                <h6 class="text-body-highlight mb-0">Nov 06, 8:00 AM</h6>
                            </div>
                        </td>
                        <td class="align-middle white-space-nowrap text-end pe-0">
                            <div class="position-relative">
                                <div class="hover-actions"><button
                                        class="btn btn-sm btn-phoenix-secondary me-1 fs-10"><span
                                            class="fas fa-check"></span></button><button
                                        class="btn btn-sm btn-phoenix-secondary fs-10"><span
                                            class="fas fa-trash"></span></button></div>
                            </div>
                            <div class="btn-reveal-trigger position-static"><button
                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                        class="fas fa-ellipsis-h fs-10"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item"
                                        href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger"
                                        href="#!">Remove</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                        <td class="fs-9 align-middle ps-0">
                            <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox"
                                    data-bulk-select-row='{"product":"Echo Dot (4th Gen) _ Smart speaker with Alexa _ Glacier White","productImage":"/products/60x60/11.png","customer":{"name":"Jennifer Schramm","avatar":"/team/40x40/8.webp"},"rating":4.5,"review":"The theme is really beautiful and the support answer very quickly and is friendly. Buy it, you will not regret it.","status":{"title":"Pending","badge":"warning","icon":"clock"},"time":"Nov 05, 4:00 AM"}' />
                            </div>
                        </td>
                        <td class="align-middle product white-space-nowrap py-0"><a
                                class="d-block rounded-2 border border-translucent"
                                href="apps/e-commerce/landing/product-details.html"><img src=""
                                    alt="" width="53" /></a>
                        </td>
                        <td class="align-middle product white-space-nowrap"><a class="fw-semibold"
                                href="apps/e-commerce/landing/product-details.html">Echo Dot (4th Gen) _
                                Smart speaker with Alexa ...</a></td>
                        <td class="align-middle customer white-space-nowrap"><a
                                class="d-flex align-items-center text-body"
                                href="apps/e-commerce/landing/profile.html">
                                <div class="avatar avatar-l"><img class="rounded-circle" src=""
                                        alt="" /></div>
                                <h6 class="mb-0 ms-3 text-body">Jennifer Schramm</h6>
                            </a></td>
                        <td class="align-middle rating white-space-nowrap fs-10"><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star-half-alt star-icon text-warning"></span></td>
                        <td class="align-middle review" style="min-width:350px;">
                            <p class="fs-9 fw-semibold text-body-highlight mb-0">The theme is really
                                beautiful and the support answer very quickly and is friendly. Buy it, you
                                will not regret it.</p>
                        </td>
                        <td class="align-middle text-start ps-5 status"><span
                                class="badge badge-phoenix fs-10 badge-phoenix-warning"><span
                                    class="badge-label">Pending</span><span class="ms-1" data-feather="clock"
                                    style="height:12.8px;width:12.8px;"></span></span>
                        </td>
                        <td class="align-middle text-end time white-space-nowrap">
                            <div class="hover-hide">
                                <h6 class="text-body-highlight mb-0">Nov 05, 4:00 AM</h6>
                            </div>
                        </td>
                        <td class="align-middle white-space-nowrap text-end pe-0">
                            <div class="position-relative">
                                <div class="hover-actions"><button
                                        class="btn btn-sm btn-phoenix-secondary me-1 fs-10"><span
                                            class="fas fa-check"></span></button><button
                                        class="btn btn-sm btn-phoenix-secondary fs-10"><span
                                            class="fas fa-trash"></span></button></div>
                            </div>
                            <div class="btn-reveal-trigger position-static"><button
                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                        class="fas fa-ellipsis-h fs-10"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item"
                                        href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger"
                                        href="#!">Remove</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                        <td class="fs-9 align-middle ps-0">
                            <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox"
                                    data-bulk-select-row='{"product":"HORI Racing Wheel Apex for PlayStation 4_3, and PC","productImage":"/products/60x60/12.png","customer":{"name":"Raymond Mims","avatar":"/team/40x40/avatar.webp","avatarPlaceholder":true},"rating":4,"review":"As others mentioned, the team behind this theme is super responsive. I sent a message during the weekend, fully expecting a response after the weekend, but I got one within minutes, and I was unblocked.","status":{"title":"Approved","badge":"success","icon":"check"},"time":"Nov 04, 6:53 PM"}' />
                            </div>
                        </td>
                        <td class="align-middle product white-space-nowrap py-0"><a
                                class="d-block rounded-2 border border-translucent"
                                href="apps/e-commerce/landing/product-details.html"><img src=""
                                    alt="" width="53" /></a>
                        </td>
                        <td class="align-middle product white-space-nowrap"><a class="fw-semibold"
                                href="apps/e-commerce/landing/product-details.html">HORI Racing Wheel Apex
                                for PlayStation 4_3, an...</a></td>
                        <td class="align-middle customer white-space-nowrap"><a
                                class="d-flex align-items-center text-body"
                                href="apps/e-commerce/landing/profile.html">
                                <div class="avatar avatar-l"><img class="rounded-circle avatar-placeholder"
                                        src="" alt="" /></div>
                                <h6 class="mb-0 ms-3 text-body">Raymond Mims</h6>
                            </a></td>
                        <td class="align-middle rating white-space-nowrap fs-10"><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span>
                        </td>
                        <td class="align-middle review" style="min-width:350px;">
                            <p class="fs-9 fw-semibold text-body-highlight mb-0">As others mentioned, the
                                team behind this theme is super responsive. I sent a message during the
                                weekend, fully expecting a response a...<a href='#!'>See more</a></p>
                        </td>
                        <td class="align-middle text-start ps-5 status"><span
                                class="badge badge-phoenix fs-10 badge-phoenix-success"><span
                                    class="badge-label">Approved</span><span class="ms-1" data-feather="check"
                                    style="height:12.8px;width:12.8px;"></span></span>
                        </td>
                        <td class="align-middle text-end time white-space-nowrap">
                            <div class="hover-hide">
                                <h6 class="text-body-highlight mb-0">Nov 04, 6:53 PM</h6>
                            </div>
                        </td>
                        <td class="align-middle white-space-nowrap text-end pe-0">
                            <div class="position-relative">
                                <div class="hover-actions"><button
                                        class="btn btn-sm btn-phoenix-secondary me-1 fs-10"><span
                                            class="fas fa-check"></span></button><button
                                        class="btn btn-sm btn-phoenix-secondary fs-10"><span
                                            class="fas fa-trash"></span></button></div>
                            </div>
                            <div class="btn-reveal-trigger position-static"><button
                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                        class="fas fa-ellipsis-h fs-10"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item"
                                        href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger"
                                        href="#!">Remove</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                        <td class="fs-9 align-middle ps-0">
                            <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox"
                                    data-bulk-select-row='{"product":"Nintendo Switch with Neon Blue and Neon Red Joy‑Con - HAC-001(-01)","productImage":"/products/60x60/13.png","customer":{"name":"Michael Jenkins","avatar":"/team/40x40/9.webp"},"rating":5,"review":"I had a bit of a hard time at first but after I contacted the team they were able to help me set up the theme. It&#39;s really good and I highly recommend it to everyone.","status":{"title":"Pending","badge":"warning","icon":"clock"},"time":"Nov 04, 12:00 PM"}' />
                            </div>
                        </td>
                        <td class="align-middle product white-space-nowrap py-0"><a
                                class="d-block rounded-2 border border-translucent"
                                href="apps/e-commerce/landing/product-details.html"><img src=""
                                    alt="" width="53" /></a>
                        </td>
                        <td class="align-middle product white-space-nowrap"><a class="fw-semibold"
                                href="apps/e-commerce/landing/product-details.html">Nintendo Switch with
                                Neon Blue and Neon Red Jo...</a></td>
                        <td class="align-middle customer white-space-nowrap"><a
                                class="d-flex align-items-center text-body"
                                href="apps/e-commerce/landing/profile.html">
                                <div class="avatar avatar-l"><img class="rounded-circle" src=""
                                        alt="" /></div>
                                <h6 class="mb-0 ms-3 text-body">Michael Jenkins</h6>
                            </a></td>
                        <td class="align-middle rating white-space-nowrap fs-10"><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span>
                        </td>
                        <td class="align-middle review" style="min-width:350px;">
                            <p class="fs-9 fw-semibold text-body-highlight mb-0">I had a bit of a hard time
                                at first but after I contacted the team they were able to help me set up the
                                theme. It's really good and I ...<a href='#!'>See more</a></p>
                        </td>
                        <td class="align-middle text-start ps-5 status"><span
                                class="badge badge-phoenix fs-10 badge-phoenix-warning"><span
                                    class="badge-label">Pending</span><span class="ms-1" data-feather="clock"
                                    style="height:12.8px;width:12.8px;"></span></span>
                        </td>
                        <td class="align-middle text-end time white-space-nowrap">
                            <div class="hover-hide">
                                <h6 class="text-body-highlight mb-0">Nov 04, 12:00 PM</h6>
                            </div>
                        </td>
                        <td class="align-middle white-space-nowrap text-end pe-0">
                            <div class="position-relative">
                                <div class="hover-actions"><button
                                        class="btn btn-sm btn-phoenix-secondary me-1 fs-10"><span
                                            class="fas fa-check"></span></button><button
                                        class="btn btn-sm btn-phoenix-secondary fs-10"><span
                                            class="fas fa-trash"></span></button></div>
                            </div>
                            <div class="btn-reveal-trigger position-static"><button
                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                        class="fas fa-ellipsis-h fs-10"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item"
                                        href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger"
                                        href="#!">Remove</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                        <td class="fs-9 align-middle ps-0">
                            <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox"
                                    data-bulk-select-row='{"product":"Oculus Rift S PC-Powered VR Gaming Headset","productImage":"/products/60x60/14.png","customer":{"name":"Kristine Cadena","avatar":"/team/40x40/avatar.webp","avatarPlaceholder":true},"rating":5,"review":"Excellent. All my doubts were answered by the team quickly. I highly recommend it.","status":{"title":"Pending","badge":"warning","icon":"clock"},"time":"Nov 03, 8:53 AM"}' />
                            </div>
                        </td>
                        <td class="align-middle product white-space-nowrap py-0"><a
                                class="d-block rounded-2 border border-translucent"
                                href="apps/e-commerce/landing/product-details.html"><img src=""
                                    alt="" width="53" /></a>
                        </td>
                        <td class="align-middle product white-space-nowrap"><a class="fw-semibold"
                                href="apps/e-commerce/landing/product-details.html">Oculus Rift S PC-Powered
                                VR Gaming Headset</a></td>
                        <td class="align-middle customer white-space-nowrap"><a
                                class="d-flex align-items-center text-body"
                                href="apps/e-commerce/landing/profile.html">
                                <div class="avatar avatar-l"><img class="rounded-circle avatar-placeholder"
                                        src="" alt="" /></div>
                                <h6 class="mb-0 ms-3 text-body">Kristine Cadena</h6>
                            </a></td>
                        <td class="align-middle rating white-space-nowrap fs-10"><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span>
                        </td>
                        <td class="align-middle review" style="min-width:350px;">
                            <p class="fs-9 fw-semibold text-body-highlight mb-0">Excellent. All my doubts
                                were answered by the team quickly. I highly recommend it.</p>
                        </td>
                        <td class="align-middle text-start ps-5 status"><span
                                class="badge badge-phoenix fs-10 badge-phoenix-warning"><span
                                    class="badge-label">Pending</span><span class="ms-1" data-feather="clock"
                                    style="height:12.8px;width:12.8px;"></span></span>
                        </td>
                        <td class="align-middle text-end time white-space-nowrap">
                            <div class="hover-hide">
                                <h6 class="text-body-highlight mb-0">Nov 03, 8:53 AM</h6>
                            </div>
                        </td>
                        <td class="align-middle white-space-nowrap text-end pe-0">
                            <div class="position-relative">
                                <div class="hover-actions"><button
                                        class="btn btn-sm btn-phoenix-secondary me-1 fs-10"><span
                                            class="fas fa-check"></span></button><button
                                        class="btn btn-sm btn-phoenix-secondary fs-10"><span
                                            class="fas fa-trash"></span></button></div>
                            </div>
                            <div class="btn-reveal-trigger position-static"><button
                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                        class="fas fa-ellipsis-h fs-10"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item"
                                        href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger"
                                        href="#!">Remove</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                        <td class="fs-9 align-middle ps-0">
                            <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox"
                                    data-bulk-select-row='{"product":"Sony X85J 75 Inch Sony 4K Ultra HD LED Smart Google TV","productImage":"/products/60x60/15.png","customer":{"name":"Suzanne Martinez","avatar":"/team/40x40/24.webp"},"rating":3.5,"review":"This theme is great. Clean and easy to understand. Perfect for those who don&#39;t have time to start everything from scratch. The support is simply phenomenal! Highly recommended!","status":{"title":"Approved","badge":"success","icon":"check"},"time":"Nov 03, 10:43 AM"}' />
                            </div>
                        </td>
                        <td class="align-middle product white-space-nowrap py-0"><a
                                class="d-block rounded-2 border border-translucent"
                                href="apps/e-commerce/landing/product-details.html"><img src=""
                                    alt="" width="53" /></a>
                        </td>
                        <td class="align-middle product white-space-nowrap"><a class="fw-semibold"
                                href="apps/e-commerce/landing/product-details.html">Sony X85J 75 Inch Sony
                                4K Ultra HD LED Smart G...</a></td>
                        <td class="align-middle customer white-space-nowrap"><a
                                class="d-flex align-items-center text-body"
                                href="apps/e-commerce/landing/profile.html">
                                <div class="avatar avatar-l"><img class="rounded-circle" src=""
                                        alt="" /></div>
                                <h6 class="mb-0 ms-3 text-body">Suzanne Martinez</h6>
                            </a></td>
                        <td class="align-middle rating white-space-nowrap fs-10"><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star text-warning"></span><span
                                class="fa fa-star-half-alt star-icon text-warning"></span><span
                                class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span>
                        </td>
                        <td class="align-middle review" style="min-width:350px;">
                            <p class="fs-9 fw-semibold text-body-highlight mb-0">This theme is great. Clean
                                and easy to understand. Perfect for those who don't have time to start
                                everything from scratch. The support...<a href='#!'>See more</a></p>
                        </td>
                        <td class="align-middle text-start ps-5 status"><span
                                class="badge badge-phoenix fs-10 badge-phoenix-success"><span
                                    class="badge-label">Approved</span><span class="ms-1" data-feather="check"
                                    style="height:12.8px;width:12.8px;"></span></span>
                        </td>
                        <td class="align-middle text-end time white-space-nowrap">
                            <div class="hover-hide">
                                <h6 class="text-body-highlight mb-0">Nov 03, 10:43 AM</h6>
                            </div>
                        </td>
                        <td class="align-middle white-space-nowrap text-end pe-0">
                            <div class="position-relative">
                                <div class="hover-actions"><button
                                        class="btn btn-sm btn-phoenix-secondary me-1 fs-10"><span
                                            class="fas fa-check"></span></button><button
                                        class="btn btn-sm btn-phoenix-secondary fs-10"><span
                                            class="fas fa-trash"></span></button></div>
                            </div>
                            <div class="btn-reveal-trigger position-static"><button
                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                        class="fas fa-ellipsis-h fs-10"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item"
                                        href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger"
                                        href="#!">Remove</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row align-items-center py-1">
            <div class="pagination d-none"></div>
            <div class="col d-flex fs-9">
                <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                </p><a class="fw-semibold" href="#!" data-list-view="*">View all<span
                        class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a
                    class="fw-semibold d-none" href="#!" data-list-view="less">View Less</a>
            </div>
            <div class="col-auto d-flex">
                <button class="btn btn-link px-1 me-1" type="button" title="Previous"
                    data-list-pagination="prev"><span
                        class="fas fa-chevron-left me-2"></span>Previous</button><button
                    class="btn btn-link px-1 ms-1" type="button" title="Next"
                    data-list-pagination="next">Next<span class="fas fa-chevron-right ms-2"></span></button>
            </div>
        </div>
    </div>
</div>
<div class="row gx-6">
    <div class="col-12 col-xl-6">
        <div data-list='{"valueNames":["country","users","transactions","revenue","conv-rate"],"page":5}'>
            <div class="mb-5 mt-7">
                <h3>Khu vực có doanh thu cao nhất</h3>
                <p class="text-body-tertiary">Nơi bạn tạo ra nhiều doanh thu nhất</p>
            </div>
            <div class="table-responsive scrollbar">
                <table class="table fs-10 mb-0">
                    <thead>
                        <tr>
                            <th class="sort border-top border-translucent ps-0 align-middle" scope="col"
                                data-sort="country" style="width:32%">COUNTRY</th>
                            <th class="sort border-top border-translucent align-middle" scope="col"
                                data-sort="users" style="width:17%">USERS</th>
                            <th class="sort border-top border-translucent text-end align-middle" scope="col"
                                data-sort="transactions" style="width:16%">TRANSACTIONS</th>
                            <th class="sort border-top border-translucent text-end align-middle" scope="col"
                                data-sort="revenue" style="width:20%">REVENUE</th>
                            <th class="sort border-top border-translucent text-end pe-0 align-middle" scope="col"
                                data-sort="conv-rate" style="width:17%">CONV. RATE</th>
                        </tr>
                    </thead>
                    <tr>
                        <td></td>
                        <td class="align-middle py-4">
                            <h4 class="mb-0 fw-normal">377,620</h4>
                        </td>
                        <td class="align-middle text-end py-4">
                            <h4 class="mb-0 fw-normal">236</h4>
                        </td>
                        <td class="align-middle text-end py-4">
                            <h4 class="mb-0 fw-normal">$15,758</h4>
                        </td>
                        <td class="align-middle text-end py-4 pe-0">
                            <h4 class="mb-0 fw-normal">10.32%</h4>
                        </td>
                    </tr>
                    <tbody class="list" id="table-regions-by-revenue">
                        <tr>
                            <td class="white-space-nowrap ps-0 country" style="width:32%">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-3">1. </h6><a href="#!">
                                        <div class="d-flex align-items-center"><img
                                                src="assets/img/country/india.png" alt=""
                                                width="24" />
                                            <p class="mb-0 ps-3 text-primary fw-bold fs-9">India</p>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td class="align-middle users" style="width:17%">
                                <h6 class="mb-0">92896<span
                                        class="text-body-tertiary fw-semibold ms-2">(41.6%)</span></h6>
                            </td>
                            <td class="align-middle text-end transactions" style="width:17%">
                                <h6 class="mb-0">67<span
                                        class="text-body-tertiary fw-semibold ms-2">(34.3%)</span></h6>
                            </td>
                            <td class="align-middle text-end revenue" style="width:17%">
                                <h6 class="mb-0">$7560<span
                                        class="text-body-tertiary fw-semibold ms-2">(36.9%)</span></h6>
                            </td>
                            <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                <h6>14.01%</h6>
                            </td>
                        </tr>
                        <tr>
                            <td class="white-space-nowrap ps-0 country" style="width:32%">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-3">2. </h6><a href="#!">
                                        <div class="d-flex align-items-center"><img
                                                src="assets/img/country/china.png" alt=""
                                                width="24" />
                                            <p class="mb-0 ps-3 text-primary fw-bold fs-9">China</p>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td class="align-middle users" style="width:17%">
                                <h6 class="mb-0">50496<span
                                        class="text-body-tertiary fw-semibold ms-2">(32.8%)</span></h6>
                            </td>
                            <td class="align-middle text-end transactions" style="width:17%">
                                <h6 class="mb-0">54<span
                                        class="text-body-tertiary fw-semibold ms-2">(23.8%)</span></h6>
                            </td>
                            <td class="align-middle text-end revenue" style="width:17%">
                                <h6 class="mb-0">$6532<span
                                        class="text-body-tertiary fw-semibold ms-2">(26.5%)</span></h6>
                            </td>
                            <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                <h6>23.56%</h6>
                            </td>
                        </tr>
                        <tr>
                            <td class="white-space-nowrap ps-0 country" style="width:32%">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-3">3. </h6><a href="#!">
                                        <div class="d-flex align-items-center"><img src="assets/img/country/usa.png"
                                                alt="" width="24" />
                                            <p class="mb-0 ps-3 text-primary fw-bold fs-9">USA</p>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td class="align-middle users" style="width:17%">
                                <h6 class="mb-0">45679<span
                                        class="text-body-tertiary fw-semibold ms-2">(24.3%)</span></h6>
                            </td>
                            <td class="align-middle text-end transactions" style="width:17%">
                                <h6 class="mb-0">35<span
                                        class="text-body-tertiary fw-semibold ms-2">(19.7%)</span></h6>
                            </td>
                            <td class="align-middle text-end revenue" style="width:17%">
                                <h6 class="mb-0">$5432<span
                                        class="text-body-tertiary fw-semibold ms-2">(16.9%)</span></h6>
                            </td>
                            <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                <h6>10.23%</h6>
                            </td>
                        </tr>
                        <tr>
                            <td class="white-space-nowrap ps-0 country" style="width:32%">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-3">4. </h6><a href="#!">
                                        <div class="d-flex align-items-center"><img
                                                src="assets/img/country/south-korea.png" alt=""
                                                width="24" />
                                            <p class="mb-0 ps-3 text-primary fw-bold fs-9">South Korea</p>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td class="align-middle users" style="width:17%">
                                <h6 class="mb-0">36453<span
                                        class="text-body-tertiary fw-semibold ms-2">(19.7%)</span></h6>
                            </td>
                            <td class="align-middle text-end transactions" style="width:17%">
                                <h6 class="mb-0">22<span
                                        class="text-body-tertiary fw-semibold ms-2">(9.54%)</span></h6>
                            </td>
                            <td class="align-middle text-end revenue" style="width:17%">
                                <h6 class="mb-0">$4673<span
                                        class="text-body-tertiary fw-semibold ms-2">(11.6%)</span></h6>
                            </td>
                            <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                <h6>8.85%</h6>
                            </td>
                        </tr>
                        <tr>
                            <td class="white-space-nowrap ps-0 country" style="width:32%">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-3">5. </h6><a href="#!">
                                        <div class="d-flex align-items-center"><img
                                                src="assets/img/country/vietnam.png" alt=""
                                                width="24" />
                                            <p class="mb-0 ps-3 text-primary fw-bold fs-9">Vietnam</p>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td class="align-middle users" style="width:17%">
                                <h6 class="mb-0">15007<span
                                        class="text-body-tertiary fw-semibold ms-2">(11.9%)</span></h6>
                            </td>
                            <td class="align-middle text-end transactions" style="width:17%">
                                <h6 class="mb-0">17<span
                                        class="text-body-tertiary fw-semibold ms-2">(6.91%)</span></h6>
                            </td>
                            <td class="align-middle text-end revenue" style="width:17%">
                                <h6 class="mb-0">$2456<span
                                        class="text-body-tertiary fw-semibold ms-2">(10.2%)</span></h6>
                            </td>
                            <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                <h6>6.01%</h6>
                            </td>
                        </tr>
                        <tr>
                            <td class="white-space-nowrap ps-0 country" style="width:32%">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-3">6. </h6><a href="#!">
                                        <div class="d-flex align-items-center"><img
                                                src="assets/img/country/russia.png" alt=""
                                                width="24" />
                                            <p class="mb-0 ps-3 text-primary fw-bold fs-9">Russia</p>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td class="align-middle users" style="width:17%">
                                <h6 class="mb-0">54215<span
                                        class="text-body-tertiary fw-semibold ms-2">(32.9%)</span></h6>
                            </td>
                            <td class="align-middle text-end transactions" style="width:17%">
                                <h6 class="mb-0">38<span
                                        class="text-body-tertiary fw-semibold ms-2">(7.91%)</span></h6>
                            </td>
                            <td class="align-middle text-end revenue" style="width:17%">
                                <h6 class="mb-0">$3254<span
                                        class="text-body-tertiary fw-semibold ms-2">(12.4%)</span></h6>
                            </td>
                            <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                <h6>6.21%</h6>
                            </td>
                        </tr>
                        <tr>
                            <td class="white-space-nowrap ps-0 country" style="width:32%">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-3">7. </h6><a href="#!">
                                        <div class="d-flex align-items-center"><img
                                                src="assets/img/country/australia.png" alt=""
                                                width="24" />
                                            <p class="mb-0 ps-3 text-primary fw-bold fs-9">Australia</p>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td class="align-middle users" style="width:17%">
                                <h6 class="mb-0">54789<span
                                        class="text-body-tertiary fw-semibold ms-2">(12.7%)</span></h6>
                            </td>
                            <td class="align-middle text-end transactions" style="width:17%">
                                <h6 class="mb-0">32<span
                                        class="text-body-tertiary fw-semibold ms-2">(14.0%)</span></h6>
                            </td>
                            <td class="align-middle text-end revenue" style="width:17%">
                                <h6 class="mb-0">$3215<span
                                        class="text-body-tertiary fw-semibold ms-2">(5.72%)</span></h6>
                            </td>
                            <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                <h6>12.02%</h6>
                            </td>
                        </tr>
                        <tr>
                            <td class="white-space-nowrap ps-0 country" style="width:32%">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-3">8. </h6><a href="#!">
                                        <div class="d-flex align-items-center"><img
                                                src="assets/img/country/england.png" alt=""
                                                width="24" />
                                            <p class="mb-0 ps-3 text-primary fw-bold fs-9">England</p>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td class="align-middle users" style="width:17%">
                                <h6 class="mb-0">14785<span
                                        class="text-body-tertiary fw-semibold ms-2">(12.9%)</span></h6>
                            </td>
                            <td class="align-middle text-end transactions" style="width:17%">
                                <h6 class="mb-0">11<span
                                        class="text-body-tertiary fw-semibold ms-2">(32.91%)</span></h6>
                            </td>
                            <td class="align-middle text-end revenue" style="width:17%">
                                <h6 class="mb-0">$4745<span
                                        class="text-body-tertiary fw-semibold ms-2">(10.2%)</span></h6>
                            </td>
                            <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                <h6>8.01%</h6>
                            </td>
                        </tr>
                        <tr>
                            <td class="white-space-nowrap ps-0 country" style="width:32%">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-3">9. </h6><a href="#!">
                                        <div class="d-flex align-items-center"><img
                                                src="assets/img/country/indonesia.png" alt=""
                                                width="24" />
                                            <p class="mb-0 ps-3 text-primary fw-bold fs-9">Indonesia</p>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td class="align-middle users" style="width:17%">
                                <h6 class="mb-0">32156<span
                                        class="text-body-tertiary fw-semibold ms-2">(32.2%)</span></h6>
                            </td>
                            <td class="align-middle text-end transactions" style="width:17%">
                                <h6 class="mb-0">89<span
                                        class="text-body-tertiary fw-semibold ms-2">(12.0%)</span></h6>
                            </td>
                            <td class="align-middle text-end revenue" style="width:17%">
                                <h6 class="mb-0">$2456<span
                                        class="text-body-tertiary fw-semibold ms-2">(23.2%)</span></h6>
                            </td>
                            <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                <h6>9.07%</h6>
                            </td>
                        </tr>
                        <tr>
                            <td class="white-space-nowrap ps-0 country" style="width:32%">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-3">10. </h6><a href="#!">
                                        <div class="d-flex align-items-center"><img
                                                src="assets/img/country/japan.png" alt=""
                                                width="24" />
                                            <p class="mb-0 ps-3 text-primary fw-bold fs-9">Japan</p>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td class="align-middle users" style="width:17%">
                                <h6 class="mb-0">12547<span
                                        class="text-body-tertiary fw-semibold ms-2">(12.7%)</span></h6>
                            </td>
                            <td class="align-middle text-end transactions" style="width:17%">
                                <h6 class="mb-0">21<span
                                        class="text-body-tertiary fw-semibold ms-2">(14.91%)</span></h6>
                            </td>
                            <td class="align-middle text-end revenue" style="width:17%">
                                <h6 class="mb-0">$2541<span
                                        class="text-body-tertiary fw-semibold ms-2">(23.2%)</span></h6>
                            </td>
                            <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                <h6>20.01%</h6>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row align-items-center py-1">
                <div class="pagination d-none"></div>
                <div class="col d-flex fs-9">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                    </p>
                </div>
                <div class="col-auto d-flex">
                    <button class="btn btn-link px-1 me-1" type="button" title="Previous"
                        data-list-pagination="prev"><span
                            class="fas fa-chevron-left me-2"></span>Previous</button><button
                        class="btn btn-link px-1 ms-1" type="button" title="Next"
                        data-list-pagination="next">Next<span class="fas fa-chevron-right ms-2"></span></button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-6">
        <div class="mx-n4 mx-lg-n6 ms-xl-0 h-100">
            <div class="h-100 w-100">
                <div class="h-100 bg-body-emphasis" id="map" style="min-height: 300px;"></div>
            </div>
        </div>
    </div>
</div>
<div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis pt-6 pb-9 border-top">
    <div class="row g-6">
        <div class="col-12 col-xl-6">
            <div class="me-xl-4">
                <div>
                    <h3>Dự báo so với thực tế</h3>
                    <p class="mb-1 text-body-tertiary">Doanh thu thực tế so với dự báo</p>
                </div>
                <div class="echart-projection-actual" style="height:300px; width:100%"></div>
            </div>
        </div>
        <div class="col-12 col-xl-6">
            <div>
                <h3>Tỉ lệ khách quay lại</h3>
                <p class="mb-1 text-body-tertiary">Tỉ lệ khách hàng quay lại cửa hàng của bạn theo thời gian</p>
            </div>
            <div class="echart-returning-customer" style="height:300px;"></div>
        </div>
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
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
        const customDateRange = document.getElementById('custom-date-range');
        const dateFrom = document.getElementById('date-from');
        const dateTo = document.getElementById('date-to');

        // Hiển thị/ẩn date range picker
        quickRange.addEventListener('change', function() {
            if (this.value === 'custom') {
                customDateRange.style.display = 'block';
            } else {
                customDateRange.style.display = 'none';
            }
        });

        // Tự động điền ngày hiện tại cho custom range
        if (quickRange.value === 'custom' && !dateFrom.value) {
            dateFrom.value = new Date().toISOString().split('T')[0];
            dateTo.value = new Date().toISOString().split('T')[0];
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

    // Chạy ngay khi DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initCharts, 500);
            setTimeout(initRevenueComboChart, 600);
            setTimeout(initTopProductsChart, 700);
            setTimeout(initReviewsChart, 800);
            initRevenueFilter();
        });
    } else {
        setTimeout(initCharts, 500);
        setTimeout(initRevenueComboChart, 600);
        setTimeout(initTopProductsChart, 700);
        setTimeout(initReviewsChart, 800);
        initRevenueFilter();
    }

    // Backup: Chạy sau khi load hoàn toàn
    window.addEventListener('load', function() {
        setTimeout(initCharts, 1000);
        setTimeout(initRevenueComboChart, 1100);
        setTimeout(initTopProductsChart, 1200);
        setTimeout(initReviewsChart, 1300);
        initRevenueFilter();
    });
</script>
