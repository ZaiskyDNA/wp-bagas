<?php
/**
 * Seed 15 produk BAGUS sebagai Variable Product dengan atribut global
 * "Durasi Sewa" (1/2/3/5 Hari). Idempoten (cari by SKU, variasi dibangun ulang).
 * Dijalankan via: wp eval-file setup-products.php
 *
 * Harga & stok: PRD Bagian 7.2. Stok dikelola di produk induk.
 *
 * @package bagus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'WooCommerce' ) ) {
	WP_CLI::error( 'WooCommerce tidak aktif.' );
}
require_once __DIR__ . '/_helpers.php';

// ---------------------------------------------------------------------------
// 1. Kategori produk (PRD 7.1).
// ---------------------------------------------------------------------------
$categories = array(
	'tenda'              => 'Tenda',
	'tas-carrier'        => 'Tas & Carrier',
	'perlengkapan-tidur' => 'Perlengkapan Tidur',
	'alat-masak'         => 'Alat Masak',
	'aksesoris'          => 'Aksesoris',
	'paket'              => 'Paket',
);
$cat_ids = array();
foreach ( $categories as $slug => $name ) {
	$term = get_term_by( 'slug', $slug, 'product_cat' );
	if ( ! $term ) {
		$res = wp_insert_term( $name, 'product_cat', array( 'slug' => $slug ) );
		if ( is_wp_error( $res ) ) {
			WP_CLI::error( "Kategori {$slug}: " . $res->get_error_message() );
		}
		$cat_ids[ $slug ] = (int) $res['term_id'];
		WP_CLI::log( "  + kategori {$name}" );
	} else {
		$cat_ids[ $slug ] = (int) $term->term_id;
	}
}

// ---------------------------------------------------------------------------
// 2. Atribut global "Durasi Sewa" + 4 term.
// ---------------------------------------------------------------------------
$attr_slug = 'durasi-sewa';
$taxonomy  = wc_attribute_taxonomy_name( $attr_slug ); // pa_durasi-sewa
$attr_id   = wc_attribute_taxonomy_id_by_name( $attr_slug );
if ( ! $attr_id ) {
	$attr_id = wc_create_attribute(
		array(
			'name'         => 'Durasi Sewa',
			'slug'         => $attr_slug,
			'type'         => 'select',
			'order_by'     => 'menu_order',
			'has_archives' => false,
		)
	);
	if ( is_wp_error( $attr_id ) ) {
		WP_CLI::error( 'Atribut Durasi Sewa: ' . $attr_id->get_error_message() );
	}
	WP_CLI::log( '  + atribut global Durasi Sewa' );
}
// Daftarkan taxonomy agar bisa menyisipkan term pada runtime ini.
if ( ! taxonomy_exists( $taxonomy ) ) {
	register_taxonomy( $taxonomy, 'product', array( 'hierarchical' => false ) );
}

$durations = array(
	'1-hari' => '1 Hari',
	'2-hari' => '2 Hari',
	'3-hari' => '3 Hari',
	'5-hari' => '5 Hari',
);
$term_ids = array();
$order    = 0;
foreach ( $durations as $slug => $label ) {
	$t = get_term_by( 'slug', $slug, $taxonomy );
	if ( ! $t ) {
		$res = wp_insert_term( $label, $taxonomy, array( 'slug' => $slug ) );
		if ( is_wp_error( $res ) ) {
			WP_CLI::error( "Term {$slug}: " . $res->get_error_message() );
		}
		$tid = (int) $res['term_id'];
	} else {
		$tid = (int) $t->term_id;
	}
	update_term_meta( $tid, 'order', $order++ );
	$term_ids[ $slug ] = $tid;
}

// ---------------------------------------------------------------------------
// 3. Data produk (PRD 7.2 / 7.3 / 7.4).
//    prices = [1 hari, 2 hari, 3 hari, 5 hari].
// ---------------------------------------------------------------------------
$care_default  = 'Alat sudah kami cuci dan cek sebelum sewa. Jaga tetap kering, bersihkan kotoran kasar sebelum dikembalikan, dan simpan di tempat teduh. Tidak perlu mencuci total — cukup kondisikan agar tidak lembap.';
$usage_tent    = 'Dirikan di permukaan rata bebas batu tajam, pasang frame dari pintu, lalu kaitkan pasak dan tali agar kencang. Pasang flysheet bila hujan atau berangin.';

$products = array(
	array(
		'sku'    => 'TND-02',
		'name'   => 'Tenda Dome 2 Orang',
		'cat'    => 'tenda',
		'stock'  => 8,
		'prices' => array( 35000, 70000, 95000, 149000 ),
		'img'    => 'tnd-02.webp',
		'short'  => array( 'Kapasitas: 2 orang', 'Bahan: Polyester 190T, lapisan anti-air 2.000 mm', 'Berat: ± 2,2 kg', 'Cocok untuk: Ungaran, Andong, Prau', 'Kondisi: dicuci & dicek setelah setiap penyewaan' ),
		'intro'  => 'Tenda dome ringkas untuk dua orang yang mudah didirikan oleh pemula sekalipun. Rangka fiber lentur dan flysheet anti-air membuatnya tetap nyaman saat gerimis maupun berangin di ketinggian.',
		'gets'   => array( 'Inner tent + flysheet + frame fiber', 'Pasak dan tali guy-line lengkap', 'Kantong jinjing (carry bag)' ),
		'usage'  => $usage_tent,
	),
	array(
		'sku'    => 'TND-04',
		'name'   => 'Tenda Dome 4 Orang',
		'cat'    => 'tenda',
		'stock'  => 5,
		'prices' => array( 55000, 110000, 149000, 234000 ),
		'img'    => 'tnd-04.webp',
		'short'  => array( 'Kapasitas: 4 orang', 'Bahan: Polyester 190T, lapisan anti-air 3.000 mm', 'Berat: ± 3,6 kg', 'Ada teras depan untuk alas sepatu & kompor', 'Kondisi: dicuci & dicek setelah setiap penyewaan' ),
		'intro'  => 'Tenda keluarga berkapasitas empat orang dengan teras depan lapang. Pilihan tepat untuk camping ceria bersama keluarga atau rombongan kecil di Merbabu dan Prau.',
		'gets'   => array( 'Inner tent + flysheet + frame fiber', 'Teras depan (vestibule)', 'Pasak, tali, dan carry bag' ),
		'usage'  => $usage_tent,
	),
	array(
		'sku'    => 'FLY-01',
		'name'   => 'Flysheet 3x4 m',
		'cat'    => 'tenda',
		'stock'  => 6,
		'prices' => array( 15000, 30000, 41000, 64000 ),
		'img'    => 'fly-01.webp',
		'short'  => array( 'Ukuran: 3 × 4 meter', 'Bahan: Polyester anti-air + lapisan PU', 'Berat: ± 0,7 kg', 'Fungsi: atap bivak, pelindung hujan, alas', 'Sudah dilengkapi ring & tali' ),
		'intro'  => 'Flysheet serbaguna untuk atap bivak, pelindung logistik dari hujan, atau alas bersantai. Ringan, cepat dipasang, dan muat di sela ransel.',
		'gets'   => array( 'Lembar flysheet 3×4 m', 'Tali ris di tiap sisi & ring sudut', 'Kantong simpan' ),
		'usage'  => 'Rentangkan dan ikat ke pohon, trekking pole, atau tiang. Buat kemiringan agar air mengalir ke satu sisi.',
	),
	array(
		'sku'    => 'CRR-45',
		'name'   => 'Carrier 45L',
		'cat'    => 'tas-carrier',
		'stock'  => 8,
		'prices' => array( 25000, 50000, 68000, 106000 ),
		'img'    => 'crr-45.webp',
		'short'  => array( 'Kapasitas: 45 liter', 'Cocok untuk: trip 1–2 hari', 'Punggung ber-busa + rain cover', 'Berat kosong: ± 1,3 kg', 'Kondisi: dicuci & dicek tiap selesai sewa' ),
		'intro'  => 'Carrier 45 liter yang pas untuk pendakian tektok atau camping singkat. Sistem punggung empuk dan rain cover bawaan menjaga barang tetap aman dan nyaman di pundak.',
		'gets'   => array( 'Carrier 45L + rain cover', 'Sabuk pinggang & dada', 'Kantong samping & akses bawah' ),
		'usage'  => 'Letakkan barang berat dekat punggung dan setinggi bahu. Kencangkan sabuk pinggang agar beban bertumpu di panggul.',
	),
	array(
		'sku'    => 'CRR-60',
		'name'   => 'Carrier 60L',
		'cat'    => 'tas-carrier',
		'stock'  => 6,
		'prices' => array( 35000, 70000, 95000, 149000 ),
		'img'    => 'crr-60.webp',
		'short'  => array( 'Kapasitas: 60 liter', 'Cocok untuk: trip 2–4 hari / bawaan grup', 'Frame internal + rain cover', 'Berat kosong: ± 1,8 kg', 'Kondisi: dicuci & dicek tiap selesai sewa' ),
		'intro'  => 'Carrier 60 liter untuk perjalanan lebih panjang atau saat kamu kebagian membawa logistik grup. Frame internal menjaga bentuk dan menyalurkan beban dengan baik.',
		'gets'   => array( 'Carrier 60L + rain cover', 'Sabuk pinggang & dada empuk', 'Banyak kompartemen & strap kompresi' ),
		'usage'  => 'Isi dari dasar: sleeping bag di bawah, barang berat dekat punggung. Rapatkan strap kompresi agar isi tidak bergoyang.',
	),
	array(
		'sku'    => 'SLB-01',
		'name'   => 'Sleeping Bag Polar',
		'cat'    => 'perlengkapan-tidur',
		'stock'  => 15,
		'prices' => array( 12000, 24000, 32000, 51000 ),
		'img'    => 'slb-01.webp',
		'short'  => array( 'Bahan: Polar + lapisan fleece', 'Nyaman di suhu ± 15–20°C', 'Model: envelope, ada tudung kepala', 'Berat: ± 0,9 kg', 'Kondisi: dicuci & dijemur tiap selesai sewa' ),
		'intro'  => 'Sleeping bag polar hangat dan lembut untuk gunung-gunung Jawa Tengah. Ringan, cepat kering, dan nyaman untuk tidur malam di ketinggian menengah.',
		'gets'   => array( 'Sleeping bag polar', 'Tudung kepala (hood)', 'Kantong kompresi' ),
		'usage'  => 'Gunakan alas matras di bawahnya agar tetap hangat. Longgarkan ritsleting bila gerah, rapatkan tudung saat dingin.',
	),
	array(
		'sku'    => 'MTR-01',
		'name'   => 'Matras Foil',
		'cat'    => 'perlengkapan-tidur',
		'stock'  => 15,
		'prices' => array( 8000, 16000, 22000, 34000 ),
		'img'    => 'mtr-01.webp',
		'short'  => array( 'Bahan: busa EVA + lapisan foil', 'Fungsi: alas tidur anti-dingin & lembap', 'Ukuran: ± 180 × 50 cm', 'Berat: ± 0,3 kg', 'Mudah digulung & diikat di luar ransel' ),
		'intro'  => 'Matras foil tipis yang memantulkan panas tubuh dan menahan dingin tanah. Wajib dipasangkan dengan sleeping bag agar tidurmu benar-benar hangat.',
		'gets'   => array( 'Matras foil gulung', 'Tali pengikat' ),
		'usage'  => 'Gelar dengan sisi foil menghadap ke atas (ke arah tubuh) untuk memantulkan panas.',
	),
	array(
		'sku'    => 'KMP-01',
		'name'   => 'Kompor Portable',
		'cat'    => 'alat-masak',
		'stock'  => 8,
		'prices' => array( 15000, 30000, 41000, 64000 ),
		'img'    => 'kmp-01.webp',
		'short'  => array( 'Tipe: kompor lipat hemat gas', 'Kompatibel tabung gas kaleng (butane)', 'Ada pemantik otomatis (piezo)', 'Berat: ± 0,2 kg', 'Catatan: tabung gas tidak termasuk' ),
		'intro'  => 'Kompor lipat ringkas dengan pemantik otomatis. Nyala api stabil dan mudah diatur untuk memasak atau menyeduh kopi di tengah dinginnya gunung.',
		'gets'   => array( 'Kompor lipat portable', 'Kotak penyimpanan' ),
		'usage'  => 'Pasang ke tabung gas butane, buka kaki penyangga, lalu nyalakan dengan piezo. Masak di tempat terlindung dari angin. Tabung gas dibeli terpisah.',
		'care'   => 'Dinginkan dan bersihkan sisa tumpahan sebelum dikembalikan. Lepas tabung gas setiap selesai memasak demi keamanan.',
	),
	array(
		'sku'    => 'NST-01',
		'name'   => 'Nesting Cooking Set',
		'cat'    => 'alat-masak',
		'stock'  => 8,
		'prices' => array( 12000, 24000, 32000, 51000 ),
		'img'    => 'nst-01.webp',
		'short'  => array( 'Isi: panci, wajan, ketel, + tutup', 'Bahan: aluminium anti-lengket', 'Muat 1–3 porsi', 'Menyatu & ringkas (nesting)', 'Kondisi: dicuci & dicek tiap selesai sewa' ),
		'intro'  => 'Set alat masak nesting yang menyatu rapi dalam satu wadah. Lengkap untuk memasak, merebus, dan menyeduh — cukup satu paket untuk kebutuhan dapur gunungmu.',
		'gets'   => array( 'Panci + wajan + ketel', 'Tutup serbaguna', 'Kantong jaring penyimpan' ),
		'usage'  => 'Gunakan api kecil–sedang agar lapisan anti-lengket awet. Pegang dengan kain karena gagang ikut panas.',
	),
	array(
		'sku'    => 'HDL-01',
		'name'   => 'Headlamp LED',
		'cat'    => 'aksesoris',
		'stock'  => 12,
		'prices' => array( 8000, 16000, 22000, 34000 ),
		'img'    => 'hdl-01.webp',
		'short'  => array( 'LED terang, beberapa mode cahaya', 'Tali elastis, nyaman di kepala', 'Sumber daya: baterai AAA', 'Tahan percikan air (bukan selam)', 'Catatan: baterai tidak termasuk' ),
		'intro'  => 'Headlamp ringan agar kedua tanganmu tetap bebas saat summit attack dini hari atau beraktivitas di dalam tenda. Beberapa mode cahaya untuk hemat baterai.',
		'gets'   => array( 'Headlamp LED', 'Tali kepala elastis' ),
		'usage'  => 'Pasang baterai AAA, atur sudut lampu ke jalur. Gunakan mode redup untuk menghemat daya saat di tenda.',
		'care'   => 'Keluarkan baterai bila lama tidak dipakai. Baterai dibawa sendiri (atau beli di basecamp).',
	),
	array(
		'sku'    => 'TRK-01',
		'name'   => 'Trekking Pole (Sepasang)',
		'cat'    => 'aksesoris',
		'stock'  => 6,
		'prices' => array( 15000, 30000, 41000, 64000 ),
		'img'    => 'trk-01.webp',
		'short'  => array( 'Isi: sepasang (2 batang)', 'Bahan: aluminium, bisa teleskopik', 'Pegangan gabus + tali tangan', 'Ujung karet + spike bisa diganti', 'Ringan & dapat dilipat pendek' ),
		'intro'  => 'Sepasang trekking pole untuk mengurangi beban lutut saat turunan dan menjaga keseimbangan di jalur licin. Panjangnya bisa diatur sesuai medan.',
		'gets'   => array( 'Sepasang trekking pole', 'Ujung karet pelindung' ),
		'usage'  => 'Atur panjang agar siku menekuk ± 90°. Perpendek saat menanjak, perpanjang saat menurun.',
	),
	array(
		'sku'    => 'JKT-01',
		'name'   => 'Jaket Gunung Windproof',
		'cat'    => 'aksesoris',
		'stock'  => 10,
		'prices' => array( 20000, 40000, 54000, 85000 ),
		'img'    => 'jkt-01.webp',
		'short'  => array( 'Fungsi: tahan angin & gerimis ringan', 'Ada tudung (hood) & saku resleting', 'Tersedia ukuran M–XL', 'Ringan, mudah dilipat', 'Kondisi: dicuci & dicek tiap selesai sewa' ),
		'intro'  => 'Jaket windproof ringan yang melindungi dari terpaan angin dingin dan gerimis di ketinggian. Mudah dilipat dan tidak makan tempat di ransel.',
		'gets'   => array( 'Jaket windproof + tudung', 'Saku resleting' ),
		'usage'  => 'Kenakan sebagai lapisan luar di atas baju hangat. Rapatkan tudung dan manset saat berangin.',
	),
	array(
		'sku'      => 'PKT-SOLO',
		'name'     => 'Paket Pendaki Solo',
		'cat'      => 'paket',
		'stock'    => 4,
		'prices'   => array( 75000, 150000, 203000, 319000 ),
		'img'      => 'pkt-solo.webp',
		'short'    => array( 'Untuk: 1 pendaki', 'Isi: Tenda 2 Orang, Carrier 45L, Sleeping Bag, Matras, Headlamp', 'Hemat Rp 13.000/hari dibanding satuan', 'Siap berangkat, tinggal bawa logistik', 'Kondisi: semua alat dicek sebelum sewa' ),
		'intro'    => 'Satu paket lengkap untuk pendaki solo atau trip ringkas. Semua kebutuhan dasar sudah disiapkan sehingga kamu tinggal mengisi logistik dan berangkat.',
		'gets'     => array( 'Tenda Dome 2 Orang', 'Carrier 45L', '1 Sleeping Bag Polar', '1 Matras Foil', '1 Headlamp LED' ),
		'usage'    => 'Ambil paket di basecamp atau pilih diantar. Cek kelengkapan bersama petugas saat serah terima.',
		'save'     => 'Hemat Rp 13.000 / hari',
	),
	array(
		'sku'      => 'PKT-DUO',
		'name'     => 'Paket Camping Ceria Berdua',
		'cat'      => 'paket',
		'stock'    => 4,
		'prices'   => array( 99000, 198000, 267000, 421000 ),
		'img'      => 'pkt-duo.webp',
		'short'    => array( 'Untuk: 2 orang (Terlaris ⭐)', 'Isi: Tenda 2 Orang, 2 Sleeping Bag, 2 Matras, Kompor, Nesting, 2 Headlamp', 'Hemat Rp 19.000/hari dibanding satuan', 'Lengkap untuk tidur & masak berdua', 'Kondisi: semua alat dicek sebelum sewa' ),
		'intro'    => 'Paket terlaris kami untuk camping ceria berdua. Sudah termasuk alat tidur dan alat masak lengkap, jadi tinggal pilih destinasi dan menyeduh kopi di puncak.',
		'gets'     => array( 'Tenda Dome 2 Orang', '2 Sleeping Bag Polar', '2 Matras Foil', '1 Kompor Portable', '1 Nesting Cooking Set', '2 Headlamp LED' ),
		'usage'    => 'Ambil paket di basecamp atau pilih diantar. Cek kelengkapan bersama petugas saat serah terima. Tabung gas bisa dibeli di basecamp.',
		'save'     => 'Hemat Rp 19.000 / hari',
	),
	array(
		'sku'      => 'PKT-FAM',
		'name'     => 'Paket Keluarga Glamping',
		'cat'      => 'paket',
		'stock'    => 3,
		'prices'   => array( 150000, 300000, 405000, 638000 ),
		'img'      => 'pkt-fam.webp',
		'short'    => array( 'Untuk: keluarga 4 orang', 'Isi: Tenda 4 Orang, Flysheet, 4 Sleeping Bag, 4 Matras, Kompor, Nesting', 'Hemat Rp 27.000/hari dibanding satuan', 'Nyaman untuk camping keluarga', 'Kondisi: semua alat dicek sebelum sewa' ),
		'intro'    => 'Paket glamping untuk keluarga berempat. Tenda lapang plus flysheet dan alat masak lengkap membuat camping keluarga terasa nyaman dan hangat.',
		'gets'     => array( 'Tenda Dome 4 Orang', 'Flysheet 3×4 m', '4 Sleeping Bag Polar', '4 Matras Foil', '1 Kompor Portable', '1 Nesting Cooking Set' ),
		'usage'    => 'Ambil paket di basecamp atau pilih diantar. Cek kelengkapan bersama petugas saat serah terima. Tabung gas bisa dibeli di basecamp.',
		'save'     => 'Hemat Rp 27.000 / hari',
	),
);

/**
 * Bangun deskripsi panjang (HTML) dari field produk.
 */
