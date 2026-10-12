<?php
/**
 * Footer widget content (idempoten). Dijalankan via: wp eval-file setup-footer-widgets.php
 *
 * Kadence footer builder menggunakan widget areas footer1–footer4.
 * Kita isi langsung sebagai block-based widget (WP 5.8+).
 *
 * @package bagus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Nomor WA dari mu-plugin.
$wa = defined( 'BAGUS_WA_NUMBER' ) ? BAGUS_WA_NUMBER : '6285777598395';

// ----- Footer Widget 1: Logo & deskripsi -----
$f1 = <<<HTML
<!-- wp:paragraph {"className":"footer-brand"} -->
<p class="footer-brand"><strong>BAGUS</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"footer-tagline","fontSize":"small"} -->
<p class="footer-tagline">Mendaki Jadi Lebih BAGUS.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p>Sewa alat camping & hiking bersih, terawat, dan terjangkau di Semarang.</p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"iconColor":"on-dark-muted","iconColorValue":"#A9B4B6","className":"footer-social","layout":{"type":"flex"}} -->
<ul class="wp-block-social-links footer-social has-icon-color">
<!-- wp:social-link {"url":"https://wa.me/{$wa}","service":"whatsapp"} /-->
<!-- wp:social-link {"url":"https://instagram.com/bagus.outdoor","service":"instagram"} /-->
<!-- wp:social-link {"url":"mailto:halo@bagus-outdoor.id","service":"mail"} /-->
</ul>
<!-- /wp:social-links -->
HTML;

// ----- Footer Widget 2: Jelajahi -----
$f2 = <<<'HTML'
<!-- wp:heading {"level":4,"className":"footer-heading"} -->
<h4 class="footer-heading">Jelajahi</h4>
<!-- /wp:heading -->

<!-- wp:list {"className":"footer-links"} -->
<ul class="footer-links">
<li><a href="/katalog/">Katalog</a></li>
<li><a href="/paket-camping/">Paket Camping</a></li>
<li><a href="/tips-destinasi/">Tips &amp; Destinasi</a></li>
</ul>
<!-- /wp:list -->
HTML;

// ----- Footer Widget 3: Bantuan -----
$f3 = <<<'HTML'
<!-- wp:heading {"level":4,"className":"footer-heading"} -->
<h4 class="footer-heading">Bantuan</h4>
<!-- /wp:heading -->

<!-- wp:list {"className":"footer-links"} -->
<ul class="footer-links">
<li><a href="/cara-sewa/">Cara Sewa</a></li>
<li><a href="/kontak/">Kontak</a></li>
<li><a href="/akun-saya/">Akun Saya</a></li>
</ul>
<!-- /wp:list -->
HTML;

// ----- Footer Widget 4: Basecamp -----
$f4 = <<<HTML
<!-- wp:heading {"level":4,"className":"footer-heading"} -->
<h4 class="footer-heading">Basecamp</h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p>Jl. Banjarsari Raya No. 17, Tembalang, Kota Semarang, Jawa Tengah 50275</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p>Senin–Jumat 08.00–21.00<br>Sabtu–Minggu 06.00–22.00 WIB</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p><a href="https://wa.me/{$wa}" target="_blank" rel="noopener">WhatsApp CS: 0857-7759-8395</a></p>
<!-- /wp:paragraph -->
HTML;

$widgets_map = array(
	'footer1' => $f1,
	'footer2' => $f2,
	'footer3' => $f3,
	'footer4' => $f4,
);

foreach ( $widgets_map as $sidebar_id => $content ) {
	// Hapus widget lama di sidebar ini.
	$sidebars = get_option( 'sidebars_widgets', array() );
	if ( ! empty( $sidebars[ $sidebar_id ] ) ) {
		foreach ( $sidebars[ $sidebar_id ] as $widget_id ) {
			// Widget berbasis block disimpan di 'block' option_group.
			if ( preg_match( '/block-(\d+)/', $widget_id, $m ) ) {
				$blocks = get_option( 'widget_block', array() );
				unset( $blocks[ (int) $m[1] ] );
				update_option( 'widget_block', $blocks );
			}
		}
		$sidebars[ $sidebar_id ] = array();
		update_option( 'sidebars_widgets', $sidebars );
	}

	// Tambah satu block widget.
	$blocks = get_option( 'widget_block', array() );
	// widget_block has `_multiwidget` string key — filter to int keys only.
	$int_keys = array_filter( array_keys( $blocks ), 'is_int' );
	$idx      = empty( $int_keys ) ? 2 : max( $int_keys ) + 1;
	$blocks[ $idx ] = array( 'content' => $content );
	update_option( 'widget_block', $blocks );

	$sidebars                     = get_option( 'sidebars_widgets', array() );
	$sidebars[ $sidebar_id ]      = array( "block-{$idx}" );
	update_option( 'sidebars_widgets', $sidebars );

	WP_CLI::log( "  ✓ {$sidebar_id}" );
}

WP_CLI::success( 'Footer widgets siap.' );
