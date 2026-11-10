<?php
/**
 * One-click store setup: WooCommerce settings, categories, sample products,
 * shipping, coupon and legal pages. Safe to run more than once
 * (existing items are skipped by slug / SKU).
 *
 * Runs automatically when the theme is activated, and can be re-run from
 * Appearance > «راه‌اندازی فروشگاه».
 */
defined( 'ABSPATH' ) || exit;

function bzk_demo_categories() {
	return array(
		'consoles'    => array( 'کنسول بازی', 'categories/cat-consoles.webp' ),
		'controllers' => array( 'دسته و کنترلر', 'categories/cat-controllers.webp' ),
		'headsets'    => array( 'هدست گیمینگ', 'categories/cat-headsets.webp' ),
		'games'       => array( 'بازی‌ها', 'categories/cat-games.webp' ),
		'accessories' => array( 'VR و لوازم جانبی', 'categories/cat-accessories.webp' ),
		'pc-gaming'   => array( 'موس و کیبورد گیمینگ', '' ),
		'gift-cards'  => array( 'گیفت‌کارت و اشتراک', 'categories/cat-digital.webp' ),
	);
}

/**
 * sku, slug, name, category, regular, sale, image, badges, short description
 * Prices are in toman (store currency IRT).
 */
function bzk_demo_products() {
	return array(
		array( 'BZK-PS5-SLIM', 'ps5-slim-digital', 'کنسول پلی‌استیشن ۵ اسلیم دیجیتال', 'consoles', 197980000, 191980000, 'products/product-ps5-slim.webp', 'ارسال رایگان،۱۸ ماه گارانتی', 'نسل جدید پلی‌استیشن با SSD فوق‌سریع یک ترابایتی، خروجی 4K و دسته DualSense. نسخه دیجیتال بدون درایو دیسک.' ),
		array( 'BZK-XSX', 'xbox-series-x', 'کنسول ایکس‌باکس سری X', 'consoles', 199000000, 189500000, 'products/product-xbox-series-x.webp', 'ارسال رایگان،۱۸ ماه گارانتی', 'قدرتمندترین ایکس‌باکس با ۱ ترابایت حافظه، اجرای 4K تا ۱۲۰ فریم و سازگار با Game Pass.' ),
		array( 'BZK-SWITCH-OLED', 'nintendo-switch-oled', 'کنسول نینتندو سوییچ OLED', 'consoles', 109000000, 98900000, 'products/product-switch-oled.webp', 'ارسال رایگان', 'صفحه نمایش ۷ اینچی OLED، حافظه ۶۴ گیگابایتی و پایه قابل تنظیم؛ هم دستی، هم روی تلویزیون.' ),
		array( 'BZK-DUALSENSE', 'dualsense-ps5', 'دسته DualSense پلی‌استیشن ۵', 'controllers', 19480000, 0, 'products/product-dualsense.webp', 'اورجینال', 'بازخورد لمسی و تریگرهای تطبیقی برای حس واقعی‌تر بازی؛ اتصال بی‌سیم و باتری قابل شارژ.' ),
		array( 'BZK-XBOX-CTRL', 'xbox-wireless-controller', 'دسته بی‌سیم ایکس‌باکس', 'controllers', 18200000, 16900000, 'products/product-xbox-controller.webp', 'اورجینال', 'طراحی ارگونومیک، دکمه Share و اتصال بی‌سیم و بلوتوث؛ سازگار با ایکس‌باکس، PC و موبایل.' ),
		array( 'BZK-PULSE3D', 'pulse-3d-headset', 'هدست گیمینگ PULSE 3D', 'headsets', 22800000, 0, 'products/product-pulse-headset.webp', 'صدای سه‌بعدی', 'هدست بی‌سیم رسمی PS5 با صدای سه‌بعدی Tempest و دو میکروفون حذف نویز.' ),
		array( 'BZK-DS4', 'dualshock-4', 'دسته DualShock 4 پلی‌استیشن ۴', 'controllers', 11500000, 9800000, 'products/product-dualshock4.webp', 'اورجینال', 'دسته رسمی PS4 با تاچ‌پد، نوار نوری و جک هدفون.' ),
		array( 'BZK-CHARGE-PS5', 'ps5-charging-station', 'پایه شارژ دوتایی دسته PS5', 'accessories', 6480000, 0, 'products/product-charging-station.webp', 'پرفروش', 'شارژ هم‌زمان دو دسته DualSense بدون نیاز به روشن بودن کنسول.' ),
		array( 'BZK-CASE-PS5', 'ps5-slim-case', 'کیف حمل کنسول PS5 اسلیم', 'accessories', 5900000, 4980000, 'products/product-ps5-case.webp', 'ضد ضربه', 'کیف ضد ضربه با جای مخصوص کنسول، دو دسته و کابل‌ها.' ),
		array( 'BZK-XBOX-BATT', 'xbox-rechargeable-battery', 'باتری قابل شارژ دسته ایکس‌باکس', 'accessories', 3680000, 0, 'products/product-xbox-battery.webp', 'کابل USB-C', 'باتری رسمی قابل شارژ با کابل USB-C؛ خداحافظی با باتری قلمی.' ),
		array( 'BZK-GOW-PS5', 'god-of-war-ragnarok-ps5', 'دیسک بازی God of War Ragnarök برای PS5', 'games', 11980000, 8980000, 'products/product-game-ps5.webp', 'ارسال رایگان', 'ماجرای کریتوس و آترئوس در دنیای اساطیر نورس؛ نسخه دیسکی اورجینال.' ),
		array( 'BZK-GEARS-XBOX', 'gears-of-war-xbox', 'دیسک بازی Gears of War برای ایکس‌باکس', 'games', 7480000, 6480000, 'products/product-game-xbox.webp', 'ارسال رایگان', 'بازی اکشن سوم‌شخص محبوب ایکس‌باکس؛ نسخه دیسکی اورجینال.' ),
	);
}