function bagus_build_long_desc( $p, $care_default ) {
	$heading = ( 'paket' === $p['cat'] ) ? 'Isi Paket' : 'Yang Kamu Dapatkan';
	$care    = isset( $p['care'] ) ? $p['care'] : $care_default;

	$html  = '<p>' . esc_html( $p['intro'] ) . '</p>';
	$html .= '<h3>' . esc_html( $heading ) . '</h3><ul>';
	foreach ( $p['gets'] as $g ) {
		$html .= '<li>' . esc_html( $g ) . '</li>';
	}
	$html .= '</ul>';
	$html .= '<h3>Cara Pakai Singkat</h3><p>' . esc_html( $p['usage'] ) . '</p>';
	$html .= '<h3>Tips Perawatan Selama Sewa</h3><p>' . esc_html( $care ) . '</p>';
	return $html;
}

/**
 * Bangun deskripsi singkat (HTML bullet).
 */
function bagus_build_short_desc( $bullets ) {
	$html = '<ul>';
	foreach ( $bullets as $b ) {
		$html .= '<li>' . esc_html( $b ) . '</li>';
	}
	return $html . '</ul>';
}

// ---------------------------------------------------------------------------
// 4. Buat / perbarui tiap produk.
// ---------------------------------------------------------------------------
$attribute = new WC_Product_Attribute();
$attribute->set_id( $attr_id );
$attribute->set_name( $taxonomy );
$attribute->set_options( array_values( $term_ids ) );
$attribute->set_position( 0 );
$attribute->set_visible( true );
$attribute->set_variation( true );

