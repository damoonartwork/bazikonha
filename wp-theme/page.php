<?php
defined( 'ABSPATH' ) || exit;
get_header();
$is_wc = function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() );
?>
<main class="page-main<?php echo $is_wc ? ' shop-main' : ''; ?>">
	<div class="container<?php echo $is_wc ? '' : ' container--narrow'; ?>">
		<?php while ( have_posts() ) : the_post(); ?>
			<header class="page-head">
				<span class="eyebrow">بازی‌کن‌ها</span>
				<h1 class="page-title"><?php the_title(); ?></h1>
			</header>
			<div class="entry <?php echo $is_wc ? 'entry--wc' : 'entry--text'; ?>">
				<?php the_content(); ?>
			</div>
		<?php endwhile; ?>
	</div>
</main>
<?php
get_footer();