/** Gift cards: virtual products. sku, slug, name, price, image, sub, hot label */
function bzk_demo_giftcards() {
	return array(
		array( 'BZK-GC-PSN10', 'psn-gift-card-10', 'PlayStation Store 10$', 790000, 'gift-cards/gift-psn.webp', 'ریجن آمریکا · ۱۰ دلار', 'پرفروش' ),
		array( 'BZK-GC-PSPLUS', 'ps-plus-essential-1m', 'PS Plus Essential', 1290000, 'gift-cards/gift-ps-plus.webp', 'اشتراک یک‌ماهه اسنشال', '' ),
		array( 'BZK-GC-GAMEPASS', 'xbox-game-pass-ultimate-1m', 'Xbox Game Pass Ultimate', 1480000, 'gift-cards/gift-game-pass.webp', 'آلتیمیت · یک‌ماهه', '' ),
		array( 'BZK-GC-STEAM5', 'steam-wallet-5', 'Steam Wallet 5$', 420000, 'gift-cards/gift-steam.webp', 'کیف پول استیم · ۵ دلار', 'محبوب' ),
		array( 'BZK-GC-ESHOP10', 'nintendo-eshop-10', 'Nintendo eShop 10$', 810000, 'gift-cards/gift-eshop.webp', 'ریجن آمریکا · ۱۰ دلار', '' ),
		array( 'BZK-GC-COD500', 'call-of-duty-points-500', 'Call of Duty Points 500', 390000, 'gift-cards/gift-cod.webp', '۵۰۰ پوینت', '' ),
	);
}

