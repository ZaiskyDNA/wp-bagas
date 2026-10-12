<?php
/**
 * Data demo untuk penguji (PRD 12.4): 1 akun pelanggan + 2 pesanan contoh.
 * Idempoten: lewati pembuatan bila pesanan demo sudah ada.
 * Dijalankan via: wp eval-file seed-demo.php
 *
 * Password demo diambil dari env BAGUS_DEMO_PASSWORD (default: DemoBagus123!).
 * Akun ini hanya untuk demo — aman didokumentasikan di docs/demo-accounts.md.
 *
 * @package bagus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'WooCommerce' ) ) {
	WP_CLI::error( 'WooCommerce tidak aktif.' );
}

$email = 'demo@bagus-outdoor.id';
$pass  = getenv( 'BAGUS_DEMO_PASSWORD' ) ?: 'DemoBagus123!';

// --- 1. Akun pelanggan demo -------------------------------------------------
$user = get_user_by( 'email', $email );
if ( ! $user ) {
	$uid = wp_insert_user(
		array(
			'user_login'   => 'demo',
			'user_email'   => $email,
			'user_pass'    => $pass,
			'role'         => 'customer',
			'first_name'   => 'Demo',
			'last_name'    => 'Pelanggan',
			'display_name' => 'Demo Pelanggan',
		)
	);
	if ( is_wp_error( $uid ) ) {
		WP_CLI::error( 'Buat user demo: ' . $uid->get_error_message() );
	}
	WP_CLI::log( "  + akun demo {$email}" );
} else {
	$uid = $user->ID;
	WP_CLI::log( "  ✓ akun demo {$email} sudah ada" );
}

$billing = array(
	'first_name' => 'Demo',
	'last_name'  => 'Pelanggan',
	'address_1'  => 'Jl. Prof. Soedarto No. 1',
	'city'       => 'Semarang',
	'state'      => 'JT',
	'postcode'   => '50275',
	'country'    => 'ID',
	'email'      => $email,
	'phone'      => '081200000000',
);
foreach ( $billing as $k => $v ) {
	update_user_meta( $uid, 'billing_' . $k, $v );
}

// --- 2. Cek apakah pesanan demo sudah ada -----------------------------------
$existing = wc_get_orders(
	array(
		'limit'      => 1,
		'meta_key'   => '_bagus_demo',
		'meta_value' => '1',
		'return'     => 'ids',
	)
);
if ( ! empty( $existing ) ) {
	WP_CLI::success( 'Data demo sudah ada (pesanan contoh tidak dibuat ulang).' );
	return;
}

/**
 * Ambil variation id dari SKU induk + slug durasi (mis. '2-hari').
 */
function bagus_demo_variation( $sku, $duration_slug ) {
	$pid = wc_get_product_id_by_sku( $sku );
	if ( ! $pid ) {
		return null;
	}
	$parent = wc_get_product( $pid );
	foreach ( $parent->get_children() as $cid ) {
		$v    = wc_get_product( $cid );
		$attr = $v->get_attributes();
		if ( isset( $attr['pa_durasi-sewa'] ) && $attr['pa_durasi-sewa'] === $duration_slug ) {
			return $v;
		}
	}
	return null;
}

/**
 * Buat satu pesanan demo.
 */
function bagus_demo_order( $uid, $billing, $lines, $shipping, $gateway, $status, $date, $tujuan ) {
	$order = wc_create_order( array( 'customer_id' => $uid ) );
	foreach ( $lines as $line ) {
		$v = bagus_demo_variation( $line[0], $line[1] );
		if ( $v ) {
			$order->add_product( $v, $line[2] );
		}
	}
	$order->set_address( $billing, 'billing' );

	$ship = new WC_Order_Item_Shipping();
	$ship->set_method_title( $shipping[0] );
	$ship->set_total( (string) $shipping[1] );
	$order->add_item( $ship );

	$titles = array( 'bacs' => 'Transfer Bank', 'cod' => 'Bayar di Tempat' );
	$order->set_payment_method( $gateway );
	$order->set_payment_method_title( $titles[ $gateway ] );

	$order->update_meta_data( '_bagus_tanggal_mulai', $date );
	$order->update_meta_data( '_bagus_tujuan', $tujuan );
	$order->update_meta_data( '_bagus_demo', '1' );

	$order->calculate_totals();
	$order->update_status( $status, 'Pesanan contoh (seed-demo).', true );
	return $order;
}

$besok  = wp_date( 'Y-m-d', strtotime( '+2 day' ) );
$besok2 = wp_date( 'Y-m-d', strtotime( '+5 day' ) );

// Pesanan 1: Transfer Bank, on-hold, ambil di basecamp.
$o1 = bagus_demo_order(
	$uid,
	$billing,
	array( array( 'TND-02', '2-hari', 1 ), array( 'SLB-01', '2-hari', 2 ) ),
	array( 'Ambil di Basecamp (Tembalang)', 0 ),
	'bacs',
	'on-hold',
	$besok,
	'Gunung Ungaran via Mawar'
);
WP_CLI::log( '  + pesanan #' . $o1->get_order_number() . ' (Transfer Bank, on-hold)' );

// Pesanan 2: COD, processing, diantar.
$o2 = bagus_demo_order(
	$uid,
	$billing,
	array( array( 'PKT-DUO', '3-hari', 1 ) ),
	array( 'Antar Area Kota Semarang', 15000 ),
	'cod',
	'processing',
	$besok2,
	'Gunung Andong'
);
WP_CLI::log( '  + pesanan #' . $o2->get_order_number() . ' (COD, processing)' );

wc_delete_product_transients();
WP_CLI::success( 'Data demo siap (akun ' . $email . ' + 2 pesanan contoh).' );
