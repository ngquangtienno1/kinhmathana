@extends('client.layouts.app')

@section('content')
    <div class="qodef-page-title qodef-m qodef-title--standard-with-breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
        <div class="qodef-m-inner">
            <div class="qodef-m-content qodef-content-grid">
                <h1 class="qodef-m-title entry-title">So sánh sản phẩm</h1>
                <div itemprop="breadcrumb" class="qodef-breadcrumbs">
                    <a itemprop="url" class="qodef-breadcrumbs-link" href="{{ route('client.home') }}"><span itemprop="title">Trang chủ</span></a>
                    <span class="qodef-breadcrumbs-separator"></span>
                    <a itemprop="url" class="qodef-breadcrumbs-link" href="{{ route('client.products.index') }}"><span itemprop="title">Sản phẩm</span></a>
                    <span class="qodef-breadcrumbs-separator"></span>
                    <span itemprop="title" class="qodef-breadcrumbs-current">So sánh</span>
                </div>
            </div>
        </div>
    </div>

    <div class="compare-section">
        <h3>So sánh sản phẩm</h3>
        <div class="row g-3 mb-3">
            <div class="col-md-5">
                <label class="form-label">Sản phẩm 1</label>
                <div class="search-box">
                    <input type="hidden" name="compare_product1_id" id="compare_product1_id">
                    <input class="form-control compare-search" type="search" id="compare_product1_search"
                        placeholder="Tìm sản phẩm theo tên hoặc SKU" autocomplete="off" />
                    <span class="fas fa-search search-box-icon"></span>
                    <div class="dropdown-menu dropdown-menu-end search-dropdown-menu py-0 shadow border rounded-2"
                        id="compareProduct1Results" style="width: 100%; max-height: 24rem; overflow-y: auto;">
                        <div class="list-group list-group-flush" id="compareProduct1ResultsList">
                            <!-- Search results will be loaded here -->
                        </div>
                        <div class="list-group-item px-3 py-2 text-center" id="compareProduct1Loading" style="display: none;">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Đang tải...</span>
                            </div>
                        </div>
                        <div class="list-group-item px-3 py-2 text-center text-muted" id="compareProduct1NoResults" style="display: none;">
                            Không tìm thấy kết quả.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <label class="form-label">Sản phẩm 2</label>
                <div class="search-box">
                    <input type="hidden" name="compare_product2_id" id="compare_product2_id">
                    <input class="form-control compare-search" type="search" id="compare_product2_search"
                        placeholder="Tìm sản phẩm theo tên hoặc SKU" autocomplete="off" />
                    <span class="fas fa-search search-box-icon"></span>
                    <div class="dropdown-menu dropdown-menu-end search-dropdown-menu py-0 shadow border rounded-2"
                        id="compareProduct2Results" style="width: 100%; max-height: 24rem; overflow-y: auto;">
                        <div class="list-group list-group-flush" id="compareProduct2ResultsList">
                            <!-- Search results will be loaded here -->
                        </div>
                        <div class="list-group-item px-3 py-2 text-center" id="compareProduct2Loading" style="display: none;">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Đang tải...</span>
                            </div>
                        </div>
                        <div class="list-group-item px-3 py-2 text-center text-muted" id="compareProduct2NoResults" style="display: none;">
                            Không tìm thấy kết quả.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="compare-btn w-100" id="compare-button">So sánh</button>
            </div>
        </div>
        <div id="comparison-result" class="table-responsive mt-3" style="display: none;">
            <table class="compare-table">
                <thead>
                    <tr>
                        <th>Tiêu chí</th>
                        <th>Sản phẩm 1</th>
                        <th>Sản phẩm 2</th>
                    </tr>
                </thead>
                <tbody id="comparison-table-body">
                    <!-- Kết quả so sánh sẽ được thêm động qua JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .compare-section {
            margin-top: 20px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
        }
        .compare-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .compare-table th, .compare-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .compare-table th {
            background: #f1f1f1;
        }
        .compare-search {
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 4px;
        }
        .compare-btn {
            background: #0073aa;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        .compare-btn:hover {
            background: #005d87;
        }
    </style>


@endsection
