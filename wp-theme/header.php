<?php defined( 'ABSPATH' ) || exit; ?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( is_front_page() ) : ?>
	<div class="preloader" id="preloader" aria-hidden="true">
		<div class="preloader__inner">
			<span class="preloader__brand">بازی‌کن‌ها</span>
			<span class="preloader__bar"><i></i></span>
			<span class="preloader__hint">LOADING&nbsp;GAME</span>
		</div>
	</div>
<?php endif; ?>

<div class="grid-lines" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></div>
<div class="grid-rows" aria-hidden="true"></div>

<header class="header" id="header">
	<div class="container header__row">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand" aria-label="بازی‌کن‌ها - صفحه اصلی">
			<img class="brand__logo" src="<?php echo bzk_img( 'brand/logo.png' ); ?>" alt="لوگوی بازی‌کن‌ها" width="734" height="369">
			<span class="brand__name">بازی‌کن‌ها</span>
		</a>

		<nav class="nav" id="nav" aria-label="منوی اصلی">
			<ul class="nav__list">
				<li class="nav__item has-drop">
					<button class="nav__link" aria-haspopup="true">دسته‌بندی‌ها
						<svg viewBox="0 0 24 24" width="14" height="14"><path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
					</button>
					<div class="drop">
						<?php
						$cats = taxonomy_exists( 'product_cat' ) ? get_terms( array(
							'taxonomy'   => 'product_cat',
							'hide_empty' => true,
							'parent'     => 0,
							'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
							'orderby'    => 'meta_value_num',
							'meta_key'   => 'order', // phpcs:ignore
						) ) : array();
						if ( $cats && ! is_wp_error( $cats ) ) {
							foreach ( $cats as $c ) {
								echo '<a href="' . esc_url( get_term_link( $c ) ) . '">' . esc_html( $c->name ) . '</a>';
							}
						}
						echo '<a href="' . bzk_shop_url() . '">همه‌ی محصولات</a>'; // phpcs:ignore
						?>
					</div>
				</li>
				<li class="nav__item"><a class="nav__link" href="<?php echo bzk_shop_url(); ?>">فروشگاه</a></li>
				<li class="nav__item"><a class="nav__link" href="<?php echo bzk_anchor( 'deals' ); ?>">پیشنهاد ویژه</a></li>
				<li class="nav__item"><a class="nav__link nav__link--hl" href="<?php echo bzk_cat_url( 'gift-cards' ); ?>">خرید گیفت‌کارت</a></li>
				<li class="nav__item"><a class="nav__link" href="<?php echo bzk_anchor( 'faq' ); ?>">سوالات متداول</a></li>
			</ul>
		</nav>

		<div class="header__actions">
			<button class="icon-btn" aria-label="جستجو" id="searchBtn">
				<svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7" fill="none" stroke="currentColor" stroke-width="2"/><path d="M20 20l-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
			</button>
			<a class="icon-btn cart-btn" href="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#' ); ?>" aria-label="سبد خرید">
				<svg viewBox="0 0 24 24"><path d="M3 4h2l2.2 11.2a2 2 0 0 0 2 1.6h7.9a2 2 0 0 0 2-1.5L21 8H6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20.5" r="1.4" fill="currentColor"/><circle cx="17" cy="20.5" r="1.4" fill="currentColor"/></svg>
				<span class="cart-count" id="cartCount"><?php echo bzk_fa( bzk_cart_count() ); ?></span>
			</a>
			<?php
			$acc = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url();
			$lbl = is_user_logged_in() ? 'حساب کاربری' : 'ورود / ثبت‌نام';
			?>
			<a href="<?php echo esc_url( $acc ); ?>" class="btn btn--lime btn--sm header__cta"><?php echo esc_html( $lbl ); ?></a>
			<button class="burger" id="burger" aria-label="باز کردن منو" aria-expanded="false"><span></span><span></span></button>
		</div>
	</div>

	<div class="search" id="search">
		<div class="container">
			<form class="search__box" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="جستجوی کالا… مثلاً دسته PS5" aria-label="جستجوی کالا">
				<input type="hidden" name="post_type" value="product">
				<button class="btn btn--lime btn--sm" type="submit">جستجو</button>
			</form>
			<div class="search__tags">
				<span>جستجوهای محبوب:</span>
				<?php
				foreach ( array( 'PS5', 'DualSense', 'نینتندو', 'Steam', 'هدست' ) as $q ) {
					echo '<a href="' . esc_url( add_query_arg( array( 's' => $q, 'post_type' => 'product' ), home_url( '/' ) ) ) . '">' . esc_html( $q ) . '</a>';
				}
				?>
			</div>
		</div>
	</div>
</header>