/** Copy an image from the theme into the media library (once). */
function bzk_import_image( $rel ) {
	if ( ! $rel ) {
		return 0;
	}
	$map = get_option( 'bzk_img_map', array() );
	if ( ! empty( $map[ $rel ] ) && get_post( $map[ $rel ] ) ) {
		return (int) $map[ $rel ];
	}
	$file = BZK_DIR . '/assets/img/' . $rel;
	if ( ! file_exists( $file ) ) {
		return 0;
	}
	$up = wp_upload_bits( basename( $file ), null, file_get_contents( $file ) ); // phpcs:ignore
	if ( ! empty( $up['error'] ) ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$type = wp_check_filetype( $up['file'] );
	$id   = wp_insert_attachment( array(
		'post_mime_type' => $type['type'],
		'post_title'     => sanitize_title( pathinfo( $file, PATHINFO_FILENAME ) ),
		'post_status'    => 'inherit',
	), $up['file'] );
	if ( $id && ! is_wp_error( $id ) ) {
		wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $up['file'] ) );
		$map[ $rel ] = $id;
		update_option( 'bzk_img_map', $map, false );
		return $id;
	}
	return 0;
}

function bzk_upsert_page( $slug, $title, $content ) {
	$p = get_page_by_path( $slug );
	if ( $p ) {
		return $p->ID;
	}
	return wp_insert_post( array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_name'    => $slug,
		'post_title'   => $title,
		'post_content' => $content,
	) );
}

