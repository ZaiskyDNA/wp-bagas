<?php
/**
 * Pengiriman & pembayaran BAGUS (idempoten). Dijalankan via: wp eval-file setup-commerce.php
 *
 * @package bagus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ---------------------------------------------------------------------------
// 1. Shipping zone "Indonesia" + 2 metode.
// ---------------------------------------------------------------------------
$zone = null;
foreach ( WC_Shipping_Zones::get_zones() as $z ) {
	if ( 'Indonesia' === $z['zone_name'] ) {
		$zone = new WC_Shipping_Zone( $z['id'] );
		break;
	}
}
if ( ! $zone ) {
	$zone = new WC_Shipping_Zone();
	$zone->set_zone_name( 'Indonesia' );
	$zone->set_zone_order( 0 );
	$zone->add_location( 'ID', 'country' );
	$zone->save();
	WP_CLI::log( '  + shipping zone Indonesia dibuat' );
} else {
	WP_CLI::log( '  ✓ shipping zone Indonesia sudah ada' );
}

$wanted = array(
	'local_pickup' => array(
		'title'      => 'Ambil di Basecamp (Tembalang)',
		'tax_status' => 'none',
		'cost'       => '0',
	),
	'flat_rate'    => array(
		'title'      => 'Antar Area Kota Semarang',
		'tax_status' => 'none',
		'cost'       => '15000',
	),
);

$existing = array();
foreach ( $zone->get_shipping_methods() as $instance_id => $method ) {
	if ( isset( $wanted[ $method->id ] ) && ! isset( $existing[ $method->id ] ) ) {
		$existing[ $method->id ] = $instance_id;
	} else {
		$zone->delete_shipping_method( $instance_id ); // Buang metode lain / duplikat.
	}
}

$order = 1;
foreach ( $wanted as $method_id => $settings ) {
	$instance_id = $existing[ $method_id ] ?? $zone->add_shipping_method( $method_id );
	$method      = WC_Shipping_Zones::get_shipping_method( $instance_id );
	$current     = (array) get_option( $method->get_instance_option_key(), array() );
	update_option( $method->get_instance_option_key(), array_merge( $current, $settings ) );

	global $wpdb;
	$wpdb->update(
		"{$wpdb->prefix}woocommerce_shipping_zone_methods",
		array(
			'is_enabled'   => 1,
			'method_order' => $order++,
		),
		array( 'instance_id' => $instance_id )
	);
	WP_CLI::log( "  ✓ {$settings['title']} (Rp {$settings['cost']})" );
}

// Zona "Locations not covered": tanpa metode (pengunjung luar Indonesia tidak bisa checkout).
$rest = new WC_Shipping_Zone( 0 );
foreach ( array_keys( $rest->get_shipping_methods() ) as $instance_id ) {
	$rest->delete_shipping_method( $instance_id );
}
WC_Cache_Helper::get_transient_version( 'shipping', true );

// ---------------------------------------------------------------------------
// 2. Payment gateway: Transfer Bank (BACS) + Bayar di Tempat (COD).
// ---------------------------------------------------------------------------
$bacs_text = 'Transfer ke Bank BCA 1234567890 a.n. Bagus Pratama. Setelah transfer, kirim bukti pembayaran ke CS BAGUS via WhatsApp agar pesananmu segera diproses.';

update_option(
	'woocommerce_bacs_settings',
	array_merge(
		(array) get_option( 'woocommerce_bacs_settings', array() ),
		array(
			'enabled'      => 'yes',
			'title'        => 'Transfer Bank',
			'description'  => 'Transfer ke rekening BCA BAGUS. Nomor rekening tampil setelah pesanan dibuat.',
			'instructions' => $bacs_text,
		)
	)
);
update_option(
	'woocommerce_bacs_accounts',
	array(
		array(
			'account_name'   => 'Bagus Pratama',
			'account_number' => '1234567890',
			'bank_name'      => 'BCA',
			'sort_code'      => '',
			'iban'           => '',
			'bic'            => '',
		),
	)
);

update_option(
	'woocommerce_cod_settings',
	array_merge(
		(array) get_option( 'woocommerce_cod_settings', array() ),
		array(
			'enabled'            => 'yes',
			'title'              => 'Bayar di Tempat',
			'description'        => 'Bayar tunai saat alat diambil di basecamp atau diantar ke lokasimu.',
			'instructions'       => 'Siapkan pembayaran tunai saat pengambilan/pengantaran alat. Jangan lupa bawa KTP/KTM asli sebagai jaminan.',
			'enable_for_methods' => array(),
			'enable_for_virtual' => 'yes',
		)
	)
);

// Matikan gateway lain.
foreach ( array( 'cheque', 'paypal' ) as $gw ) {
	$opt = get_option( "woocommerce_{$gw}_settings" );
	if ( is_array( $opt ) ) {
		$opt['enabled'] = 'no';
		update_option( "woocommerce_{$gw}_settings", $opt );
	}
}
update_option( 'woocommerce_gateway_order', array( 'bacs' => 0, 'cod' => 1 ) );

WP_CLI::success( 'Pengiriman & pembayaran siap.' );
