@extends('client.layouts.app')

@section('content')
    <div id="qodef-page-outer">
        <div
            class="qodef-page-title qodef-m qodef-title--standard-with-breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
            <div class="qodef-m-inner">
                <div class="qodef-m-content qodef-content-grid">
                    <h1 class="qodef-m-title entry-title">Sản phẩm yêu thích</h1>
                    <div itemprop="breadcrumb" class="qodef-breadcrumbs">
                        <a itemprop="url" class="qodef-breadcrumbs-link" href="{{ route('client.home') }}"><span
                                itemprop="title">Trang chủ</span></a>
                        <span class="qodef-breadcrumbs-separator"></span>
                        <span itemprop="title" class="qodef-breadcrumbs-current">Sản phẩm yêu thích</span>
                        <span class="qodef-breadcrumbs-separator"></span>
                        <span itemprop="title" class="qodef-breadcrumbs-current"></span>
                    </div>
                </div>
            </div>
        </div>
        <div id="qodef-page-inner" class="qodef-content-grid">
            <main id="qodef-page-content" class="qodef-grid qodef-layout--template " role="main">
                <div class="qodef-grid-inner clear">
                    <div class="qodef-grid-item qodef-page-content-section qodef-col--12">
                        <div class="qwfw-shortcode qwfw-m  qwfw-wishlist-table qwfw-layout--table qodef-neoocular-theme"
                            data-token="e94df7797f013c48" data-table="default"
                            data-shortcode-atts="{&quot;layout&quot;:&quot;table&quot;,&quot;table_name&quot;:&quot;default&quot;,&quot;table_title_tag&quot;:&quot;h3&quot;,&quot;products_per_page&quot;:10,&quot;current&quot;:1,&quot;total&quot;:1,&quot;items_count&quot;:1,&quot;enable_remove_item&quot;:&quot;&quot;,&quot;enable_add_to_cart&quot;:&quot;&quot;,&quot;orderby&quot;:&quot;&quot;}">
                            <div class="qwfw-m-inner">
                                <table class="qwfw-m-items shop_table">
                                    <thead class="qwfw-m-items-heading">
                                        <tr>
                                            <th class="qwfw-m-items-heading-item product-remove">
                                            </th>
                                            <th class="qwfw-m-items-heading-item product-thumbnail">
                                            </th>
                                            <th class="qwfw-m-items-heading-item product-name">
                                                Sản phẩm </th>
                                            <th class="qwfw-m-items-heading-item product-price">
                                                Đơn giá </th>
                                            <th class="qwfw-m-items-heading-item product-stock-status">
                                                Tình trạng kho </th>
                                            <th class="qwfw-m-items-heading-item product-add-to-cart">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="qwfw-m-items-content">
                                        @forelse ($wishlists as $item)
                                            @php
                                                $variation = $item->variation ?? null;
                                            @endphp
                                            <tr class="qwfw-m-items-content-row qwfw-e qwfw--simple"
                                                data-item-id="{{ $item->product->id }}">
                                                <td class="qwfw-e-item product-remove">
                                                    <div class="qwfw-e-item-inner">
                                                        <form method="POST" action="{{ route('client.wishlist.remove') }}">
                                                            @csrf
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $item->product->id }}">
                                                            <button type="submit"
                                                                class="qwfw-e-remove-button qwfw-spinner-item"
                                                                aria-label="Remove this item"
                                                                style="background:none;border:none;padding:0;margin:0;line-height:1;">
                                                                <span class="qwfw-e-remove-button-icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                        height="18" viewBox="0 0 18 18">
                                                                        <line x1="1" y1="1" x2="17"
                                                                            y2="17" stroke="red"
                                                                            stroke-width="2" />
                                                                        <line x1="17" y1="1" x2="1"
                                                                            y2="17" stroke="red"
                                                                            stroke-width="2" />
                                                                    </svg>
                                                                </span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td class="qwfw-e-item product-thumbnail">
                                                    <div class="qwfw-e-item-inner">
                                                        <a href="{{ route('client.products.show', $item->product->slug) }}">
                                                            @php
                                                                $featuredImage = null;
                                                                $imagePath = '/images/no-image.jpg';

                                                                // Kiểm tra sản phẩm có biến thể không
                                                                if ($variation && $variation->images->count() > 0) {
                                                                    // Có biến thể: lấy ảnh từ biến thể
                                                                    $featuredImage =
                                                                        $variation->images
                                                                            ->where('is_featured', true)
                                                                            ->first() ?? $variation->images->first();
                                                                    if ($featuredImage) {
                                                                        $imagePath = asset(
                                                                            'storage/' . $featuredImage->image_path,
                                                                        );
                                                                    }
                                                                } elseif ($item->product->images->count() > 0) {
                                                                    // Không có biến thể hoặc biến thể không có ảnh: lấy ảnh từ sản phẩm chính
                                                                    $featuredImage =
                                                                        $item->product->images
                                                                            ->where('is_featured', true)
                                                                            ->first() ??
                                                                        $item->product->images->first();
                                                                    if ($featuredImage) {
                                                                        $imagePath = asset(
                                                                            'storage/' . $featuredImage->image_path,
                                                                        );
                                                                    }
                                                                }
                                                            @endphp
                                                            <img src="{{ $imagePath }}" alt="{{ $item->product->name }}"
                                                                width="80" style="object-fit: cover;">
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="qwfw-e-item product-name">
                                                    <div class="qwfw-e-item-inner">
                                                        <a class="qwfw-e-item-name"
                                                            href="{{ route('client.products.show', $item->product->slug) }}">
                                                            {{ $item->product->name }}
                                                        </a>
                                                        @if ($variation)
                                                            <div style="font-size:13px;color:#444;">
                                                                @if ($variation->color)
                                                                    Màu: {{ $variation->color->name }}
                                                                @endif
                                                                @if ($variation->size)
                                                                    | Size: {{ $variation->size->name }}
                                                                @endif
                                                                @if ($variation->spherical)
                                                                    | Độ cận: {{ $variation->spherical->name }}
                                                                @endif
                                                                @if ($variation->cylindrical)
                                                                    | Độ loạn: {{ $variation->cylindrical->name }}
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="qwfw-e-item product-price">
                                                    <div class="qwfw-e-item-inner">
                                                        <span class="price">
                                                            @if ($variation)
                                                                @if ($variation->sale_price && $variation->sale_price < $variation->price)
                                                                    <del class="original-price">
                                                                        <span class="woocommerce-Price-amount amount">
                                                                            {{ number_format($variation->price, 0, ',', '.') }}₫
                                                                        </span>
                                                                    </del>
                                                                    <ins class="sale-price">
                                                                        <span class="woocommerce-Price-amount amount">
                                                                            {{ number_format($variation->sale_price, 0, ',', '.') }}₫
                                                                        </span>
                                                                    </ins>
                                                                @else
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        {{ number_format($variation->price, 0, ',', '.') }}₫
                                                                    </span>
                                                                @endif
                                                            @else
                                                                @if ($item->product->sale_price && $item->product->sale_price < $item->product->price)
                                                                    <del class="original-price">
                                                                        <span class="woocommerce-Price-amount amount">
                                                                            {{ number_format($item->product->price, 0, ',', '.') }}₫
                                                                        </span>
                                                                    </del>
                                                                    <ins class="sale-price">
                                                                        <span class="woocommerce-Price-amount amount">
                                                                            {{ number_format($item->product->sale_price, 0, ',', '.') }}₫
                                                                        </span>
                                                                    </ins>
                                                                @else
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        {{ number_format($item->product->price, 0, ',', '.') }}₫
                                                                    </span>
                                                                @endif
                                                            @endif
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="qwfw-e-item product-stock-status">
                                                    <div class="qwfw-e-item-inner">
                                                        @if ($variation)
                                                            @if ($variation->quantity === 0)
                                                                <span class="qwfw-e-item-stock qwfw--out-of-stock">Hết
                                                                    hàng</span>
                                                            @else
                                                                <span class="qwfw-e-item-stock qwfw--in-stock">Còn
                                                                    hàng</span>
                                                            @endif
                                                        @else
                                                            @if ($item->product->quantity <= 0)
                                                                <span class="qwfw-e-item-stock qwfw--out-of-stock">Hết
                                                                    hàng</span>
                                                            @else
                                                                <span class="qwfw-e-item-stock qwfw--in-stock">Còn
                                                                    hàng</span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="qwfw-e-item product-add-to-cart">
                                                    <div class="qwfw-e-item-inner">
                                                        <form method="POST" action="{{ route('client.cart.add') }}">
                                                            @csrf
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $item->product->id }}">
                                                            @if ($variation)
                                                                <input type="hidden" name="variation_id"
                                                                    value="{{ $variation->id }}">
                                                            @endif
                                                            <input type="hidden" name="quantity" value="1">
                                                            <button type="submit"
                                                                class="single_add_to_cart_button button alt"
                                                                style="min-width:180px;min-height:48px;font-size:15px;letter-spacing:1px;white-space:nowrap;text-transform:uppercase;border:1.5px solid #222;background:#fff;color:#222;font-weight:500;box-shadow:none;outline:none;transition:background 0.2s, color 0.2s;"
                                                                @if (($variation && $variation->quantity === 0) || (!$variation && $item->product->quantity <= 0)) disabled @endif>
                                                                Thêm giỏ hàng
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6">
                                                    <div class="alert alert-info">Bạn chưa có sản phẩm yêu thích nào.</div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>

    <style>
        /* Giá sản phẩm styling cho wishlist */
        .price .original-price {
            color: #999 !important;
            text-decoration: line-through;
            font-size: 1.1em;
            margin-right: 8px;
        }

        .price .sale-price {
            color: #e74c3c !important;
            font-weight: bold;
            font-size: 1.3em;
            text-decoration: none;
        }

        .price .sale-price .woocommerce-Price-amount {
            color: #e74c3c !important;
            font-size: 1.3em;
        }

        /* Giá chính của sản phẩm (không có khuyến mãi) */
        .price .woocommerce-Price-amount {
            color: #111;
            font-weight: 600;
            font-size: 1.2em;
        }

        /* Styling cho bảng wishlist */
        .qwfw-m-items {
            width: 100%;
            border-collapse: collapse;
        }

        .qwfw-m-items th {
            background: #f8f9fa;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }

        .qwfw-m-items td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .qwfw-m-items img {
            border-radius: 4px;
            border: 1px solid #eee;
        }

        .qwfw-e-item-stock.qwfw--in-stock {
            color: #28a745;
            font-weight: 500;
        }

        .qwfw-e-item-stock.qwfw--out-of-stock {
            color: #dc3545;
            font-weight: 500;
        }
    </style>
@endsection
