@extends('admin.layouts')

@section('title', 'Trang chủ')

@section('breadcrumbs')
<li class="breadcrumb-item active">Trang chủ</li>
@endsection

@section('content')
@php
$rangeText = match(request('quick_range', 'this_month')) {
'today' => 'hôm nay',
'this_week' => 'tuần này',
'this_month' => 'tháng này',
'this_year' => 'năm nay',
'custom' => 'từ ' . (request('date_from') ? \Carbon\Carbon::parse(request('date_from'))->format('d/m/Y') : '...') . '
đến ' . (request('date_to') ? \Carbon\Carbon::parse(request('date_to'))->format('d/m/Y') : '...'),
default => 'Tháng này'
};
@endphp

<style>
    /* Đảm bảo toast hiện đúng màu và text rõ */
    .toast {
        color: #fff !important;
        background-color: #28a745 !important;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3) !important;
        opacity: 1 !important;
        font-weight: 600 !important;
        margin-top: 50px !important;
    }

    .toast-success {
        background-color: #28a745 !important;
    }

    .toast-error {
        background-color: #dc3545 !important;
    }

    .toast-info {
        background-color: #17a2b8 !important;
    }

    .toast-warning {
        background-color: #ffc107 !important;
        color: #000 !important;
    }

    .toast-message {
        overflow: visible !important;
    }

    .toast-message,
    .toast-title {
        font-size: 14px !important;
    }
</style>
@if (session('message'))
<script>
    toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "3000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr.success("{{ session('message') }}");
</script>
@endif


