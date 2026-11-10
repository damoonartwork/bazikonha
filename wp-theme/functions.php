<?php
/**
 * Bazikonha theme — setup, assets, WooCommerce glue.
 */
defined( 'ABSPATH' ) || exit;

define( 'BZK_DIR', get_template_directory() );
define( 'BZK_URI', get_template_directory_uri() );
define( 'BZK_VER', '1.0.0' );

require BZK_DIR . '/inc/helpers.php';
require BZK_DIR . '/inc/customizer.php';
require BZK_DIR . '/inc/woocommerce.php';
require BZK_DIR . '/inc/setup-content.php';
require BZK_DIR . '/inc/email-verify.php';

/* ---------- Theme supports ---------- */
add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'bazikonha', BZK_DIR . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 600,
		'single_image_width'    => 900,
		'product_grid'          => array( 'default_columns' => 4, 'default_rows' => 3 ),
	) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
} );

/* ---------- Assets ---------- */
function bzk_asset_ver( $rel ) {
	$f = BZK_DIR . '/' . $rel;
	return file_exists( $f ) ? BZK_VER . '.' . filemtime( $f ) : BZK_VER;
}

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'bzk-main', BZK_URI . '/assets/css/style.css', array(), bzk_asset_ver( 'assets/css/style.css' ) );
	wp_enqueue_style( 'bzk-shop', BZK_URI . '/assets/css/shop.css', array( 'bzk-main' ), bzk_asset_ver( 'assets/css/shop.css' ) );

	$deps = array();
	if ( is_front_page() ) {
		wp_enqueue_script( 'gsap', BZK_URI . '/assets/js/vendor/gsap.min.js', array(), '3.12.5', true );
		wp_enqueue_script( 'gsap-st', BZK_URI . '/assets/js/vendor/ScrollTrigger.min.js', array( 'gsap' ), '3.12.5', true );
		wp_enqueue_script( 'lenis', BZK_URI . '/assets/js/vendor/lenis.min.js', array(), '1.1.13', true );
		$deps = array( 'gsap', 'gsap-st', 'lenis' );
	}
	wp_enqueue_script( 'bzk-main', BZK_URI . '/assets/js/main.js', $deps, bzk_asset_ver( 'assets/js/main.js' ), true );
	wp_localize_script( 'bzk-main', 'BZK', array(
		'theme'   => BZK_URI,
		'wcAjax'  => class_exists( 'WC_AJAX' ) ? WC_AJAX::get_endpoint( '%%endpoint%%' ) : '',
		'cartUrl' => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '',
		'added'   => 'به سبد خرید اضافه شد ✓',
		'error'   => 'افزودن به سبد انجام نشد؛ دوباره تلاش کن.',
		'viewCart'=> 'مشاهده سبد',
	) );
}, 20 );

/* Preload hero assets on the front page only */
add_action( 'wp_head', function () {
	echo '<meta name="theme-color" content="#061012">' . "\n";
	echo '<link rel="icon" type="image/png" href="' . esc_url( BZK_URI . '/assets/img/brand/favicon.png' ) . '">' . "\n";
	echo '<link rel="apple-touch-icon" href="' . esc_url( BZK_URI . '/assets/img/brand/apple-touch-icon.png' ) . '">' . "\n";
	echo '<link rel="preload" href="' . esc_url( BZK_URI . '/assets/fonts/vazirmatn-arabic-900-normal.woff2' ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
	if ( is_front_page() ) {
		echo '<link rel="preload" href="' . esc_url( BZK_URI . '/assets/img/hero/hero-character.webp' ) . '" as="image">' . "\n";
	}
}, 2 );

/* Meta description fallback */
add_action( 'wp_head', function () {
	if ( is_front_page() ) {
		echo '<meta name="description" content="بازی‌کن‌ها؛ فروشگاه آنلاین کنسول، دسته، هدست، بازی و گیفت‌کارت با ضمانت اصالت، گارانتی و ارسال سریع.">' . "\n";
	}
}, 3 );

add_filter( 'document_title_separator', fn() => '|' );

add_filter( 'body_class', function ( $c ) {
	if ( ! is_front_page() ) {
		$c[] = 'bzk-inner';
	}
	return $c;
} );

/*
 * Fallback for domain-verification files (Enamad etc.): if a file listed in
 * site-root/ is requested but missing on the host, serve it from the theme.
 */
add_action( 'init', function () {
	$path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' ); // phpcs:ignore
	if ( ! preg_match( '/^[0-9]{4,20}\.txt$/', $path ) ) {
		return;
	}
	$file = BZK_DIR . '/verify/' . $path;
	if ( file_exists( $file ) ) {
		status_header( 200 );
		header( 'Content-Type: text/plain; charset=utf-8' );
		readfile( $file ); // phpcs:ignore
		exit;
	}
}, 0 );