function bzk_run_setup() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return new WP_Error( 'no_wc', 'ووکامرس فعال نیست.' );
	}
	@set_time_limit( 300 ); // phpcs:ignore
	$log = array();

	/* --- 1. Store settings --- */
	$opts = array(
		'woocommerce_currency'                => 'IRT',
		'woocommerce_currency_pos'            => 'right_space',
		'woocommerce_price_num_decimals'      => 0,
		'woocommerce_price_thousand_sep'      => '٬',
		'woocommerce_price_decimal_sep'       => '.',
		'woocommerce_default_country'         => 'IR:THR',
		'woocommerce_allowed_countries'       => 'specific',
		'woocommerce_specific_allowed_countries' => array( 'IR' ),
		'woocommerce_ship_to_countries'       => '',
		'woocommerce_calc_taxes'              => 'no',
		'woocommerce_enable_coupons'          => 'yes',
		'woocommerce_enable_guest_checkout'   => 'yes',
		'woocommerce_enable_signup_and_login_from_checkout' => 'yes',
		'woocommerce_enable_myaccount_registration' => 'yes',
		'woocommerce_registration_generate_password' => 'no',
		'woocommerce_weight_unit'             => 'kg',
		'woocommerce_coming_soon'             => 'no',
		'woocommerce_checkout_phone_field'    => 'required',
		'woocommerce_checkout_company_field'  => 'hidden',
		'woocommerce_checkout_address_2_field' => 'hidden',
		'woocommerce_checkout_privacy_policy_text' => 'اطلاعات شما فقط برای پردازش سفارش و پشتیبانی استفاده می‌شود. جزئیات در [privacy_policy] آمده است.',
		'woocommerce_registration_privacy_policy_text' => 'اطلاعات شما طبق [privacy_policy] نگهداری می‌شود.',
		'woocommerce_checkout_terms_and_conditions_checkbox_text' => '[terms] را خوانده‌ام و می‌پذیرم',
		'woocommerce_store_pages_only'        => 'no',
		'woocommerce_onboarding_profile'      => array( 'skipped' => true, 'completed' => true ),
	);
	foreach ( $opts as $k => $v ) {
		update_option( $k, $v );
	}
	$log[] = 'تنظیمات فروشگاه (تومان، ایران)';

	/* --- 2. WooCommerce pages as classic shortcodes (needed by Iranian payment gateways) --- */
	if ( class_exists( 'WC_Install' ) ) {
		WC_Install::create_pages();
	}
	$wc_pages = array(
		'cart'      => array( '[woocommerce_cart]', 'سبد خرید' ),
		'checkout'  => array( '[woocommerce_checkout]', 'تسویه حساب' ),
		'myaccount' => array( '[woocommerce_my_account]', 'حساب کاربری' ),
	);
	foreach ( $wc_pages as $page => $d ) {
		$id = wc_get_page_id( $page );
		if ( $id > 0 ) {
			wp_update_post( array(
				'ID'           => $id,
				'post_title'   => $d[1],
				'post_content' => '<!-- wp:shortcode -->' . $d[0] . '<!-- /wp:shortcode -->',
			) );
		}
	}
	$shop_id = wc_get_page_id( 'shop' );
	if ( $shop_id > 0 ) {
		wp_update_post( array( 'ID' => $shop_id, 'post_title' => 'فروشگاه', 'post_name' => 'shop' ) );
	}
	$log[] = 'صفحه‌های سبد خرید، تسویه‌حساب و حساب کاربری';

	/* --- 3. Categories --- */
	$cat_ids = array();
	$i       = 0;
	foreach ( bzk_demo_categories() as $slug => $c ) {
		$t = get_term_by( 'slug', $slug, 'product_cat' );
		if ( ! $t ) {
			$r = wp_insert_term( $c[0], 'product_cat', array( 'slug' => $slug ) );
			$tid = is_wp_error( $r ) ? 0 : $r['term_id'];
		} else {
			$tid = $t->term_id;
		}
		if ( $tid ) {
			$cat_ids[ $slug ] = $tid;
			update_term_meta( $tid, 'order', $i++ );
			if ( $c[1] && ! get_term_meta( $tid, 'thumbnail_id', true ) ) {
				$img = bzk_import_image( $c[1] );
				if ( $img ) {
					update_term_meta( $tid, 'thumbnail_id', $img );
				}
			}
		}
	}
	$log[] = count( $cat_ids ) . ' دسته‌بندی';

	/* --- 4. Physical products --- */
	$made = 0;
	$order = 0;
	foreach ( bzk_demo_products() as $p ) {
		list( $sku, $slug, $name, $cat, $reg, $sale, $img, $badges, $desc ) = $p;
		$order++;
		if ( wc_get_product_id_by_sku( $sku ) ) {
			continue;
		}
		$prod = new WC_Product_Simple();
		$prod->set_name( $name );
		$prod->set_slug( $slug );
		$prod->set_sku( $sku );
		$prod->set_status( 'publish' );
		$prod->set_menu_order( $order );
		$prod->set_regular_price( (string) $reg );
		if ( $sale ) {
			$prod->set_sale_price( (string) $sale );
		}
		$prod->set_short_description( $desc );
		$prod->set_description( $desc . "\n\nکالا اورجینال و پلمب است و با ضمانت اصالت ارسال می‌شود." );
		$prod->set_manage_stock( true );
		$prod->set_stock_quantity( 10 );
		$prod->set_weight( 'consoles' === $cat ? '5' : '1' );
		if ( isset( $cat_ids[ $cat ] ) ) {
			$prod->set_category_ids( array( $cat_ids[ $cat ] ) );
		}
		$img_id = bzk_import_image( $img );
		if ( $img_id ) {
			$prod->set_image_id( $img_id );
		}
		$prod->update_meta_data( '_bzk_badges', $badges );
		$prod->save();
		$made++;
	}

	/* --- 5. Gift cards (virtual, no shipping) --- */
	foreach ( bzk_demo_giftcards() as $g ) {
		list( $sku, $slug, $name, $price, $img, $sub, $hot ) = $g;
		$order++;
		if ( wc_get_product_id_by_sku( $sku ) ) {
			continue;
		}
		$prod = new WC_Product_Simple();
		$prod->set_name( $name );
		$prod->set_slug( $slug );
		$prod->set_sku( $sku );
		$prod->set_status( 'publish' );
		$prod->set_menu_order( $order );
		$prod->set_virtual( true );
		$prod->set_regular_price( (string) $price );
		$prod->set_short_description( 'گیفت‌کارت قانونی و معتبر — ' . $sub . '. کد بعد از تأیید پرداخت ارسال می‌شود.' );
		$prod->set_description( 'گیفت‌کارت قانونی و معتبر — ' . $sub . ".\n\nبعد از تأیید پرداخت، کد در بخش سفارش‌های حساب کاربری و ایمیل شما ارسال می‌شود. تا فعال‌سازی کنارتان هستیم." );
		if ( isset( $cat_ids['gift-cards'] ) ) {
			$prod->set_category_ids( array( $cat_ids['gift-cards'] ) );
		}
		$img_id = bzk_import_image( $img );
		if ( $img_id ) {
			$prod->set_image_id( $img_id );
		}
		$prod->update_meta_data( '_bzk_sub', $sub );
		$prod->update_meta_data( '_bzk_hot', $hot );
		$prod->update_meta_data( '_bzk_badges', 'تحویل دیجیتال' );
		$prod->save();
		$made++;
	}
	$log[] = $made . ' محصول جدید';

	/* --- 6. Shipping: Iran — flat 80,000 toman, free above 5,000,000 --- */
	if ( class_exists( 'WC_Shipping_Zone' ) && ! get_option( 'bzk_shipping_done' ) ) {
		$zone = new WC_Shipping_Zone();
		$zone->set_zone_name( 'ایران' );
		$zone->set_zone_order( 1 );
		$zone->add_location( 'IR', 'country' );
		$zone->save();

		$flat = $zone->add_shipping_method( 'flat_rate' );
		update_option( 'woocommerce_flat_rate_' . $flat . '_settings', array(
			'title'      => 'پست پیشتاز',
			'tax_status' => 'none',
			'cost'       => '80000',
		) );
		$free = $zone->add_shipping_method( 'free_shipping' );
		update_option( 'woocommerce_free_shipping_' . $free . '_settings', array(
			'title'            => 'ارسال رایگان (خرید بالای ۵ میلیون تومان)',
			'requires'         => 'min_amount',
			'min_amount'       => '5000000',
			'ignore_discounts' => 'no',
		) );
		update_option( 'bzk_shipping_done', 1 );
		$log[] = 'روش‌های ارسال';
	}

	/* --- 7. Coupon from the homepage --- */
	if ( ! wc_get_coupon_id_by_code( 'BAZIKON10' ) ) {
		$cp = new WC_Coupon();
		$cp->set_code( 'BAZIKON10' );
		$cp->set_description( 'تخفیف ۱۰٪ اولین خرید' );
		$cp->set_discount_type( 'percent' );
		$cp->set_amount( 10 );
		$cp->set_individual_use( true );
		$cp->set_usage_limit_per_user( 1 );
		$cp->save();
		$log[] = 'کد تخفیف BAZIKON10';
	}

	/* --- 8. Info pages (Enamad needs about / contact / terms) --- */
	$about = bzk_upsert_page( 'about', 'درباره‌ی ما', bzk_tpl_about() );
	$contact = bzk_upsert_page( 'contact', 'تماس با ما', bzk_tpl_contact() );
	$terms = bzk_upsert_page( 'terms', 'قوانین و مقررات', bzk_tpl_terms() );
	$privacy = bzk_upsert_page( 'privacy', 'حریم خصوصی', bzk_tpl_privacy() );
	$returns = bzk_upsert_page( 'returns', 'شرایط مرجوعی', bzk_tpl_returns() );
	$track = bzk_upsert_page( 'track-order', 'پیگیری سفارش', '<!-- wp:shortcode -->[woocommerce_order_tracking]<!-- /wp:shortcode -->' );
	update_option( 'woocommerce_terms_page_id', $terms );
	update_option( 'wp_page_for_privacy_policy', $privacy );
	$log[] = 'صفحه‌های درباره ما، تماس، قوانین، حریم خصوصی، مرجوعی، پیگیری سفارش';

	/* --- 9. Clean demo WordPress content + pretty URLs --- */
	foreach ( array( 'hello-world' => 'post', 'sample-page' => 'page' ) as $slug => $type ) {
		$p = get_page_by_path( $slug, OBJECT, $type );
		if ( $p ) {
			wp_trash_post( $p->ID );
		}
	}
	update_option( 'show_on_front', 'posts' ); // front-page.php renders the homepage
	update_option( 'blogname', 'بازی‌کن‌ها' );
	update_option( 'blogdescription', 'فروشگاه تجهیزات گیمینگ' );
	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}
	flush_rewrite_rules();

	update_option( 'bzk_setup_done', time() );
	return $log;
}

