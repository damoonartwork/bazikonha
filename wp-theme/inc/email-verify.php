<?php
/**
 * Email verification for new customers.
 *
 * - After registering (My Account form) the customer is NOT logged in;
 *   a verification link is emailed instead.
 * - Login is blocked until the link is clicked — for EVERY account, old or
 *   new, except the exempt emails below and administrators (so the site owner
 *   can never be locked out).
 * - Accounts created during checkout keep their checkout session so the order
 *   isn't interrupted, but must verify before logging in next time.
 * - Clicking the link verifies the email and logs the customer in.
 */
defined( 'ABSPATH' ) || exit;

const BZK_EV_META   = '_bzk_email_verified';
const BZK_EV_TOKEN  = '_bzk_email_token';
const BZK_EV_EXPIRE = 2 * DAY_IN_SECONDS;

/** Emails that never need verification */
function bzk_ev_exempt_emails() {
	return array( 'damoon.ahmady@gmail.com' );
}

/** Has this user still to verify? */
function bzk_ev_pending( $user_id ) {
	$user = get_userdata( $user_id );
	if ( ! $user ) {
		return false;
	}
	if ( in_array( strtolower( $user->user_email ), bzk_ev_exempt_emails(), true ) || user_can( $user, 'manage_options' ) ) {
		return false;
	}
	return '1' !== (string) get_user_meta( $user_id, BZK_EV_META, true );
}

/** Send a link if the user has none yet (or it expired) — rate-limited */
function bzk_ev_maybe_send( $user_id ) {
	if ( get_transient( 'bzk_ev_wait_' . $user_id ) ) {
		return false;
	}
	$data = get_user_meta( $user_id, BZK_EV_TOKEN, true );
	if ( is_array( $data ) && ( time() - (int) $data['time'] ) < BZK_EV_EXPIRE ) {
		return false;
	}
	bzk_ev_send( $user_id );
	set_transient( 'bzk_ev_wait_' . $user_id, 1, 2 * MINUTE_IN_SECONDS );
	return true;
}

function bzk_ev_send( $user_id ) {
	$user = get_userdata( $user_id );
	if ( ! $user ) {
		return false;
	}
	$token = wp_generate_password( 32, false, false );
	update_user_meta( $user_id, BZK_EV_TOKEN, array( 'hash' => wp_hash_password( $token ), 'time' => time() ) );

	$url = add_query_arg( array( 'bzk_verify' => $token, 'u' => $user_id ), wc_get_page_permalink( 'myaccount' ) );
	$site = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );

	$body = '<p>سلام!</p>'
		. '<p>برای فعال شدن حساب کاربری‌ات در ' . esc_html( $site ) . '، روی دکمه زیر بزن:</p>'
		. '<p style="margin:28px 0"><a href="' . esc_url( $url ) . '" style="background:#d4ff2a;color:#071006;padding:14px 28px;border-radius:10px;font-weight:bold;text-decoration:none;display:inline-block">تأیید ایمیل و ورود</a></p>'
		. '<p>اگر دکمه کار نکرد، این آدرس را در مرورگر باز کن:</p>'
		. '<p style="direction:ltr;text-align:left;word-break:break-all;font-size:12px">' . esc_html( $url ) . '</p>'
		. '<p>این لینک تا ۴۸ ساعت معتبر است. اگر تو ثبت‌نام نکرده‌ای، این ایمیل را نادیده بگیر.</p>';

	$subject = 'تأیید ایمیل حساب کاربری — ' . $site;
	if ( function_exists( 'WC' ) && WC()->mailer() ) {
		$mailer = WC()->mailer();
		return $mailer->send( $user->user_email, $subject, $mailer->wrap_message( 'تأیید ایمیل', $body ) );
	}
	return wp_mail( $user->user_email, $subject, $body, array( 'Content-Type: text/html; charset=UTF-8' ) );
}

/* 1. New customer → flag + send link */
add_action( 'woocommerce_created_customer', function ( $user_id ) {
	update_user_meta( $user_id, BZK_EV_META, '0' );
	bzk_ev_send( $user_id );
	if ( ! did_action( 'woocommerce_checkout_process' ) ) {
		wc_add_notice( 'ثبت‌نام انجام شد. یک لینک تأیید به ایمیلت فرستادیم؛ روی آن بزن تا حسابت فعال شود. (پوشه Spam را هم ببین)', 'success' );
	}
}, 20 );

/* 2. Don't auto-login after My Account registration */
add_filter( 'woocommerce_registration_auth_new_customer', '__return_false' );
add_filter( 'woocommerce_registration_redirect', fn() => wc_get_page_permalink( 'myaccount' ) );

/* 3. Block login until verified */
add_filter( 'wp_authenticate_user', function ( $user ) {
	if ( $user instanceof WP_User && bzk_ev_pending( $user->ID ) ) {
		$sent   = bzk_ev_maybe_send( $user->ID );
		$resend = wp_nonce_url( add_query_arg( 'bzk_resend', $user->ID, wc_get_page_permalink( 'myaccount' ) ), 'bzk_resend_' . $user->ID );
		return new WP_Error(
			'bzk_unverified',
			( $sent ? 'برای ورود، اول ایمیلت را تأیید کن. همین الان یک لینک تأیید به ایمیلت فرستادیم (پوشه Spam را هم ببین). ' : 'ایمیلت هنوز تأیید نشده. روی لینکی که برایت ایمیل کردیم بزن. ' ) . '<a href="' . esc_url( $resend ) . '">ارسال دوباره‌ی لینک</a>'
		);
	}
	return $user;
}, 20 );

