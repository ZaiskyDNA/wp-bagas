<?php
/**
 * Plugin Name: BAGUS Core
 * Description: Logika bisnis BAGUS (field sewa di checkout, tombol WhatsApp, format harga).
 * Version:     0.1.0
 *
 * Fase 1: hanya konstanta nomor WA + helper link. Fitur lengkap ditambahkan di Fase 3.
 *
 * @package bagus-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Satu-satunya sumber nomor WA CS. scripts/setup.sh membaca konstanta ini untuk Click to Chat.
define( 'BAGUS_WA_NUMBER', '6285777598395' );

/**
 * Bangun link wa.me dengan pesan ter-URL-encode.
 *
 * @param string $message Pesan prefilled.
 * @return string
 */
function bagus_wa_link( $message ) {
	return 'https://wa.me/' . BAGUS_WA_NUMBER . '?text=' . rawurlencode( $message );
}
