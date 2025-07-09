@extends('admin.layouts')

@section('title', 'Trang chủ')

@section('breadcrumbs')
<li class="breadcrumb-item active">Trang chủ</li>
@endsection

@section('content')
@php
        $rangeText = match (request('quick_range', 'this_month')) {
'today' => 'hôm nay',
'this_week' => 'tuần này',
'this_month' => 'tháng này',
'this_year' => 'năm nay',
            'custom' => 'từ ' .
                (request('date_from') ? \Carbon\Carbon::parse(request('date_from'))->format('d/m/Y') : '...') .
                '
đến ' .
                (request('date_to') ? \Carbon\Carbon::parse(request('date_to'))->format('d/m/Y') : '...'),
            default => 'Tháng này',
};
@endphp

<!-- Phoenix Admin Dashboard Styles -->
<link href="https://cdn.jsdelivr.net/npm/phoenix@1.0.0/dist/css/phoenix.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/phoenix@1.0.0/dist/css/phoenix-sprockets.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --phoenix-primary: #3874ff;
        --phoenix-secondary: #6c757d;
        --phoenix-success: #00d27a;
        --phoenix-info: #39f;
        --phoenix-warning: #f5a623;
        --phoenix-danger: #e63757;
        --phoenix-light: #f9fafd;
        --phoenix-dark: #12263f;
    }

    .card-stat {
        border: none;
        border-radius: 1.25rem;
            box-shadow: 0 4px 32px 0 rgba(56, 116, 255, 0.08);
        background: linear-gradient(135deg, var(--phoenix-primary), #6c5ce7 80%);
        color: #fff;
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
        overflow: hidden;
        min-height: 80px;
        padding: 1rem 1.2rem 1rem 1.2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .card-stat .icon-bg {
        position: absolute;
        right: 1.2rem;
        top: 1rem;
        font-size: 2.1rem;
        opacity: 0.13;
        z-index: 0;
    }

    .card-stat .stat-value {
        font-size: 1.25rem;
        font-weight: 800;
        margin-bottom: 0.15rem;
        z-index: 1;
        position: relative;
    }

    .card-stat .stat-label {
        font-size: 0.92rem;
            color: rgba(255, 255, 255, 0.85);
        z-index: 1;
        position: relative;
    }

        .card-stat.stat-success {
            background: linear-gradient(135deg, var(--phoenix-success), #00b894 80%);
        }

        .card-stat.stat-warning {
            background: linear-gradient(135deg, var(--phoenix-warning), #f39c12 80%);
        }

        .card-stat.stat-danger {
            background: linear-gradient(135deg, var(--phoenix-danger), #e74c3c 80%);
        }

        .card-stat.stat-primary {
            background: linear-gradient(135deg, var(--phoenix-primary), #6c5ce7 80%);
        }

        .card-stat.stat-info {
            background: linear-gradient(135deg, var(--phoenix-info), #00cfff 80%);
        }

        .card-stat.stat-purple {
            background: linear-gradient(135deg, #a259ec, #6c5ce7 80%);
        }

        .card-stat.stat-pink {
            background: linear-gradient(135deg, #ff6f91, #ff9472 80%);
        }

        .card-stat.stat-teal {
            background: linear-gradient(135deg, #1abc9c, #16a085 80%);
        }

    .card-stat:hover {
        transform: translateY(-6px) scale(1.03);
            box-shadow: 0 8px 32px 0 rgba(56, 116, 255, 0.18);
        z-index: 2;
    }

    .phoenix-card {
        border-radius: 1.25rem;
            box-shadow: 0 4px 32px 0 rgba(56, 116, 255, 0.08);
        border: none;
        margin-bottom: 32px;
        transition: box-shadow 0.2s, transform 0.2s;
    }

    .phoenix-card:hover {
            box-shadow: 0 8px 32px 0 rgba(56, 116, 255, 0.18);
        transform: translateY(-4px) scale(1.01);
    }

    .phoenix-card .card-header {
        background: none;
        border-bottom: 1px solid #f1f1f1;
        padding: 1.25rem 1.5rem 1rem 1.5rem;
        font-weight: 700;
        font-size: 1.15rem;
    }

    .phoenix-card .card-body {
        padding: 1.5rem;
    }

    .chart-container {
        position: relative;
        height: 280px;
        margin: 1rem 0;
    }

    .table th {
        font-weight: 700;
        background-color: #f8f9fa;
    }

    .table tr {
        transition: background 0.2s;
    }

    .table tr:hover {
        background: #f1f7ff;
    }

        .btn,
        .phoenix-btn {
        border-radius: 0.5rem;
        font-weight: 600;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s, transform 0.2s;
    }

        .btn:hover,
        .phoenix-btn:hover {
            box-shadow: 0 2px 8px 0 rgba(56, 116, 255, 0.12);
        transform: translateY(-2px) scale(1.03);
    }

    .product-image {
        width: 56px;
        height: 56px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #fff;
            box-shadow: 0 2px 8px 0 rgba(56, 116, 255, 0.10);
        background: #f8f9fa;
    }

    .rating-stars {
        color: var(--phoenix-warning);
    }

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
            <!-- Bộ lọc khoảng thời gian đẹp -->
            <div class="phoenix-card mb-4 p-4">
                <form method="GET" action="{{ route('admin.home') }}" class="row g-3 align-items-end">
                    <div class="col-md-3">
                            <label class="form-label fw-semibold"><i class="fa fa-calendar-alt me-1"></i>Khoảng thời
                                gian</label>
                    <select class="form-select" name="quick_range" id="quick_range" onchange="toggleDateInputs()">
                                <option value="today" {{ request('quick_range') == 'today' ? 'selected' : '' }}>Hôm nay
                                </option>
                                <option value="this_week" {{ request('quick_range') == 'this_week' ? 'selected' : '' }}>Tuần
                                    này</option>
                                <option value="this_month"
                                    {{ request('quick_range') == 'this_month' || request('quick_range') == null ? 'selected' : '' }}>
                                    Tháng này</option>
                                <option value="this_year" {{ request('quick_range') == 'this_year' ? 'selected' : '' }}>Năm
                                    nay</option>
                                <option value="custom" {{ request('quick_range') == 'custom' ? 'selected' : '' }}>Tùy chọn
                                </option>
                    </select>
                </div>
                    <div class="col-md-3" id="date_from_col" style="display:none;">
                        <label class="form-label fw-semibold"><i class="fa fa-calendar-day me-1"></i>Từ ngày</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                    <div class="col-md-3" id="date_to_col" style="display:none;">
                        <label class="form-label fw-semibold"><i class="fa fa-calendar-day me-1"></i>Đến ngày</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                    <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1"><i
                                    class="fa fa-filter me-1"></i>Lọc</button>
                            <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary flex-grow-1"><i
                                    class="fa fa-times me-1"></i>Xoá lọc</a>
                </div>
            </form>
            </div>
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

    <!-- Card thống kê nhỏ gọn -->
    <div class="row g-2 mb-2">
        <div class="col-6 col-md-3">
            <div class="card card-stat stat-primary">
                <div class="icon-bg"><i class="fas fa-shopping-cart"></i></div>
                <div class="stat-value">{{ $totalOrders }}</div>
                <div class="stat-label">Tổng đơn hàng {{ $rangeText }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-stat stat-warning">
                <div class="icon-bg"><i class="fas fa-user-plus"></i></div>
                <div class="stat-value">{{ $newCustomers }}</div>
                <div class="stat-label">Khách hàng mới</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-stat stat-success">
                <div class="icon-bg"><i class="fas fa-box"></i></div>
                <div class="stat-value">{{ $totalProducts }}</div>
                <div class="stat-label">Tổng sản phẩm</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-stat stat-danger">
                <div class="icon-bg"><i class="fas fa-cube"></i></div>
                <div class="stat-value">{{ $newProductsThisMonth }}</div>
                <div class="stat-label">Sản phẩm mới tháng này</div>
            </div>
        </div>
    </div>
    <div class="row g-2 mb-2">
        <div class="col-6 col-md-3">
            <div class="card card-stat stat-info">
                <div class="icon-bg"><i class="fas fa-truck"></i></div>
                <div class="stat-value">{{ $shippingOrders }}</div>
                <div class="stat-label">Đơn hàng đang giao</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-stat stat-danger">
                <div class="icon-bg"><i class="fas fa-times-circle"></i></div>
                <div class="stat-value">{{ $cancelledOrders }}</div>
                <div class="stat-label">Đơn đã huỷ</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-stat stat-warning">
                <div class="icon-bg"><i class="fas fa-box-open"></i></div>
                <div class="stat-value">{{ $lowStockProducts }}</div>
                <div class="stat-label">Sản phẩm sắp hết hàng</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-stat stat-purple">
                <div class="icon-bg"><i class="fas fa-user-tie"></i></div>
                <div class="stat-value">{{ $topCustomerName }}</div>
                <div class="stat-label">Khách hàng mua nhiều nhất</div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ chia 2 cột nhỏ gọn -->
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <div class="phoenix-card p-3" style="height:240px;">
                <div class="card-header py-2 px-3">Doanh thu</div>
                <div class="card-body py-2 px-3">
                    <canvas id="revenueChart" style="height:160px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="phoenix-card p-3" style="height:240px;">
                <div class="card-header py-2 px-3">Khách hàng mới</div>
                <div class="card-body py-2 px-3">
                    <canvas id="customerChart" style="height:160px"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <div class="phoenix-card p-3" style="height:240px;">
                <div class="card-header py-2 px-3">Số lượng đơn hàng</div>
                <div class="card-body py-2 px-3">
                    <canvas id="orderChart" style="height:160px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="phoenix-card p-3" style="height:240px;">
                <div class="card-header py-2 px-3">Đánh giá sản phẩm</div>
                <div class="card-body py-2 px-3">
                    <canvas id="reviewChart" style="height:160px"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Accordion cho bảng phụ và tổng hợp hệ thống -->
    <div class="accordion mb-3" id="moreStatsAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingMore">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseMore">
                    Xem thêm thống kê
                </button>
            </h2>
            <div id="collapseMore" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <!-- Top sản phẩm bán chạy -->
                            <div class="phoenix-card p-3 mb-3">
                                <div class="card-header py-2 px-3">Top sản phẩm bán chạy</div>
                                <div class="card-body py-2 px-3">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Sản phẩm</th>
                                                    <th class="text-end">Đã bán</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach ($topProducts as $product)
                                                    @php $featuredImage = $product->images->where('is_featured', true)->first(); @endphp
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-3">
                                                                    <img src="{{ $featuredImage ? asset('storage/' . $featuredImage->image_path) : asset('images/no-image.png') }}"
                                                                        alt="{{ $product->name }}" class="product-image">
                                                                <div class="fw-semibold">{{ $product->name }}</div>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <span class="badge bg-success">{{ $product->sold }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Biểu đồ tổng hợp hệ thống nhỏ gọn -->
                            <div class="phoenix-card p-3">
                                <div class="card-header py-2 px-3">Tổng hợp hệ thống</div>
                                <div class="card-body py-2 px-3">
                                    <canvas id="summaryBarChart" style="height: 140px;"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Đánh giá mới nhất -->
                            <div class="phoenix-card p-3">
                                <div class="card-header py-2 px-3">Đánh giá mới nhất</div>
                                <div class="card-body py-2 px-3">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Sản phẩm</th>
                                                    <th>Đánh giá</th>
                                                    <th>Thời gian</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($latestReviews as $review)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-3">
                                                                    <div class="fw-semibold">
                                                                        {{ $review->product->name ?? 'N/A' }}</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="rating-stars">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($review->rating >= $i)
                                                                    <i class="fas fa-star"></i>
                                                                @elseif($review->rating > $i - 1)
                                                                    <i class="fas fa-star-half-alt"></i>
                                                                @else
                                                                    <i class="far fa-star"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                    </td>
                                                    <td>{{ $review->created_at->diffForHumans() }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/phoenix@1.0.0/dist/js/phoenix.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueLabels) !!},
            datasets: [{
                label: 'Doanh thu',
                data: {!! json_encode($revenueData) !!},
                borderColor: '#3874ff',
                backgroundColor: 'rgba(56, 116, 255, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 2,
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
                    boxPadding: 6,
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y.toLocaleString('vi-VN') + ' đ';
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
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + ' đ';
                        }
                    }
                },
                    x: {
                        grid: {
                            display: false
                        }
                    }
            }
        }
    });
    // Customer Chart
    const cctx = document.getElementById('customerChart').getContext('2d');
    const customerChart = new Chart(cctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($customerLabels) !!},
            datasets: [{
                label: 'Khách hàng mới',
                data: {!! json_encode($customerData) !!},
                borderColor: '#00d27a',
                backgroundColor: 'rgba(0,210,122,0.08)',
                fill: true,
                tension: 0.4,
                borderWidth: 2,
                pointRadius: 3,
                pointBackgroundColor: '#00d27a',
                pointBorderColor: '#fff',
                pointHoverRadius: 5
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
                    boxPadding: 6,
                    usePointStyle: true,
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
                        callback: function(value) {
                            return value;
                        }
                    }
                },
                    x: {
                        grid: {
                            display: false
                        }
                    }
            }
        }
    });
    // Order Chart
    const octx = document.getElementById('orderChart').getContext('2d');
    const orderChart = new Chart(octx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($orderLabels) !!},
            datasets: [{
                label: 'Đơn hàng',
                data: {!! json_encode($orderData) !!},
                backgroundColor: 'rgba(56, 116, 255, 0.7)',
                borderColor: '#3874ff',
                borderWidth: 1,
                borderRadius: 6,
                maxBarThickness: 32
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
                    boxPadding: 6,
                    usePointStyle: true,
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
                        callback: function(value) {
                            return value;
                        }
                    }
                },
                    x: {
                        grid: {
                            display: false
                        }
                    }
            }
        }
    });
    // Review Chart
    const rctx = document.getElementById('reviewChart').getContext('2d');
    const reviewChart = new Chart(rctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($reviewChartLabels) !!},
            datasets: [{
                label: 'Đánh giá',
                data: {!! json_encode($reviewChartData) !!},
                borderColor: '#f5a623',
                backgroundColor: 'rgba(245,166,35,0.08)',
                fill: true,
                tension: 0.4,
                borderWidth: 2,
                pointRadius: 3,
                pointBackgroundColor: '#f5a623',
                pointBorderColor: '#fff',
                pointHoverRadius: 5
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
                    boxPadding: 6,
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' đánh giá';
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
                        callback: function(value) {
                            return value;
                        }
                    }
                },
                    x: {
                        grid: {
                            display: false
                        }
                    }
            }
        }
    });
    // Biểu đồ tổng hợp hệ thống
    const summaryBarChart = new Chart(document.getElementById('summaryBarChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: [
                'Đang khuyến mãi', 'Khách chưa từng mua', 'Đánh giá nhiều nhất', 'Bình luận mới tuần này',
                'Tổng biến thể', 'Biến thể sắp hết hàng', 'Thương hiệu', 'Danh mục'
            ],
            datasets: [{
                label: 'Số lượng',
                data: [
                        {{ $promotionProducts }}, {{ $neverOrderedCustomers }},
                        {{ $mostReviewedProductCount }}, {{ $newCommentsThisWeek }},
                        {{ $totalVariations }}, {{ $lowStockVariations }}, {{ $totalBrands }},
                        {{ $totalCategories }}
                ],
                backgroundColor: [
                        '#f5a623', '#3874ff', '#e74c3c', '#39f', '#00d27a', '#e63757', '#6c5ce7',
                        '#00b894'
                ],
                borderRadius: 8,
                maxBarThickness: 38
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
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
                    boxPadding: 6,
                    usePointStyle: true
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        },
                        ticks: {
                            color: '#12263f',
                            font: {
                                weight: 600
                            }
                        }
                },
                y: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#12263f',
                            font: {
                                weight: 600
                            }
                        }
                }
            }
        }
    });
</script>
@endsection
