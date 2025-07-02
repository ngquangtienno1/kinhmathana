@extends('client.layouts.app')

@section('content')
    <div id="qodef-page-outer">
        <div
            class="qodef-page-title qodef-m qodef-title--standard-with-breadcrumbs qodef-alignment--left qodef-vertical-alignment--header-bottom qodef--has-image">
            <div class="qodef-m-inner">
                <div class="qodef-m-content qodef-content-grid">
                    <h1 class="qodef-m-title entry-title">
                        Giỏ hàng </h1>
                    <div itemprop="breadcrumb" class="qodef-breadcrumbs"><a itemprop="url" class="qodef-breadcrumbs-link"
                            href="../index.html"><span itemprop="title">Trang chủ</span></a><span
                            class="qodef-breadcrumbs-separator"></span><span itemprop="title"
                            class="qodef-breadcrumbs-current">Giỏ hàng</span></div>
                </div>
            </div>
        </div>
        <div id="qodef-page-inner" class="qodef-content-grid">
            <main id="qodef-page-content" class="qodef-grid qodef-layout--template " role="main">
                <div class="qodef-grid-inner clear">
                    <div class="qodef-grid-item qodef-page-content-section qodef-col--12">
                        <div class="woocommerce">
                            <div id="qodef-woo-page" class="qodef--cart">
                                <div class="woocommerce-notices-wrapper"></div>
                                <form class="woocommerce-cart-form" action="https://neoocular.qodeinteractive.com/cart/"
                                    method="post">

                                    <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents"
                                        cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="product-remove"><span class="screen-reader-text">Remove
                                                        item</span></th>
                                                <th class="product-thumbnail"><span class="screen-reader-text">Thumbnail
                                                        image</span></th>
                                                <th class="product-name">Product</th>
                                                <th class="product-price">Price</th>
                                                <th class="product-quantity">Quantity</th>
                                                <th class="product-subtotal">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr class="woocommerce-cart-form__cart-item cart_item">

                                                <td class="product-remove">
                                                    <a href="" class="remove"
                                                        aria-label="Remove Gold glasses from cart" data-product_id="253"
                                                        data-product_sku="005">&times;</a>
                                                </td>

                                                <td class="product-thumbnail">
                                                    <a href="https://neoocular.qodeinteractive.com/product/gold-glasses/"><img
                                                            fetchpriority="high" fetchpriority="high" decoding="async"
                                                            width="600" height="431"
                                                            src="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-01-img-01-600x431.jpg"
                                                            class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                            alt="m"
                                                            srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-01-img-01-600x431.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-01-img-01-300x216.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-01-img-01-768x552.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-01-img-01.jpg 800w"
                                                            sizes="(max-width: 600px) 100vw, 600px" /></a>
                                                </td>

                                                <td class="product-name" data-title="Product">
                                                    <a href="https://neoocular.qodeinteractive.com/product/gold-glasses/">Gold
                                                        glasses</a>
                                                </td>

                                                <td class="product-price" data-title="Price">
                                                    <span class="woocommerce-Price-amount amount"><bdi><span
                                                                class="woocommerce-Price-currencySymbol">&#36;</span>199.00</bdi></span>
                                                </td>

                                                <td class="product-quantity" data-title="Quantity">
                                                    <div class="qodef-quantity-buttons quantity">
                                                        <label class="screen-reader-text" for="quantity_6864021f33fdb">Gold
                                                            glasses quantity</label>
                                                        <span class="qodef-quantity-minus"></span>
                                                        <input type="text" id="quantity_6864021f33fdb"
                                                            class="input-text qty text qodef-quantity-input" data-step="1"
                                                            data-min="0" data-max=""
                                                            name="cart[c24cd76e1ce41366a4bbe8a49b02a028][qty]"
                                                            value="01" title="Qty" size="4" placeholder=""
                                                            inputmode="numeric" />
                                                        <span class="qodef-quantity-plus"></span>
                                                    </div>
                                                </td>

                                                <td class="product-subtotal" data-title="Subtotal">
                                                    <span class="woocommerce-Price-amount amount"><bdi><span
                                                                class="woocommerce-Price-currencySymbol">&#36;</span>199.00</bdi></span>
                                                </td>
                                            </tr>
                                            <tr class="woocommerce-cart-form__cart-item cart_item">

                                                <td class="product-remove">
                                                    <a href="" class="remove"
                                                        aria-label="Remove Cat Eyewear from cart" data-product_id="11595"
                                                        data-product_sku="0134">&times;</a>
                                                </td>

                                                <td class="product-thumbnail">
                                                    <a href="https://neoocular.qodeinteractive.com/product/cat-eyewear/"><img
                                                            decoding="async" width="600" height="431"
                                                            src="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-04-img-600x431.jpg"
                                                            class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                            alt="m"
                                                            srcset="https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-04-img-600x431.jpg 600w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-04-img-300x216.jpg 300w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-04-img-768x552.jpg 768w, https://neoocular.qodeinteractive.com/wp-content/uploads/2021/07/Shop-Single-04-img.jpg 800w"
                                                            sizes="(max-width: 600px) 100vw, 600px" /></a>
                                                </td>

                                                <td class="product-name" data-title="Product">
                                                    <a href="https://neoocular.qodeinteractive.com/product/cat-eyewear/">Cat
                                                        Eyewear</a>
                                                </td>

                                                <td class="product-price" data-title="Price">
                                                    <span class="woocommerce-Price-amount amount"><bdi><span
                                                                class="woocommerce-Price-currencySymbol">&#36;</span>199.00</bdi></span>
                                                </td>

                                                <td class="product-quantity" data-title="Quantity">
                                                    <div class="qodef-quantity-buttons quantity">
                                                        <label class="screen-reader-text" for="quantity_6864021f347a6">Cat
                                                            Eyewear quantity</label>
                                                        <span class="qodef-quantity-minus"></span>
                                                        <input type="text" id="quantity_6864021f347a6"
                                                            class="input-text qty text qodef-quantity-input"
                                                            data-step="1" data-min="0" data-max=""
                                                            name="cart[498bce62bd2bda584246701fa0166482][qty]"
                                                            value="01" title="Qty" size="4" placeholder=""
                                                            inputmode="numeric" />
                                                        <span class="qodef-quantity-plus"></span>
                                                    </div>
                                                </td>

                                                <td class="product-subtotal" data-title="Subtotal">
                                                    <span class="woocommerce-Price-amount amount"><bdi><span
                                                                class="woocommerce-Price-currencySymbol">&#36;</span>199.00</bdi></span>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td colspan="6" class="actions">

                                                    <div class="coupon">
                                                        <label for="coupon_code"
                                                            class="screen-reader-text">Coupon:</label> <input
                                                            type="text" name="coupon_code" class="input-text"
                                                            id="coupon_code" value="" placeholder="Coupon code" />
                                                        <button type="submit" class="button" name="apply_coupon"
                                                            value="Apply coupon">Apply coupon</button>
                                                    </div>

                                                    <button type="submit" class="button" name="update_cart"
                                                        value="Update cart">Update cart</button>


                                                    <input type="hidden" id="woocommerce-cart-nonce"
                                                        name="woocommerce-cart-nonce" value="665c378ca6" /><input
                                                        type="hidden" name="_wp_http_referer" value="/cart/" />
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </form>


                                <div class="cart-collaterals">
                                    <div class="cart_totals ">


                                        <h2>Cart totals</h2>

                                        <table cellspacing="0" class="shop_table shop_table_responsive">

                                            <tr class="cart-subtotal">
                                                <th>Subtotal</th>
                                                <td data-title="Subtotal"><span
                                                        class="woocommerce-Price-amount amount"><bdi><span
                                                                class="woocommerce-Price-currencySymbol">&#36;</span>398.00</bdi></span>
                                                </td>
                                            </tr>






                                            <tr class="order-total">
                                                <th>Total</th>
                                                <td data-title="Total"><strong><span
                                                            class="woocommerce-Price-amount amount"><bdi><span
                                                                    class="woocommerce-Price-currencySymbol">&#36;</span>398.00</bdi></span></strong>
                                                </td>
                                            </tr>


                                        </table>

                                        <div class="wc-proceed-to-checkout">

                                            <a href="https://neoocular.qodeinteractive.com/checkout/"
                                                class="checkout-button button alt wc-forward">
                                                Proceed to checkout</a>
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div><!-- close #qodef-page-inner div from header.php -->
    </div>
@endsection
