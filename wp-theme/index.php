<?php
defined( 'ABSPATH' ) || exit;
get_header();
?>
<main class="page-main">
	<div class="container container--narrow">
		<header class="page-head">
			<span class="eyebrow">بازی‌کن‌ها</span>
			<h1 class="page-title">
				<?php
				if ( is_search() ) {
					printf( 'نتایج جستجو برای «%s»', esc_html( get_search_query() ) );
				} elseif ( is_404() ) {
					echo 'صفحه پیدا نشد';
				} else {
					echo esc_html( wp_strip_all_tags( get_the_archive_title() ?: get_bloginfo( 'name' ) ) );
				}
				?>
			</h1>
		</header>
		<div class="entry entry--text">
			<?php if ( ! is_404() && have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<article class="post-row">
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php the_excerpt(); ?>
					</article>
				<?php endwhile; ?>
				<?php the_posts_pagination(); ?>
			<?php else : ?>
				<p>چیزی پیدا نکردیم. از <a href="<?php echo bzk_shop_url(); ?>">فروشگاه</a> دیدن کن یا دوباره جستجو کن.</p>
				<p><a class="btn btn--lime" href="<?php echo esc_url( home_url( '/' ) ); ?>">بازگشت به صفحه اصلی</a></p>
			<?php endif; ?>
		</div>
	</div>
</main>
<?php
get_footer();
