<?php defined( 'ABSPATH' ) || exit; ?>
<footer class="footer">
	<div class="container">
		<div class="footer__top">
			<div class="footer__brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand"><img class="brand__logo" src="<?php echo bzk_img( 'brand/logo.png' ); ?>" alt="" width="734" height="369"><span class="brand__name">بازی‌کن‌ها</span></a>
				<p>فروشگاه تخصصی تجهیزات گیمینگ.<br>ساخته‌شده برای گیمرها، توسط گیمرها.</p>
				<p class="footer__contact">
					<span>تلفن: <?php echo esc_html( bzk_opt( 'bzk_phone' ) ); ?></span>
					<span>ایمیل: <a class="en" href="mailto:<?php echo esc_attr( bzk_opt( 'bzk_email' ) ); ?>"><?php echo esc_html( bzk_opt( 'bzk_email' ) ); ?></a></span>
				</p>
				<div class="socials">
					<a href="<?php echo esc_url( bzk_opt( 'bzk_instagram' ) ); ?>" aria-label="اینستاگرام"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="5" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="17.5" cy="6.5" r="1.2" fill="currentColor"/></svg></a>
					<a href="<?php echo esc_url( bzk_opt( 'bzk_telegram' ) ); ?>" aria-label="تلگرام"><svg viewBox="0 0 24 24"><path d="M21 4L3 11l6 2 2 6 3-4 5 4z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg></a>
				</div>
			</div>
			<div class="footer__col"><h4>فروشگاه</h4>
				<a href="<?php echo bzk_cat_url( 'consoles' ); ?>">کنسول بازی</a>
				<a href="<?php echo bzk_cat_url( 'controllers' ); ?>">دسته و کنترلر</a>
				<a href="<?php echo bzk_cat_url( 'headsets' ); ?>">هدست گیمینگ</a>
				<a href="<?php echo bzk_cat_url( 'gift-cards' ); ?>">گیفت‌کارت</a>
			</div>
			<div class="footer__col"><h4>راهنمای خرید</h4>
				<a href="<?php echo bzk_anchor( 'installments' ); ?>">نحوه‌ی خرید</a>
				<a href="<?php echo bzk_anchor( 'faq' ); ?>">سوالات متداول</a>
				<a href="<?php echo bzk_page_url( 'track-order' ); ?>">پیگیری سفارش</a>
				<a href="<?php echo bzk_page_url( 'returns' ); ?>">شرایط مرجوعی</a>
			</div>
			<div class="footer__col"><h4>بازی‌کن‌ها</h4>
				<a href="<?php echo bzk_page_url( 'about' ); ?>">درباره‌ی ما</a>
				<a href="<?php echo bzk_page_url( 'contact' ); ?>">تماس با ما</a>
				<a href="<?php echo bzk_page_url( 'terms' ); ?>">قوانین و مقررات</a>
				<a href="<?php echo bzk_page_url( 'privacy' ); ?>">حریم خصوصی</a>
			</div>
			<div class="footer__trust">
				<?php
				foreach ( array( 'bzk_enamad' => 'نماد اعتماد', 'bzk_samandehi' => 'ساماندهی' ) as $k => $label ) {
					$code = bzk_opt( $k );
					if ( $code ) {
						echo '<span class="trust-slot trust-slot--on">' . bzk_sanitize_badge( $code ) . '</span>'; // phpcs:ignore
					} else {
						echo '<span class="trust-slot">' . esc_html( $label ) . '</span>';
					}
				}
				?>
			</div>
		</div>
		<div class="footer__bottom">
			<span>© ۱۴۰۵ بازی‌کن‌ها. تمامی حقوق محفوظ است.</span>
			<span class="en">BAZIKONHA.IR</span>
		</div>
	</div>
</footer>

<a href="#top" class="to-top" id="toTop" aria-label="بازگشت به بالا">
	<svg viewBox="0 0 24 24" width="14" height="14"><path d="M12 19V5M6 11l6-6 6 6" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
	بالای صفحه
</a>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<?php wp_footer(); ?>
</body>
</html>
