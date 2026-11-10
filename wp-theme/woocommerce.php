<?php
/**
 * Wrapper for all WooCommerce archive & product pages.
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>
<main class="page-main shop-main">
	<div class="container">
		<?php woocommerce_content(); ?>
	</div>
</main>
<?php
get_footer();