<div class="container-fluid pb-5">
    <div class="row g-4">
        <div class="col-12">
            <div class="mb-4">
                <h2 class="mb-2">Thống kê tổng quan</h2>
                <h5 class="text-body-tertiary fw-semibold">Tổng quan về hoạt động kinh doanh của bạn</h5>
            </div>
            <form method="GET" action="{{ route('admin.home') }}" class="row g-2 mb-4 align-items-end">
                <div class="col-auto">
                    <label class="form-label mb-1">Khoảng thời gian</label>
                    <select class="form-select" name="quick_range" id="quick_range" onchange="toggleDateInputs()">
                        <option value="today" {{ request('quick_range')=='today' ? 'selected' : '' }}>Hôm nay
                        </option>
                        <option value="this_week" {{ request('quick_range')=='this_week' ? 'selected' : '' }}>Tuần
                            này</option>
                        <option value="this_month" {{ (request('quick_range')=='this_month' ||
                            request('quick_range')==null) ? 'selected' : '' }}>
                            Tháng này</option>
                        <option value="this_year" {{ request('quick_range')=='this_year' ? 'selected' : '' }}>
                            Năm nay</option>
                        <option value="custom" {{ request('quick_range')=='custom' ? 'selected' : '' }}>Tùy chọn
                        </option>
                    </select>
                </div>
                <div class="col-auto" id="date_from_col" style="display:none;">
                    <label class="form-label mb-1">Từ ngày</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-auto" id="date_to_col" style="display:none;">
                    <label class="form-label mb-1">Đến ngày</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                    <a href="{{ route('admin.home') }}" class="btn btn-secondary">Xoá lọc</a>
                </div>
            </form>
            <script>
                function toggleDateInputs() {
                    var quickRange = document.getElementById('quick_range').value;
                    var show = quickRange === 'custom';
                    document.getElementById('date_from_col').style.display = show ? '' : 'none';
                    document.getElementById('date_to_col').style.display = show ? '' : 'none';
                }
                document.addEventListener('DOMContentLoaded', toggleDateInputs);
            </script>
        </div>
    </div>

    <!-- Thống kê nhanh -->
    <div class="row g-3 row-cols-2 row-cols-md-4 mb-4">
        <div class="col">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <span class="fa-stack fa-2x mb-2">
                        <span class="fa-solid fa-square fa-stack-2x text-success-light"></span>
                        <span class="fa-solid fa-shopping-cart fa-stack-1x text-success"></span>
                    </span>
                    <h4 class="mb-0">{{ $totalOrders }}</h4>
                    <p class="text-body-secondary fs-9 mb-0">Tổng số đơn hàng {{ $rangeText }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <span class="fa-stack fa-2x mb-2">
                        <span class="fa-solid fa-square fa-stack-2x text-warning-light"></span>
                        <span class="fa-solid fa-clock fa-stack-1x text-warning"></span>
                    </span>
                    <h4 class="mb-0">{{ $pendingOrders }}</h4>
                    <p class="text-body-secondary fs-9 mb-0">Đang chờ xử lý</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <span class="fa-stack fa-2x mb-2">
                        <span class="fa-solid fa-square fa-stack-2x text-success-light"></span>
                        <span class="fa-solid fa-check fa-stack-1x text-success"></span>
                    </span>
                    <h4 class="mb-0">{{ $completedOrders }}</h4>
                    <p class="text-body-secondary fs-9 mb-0">Đã hoàn thành</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <span class="fa-stack fa-2x mb-2">
                        <span class="fa-solid fa-square fa-stack-2x text-danger-light"></span>
                        <span class="fa-solid fa-box fa-stack-1x text-danger"></span>
                    </span>
                    <h4 class="mb-0">{{ $outOfStockProducts }}</h4>
                    <p class="text-body-secondary fs-9 mb-0">Sản phẩm hết hàng</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Doanh thu và biểu đồ -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-8">
            <div class="card h-100">
                <div class="card-body">
                    <h3>Tổng doanh thu {{ $rangeText }}</h3>
                    <p class="text-body-tertiary lh-sm mb-3">Doanh thu từ tất cả các đơn hàng</p>
                    <h2 class="text-success mb-4">{{ number_format($totalRevenue, 0, ',', '.') }} đ</h2>
                    <div class="echart-total-sales-chart" style="min-height:320px;width:100%"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="mb-1">Khách hàng</h5>
                    <h6 class="text-body-tertiary">Tổng số: {{ $totalCustomers }}</h6>
                    <h6 class="text-body-tertiary">Khách hàng mới: {{ $newCustomers }}</h6>
                    <div class="echarts-new-customers" style="height:180px;width:100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Đánh giá sản phẩm -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="mb-2">Đánh giá sản phẩm {{ $rangeText }}</h5>
                    <div class="d-flex mb-2">
                        <div class="me-4">
                            <h6 class="mb-0">Tổng số đánh giá</h6>
                            <span class="fw-bold">{{ $totalReviews }}</span>
                        </div>
                        <div>
                            <h6 class="mb-0">Đánh giá trung bình</h6>
                            <span class="fw-bold">{{ number_format($averageRating, 1) }}/5</span>
                        </div>
                    </div>
                    <div class="echart-top-coupons" style="height:115px;width:100%;"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="mb-2">Khách hàng</h5>
                    <div class="d-flex mb-2">
                        <div class="me-4">
                            <h6 class="mb-0">Tổng khách hàng</h6>
                            <span class="fw-bold">{{ $totalCustomers }}</span>
                        </div>
                        <div>
                            <h6 class="mb-0">Khách hàng mới</h6>
                            <span class="fw-bold">{{ $newCustomers }}</span>
                        </div>
                    </div>
                    <div class="echarts-paying-customer-chart" style="height:100px;width:100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bảng đánh giá mới nhất - Full width, giữ nguyên mẫu -->
    <div class="bg-body-emphasis pt-4 pb-4 border-y p-5 rounded-3">

        <div class="container-fluid px-0">
            <div class="row align-items-end justify-content-between pb-3 g-3">
                <div class="col-auto">
                    <h3 class="fw-bold mb-1">Đánh giá {{ $rangeText }}</h3>
                    <p class="text-body-tertiary lh-sm mb-0">Tổng hợp các phản hồi gần đây từ khách hàng</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table fs-9 mb-0 border-top border-translucent align-middle">
                    <thead>
                        <tr>
                            <th style="min-width: 200px;">Sản phẩm</th>
                            <th style="min-width: 140px;">Khách hàng</th>
                            <th style="min-width: 100px;">Đánh giá</th>
                            <th class="d-none d-md-table-cell" style="min-width: 220px;">Nội dung</th>
                            <th class="text-nowrap">Thời gian</th>
                            <th class="text-end pe-3 text-nowrap">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestReviews as $review)
                        <tr>
                            <td class="py-3 text-truncate" style="max-width:180px;">
                                {{ $review->product->name ?? 'N/A' }}
                            </td>
                            <td class="py-3 text-truncate" style="max-width:120px;">
                                {{ $review->user->name ?? 'N/A' }}
                            </td>
                            <td>
                                @for ($i = 1; $i <= 5; $i++) @if ($review->rating >= $i)
                                    <span class="fa fa-star text-warning"></span>
                                    @elseif($review->rating > $i - 1)
                                    <span class="fa fa-star-half-alt text-warning"></span>
                                    @else
                                    <span class="fa-regular fa-star text-secondary"></span>
                                    @endif
                                    @endfor
                            </td>
                            <td class="d-none d-md-table-cell text-body-secondary text-truncate"
                                style="max-width:200px;">
                                {{ \Illuminate\Support\Str::limit($review->content, 60) }}
                            </td>
                            <td class="text-muted text-nowrap">
                                {{ $review->created_at->diffForHumans() }}
                            </td>
                            <td class="text-end pe-3 text-nowrap">
                                <a href="{{ route('admin.products.show', $review->product->id) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-eye me-1"></i> Xem
                                </a>
                            </td>
                        </tr>
                        @endforeach

                        @if ($latestReviews->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Không có đánh giá nào gần đây.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top sản phẩm bán chạy & Biểu đồ doanh thu -->
    <div class="row g-4 mb-4 mt-3">
        <div class="col-12 col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="mb-2">Top sản phẩm bán chạy {{ $rangeText }}</h5>
                    <ul class="list-group list-group-flush">
                        @forelse($topProducts as $product)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <img src="{{ asset($product->image) }}" alt="" width="32" height="32"
                                    class="rounded me-2" style="object-fit:cover;">
                                {{ $product->name }}
                            </span>
                            <span class="badge bg-success rounded-pill">{{ $product->sold }} đã bán</span>
                        </li>
                        @empty
                        <li class="list-group-item text-center text-muted">Không có dữ liệu</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="mb-2">Biểu đồ doanh thu {{ $rangeText }}</h5>
                    <canvas id="revenueChart" style="height:260px"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Thống kê tổng hợp + Tỷ lệ chuyển đổi trên cùng 1 hàng -->
    <div class="row g-3 row-cols-2 row-cols-md-5 mb-4">
        <div class="col">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h4 class="mb-0">{{ $totalProducts }}</h4>
                    <p class="text-body-secondary fs-9 mb-0">Tổng sản phẩm</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h4 class="mb-0">{{ $totalStock }}</h4>
                    <p class="text-body-secondary fs-9 mb-0">Tổng tồn kho</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h4 class="mb-0">{{ $cancelledOrders }}</h4>
                    <p class="text-body-secondary fs-9 mb-0">Đơn hủy</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h4 class="mb-0">{{ $returnedOrders }}</h4>
                    <p class="text-body-secondary fs-9 mb-0">Đơn trả hàng</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 text-center border-primary border-2">
                <div class="card-body">
                    <h6 class="mb-2 text-primary">Tỷ lệ chuyển đổi đơn hàng</h6>
                    <h2 class="text-primary mb-0">{{ $conversionRate }}%</h2>
                    <p class="text-body-secondary fs-9 mb-0">Tổng số đơn hàng / số lượt đặt hàng</p>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Script Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueLabels) !!},
            datasets: [{
                label: 'Doanh thu',
                data: {!! json_encode($revenueData) !!},
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
</script>
@endsection
