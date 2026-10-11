<?php
/**
 * Halaman inti BAGUS (idempoten). Dijalankan via: wp eval-file setup-pages.php
 *
 * - Halaman konten dibuat jika belum ada (isi awal placeholder; konten final di-import
 *   oleh scripts/seed-content.sh dari content/pages/*.html pada Fase 4).
 * - Halaman WooCommerce SELALU disetel ke shortcode klasik (bukan block Cart/Checkout).
 *
 * @package bagus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Cari halaman by slug, atau buat jika belum ada.
 *
 * @param string   $slug    Slug halaman.
 * @param string   $title   Judul.
 * @param string   $content Isi awal (hanya dipakai saat membuat).
 * @param int|null $reuse   ID halaman lama (mis. dari WooCommerce) untuk dipakai ulang.
 * @return int Page ID.
 */
function bagus_ensure_page( $slug, $title, $content = '', $reuse = null ) {
	$page = get_page_by_path( $slug, OBJECT, 'page' );

	// Pakai ulang halaman bawaan WooCommerce (mis. "shop", "cart") alih-alih membuat duplikat.
	if ( ! $page && $reuse ) {
		$old = get_post( $reuse );
		if ( $old && 'page' === $old->post_type && 'trash' !== $old->post_status ) {
			wp_update_post(
				array(
					'ID'          => $old->ID,
					'post_name'   => $slug,
					'post_title'  => $title,
					'post_status' => 'publish',
				)
			);
			WP_CLI::log( "  ↻ pakai ulang #{$old->ID} → /{$slug}/" );
			return (int) $old->ID;
		}
	}

	if ( $page ) {
		if ( 'publish' !== $page->post_status ) {
			wp_update_post( array( 'ID' => $page->ID, 'post_status' => 'publish' ) );
		}
		WP_CLI::log( "  ✓ /{$slug}/ sudah ada (#{$page->ID})" );
		return (int) $page->ID;
	}

	$id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_name'    => $slug,
			'post_title'   => $title,
			'post_content' => $content,
		),
		true
	);
	if ( is_wp_error( $id ) ) {
		WP_CLI::error( $id->get_error_message() );
	}
	WP_CLI::log( "  + /{$slug}/ dibuat (#{$id})" );
	return (int) $id;
}

/**
 * Placeholder sementara untuk halaman konten.
 *
 * @param string $text Teks paragraf.
 * @return string Block markup.
 */
function bagus_placeholder( $text ) {
	return "<!-- wp:paragraph -->\n<p>" . esc_html( $text ) . "</p>\n<!-- /wp:paragraph -->";
}

// 1. Halaman konten.
$content_pages = array(
	'beranda'        => 'Beranda',
	'paket-camping'  => 'Paket Camping',
	'cara-sewa'      => 'Cara Sewa',
	'tips-destinasi' => 'Tips & Destinasi',
	'tentang-kami'   => 'Tentang Kami',
	'kontak'         => 'Kontak',
);
$ids = array();
foreach ( $content_pages as $slug => $title ) {
	$text         = 'tips-destinasi' === $slug ? '' : bagus_placeholder( "Konten halaman {$title} sedang disiapkan." );
	$ids[ $slug ] = bagus_ensure_page( $slug, $title, $text );
}

// 2. Halaman WooCommerce (shortcode klasik — wajib untuk field checkout kustom).
$woo_pages = array(
	'shop'      => array( 'katalog', 'Katalog', '' ),
	'cart'      => array( 'keranjang', 'Keranjang', "<!-- wp:shortcode -->\n[woocommerce_cart]\n<!-- /wp:shortcode -->" ),
	'checkout'  => array( 'checkout', 'Checkout', "<!-- wp:shortcode -->\n[woocommerce_checkout]\n<!-- /wp:shortcode -->" ),
	'myaccount' => array( 'akun-saya', 'Akun Saya', "<!-- wp:shortcode -->\n[woocommerce_my_account]\n<!-- /wp:shortcode -->" ),
);
foreach ( $woo_pages as $key => list( $slug, $title, $content ) ) {
	$option = "woocommerce_{$key}_page_id";
	$id     = bagus_ensure_page( $slug, $title, $content, (int) get_option( $option ) );
	// Paksa isi shortcode klasik (WooCommerce baru membuat block Cart/Checkout secara default).
	if ( 'shop' !== $key && trim( get_post_field( 'post_content', $id ) ) !== $content ) {
		wp_update_post( array( 'ID' => $id, 'post_content' => $content ) );
		WP_CLI::log( "    ↳ isi /{$slug}/ diganti ke shortcode klasik" );
	}
	update_option( $option, $id );
	$ids[ $slug ] = $id;
}

// 3. Front page statis & posts page.
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $ids['beranda'] );
update_option( 'page_for_posts', $ids['tips-destinasi'] );

// 4. Permalink produk: /produk/{slug}/.
$permalinks                     = (array) get_option( 'woocommerce_permalinks', array() );
$permalinks['product_base']     = '/produk';
$permalinks['category_base']    = 'kategori-alat';
$permalinks['tag_base']         = 'tag-alat';
$permalinks['attribute_base']   = '';
$permalinks['use_verbose_page_rules'] = false;
update_option( 'woocommerce_permalinks', $permalinks );

// 5. Hapus konten contoh bawaan WordPress.
foreach ( array( array( 'sample-page', 'page' ), array( 'hello-world', 'post' ) ) as list( $slug, $type ) ) {
	$p = get_page_by_path( $slug, OBJECT, $type );
	if ( $p ) {
		wp_delete_post( $p->ID, true );
		WP_CLI::log( "  − konten contoh '{$slug}' dihapus" );
	}
}

WP_CLI::success( 'Halaman siap.' );