/* 4. Handle the link and the resend request */
add_action( 'template_redirect', function () {
	if ( ! function_exists( 'is_account_page' ) || ! is_account_page() ) {
		return;
	}

	// Verify
	if ( isset( $_GET['bzk_verify'], $_GET['u'] ) ) { // phpcs:ignore
		$uid   = absint( $_GET['u'] ); // phpcs:ignore
		$token = sanitize_text_field( wp_unslash( $_GET['bzk_verify'] ) ); // phpcs:ignore
		$data  = get_user_meta( $uid, BZK_EV_TOKEN, true );
		$ok    = $uid && is_array( $data ) && ( time() - (int) $data['time'] ) < BZK_EV_EXPIRE && wp_check_password( $token, $data['hash'] );

		if ( $ok ) {
			update_user_meta( $uid, BZK_EV_META, '1' );
			delete_user_meta( $uid, BZK_EV_TOKEN );
			if ( ! is_user_logged_in() ) {
				wc_set_customer_auth_cookie( $uid );
			}
			wc_add_notice( 'ایمیلت تأیید شد. به بازی‌کن‌ها خوش آمدی! 🎮', 'success' );
		} elseif ( $uid && ! bzk_ev_pending( $uid ) && get_userdata( $uid ) ) {
			wc_add_notice( 'این حساب قبلاً تأیید شده؛ می‌توانی وارد شوی.', 'notice' );
		} else {
			$resend = $uid ? wp_nonce_url( add_query_arg( 'bzk_resend', $uid, wc_get_page_permalink( 'myaccount' ) ), 'bzk_resend_' . $uid ) : '';
			wc_add_notice( 'لینک تأیید نامعتبر یا منقضی است.' . ( $resend ? ' <a href="' . esc_url( $resend ) . '">ارسال لینک جدید</a>' : '' ), 'error' );
		}
		wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
		exit;
	}

	// Resend (rate-limited)
	if ( isset( $_GET['bzk_resend'] ) ) { // phpcs:ignore
		$uid = absint( $_GET['bzk_resend'] ); // phpcs:ignore
		if ( $uid && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ?? '' ) ), 'bzk_resend_' . $uid ) && bzk_ev_pending( $uid ) ) { // phpcs:ignore
			if ( get_transient( 'bzk_ev_wait_' . $uid ) ) {
				wc_add_notice( 'لینک همین الان فرستاده شد؛ چند دقیقه صبر کن و ایمیلت (و پوشه Spam) را ببین.', 'notice' );
			} else {
				bzk_ev_send( $uid );
				set_transient( 'bzk_ev_wait_' . $uid, 1, 2 * MINUTE_IN_SECONDS );
				wc_add_notice( 'لینک تأیید دوباره ارسال شد.', 'success' );
			}
		}
		wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
		exit;
	}
} );

/* 4b. Already logged-in but unverified (old sessions) → log out on the account page */
add_action( 'template_redirect', function () {
	if ( ! is_user_logged_in() || ! function_exists( 'is_account_page' ) || ! is_account_page() || isset( $_GET['bzk_verify'] ) ) { // phpcs:ignore
		return;
	}
	$uid = get_current_user_id();
	if ( ! bzk_ev_pending( $uid ) || ! empty( WC()->session ) && WC()->session->get( 'bzk_checkout_account' ) ) {
		return;
	}
	$sent = bzk_ev_maybe_send( $uid );
	wp_logout();
	if ( WC()->session ) {
		WC()->session->set_customer_session_cookie( true );
	}
	wc_add_notice( ( $sent ? 'برای ادامه، ایمیلت را تأیید کن؛ یک لینک تأیید برایت فرستادیم.' : 'برای ادامه، ایمیلت را با لینکی که برایت فرستادیم تأیید کن.' ) . ' (پوشه Spam را هم ببین)', 'notice' );
	wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
	exit;
}, 5 );

/* Accounts made at checkout may see their order in this session */
add_action( 'woocommerce_created_customer', function () {
	if ( did_action( 'woocommerce_checkout_process' ) && WC()->session ) {
		WC()->session->set( 'bzk_checkout_account', 1 );
	}
}, 30 );

/* 5. Reminder inside My Account for checkout-created, still unverified accounts */
add_action( 'woocommerce_account_content', function () {
	$uid = get_current_user_id();
	if ( $uid && bzk_ev_pending( $uid ) ) {
		$resend = wp_nonce_url( add_query_arg( 'bzk_resend', $uid, wc_get_page_permalink( 'myaccount' ) ), 'bzk_resend_' . $uid );
		echo '<div class="woocommerce-info">ایمیلت هنوز تأیید نشده؛ برای ورودهای بعدی لازم است. <a href="' . esc_url( $resend ) . '">ارسال لینک تأیید</a></div>';
	}
}, 5 );

/* 6. Admin: show status in Users list */
add_filter( 'manage_users_columns', function ( $c ) {
	$c['bzk_ev'] = 'تأیید ایمیل';
	return $c;
} );
add_filter( 'manage_users_custom_column', function ( $out, $col, $uid ) {
	if ( 'bzk_ev' !== $col ) {
		return $out;
	}
	if ( ! bzk_ev_pending( $uid ) ) {
		return '1' === (string) get_user_meta( $uid, BZK_EV_META, true ) ? '✅ تأیید شده' : '— معاف';
	}
	return '⏳ در انتظار';
}, 10, 3 );

/* Drop WooCommerce's own "account created / login details sent" notice — ours replaces it */
add_filter( 'woocommerce_add_success', function ( $msg ) {
	$wc = __( 'Your account was created successfully. Your login details have been sent to your email address.', 'woocommerce' );
	$wc2 = __( 'Your account was created successfully and a password has been sent to your email address.', 'woocommerce' );
	return ( $msg === $wc || $msg === $wc2 ) ? '' : $msg;
} );
