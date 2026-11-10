<?php
/**
 * WooCommerce integration.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

/* No sidebar, our own breadcrumbs style */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

add_filter( 'woocommerce_breadcrumb_defaults', function ( $d ) {
	$d['delimiter']   = '<span class="sep">/</span>';
	$d['wrap_before'] = '<nav class="crumbs" aria-label="مسیر صفحه">';
	$d['wrap_after']  = '</nav>';
	$d['home']        = 'خانه';
	return $d;
} );

add_filter( 'loop_shop_per_page', fn() => 12 );
add_filter( 'loop_shop_columns', fn() => 4 );
add_filter( 'woocommerce_output_related_products_args', function ( $a ) {
	$a['posts_per_page'] = 4;
	$a['columns']        = 4;
	return $a;
} );

/* Persian digits for every WooCommerce price */
add_filter( 'formatted_woocommerce_price', fn( $p ) => bzk_fa( $p ) );
add_filter( 'woocommerce_currency_symbol', function ( $s, $c ) {
	return 'IRT' === $c ? 'تومان' : $s;
}, 10, 2 );

/* Keep the header cart counter in sync after AJAX add-to-cart */
add_filter( 'woocommerce_add_to_cart_fragments', function ( $f ) {
	$f['span.cart-count'] = '<span class="cart-count" id="cartCount">' . bzk_fa( bzk_cart_count() ) . '</span>';
	return $f;
} );

/* Simpler Iranian checkout form */
add_filter( 'woocommerce_checkout_fields', function ( $f ) {
	unset( $f['billing']['billing_company'], $f['shipping']['shipping_company'] );
	if ( isset( $f['billing']['billing_address_2'] ) ) {
		unset( $f['billing']['billing_address_2'] );
	}
	if ( isset( $f['billing']['billing_phone'] ) ) {
		$f['billing']['billing_phone']['required'] = true;
		$f['billing']['billing_phone']['label']    = 'شماره موبایل';
	}
	return $f;
} );

/* Products with only virtual items (gift cards) don't need an address */
add_filter( 'woocommerce_checkout_fields', function ( $f ) {
	if ( ! WC()->cart || WC()->cart->needs_shipping() ) {
		return $f;
	}
	foreach ( array( 'billing_address_1', 'billing_city', 'billing_state', 'billing_postcode', 'billing_country' ) as $k ) {
		if ( isset( $f['billing'][ $k ] ) ) {
			$f['billing'][ $k ]['required'] = false;
			$f['billing'][ $k ]['class'][]  = 'bzk-hidden';
		}
	}
	return $f;
}, 20 );

/* Gift-card note on single product + thank-you page */
add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	if ( $product && $product->is_virtual() ) {
		echo '<p class="bzk-note">کد این محصول بعد از تأیید پرداخت، در بخش «سفارش‌ها»ی حساب کاربری و ایمیل شما ارسال می‌شود.</p>';
	}
}, 25 );

/* Badges under the product title on single product */
add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	if ( ! $product ) {
		return;
	}
	$badges = array_filter( array_map( 'trim', explode( '،', (string) $product->get_meta( '_bzk_badges' ) ) ) );
	if ( $badges ) {
		echo '<div class="bzk-badges">';
		foreach ( $badges as $b ) {
			echo '<span>' . esc_html( $b ) . '</span>';
		}
		echo '</div>';
	}
}, 6 );

/* Trust strip under the add-to-cart button */
add_action( 'woocommerce_single_product_summary', function () {
	echo '<ul class="bzk-trust"><li>ضمانت اصالت کالا</li><li>ارسال سریع به سراسر ایران</li><li>پرداخت امن بانکی</li></ul>';
}, 35 );

/* Category chips above product archives */
function bzk_shop_cats() {
	if ( ! is_shop() && ! is_product_category() ) {
		return;
	}
	$cats = get_terms( array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => true,
		'parent'     => 0,
		'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
		'orderby'    => 'meta_value_num',
		'meta_key'   => 'order', // phpcs:ignore
	) );
	if ( ! $cats || is_wp_error( $cats ) ) {
		return;
	}
	$cur = is_product_category() ? get_queried_object_id() : 0;
	echo '<nav class="shop-cats" aria-label="دسته‌بندی محصولات">';
	echo '<a href="' . bzk_shop_url() . '" class="' . ( $cur ? '' : 'is-on' ) . '">همه</a>'; // phpcs:ignore
	foreach ( $cats as $c ) {
		echo '<a href="' . esc_url( get_term_link( $c ) ) . '" class="' . ( $cur === $c->term_id ? 'is-on' : '' ) . '">' . esc_html( $c->name ) . '</a>';
	}
	echo '</nav>';
}
add_action( 'woocommerce_before_shop_loop', 'bzk_shop_cats', 5 );
add_action( 'woocommerce_no_products_found', 'bzk_shop_cats', 5 );

/*
 * Payment gateways (e.g. ZarinPal) redirect to the bank from the
 * "order-pay" receipt page, after the page has started printing.
 * Some hosts (LiteSpeed) send headers early, so the redirect is lost and
 * the page stops half-way. Buffering this page keeps the redirect working.
 */
add_action( 'template_redirect', function () {
	if ( function_exists( 'is_checkout_pay_page' ) && is_checkout_pay_page() && ! isset( $_GET['pay_for_order'] ) ) { // phpcs:ignore
		ob_start();
	}
}, 0 );

/*
 * If the gateway can't start the payment it only adds a notice, which the
 * receipt page never prints. Show it, plus a "try again" button.
 */
add_action( 'template_redirect', function () {
	if ( ! function_exists( 'is_checkout_pay_page' ) || ! is_checkout_pay_page() || isset( $_GET['pay_for_order'] ) ) { // phpcs:ignore
		return;
	}
	$order = wc_get_order( absint( get_query_var( 'order-pay' ) ) );
	if ( ! $order ) {
		return;
	}
	add_action( 'woocommerce_receipt_' . $order->get_payment_method(), function () use ( $order ) {
		if ( ! wc_notice_count() ) {
			return;
		}
		echo '<div class="bzk-pay-error">';
		wc_print_notices();
		echo '<p>اتصال به درگاه پرداخت انجام نشد. چند لحظه بعد دوباره تلاش کنید یا با پشتیبانی تماس بگیرید.</p>';
		echo '<a class="button" href="' . esc_url( $order->get_checkout_payment_url() ) . '">تلاش دوباره برای پرداخت</a>';
		echo '</div>';
	}, 99 );
}, 1 );
