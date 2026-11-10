<?php
/**
 * Small template helpers.
 */
defined( 'ABSPATH' ) || exit;

/** Latin digits -> Persian digits */
function bzk_fa( $s ) {
	return strtr( (string) $s, array( '0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹' ) );
}

/** 191980000 -> ۱۹۱٬۹۸۰٬۰۰۰ */
function bzk_num( $n ) {
	return bzk_fa( number_format( (float) $n, 0, '.', '٬' ) );
}

/** Theme asset URL */
function bzk_img( $rel ) {
	return esc_url( BZK_URI . '/assets/img/' . ltrim( $rel, '/' ) );
}

/** Link to a section of the homepage (works from any page) */
function bzk_anchor( $id ) {
	return is_front_page() ? '#' . $id : esc_url( home_url( '/#' . $id ) );
}

/** URL of a page created by the setup (by slug), with a fallback */
function bzk_page_url( $slug, $fallback = '#' ) {
	$p = get_page_by_path( $slug );
	return $p ? esc_url( get_permalink( $p ) ) : $fallback;
}

/** URL of a product category (by slug) */
function bzk_cat_url( $slug ) {
	if ( ! taxonomy_exists( 'product_cat' ) ) {
		return '#';
	}
	$t = get_term_by( 'slug', $slug, 'product_cat' );
	if ( ! $t ) {
		return bzk_shop_url();
	}
	$l = get_term_link( $t );
	return is_wp_error( $l ) ? '#' : esc_url( $l );
}

function bzk_shop_url() {
	return function_exists( 'wc_get_page_permalink' ) ? esc_url( wc_get_page_permalink( 'shop' ) ) : esc_url( home_url( '/' ) );
}

/** Find a product by SKU */
function bzk_product( $sku ) {
	if ( ! function_exists( 'wc_get_product_id_by_sku' ) ) {
		return null;
	}
	$id = wc_get_product_id_by_sku( $sku );
	$p  = $id ? wc_get_product( $id ) : null;
	return ( $p && 'publish' === $p->get_status() ) ? $p : null;
}

function bzk_cart_count() {
	if ( function_exists( 'WC' ) && WC()->cart ) {
		return (int) WC()->cart->get_cart_contents_count();
	}
	return 0;
}

/** Price block (old + current) for a product, in toman */
function bzk_price_html( $product, $class = 'price' ) {
	if ( ! $product ) {
		return '';
	}
	$price = (float) $product->get_price();
	$reg   = (float) $product->get_regular_price();
	$out   = '<div class="' . esc_attr( $class ) . '">';
	if ( $product->is_on_sale() && $reg > $price ) {
		$out .= '<del>' . bzk_num( $reg ) . '</del>';
	}
	$out .= '<strong>' . bzk_num( $price ) . ' <small>تومان</small></strong></div>';
	return $out;
}

/** Discount percent of a product */
function bzk_off( $product ) {
	$price = (float) $product->get_price();
	$reg   = (float) $product->get_regular_price();
	return ( $product->is_on_sale() && $reg > 0 && $reg > $price ) ? (int) round( ( 1 - $price / $reg ) * 100 ) : 0;
}

/**
 * Add-to-cart attributes: simple purchasable products get AJAX add,
 * everything else links to the product page.
 */
function bzk_cart_attrs( $product ) {
	if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() ) {
		return 'data-product_id="' . esc_attr( $product->get_id() ) . '"';
	}
	return '';
}

/** Renders the add-to-cart control: <button> for AJAX products, <a> otherwise */
function bzk_cart_button( $product, $class, $inner, $label = '' ) {
	$attrs = bzk_cart_attrs( $product );
	$label = $label ? ' aria-label="' . esc_attr( $label ) . '"' : '';
	if ( $attrs ) {
		return '<button type="button" class="' . esc_attr( $class ) . ' add-cart" ' . $attrs . $label . '>' . $inner . '</button>';
	}
	$url = $product ? $product->get_permalink() : bzk_shop_url();
	return '<a class="' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '"' . $label . '>' . $inner . '</a>';
}

/** Product card used on the homepage slider and on shop archives */
function bzk_product_card( $product ) {
	if ( ! $product ) {
		return;
	}
	$badges = array_filter( array_map( 'trim', explode( '،', (string) $product->get_meta( '_bzk_badges' ) ) ) );
	$off    = bzk_off( $product );
	$img    = $product->get_image_id() ? wp_get_attachment_image_url( $product->get_image_id(), 'woocommerce_thumbnail' ) : wc_placeholder_img_src();
	$name   = $product->get_name();
	$plus   = '<svg viewBox="0 0 24 24"><path d="M12 5v14M5 12h14" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"/></svg>';
	?>
	<article class="p-card">
		<a class="p-card__media" href="<?php echo esc_url( $product->get_permalink() ); ?>">
			<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy" width="600" height="600">
			<?php if ( $off ) : ?><span class="p-card__off">٪<?php echo bzk_fa( $off ); ?></span><?php endif; ?>
			<?php if ( ! $product->is_in_stock() ) : ?><span class="p-card__off p-card__off--out">ناموجود</span><?php endif; ?>
			<?php if ( $badges ) : ?>
				<span class="p-card__badges"><?php foreach ( $badges as $b ) { echo '<span>' . esc_html( $b ) . '</span>'; } ?></span>
			<?php endif; ?>
		</a>
		<div class="p-card__body">
			<h3 class="p-card__name"><a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $name ); ?></a></h3>
			<div class="p-card__foot">
				<?php echo bzk_price_html( $product, 'p-card__price' ); // phpcs:ignore ?>
				<?php echo bzk_cart_button( $product, 'round-btn', $plus, 'افزودن ' . $name . ' به سبد' ); // phpcs:ignore ?>
			</div>
		</div>
	</article>
	<?php
}

/** Shared SVG snippets */
function bzk_svg( $name ) {
	$s = array(
		'arrow' => '<svg viewBox="0 0 24 24"><path d="M19 12H5M11 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>',
		'arrow16' => '<svg viewBox="0 0 24 24" width="16" height="16"><path d="M19 12H5M11 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	);
	return $s[ $name ] ?? '';
}
