<?php
/**
 * Customizer: contact info + trust badges (Enamad / Samandehi).
 * Appearance > Customize > «اطلاعات فروشگاه»
 */
defined( 'ABSPATH' ) || exit;

function bzk_defaults() {
	return array(
		'bzk_phone'     => '۰۲۱-۰۰۰۰۰۰۰۰',
		'bzk_mobile'    => '۰۹۰۰-۰۰۰-۰۰۰۰',
		'bzk_email'     => 'info@bazikonha.ir',
		'bzk_address'   => 'تهران، (آدرس فروشگاه را از بخش سفارشی‌سازی وارد کنید)',
		'bzk_hours'     => 'شنبه تا پنج‌شنبه، ۱۰ تا ۱۹',
		'bzk_instagram' => '#',
		'bzk_telegram'  => '#',
		'bzk_enamad'    => '',
		'bzk_samandehi' => '',
	);
}

function bzk_opt( $key ) {
	$d = bzk_defaults();
	return get_theme_mod( $key, $d[ $key ] ?? '' );
}

add_action( 'customize_register', function ( $wp ) {
	$wp->add_section( 'bzk_shop', array(
		'title'    => 'اطلاعات فروشگاه',
		'priority' => 30,
	) );
	$fields = array(
		'bzk_phone'     => array( 'تلفن ثابت', 'text' ),
		'bzk_mobile'    => array( 'موبایل / واتساپ', 'text' ),
		'bzk_email'     => array( 'ایمیل', 'text' ),
		'bzk_address'   => array( 'آدرس', 'textarea' ),
		'bzk_hours'     => array( 'ساعت کاری', 'text' ),
		'bzk_instagram' => array( 'لینک اینستاگرام', 'url' ),
		'bzk_telegram'  => array( 'لینک تلگرام', 'url' ),
		'bzk_enamad'    => array( 'کد نماد اعتماد (اینماد) — کد HTML', 'textarea' ),
		'bzk_samandehi' => array( 'کد ساماندهی — کد HTML', 'textarea' ),
	);
	$d = bzk_defaults();
	foreach ( $fields as $id => $f ) {
		$is_code = in_array( $id, array( 'bzk_enamad', 'bzk_samandehi' ), true );
		$wp->add_setting( $id, array(
			'default'           => $d[ $id ],
			'sanitize_callback' => $is_code ? 'bzk_sanitize_badge' : ( 'url' === $f[1] ? 'esc_url_raw' : 'sanitize_textarea_field' ),
		) );
		$wp->add_control( $id, array(
			'label'   => $f[0],
			'section' => 'bzk_shop',
			'type'    => $f[1],
		) );
	}
} );

/** Trust badge codes are <a><img></a> snippets; allow only those tags. */
function bzk_sanitize_badge( $html ) {
	return wp_kses( $html, array(
		'a'   => array( 'href' => true, 'target' => true, 'referrerpolicy' => true, 'rel' => true ),
		'img' => array( 'src' => true, 'alt' => true, 'style' => true, 'code' => true, 'id' => true, 'referrerpolicy' => true, 'width' => true, 'height' => true ),
	) );
}

/** [bzk_contact] — contact card used on the contact page */
add_shortcode( 'bzk_contact', function () {
	$rows = array(
		'تلفن'      => bzk_opt( 'bzk_phone' ),
		'موبایل'    => bzk_opt( 'bzk_mobile' ),
		'ایمیل'     => bzk_opt( 'bzk_email' ),
		'آدرس'      => bzk_opt( 'bzk_address' ),
		'ساعت کاری' => bzk_opt( 'bzk_hours' ),
	);
	$out = '<div class="contact-card">';
	foreach ( $rows as $k => $v ) {
		if ( '' === trim( (string) $v ) ) {
			continue;
		}
		$val = 'ایمیل' === $k ? '<a href="mailto:' . esc_attr( $v ) . '" class="en">' . esc_html( $v ) . '</a>' : nl2br( esc_html( $v ) );
		$out .= '<div class="contact-card__row"><span>' . esc_html( $k ) . '</span><b>' . $val . '</b></div>';
	}
	return $out . '</div>';
} );