$done = 0;
foreach ( $products as $p ) {
	$product_id = wc_get_product_id_by_sku( $p['sku'] );
	$product    = $product_id ? wc_get_product( $product_id ) : null;

	if ( ! $product || ! $product->is_type( 'variable' ) ) {
		// Jika ada tapi tipe salah, hapus lalu buat ulang.
		if ( $product ) {
			$product->delete( true );
		}
		$product = new WC_Product_Variable();
	}

	$product->set_name( $p['name'] );
	$product->set_sku( $p['sku'] );
	$product->set_status( 'publish' );
	$product->set_catalog_visibility( 'visible' );
	$product->set_short_description( bagus_build_short_desc( $p['short'] ) );
	$product->set_description( bagus_build_long_desc( $p, $care_default ) );
	$product->set_category_ids( array( $cat_ids[ $p['cat'] ] ) );
	$product->set_attributes( array( $attribute ) );

	// Stok di induk (PRD 7.2).
	$product->set_manage_stock( true );
	$product->set_stock_quantity( $p['stock'] );
	$product->set_stock_status( 'instock' );
	$product->set_backorders( 'no' );

	// Gambar utama.
	$img_id = bagus_import_image( $p['img'] );
	if ( $img_id ) {
		$product->set_image_id( $img_id );
	}

	$parent_id = $product->save();

	// Variasi: bangun ulang agar idempoten & sesuai harga PRD.
	foreach ( $product->get_children() as $child_id ) {
		$child = wc_get_product( $child_id );
		if ( $child ) {
			$child->delete( true );
		}
	}

	$slugs = array_keys( $durations );
	foreach ( $slugs as $i => $slug ) {
		$variation = new WC_Product_Variation();
		$variation->set_parent_id( $parent_id );
		$variation->set_attributes( array( $taxonomy => $slug ) );
		$variation->set_regular_price( (string) $p['prices'][ $i ] );
		$variation->set_manage_stock( false ); // Stok dikelola induk.
		$variation->set_stock_status( 'instock' );
		$variation->save();
	}

	// Pastikan term atribut ter-assign ke produk (untuk taxonomy global).
	wp_set_object_terms( $parent_id, array_values( $term_ids ), $taxonomy );

	// Tanpa default attribute: pembeli wajib memilih Durasi Sewa dulu, sehingga
	// tombol "Tambah ke Keranjang" nonaktif sampai durasi dipilih (PRD F-04 AC2).
	$product = wc_get_product( $parent_id );
	$product->set_default_attributes( array() );
	$product->save();

	WC_Product_Variable::sync( $parent_id );
	++$done;
	WP_CLI::log( "  ✓ {$p['sku']} — {$p['name']} (stok {$p['stock']}, 4 variasi)" );
}

// ---------------------------------------------------------------------------
// 5. Produk unggulan (Beranda "Produk Terlaris" bisa pakai featured).
// ---------------------------------------------------------------------------
foreach ( array( 'TND-02', 'CRR-45', 'SLB-01', 'KMP-01' ) as $sku ) {
	$pid = wc_get_product_id_by_sku( $sku );
	if ( $pid ) {
		$pr = wc_get_product( $pid );
		$pr->set_featured( true );
		$pr->save();
	}
}

wc_delete_product_transients();
WP_CLI::success( "Produk siap ({$done} produk, 6 kategori, atribut Durasi Sewa)." );
