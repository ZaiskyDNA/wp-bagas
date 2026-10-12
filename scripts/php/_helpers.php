<?php
/**
 * Helper bersama untuk seeder BAGUS (produk, konten, blog).
 * Di-include dari setup-products.php / setup-content.php / setup-blog.php via:
 *   require_once __DIR__ . '/_helpers.php';
 *
 * Idempoten: impor gambar hanya sekali per nama file (ditandai meta _bagus_src).
 *
 * @package bagus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'BAGUS_IMG_DIR' ) ) {
	define( 'BAGUS_IMG_DIR', '/content/images/optimized' );
}

/**
 * Alt text resmi tiap gambar (sumber: content/images/IMAGE-PROMPTS.md).
 *
 * @return array<string,string> nama file => alt.
 */
function bagus_alt_map() {
	static $map = array(
		'about-story.webp'          => 'Bagus Pratama, pendiri BAGUS, berdiri di basecamp dengan rak tenda dan carrier',
		'banner-paket-duo.webp'     => 'Dua sahabat tertawa di depan tenda sambil menyeduh kopi di pagi hari',
		'blog-andong-sunrise.webp'  => 'Keluarga menikmati matahari terbit di samping tenda di puncak Gunung Andong',
		'blog-checklist-alat.webp'  => 'Susunan alat camping wajib untuk pemula di atas papan kayu dilihat dari atas',
		'blog-ungaran-mawar.webp'   => 'Dua pendaki menyusuri jalur hutan pinus Gunung Ungaran via Basecamp Mawar',
		'crr-45.webp'               => 'Carrier 45 liter warna hijau zaitun dengan tali bahu abu-abu gelap',
		'crr-60.webp'               => 'Carrier 60 liter warna abu-abu gelap dengan aksen hijau dan oranye',
		'cta-bg.webp'               => 'Pendaki berdiri di batu karang menatap jajaran pegunungan berkabut saat senja',
		'dest-andong.webp'          => 'Punggung puncak Gunung Andong dengan deretan tenda dan Gunung Merbabu di belakangnya',
		'dest-merbabu.webp'         => 'Sabana luas Gunung Merbabu dengan jalur pendakian dan Gunung Merapi di kejauhan',
		'dest-prau.webp'            => 'Bukit hijau Gunung Prau dengan Gunung Sindoro dan Sumbing di atas lautan awan',
		'dest-ungaran.webp'         => 'Puncak Gunung Ungaran berbatu dengan lautan awan saat matahari terbit',
		'fly-01.webp'               => 'Flysheet 3x4 meter warna krem terpasang model segitiga dengan dua tiang',
		'hdl-01.webp'               => 'Headlamp LED warna abu-abu gelap dengan tali elastis',
		'hero-cara-sewa.webp'       => 'Petugas basecamp BAGUS menyerahkan carrier kepada penyewa di meja kayu dengan rak alat camping di belakangnya',
		'hero-home.webp'            => 'Pendaki berdiri di puncak berbatu menatap lautan awan saat matahari terbit dengan Gunung Sindoro dan Sumbing di kejauhan',
		'hero-katalog.webp'         => 'Tenda hijau menyala hangat di punggung bukit saat senja dengan carrier dan kompor di depannya',
		'hero-kontak.webp'          => 'Pendaki duduk di depan tenda saat senja sambil memegang ponsel di bawah cahaya lentera',
		'hero-paket.webp'           => 'Dua sahabat mendirikan tenda bersama di sabana Gunung Merbabu saat sore hari',
		'hero-tentang.webp'         => 'Rombongan pendaki berjalan beriringan di punggung bukit saat matahari terbit',
		'hero-tips.webp'            => 'Jalur pendakian di hutan pinus berkabut Gunung Ungaran dengan sinar matahari pagi',
		'jkt-01.webp'               => 'Jaket gunung windproof warna hijau tua dengan tudung dan resleting krem',
		'kmp-01.webp'               => 'Kompor portable lipat terpasang di atas tabung gas warna krem',
		'mtr-01.webp'               => 'Matras foil lipat dengan sisi perak dan sisi busa hijau',
		'nst-01.webp'               => 'Set alat masak nesting berisi panci, wajan, dan ketel aluminium warna abu-abu dan hijau',
		'og-image.jpg'              => 'BAGUS, Mendaki Jadi Lebih BAGUS: pendaki di punggung bukit saat matahari terbit',
		'pkt-duo.webp'              => 'Isi Paket Camping Ceria Berdua: tenda 2 orang, 2 sleeping bag, 2 matras, kompor, nesting, dan 2 headlamp',
		'pkt-fam.webp'              => 'Isi Paket Keluarga Glamping: tenda 4 orang, flysheet, 4 sleeping bag, 4 matras, kompor, dan nesting',
		'pkt-solo.webp'             => 'Isi Paket Pendaki Solo: carrier 45 liter, tenda, sleeping bag, matras foil, dan headlamp',
		'slb-01.webp'               => 'Sleeping bag polar warna hijau sage setengah terbuka dengan lapisan fleece abu-abu',
		'step-01-pilih.webp'        => 'Penyewa memilih alat camping lewat ponsel',
		'step-02-checkout.webp'     => 'Penyewa mengonfirmasi pesanan lewat WhatsApp',
		'step-03-jelajah.webp'      => 'Pendaki bergembira tiba di titik pandang pegunungan',
		'tnd-02.webp'               => 'Tenda dome 2 orang warna hijau zaitun berdiri utuh dengan pintu setengah terbuka',
		'tnd-04.webp'               => 'Tenda dome 4 orang warna hijau tua dengan teras depan dan pintu terbuka',
		'trk-01.webp'               => 'Sepasang trekking pole aluminium dengan pegangan gabus disilangkan',
	);
	return $map;
}

