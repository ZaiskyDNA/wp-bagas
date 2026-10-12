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
const BAGUS_STYLES = array( 'fonts', 'base', 'header', 'footer', 'components', 'woocommerce', 'content', 'motion' );

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

/**
 * Shortcode [bagus_account] — link Masuk/Akun untuk header (modul HTML Kadence).
 * Logged out → "Masuk"; logged in → "Akun". Ikon user digambar (SVG), bukan emoji.
 */
add_shortcode(
	'bagus_account',
	function () {
		$url   = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/akun-saya/' );
		$label = is_user_logged_in() ? __( 'Akun', 'bagus-child' ) : __( 'Masuk', 'bagus-child' );
		$icon  = '<svg class="bagus-ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="12" cy="8" r="4"/><path d="M4 20a8 8 0 0 1 16 0"/></svg>';
		return sprintf(
			'<a class="header-account" href="%s"><span class="header-account__ic">%s</span><span class="header-account__label">%s</span></a>',
			esc_url( $url ),
			$icon,
			esc_html( $label )
		);
	}
);

/**
 * Chip filter kategori di atas katalog & arsip kategori produk (PRD F-05).
 * Tampil di halaman shop (Katalog) dan arsip /kategori-alat/*.
 */
add_action(
	'woocommerce_before_shop_loop',
	function () {
		if ( ! ( is_shop() || is_product_category() ) ) {
			return;
		}
		$terms = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => true,
				'orderby'    => 'name',
			)
		);
		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return;
		}

		$current = is_product_category() ? get_queried_object_id() : 0;
		$shop    = get_permalink( wc_get_page_id( 'shop' ) );

		echo '<nav class="bagus-cat-filter" aria-label="Filter kategori produk"><ul>';
		printf(
			'<li><a class="bagus-chip%s" href="%s">Semua</a></li>',
			is_shop() ? ' is-active' : '',
			esc_url( $shop )
		);
		foreach ( $terms as $term ) {
			printf(
				'<li><a class="bagus-chip%s" href="%s">%s</a></li>',
				( $current === $term->term_id ) ? ' is-active' : '',
				esc_url( get_term_link( $term ) ),
				esc_html( $term->name )
			);
		}
		echo '</ul></nav>';
	},
	5
);

// Separator judul dokumen → em dash: "Judul — BAGUS" (PRD F-01 AC3).
add_filter(
	'document_title_separator',
	function () {
		return '—';
	}
);

// Enqueue main.js (micro-interactions).
add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_script(
			'bagus-main',
			BAGUS_CHILD_URI . '/assets/js/main.js',
			array(),
			bagus_asset_ver( 'assets/js/main.js' ),
			true
		);
	},
	20
);