/* Auto-run on theme activation */
add_action( 'after_switch_theme', function () {
	if ( class_exists( 'WooCommerce' ) && ! get_option( 'bzk_setup_done' ) ) {
		$r = bzk_run_setup();
		set_transient( 'bzk_setup_log', is_wp_error( $r ) ? $r->get_error_message() : $r, 600 );
	}
} );

/* Admin page: Appearance > راه‌اندازی فروشگاه */
add_action( 'admin_menu', function () {
	add_theme_page( 'راه‌اندازی فروشگاه', 'راه‌اندازی فروشگاه', 'manage_options', 'bzk-setup', 'bzk_setup_page' );
} );

add_action( 'admin_post_bzk_setup', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'دسترسی ندارید.' );
	}
	check_admin_referer( 'bzk_setup' );
	$r = bzk_run_setup();
	set_transient( 'bzk_setup_log', is_wp_error( $r ) ? $r->get_error_message() : $r, 600 );
	wp_safe_redirect( admin_url( 'themes.php?page=bzk-setup' ) );
	exit;
} );

function bzk_setup_page() {
	$log = get_transient( 'bzk_setup_log' );
	echo '<div class="wrap"><h1>راه‌اندازی فروشگاه بازی‌کن‌ها</h1>';
	if ( $log ) {
		echo '<div class="notice notice-success"><p><strong>انجام شد:</strong></p><ul style="list-style:disc;padding-inline-start:20px">';
		foreach ( (array) $log as $l ) {
			echo '<li>' . esc_html( $l ) . '</li>';
		}
		echo '</ul></div>';
		delete_transient( 'bzk_setup_log' );
	}
	if ( ! class_exists( 'WooCommerce' ) ) {
		echo '<div class="notice notice-error"><p>اول افزونه ووکامرس را نصب و فعال کنید.</p></div></div>';
		return;
	}
	$done = get_option( 'bzk_setup_done' );
	echo '<p>این دکمه تنظیمات فروشگاه (تومان، ایران)، دسته‌بندی‌ها، محصولات نمونه، گیفت‌کارت‌ها، روش ارسال، کد تخفیف و صفحه‌های قوانین و تماس را می‌سازد. موارد موجود دوباره ساخته نمی‌شوند.</p>';
	echo $done ? '<p>آخرین اجرا: ' . esc_html( wp_date( 'Y/m/d H:i', $done ) ) . '</p>' : '';
	echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	wp_nonce_field( 'bzk_setup' );
	echo '<input type="hidden" name="action" value="bzk_setup">';
	submit_button( $done ? 'اجرای دوباره' : 'راه‌اندازی فروشگاه' );
	echo '</form></div>';
}

