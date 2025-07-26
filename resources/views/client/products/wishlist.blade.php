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
                                                            <img src="{{ $variation && $variation->images->first() ? $variation->images->first()->url : $item->product->images->first()->url ?? '/images/no-image.jpg' }}"
                                                                alt="{{ $item->product->name }}" width="80">
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
                                                        <span class="woocommerce-Price-amount amount">
                                                            @if ($variation)
                                                                {{ number_format($variation->sale_price ?? $variation->price, 0, ',', '.') }}₫
                                                            @else
                                                                {{ number_format($item->product->price, 0, ',', '.') }}₫
                                                            @endif
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="qwfw-e-item product-stock-status">
                                                    <div class="qwfw-e-item-inner">
                                                        <span
                                                            class="qwfw-e-item-stock {{ ($variation ? $variation->stock_quantity : $item->product->stock_quantity) > 0 ? 'qwfw--in-stock' : 'qwfw--out-of-stock' }}">
                                                            {{ ($variation ? $variation->stock_quantity : $item->product->stock_quantity) > 0 ? 'Còn hàng' : 'Hết hàng' }}
                                                        </span>
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
                                                                @if (($variation && $variation->stock_quantity <= 0) || (!$variation && $item->product->stock_quantity <= 0)) disabled @endif>
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
@endsection
