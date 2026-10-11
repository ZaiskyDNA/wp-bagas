<?php
/**
 * Click to Chat (HoliThemes): tombol WA melayang (idempoten).
 * Nomor diambil dari konstanta BAGUS_WA_NUMBER di mu-plugin agar hanya ada satu sumber.
 * Dijalankan via: wp eval-file setup-ctc.php
 *
 * @package bagus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'BAGUS_WA_NUMBER' ) ) {
	WP_CLI::error( 'BAGUS_WA_NUMBER belum didefinisikan (mu-plugin bagus-core tidak termuat?).' );
}

$chat = array_merge(
	(array) get_option( 'ht_ctc_chat_options', array() ),
	array(
		'number'              => BAGUS_WA_NUMBER,
		'pre_filled'          => 'Halo BAGUS, saya mau tanya tentang sewa alat camping.',
		'call_to_action'      => 'Chat CS',
		'style_desktop'       => '7_1', // Ikon + teks dalam pil.
		'style_mobile'        => '7_1',
		'same_settings'       => '1',
		'side_1'              => 'bottom',
		'side_1_value'        => '24px',
		'side_2'              => 'right',
		'side_2_value'        => '24px',
		'mobile_side_1'       => 'bottom',
		'mobile_side_1_value' => '16px',
		'mobile_side_2'       => 'right',
		'mobile_side_2_value' => '16px',
		'display_desktop'     => 'show',
		'display_mobile'      => 'show',
		'url_target_d'        => '_blank',
		'display'             => array( 'global_display' => 'show' ),
	)
);
update_option( 'ht_ctc_chat_options', $chat );

// Warna: latar hijau WA + ikon/teks ink (#0F1D22) → kontras 8,68:1 (teks putih hanya 1,98:1, gagal AA).
update_option(
	'ht_ctc_s7_1',
	array_merge(
		(array) get_option( 'ht_ctc_s7_1', array() ),
		array(
			's7_icon_size'        => '22px',
			's7_icon_color'       => '#0F1D22',
			's7_icon_color_hover' => '#0F1D22',
			's7_bgcolor'          => '#25D366',
			's7_bgcolor_hover'    => '#3BE07A',
			's7_border_size'      => '12px',
			'cta_type'            => 'show',
			'cta_font_size'       => '15px',
		)
	)
);

// Matikan integrasi analytics/pixel (tidak dipakai, mengurangi JS).
$other = (array) get_option( 'ht_ctc_othersettings', array() );
foreach ( array( 'g_an', 'gtm', 'fb_pixel' ) as $k ) {
	unset( $other[ $k ] );
}
$other['an_type'] = 'no-animation';
update_option( 'ht_ctc_othersettings', $other );

WP_CLI::log( '  ✓ nomor ' . BAGUS_WA_NUMBER . ', style 7_1 "Chat CS", kanan bawah' );
WP_CLI::success( 'Click to Chat siap.' );