/**
 * Alt text untuk satu file (fallback ke string kosong).
 *
 * @param string $filename Nama file (mis. 'tnd-02.webp').
 * @return string
 */
function bagus_alt( $filename ) {
	$map = bagus_alt_map();
	return isset( $map[ $filename ] ) ? $map[ $filename ] : '';
}

/**
 * Impor satu gambar ke Media Library (sekali saja per file).
 *
 * @param string $filename Nama file di BAGUS_IMG_DIR.
 * @param string $alt      Alt text (kosong = ambil dari peta).
 * @return int Attachment ID, atau 0 jika gagal.
 */
function bagus_import_image( $filename, $alt = '' ) {
	// Sudah pernah diimpor?
	$found = get_posts(
		array(
			'post_type'   => 'attachment',
			'post_status' => 'inherit',
			'meta_key'    => '_bagus_src',
			'meta_value'  => $filename,
			'numberposts' => 1,
			'fields'      => 'ids',
		)
	);
	if ( ! empty( $found ) ) {
		return (int) $found[0];
	}

	$src = BAGUS_IMG_DIR . '/' . $filename;
	if ( ! file_exists( $src ) ) {
		WP_CLI::warning( "Gambar tidak ditemukan: {$src}" );
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	// Salin ke file sementara (sumber mount read-only; sideload akan memindahkannya).
	$tmp = wp_tempnam( $filename );
	if ( ! $tmp || ! copy( $src, $tmp ) ) {
		WP_CLI::warning( "Gagal menyalin {$filename} ke temp." );
		return 0;
	}

	$file_array = array(
		'name'     => $filename,
		'tmp_name' => $tmp,
	);
	$id = media_handle_sideload( $file_array, 0 );
	if ( is_wp_error( $id ) ) {
		@unlink( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		WP_CLI::warning( "Impor {$filename} gagal: " . $id->get_error_message() );
		return 0;
	}

	if ( '' === $alt ) {
		$alt = bagus_alt( $filename );
	}
	update_post_meta( $id, '_wp_attachment_image_alt', $alt );
	update_post_meta( $id, '_bagus_src', $filename );
	WP_CLI::log( "    ⬆ impor {$filename} (#{$id})" );
	return (int) $id;
}

/**
 * Ambil ID halaman dari slug.
 *
 * @param string $slug Slug halaman.
 * @return int 0 jika tidak ada.
 */
function bagus_page_id( $slug ) {
	$p = get_page_by_path( $slug, OBJECT, 'page' );
	return $p ? (int) $p->ID : 0;
}
