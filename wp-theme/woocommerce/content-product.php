<?php
/**
 * Product card in loops (shop, categories, related products).
 * Overrides woocommerce/templates/content-product.php
 *
 * @version 9.4.0
 */
defined( 'ABSPATH' ) || exit;
global $product;
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
bzk_product_card( $product );
