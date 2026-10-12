<?php
/**
 * BAGUS Child — functions.
 * Hanya urusan tampilan (enqueue, dukungan tema, markup header/footer).
 * Logika bisnis ada di mu-plugins/bagus-core.php.
 *
 * @package bagus-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BAGUS_CHILD_VERSION', '0.2.0' );
define( 'BAGUS_CHILD_DIR', get_stylesheet_directory() );
define( 'BAGUS_CHILD_URI', get_stylesheet_directory_uri() );

/**
 * Versi aset = waktu modifikasi file (cache-busting otomatis saat file berubah).
 *
 * @param string $rel Path relatif dari root child theme.
 * @return string
 */
function bagus_asset_ver( $rel ) {
	$path = BAGUS_CHILD_DIR . '/' . $rel;
	return file_exists( $path ) ? (string) filemtime( $path ) : BAGUS_CHILD_VERSION;
}

/**
 * Stylesheet komponen, dimuat berurutan setelah style Kadence.
 * File yang belum ada otomatis dilewati.
 */
const BAGUS_STYLES = array( 'fonts', 'base', 'header', 'footer', 'components', 'woocommerce', 'motion' );

add_action(
	'wp_enqueue_scripts',
	function () {
		// style.css berisi design tokens → dimuat pertama setelah Kadence.
		wp_enqueue_style( 'bagus-tokens', get_stylesheet_uri(), array( 'kadence-global' ), bagus_asset_ver( 'style.css' ) );

		$dep = 'bagus-tokens';
		foreach ( BAGUS_STYLES as $name ) {
			$rel = "assets/css/{$name}.css";
			if ( ! file_exists( BAGUS_CHILD_DIR . '/' . $rel ) ) {
				continue;
			}
			wp_enqueue_style( "bagus-{$name}", BAGUS_CHILD_URI . '/' . $rel, array( $dep ), bagus_asset_ver( $rel ) );
			$dep = "bagus-{$name}";
		}
	},
	20
);

// Preload font utama (mengurangi FOUT & membantu LCP).
add_action(
	'wp_head',
	function () {
		foreach ( array( 'playfair-display-latin-wght-normal', 'plus-jakarta-sans-latin-wght-normal' ) as $font ) {
			printf(
				'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
				esc_url( BAGUS_CHILD_URI . "/assets/fonts/{$font}.woff2" )
			);
		}
	},
	1
);
// Catatan: Kadence tidak memuat Google Fonts karena font di Customizer diset `google => false`
// (lihat scripts/php/setup-theme.php).