/* Reminder notice until the setup has run */
add_action( 'admin_notices', function () {
	if ( get_option( 'bzk_setup_done' ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	echo '<div class="notice notice-info"><p>قالب بازی‌کن‌ها: برای ساخت محصولات و صفحه‌ها <a href="' . esc_url( admin_url( 'themes.php?page=bzk-setup' ) ) . '">راه‌اندازی فروشگاه</a> را بزنید.</p></div>';
} );

/* ---------- Page contents ---------- */
function bzk_tpl_about() {
	return '<!-- wp:paragraph --><p>بازی‌کن‌ها فروشگاه تخصصی تجهیزات گیمینگ است؛ از کنسول و دسته تا هدست، بازی و گیفت‌کارت. ما خودمان گیمر هستیم و می‌دانیم یک خرید مطمئن چقدر مهم است.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2>چرا بازی‌کن‌ها؟</h2><!-- /wp:heading -->
<!-- wp:list --><ul><li>همه‌ی کالاها اورجینال و پلمب، با ضمانت اصالت</li><li>ارسال سریع به سراسر ایران</li><li>پرداخت امن از درگاه بانکی</li><li>پشتیبانی قبل و بعد از خرید</li></ul><!-- /wp:list -->';
}

function bzk_tpl_contact() {
	return '<!-- wp:paragraph --><p>سوالی داری؟ از راه‌های زیر با ما در ارتباط باش؛ در ساعت کاری پاسخگو هستیم.</p><!-- /wp:paragraph -->
<!-- wp:shortcode -->[bzk_contact]<!-- /wp:shortcode -->';
}

function bzk_tpl_terms() {
	return '<!-- wp:paragraph --><p>استفاده از خدمات و خرید از فروشگاه بازی‌کن‌ها به معنی پذیرش قوانین زیر است.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2>ثبت سفارش</h2><!-- /wp:heading -->
<!-- wp:list --><ul><li>قیمت‌ها به تومان و شامل همه‌ی هزینه‌ها به جز هزینه‌ی ارسال است.</li><li>سفارش پس از پرداخت موفق ثبت و پردازش می‌شود.</li><li>در صورت ناموجود شدن کالا پس از پرداخت، کل مبلغ ظرف ۷۲ ساعت کاری بازگردانده می‌شود.</li></ul><!-- /wp:list -->
<!-- wp:heading --><h2>ارسال</h2><!-- /wp:heading -->
<!-- wp:list --><ul><li>سفارش‌ها با پست پیشتاز ارسال می‌شوند؛ تهران معمولاً ۱ روز و سایر شهرها ۲ تا ۴ روز کاری.</li><li>برای خریدهای بالای ۵ میلیون تومان ارسال رایگان است.</li></ul><!-- /wp:list -->
<!-- wp:heading --><h2>گیفت‌کارت و محصولات دیجیتال</h2><!-- /wp:heading -->
<!-- wp:list --><ul><li>کد پس از تأیید پرداخت در حساب کاربری و ایمیل شما ارسال می‌شود.</li><li>به دلیل ماهیت دیجیتال، کد ارسال‌شده قابل بازگشت نیست مگر کد نامعتبر باشد.</li><li>به ریجن (منطقه) گیفت‌کارت و حساب خود دقت کنید.</li></ul><!-- /wp:list -->
<!-- wp:heading --><h2>گارانتی و مرجوعی</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>شرایط بازگشت کالا در صفحه‌ی «شرایط مرجوعی» آمده است. کنسول‌ها دارای گارانتی معتبر هستند.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2>حریم خصوصی</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>اطلاعات شما فقط برای پردازش سفارش استفاده می‌شود و در اختیار شخص ثالث قرار نمی‌گیرد.</p><!-- /wp:paragraph -->';
}

function bzk_tpl_privacy() {
	return '<!-- wp:paragraph --><p>حفظ اطلاعات شخصی کاربران برای ما مهم است.</p><!-- /wp:paragraph -->
<!-- wp:list --><ul><li>نام، شماره تماس، ایمیل و آدرس فقط برای ثبت و ارسال سفارش دریافت می‌شود.</li><li>اطلاعات پرداخت مستقیماً در درگاه امن بانکی وارد می‌شود و ما به اطلاعات کارت شما دسترسی نداریم.</li><li>اطلاعات شما بدون اجازه در اختیار شخص یا سازمان دیگری قرار نمی‌گیرد، مگر به حکم قانون.</li><li>این سایت برای نگه‌داشتن سبد خرید و ورود به حساب از کوکی استفاده می‌کند.</li></ul><!-- /wp:list -->';
}

function bzk_tpl_returns() {
	return '<!-- wp:list --><ul><li>تا ۷ روز پس از تحویل، در صورت مغایرت کالا با سفارش یا ایراد فنی، امکان بازگشت وجود دارد.</li><li>کالا باید در بسته‌بندی اصلی و بدون استفاده باشد (به جز موارد ایراد فنی).</li><li>هزینه‌ی ارسال مرجوعی در صورت ایراد از سمت فروشگاه، بر عهده‌ی ماست.</li><li>گیفت‌کارت‌ها و کدهای دیجیتال پس از ارسال قابل بازگشت نیستند، مگر کد نامعتبر باشد.</li><li>برای ثبت مرجوعی، شماره سفارش را از صفحه‌ی «تماس با ما» برای پشتیبانی بفرستید.</li></ul><!-- /wp:list -->';
}
