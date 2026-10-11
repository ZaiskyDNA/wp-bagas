<?php
/**
 * Menu BAGUS (idempoten: item menu dibangun ulang setiap dijalankan).
 * Dijalankan via: wp eval-file setup-menus.php
 *
 * @package bagus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Buat/ambil menu, kosongkan, lalu isi ulang dengan halaman sesuai urutan.
 *
 * @param string $name  Nama menu.
 * @param array  $items Daftar slug halaman => label.
 * @return int Menu term ID.
 */
function bagus_build_menu( $name, $items ) {
	$menu    = wp_get_nav_menu_object( $name );
	$menu_id = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu( $name );

	foreach ( (array) wp_get_nav_menu_items( $menu_id ) as $item ) {
		wp_delete_post( $item->ID, true );
	}

	$pos = 1;
	foreach ( $items as $slug => $label ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $page ) {
			WP_CLI::warning( "Halaman /{$slug}/ tidak ditemukan, dilewati." );
			continue;
		}
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => $label,
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $page->ID,
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
				'menu-item-position'  => $pos++,
			)
		);
	}
	WP_CLI::log( "  ✓ {$name}: " . ( $pos - 1 ) . ' item' );
	return $menu_id;
}

$main = bagus_build_menu(
	'Menu Utama',
	array(
		'beranda'        => 'Beranda',
		'katalog'        => 'Katalog',
		'paket-camping'  => 'Paket Camping',
		'cara-sewa'      => 'Cara Sewa',
		'tips-destinasi' => 'Tips & Destinasi',
		'tentang-kami'   => 'Tentang Kami',
		'kontak'         => 'Kontak',
	)
);

$jelajahi = bagus_build_menu(
	'Footer Jelajahi',
	array(
		'katalog'        => 'Katalog',
		'paket-camping'  => 'Paket Camping',
		'tips-destinasi' => 'Tips & Destinasi',
	)
);

$bantuan = bagus_build_menu(
	'Footer Bantuan',
	array(
		'cara-sewa' => 'Cara Sewa',
		'kontak'    => 'Kontak',
		'akun-saya' => 'Akun Saya',
	)
);

// Lokasi menu Kadence: primary, secondary, mobile, footer.
$locations            = (array) get_theme_mod( 'nav_menu_locations', array() );
$locations['primary'] = $main;
$locations['mobile']  = $main;
$locations['footer']  = $jelajahi; // Kolom "Bantuan" dipasang lewat widget footer Kadence di Fase 2.
set_theme_mod( 'nav_menu_locations', $locations );

WP_CLI::success( 'Menu siap.' );
