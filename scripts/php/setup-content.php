<?php
/**
 * Seed konten final halaman BAGUS (Fase 4). Idempoten: isi halaman ditimpa
 * dengan versi final tiap dijalankan. Dijalankan via: wp eval-file setup-content.php
 *
 * Markup = blok core (wp:html untuk section kustom + wp:shortcode untuk grid Woo),
 * membawa class .bagus-* yang di-style oleh assets/css/content.css.
 * Ikon digambar (SVG inline), bukan emoji.
 *
 * @package bagus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once __DIR__ . '/_helpers.php';

if ( ! function_exists( 'bagus_wa_link' ) ) {
	WP_CLI::error( 'mu-plugin bagus-core (bagus_wa_link) tidak termuat.' );
}

/** Ikon garis (Lucide-style), stroke currentColor. */
function bg_icon( $name, $extra = '' ) {
	static $p = null;
	if ( null === $p ) {
		$p = array(
			'badge-check' => '<path d="M12 3l7 3v5c0 4.4-3 7.6-7 9-4-1.4-7-4.6-7-9V6l7-3Z"/><path d="m9 11.5 2 2 4-4.5"/>',
			'tag'         => '<path d="M3.5 3.5h7.3a2 2 0 0 1 1.4.6l8 8a2 2 0 0 1 0 2.8l-5.3 5.3a2 2 0 0 1-2.8 0l-8-8a2 2 0 0 1-.6-1.4V3.5Z"/><circle cx="7.6" cy="7.6" r="1.3"/>',
			'truck'       => '<path d="M3 6.5h10.5v9H3z"/><path d="M13.5 9.5H17l3 3v3h-6.5z"/><circle cx="7" cy="17.5" r="2"/><circle cx="17" cy="17.5" r="2"/>',
			'chat'        => '<path d="M4 5.5h16v10H9l-4.5 3.5V5.5Z"/><path d="M8.5 10h7"/><path d="M8.5 12.6h4.5"/>',
			'tent'        => '<path d="M12 3.5 3 20.5h18z"/><path d="M12 3.5V20.5"/><path d="M12 14l3.4 6.5"/>',
			'backpack'    => '<rect x="5" y="7" width="14" height="13.5" rx="4"/><path d="M8.5 7V5.5a3.5 3.5 0 0 1 7 0V7"/><path d="M8.5 13.3h7"/><path d="M12 13.3v4"/>',
			'bed'         => '<path d="M3 19v-6.5h18V19"/><path d="M3 12.5V9a2 2 0 0 1 2-2h5v5.5"/><path d="M3 16h18"/><path d="M4 19v1.5"/><path d="M20 19v1.5"/>',
			'flame'       => '<path d="M12 3c3 3.5 5 6 5 9a5 5 0 0 1-10 0c0-1.6.6-2.8 1.6-3.8C9 10.5 10.5 9 12 3Z"/>',
			'compass'     => '<circle cx="12" cy="12" r="9"/><path d="m15.8 8.2-2 5.6-5.6 2 2-5.6z"/>',
			'package'     => '<path d="M12 3 20.5 7.5v9L12 21 3.5 16.5v-9z"/><path d="m3.5 7.5 8.5 4.5 8.5-4.5"/><path d="M12 12v9"/>',
			'map-pin'     => '<path d="M12 21s-6.5-5.8-6.5-10.5a6.5 6.5 0 0 1 13 0C18.5 15.2 12 21 12 21Z"/><circle cx="12" cy="10.5" r="2.4"/>',
			'phone'       => '<path d="M6.5 3.5h3l1.5 4-2 1.5a11 11 0 0 0 5 5l1.5-2 4 1.5v3a2 2 0 0 1-2.2 2A16 16 0 0 1 4.5 5.7 2 2 0 0 1 6.5 3.5Z"/>',
			'mail'        => '<rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="m3.5 6.5 8.5 6 8.5-6"/>',
			'clock'       => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5.2l3.3 2"/>',
			'leaf'        => '<path d="M5 19C4 11 9 5 20 5c0 11-6 16-14 15Z"/><path d="M5 19C8 15 12 12 17 10"/>',
			'wallet'      => '<path d="M4 7.5A2.5 2.5 0 0 1 6.5 5H18v3"/><rect x="4" y="7.5" width="16" height="12" rx="2.5"/><circle cx="16.5" cy="13.5" r="1.3"/>',
			'mountain'    => '<path d="M3.5 20 10 7l3.5 6 2-3.5L20.5 20z"/>',
		);
	}
	if ( ! isset( $p[ $name ] ) ) {
		return '';
	}
	$cls = trim( 'bagus-ic ' . $extra );
	return '<svg class="' . esc_attr( $cls ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $p[ $name ] . '</svg>';
}

/** Lima bintang terisi (rating), SVG. */
function bg_stars() {
	$star = '<svg class="bagus-ic" viewBox="0 0 24 24" fill="currentColor" stroke="none" aria-hidden="true" focusable="false"><path d="M12 3.6l2.5 5.2 5.7.6-4.3 3.9 1.2 5.6L12 16.9 6.9 18.9l1.2-5.6L3.8 9.4l5.7-.6z"/></svg>';
	return '<span class="bagus-stars" aria-label="Rating 5 dari 5">' . str_repeat( $star, 5 ) . '</span>';
}

/** Bungkus HTML sebagai satu blok wp:html. */
function bg_html( $html ) {
	return "<!-- wp:html -->\n" . $html . "\n<!-- /wp:html -->\n\n";
}
/** <img> responsif dari attachment. */
function bg_img( $filename, $size = 'large', $class = '' ) {
	$id = bagus_import_image( $filename );
	if ( ! $id ) {
		return '';
	}
	return wp_get_attachment_image( $id, $size, false, array( 'class' => $class, 'loading' => 'lazy' ) );
}
/** URL full attachment (untuk background-image). */
function bg_url( $filename ) {
	$id = bagus_import_image( $filename );
	return $id ? wp_get_attachment_image_url( $id, 'full' ) : '';
}

/**
 * Section berisi grid produk WooCommerce, dibungkus container.
 */
function bg_products_section( $h2, $sub, $shortcode, $after = '', $section_class = 'bagus-section' ) {
	$head = '<div class="bagus-section-head fade-up"><h2>' . $h2 . '</h2>' . ( $sub ? '<p>' . $sub . '</p>' : '' ) . '</div>';
	$out  = "<!-- wp:group {\"className\":\"{$section_class}\"} -->\n<div class=\"wp-block-group {$section_class}\">\n";
	$out .= "<!-- wp:group {\"className\":\"bagus-wrap\"} -->\n<div class=\"wp-block-group bagus-wrap\">\n";
	$out .= "<!-- wp:html -->\n{$head}\n<!-- /wp:html -->\n\n";
	$out .= "<!-- wp:shortcode -->\n{$shortcode}\n<!-- /wp:shortcode -->\n\n";
	if ( $after ) {
		$out .= "<!-- wp:html -->\n{$after}\n<!-- /wp:html -->\n\n";
	}
	$out .= "</div>\n<!-- /wp:group -->\n</div>\n<!-- /wp:group -->\n\n";
	return $out;
}
/** Set konten halaman by slug. */
function bg_set_page( $slug, $content ) {
	$id = bagus_page_id( $slug );
	if ( ! $id ) {
		WP_CLI::warning( "Halaman /{$slug}/ tidak ada, dilewati." );
		return 0;
	}
	wp_update_post( array( 'ID' => $id, 'post_content' => $content ) );
	WP_CLI::log( "  ✓ konten /{$slug}/" );
	return $id;
}
/** Nonaktifkan transparent header + tampilkan judul Kadence. */
function bg_solid_header( $slug ) {
	$id = bagus_page_id( $slug );
	if ( $id ) {
		update_post_meta( $id, '_kad_post_transparent_header', 'disable' );
		update_post_meta( $id, '_kad_post_title', 'show' );
	}
}

$hero_home = bg_url( 'hero-home.webp' );
$cta_bg    = bg_url( 'cta-bg.webp' );

/* =============================================================================
 * BERANDA
 * ========================================================================== */
$home = bg_html(
	'<section class="bagus-hero" style="background-image:url(' . esc_url( $hero_home ) . ')">
  <div class="bagus-wrap bagus-hero__inner fade-up">
    <h1>Mendaki Jadi<br>Lebih BAGUS.</h1>
    <p class="lead">Sewa alat camping &amp; hiking yang bersih, terawat, dan terjangkau di Semarang. Ambil di basecamp atau kami antar ke lokasimu.</p>
    <div class="bagus-btn-row">
      <a class="wp-block-button__link" href="/katalog/">Sewa Sekarang</a>
      <span class="wp-block-button is-style-outline"><a class="wp-block-button__link" href="/paket-camping/">Lihat Paket Hemat</a></span>
    </div>
  </div>
</section>'
);

$home .= bg_html(
	'<section class="bagus-section bagus-trust">
  <div class="bagus-wrap">
    <div class="bagus-trust__grid">
      <div class="bagus-stat"><span class="bagus-stat__num" data-count-to="2500" data-count-suffix="+">2.500+</span><span class="bagus-stat__label">Penyewa Puas</span></div>
      <div class="bagus-stat"><span class="bagus-stat__num" data-count-to="150" data-count-suffix="+">150+</span><span class="bagus-stat__label">Alat Siap Pakai</span></div>
      <div class="bagus-stat"><span class="bagus-stat__num">4,9</span><span class="bagus-stat__label">Rating Pelanggan</span></div>
      <div class="bagus-stat"><span class="bagus-stat__num">2021</span><span class="bagus-stat__label">Melayani Sejak</span></div>
    </div>
  </div>
</section>'
);

$feat = array(
	array( 'badge-check', 'Alat Bersih &amp; Terawat', 'Dicuci dan dicek setiap selesai sewa, jadi selalu siap pakai.' ),
	array( 'wallet', 'Harga Transparan', 'Mulai Rp 8.000/hari. Makin lama durasi, makin hemat.' ),
	array( 'truck', 'Antar ke Lokasimu', 'Area Kota Semarang hanya Rp 15.000, atau ambil gratis di basecamp.' ),
	array( 'chat', 'Konsultasi Gratis', 'Tanya rute dan pilihan alat kapan saja via WhatsApp.' ),
);
$feat_html = '';
foreach ( $feat as $f ) {
	$feat_html .= '<div class="bagus-feature"><span class="bagus-feature__icon">' . bg_icon( $f[0] ) . '</span><h3>' . $f[1] . '</h3><p>' . $f[2] . '</p></div>';
}
$home .= bg_html(
	'<section class="bagus-section">
  <div class="bagus-wrap">
    <div class="bagus-section-head fade-up">
      <h2>Petualanganmu, Tanpa Ribet</h2>
      <p>Empat alasan ribuan pendaki Semarang mempercayakan perlengkapannya ke kami.</p>
    </div>
    <div class="bagus-grid bagus-grid--4 fade-up-stagger">' . $feat_html . '</div>
  </div>
</section>'
);

$cats = array(
	array( 'tenda', 'tent', 'Tenda' ),
	array( 'tas-carrier', 'backpack', 'Tas &amp; Carrier' ),
	array( 'perlengkapan-tidur', 'bed', 'Perlengkapan Tidur' ),
	array( 'alat-masak', 'flame', 'Alat Masak' ),
	array( 'aksesoris', 'compass', 'Aksesoris' ),
	array( 'paket', 'package', 'Paket' ),
);
$cat_html = '';
foreach ( $cats as $c ) {
	$cat_html .= '<a class="bagus-cat" href="/kategori-alat/' . $c[0] . '/"><span class="bagus-cat__icon">' . bg_icon( $c[1] ) . '</span><span class="bagus-cat__label">' . $c[2] . '</span><span class="bagus-cat__go">' . bg_icon( 'compass' ) . '</span></a>';
}
$home .= bg_html(
	'<section class="bagus-section bagus-section--cream">
  <div class="bagus-wrap">
    <div class="bagus-section-head fade-up"><h2>Pilih Sesuai Kebutuhan</h2><p>Dari tenda sampai alat masak, semua ada. Telusuri per kategori.</p></div>
    <div class="bagus-grid bagus-grid--3 bagus-cat-grid fade-up-stagger">' . $cat_html . '</div>
  </div>
</section>'
);

$home .= bg_products_section(
	'Paling Sering Disewa',
	'Alat favorit para penyewa kami — siap untuk petualangan berikutnya.',
	'[products limit="4" columns="4" visibility="featured" orderby="menu_order"]',
	'<div class="bagus-center" style="margin-top:var(--bagus-space-7)"><a class="wp-block-button__link" href="/katalog/">Lihat Semua Alat</a></div>'
);

$home .= bg_html(
	'<section class="bagus-section bagus-section--cream">
  <div class="bagus-wrap">
    <div class="bagus-banner fade-up">
      <div class="bagus-banner__body">
        <h2>Baru Pertama Kali Camping?</h2>
        <p>Ambil <strong>Paket Camping Ceria Berdua</strong> mulai <strong>Rp 99.000/hari</strong> — tenda, alat tidur, dan alat masak lengkap. Hemat Rp 19.000 dibanding sewa satuan!</p>
        <a class="wp-block-button__link" href="/produk/paket-camping-ceria-berdua/">Lihat Paket</a>
      </div>
      <div class="bagus-banner__media">' . bg_img( 'banner-paket-duo.webp', 'large' ) . '</div>
    </div>
  </div>
</section>'
);

$steps = array(
	array( 'step-01-pilih.webp', '01', 'Pilih Alat &amp; Durasi', 'Telusuri katalog, pilih alat dan durasi sewa, lalu tambahkan ke keranjang.' ),
	array( 'step-02-checkout.webp', '02', 'Checkout &amp; Konfirmasi WA', 'Isi tanggal sewa, pilih bayar transfer atau COD, lalu konfirmasi ke CS.' ),
	array( 'step-03-jelajah.webp', '03', 'Ambil / Diantar, Lalu Jelajah!', 'Ambil di basecamp atau kami antar. Kembalikan tepat waktu. Selamat mendaki!' ),
);
$step_html = '';
foreach ( $steps as $s ) {
	$step_html .= '<article class="bagus-stepcard"><div class="bagus-stepcard__media">' . bg_img( $s[0], 'medium_large' ) . '<span class="bagus-stepcard__num">' . $s[1] . '</span></div><div class="bagus-stepcard__body"><h3>' . $s[2] . '</h3><p>' . $s[3] . '</p></div></article>';
}
$home .= bg_html(
	'<section class="bagus-section">
  <div class="bagus-wrap">
    <div class="bagus-section-head fade-up"><h2>Sewa Semudah Tiga Langkah</h2><p>Dari pilih alat sampai berangkat, prosesnya cepat dan jelas.</p></div>
    <div class="bagus-grid bagus-grid--3 fade-up-stagger">' . $step_html . '</div>
    <div class="bagus-center" style="margin-top:var(--bagus-space-7)"><a class="button btn-secondary" href="/cara-sewa/">Baca Detail Cara Sewa</a></div>
  </div>
</section>'
);

$dests = array(
	array( 'dest-ungaran.webp', 'Gunung Ungaran', '2.050 mdpl &middot; ± 1 jam dari Semarang', '/panduan-mendaki-gunung-ungaran-via-basecamp-mawar/' ),
	array( 'dest-andong.webp', 'Gunung Andong', '1.726 mdpl &middot; ramah pemula', '/camping-ceria-di-gunung-andong/' ),
	array( 'dest-prau.webp', 'Gunung Prau', '2.565 mdpl &middot; negeri di atas awan', '/tips-destinasi/' ),
	array( 'dest-merbabu.webp', 'Gunung Merbabu', '3.145 mdpl &middot; sabana luas', '/tips-destinasi/' ),
);
$dest_html = '';
foreach ( $dests as $d ) {
	$dest_html .= '<a class="bagus-dest" href="' . $d[3] . '">' . bg_img( $d[0], 'medium_large' ) . '<div class="bagus-dest__body"><h3>' . $d[1] . '</h3><span class="bagus-dest__meta">' . $d[2] . '</span></div></a>';
}
$home .= bg_html(
	'<section class="bagus-section bagus-section--ink">
  <div class="bagus-wrap">
    <div class="bagus-section-head fade-up"><h2>Mau Jelajah ke Mana?</h2><p>Gunung-gunung terbaik di sekitar Semarang untuk petualangan akhir pekanmu.</p></div>
    <div class="bagus-grid bagus-grid--4 fade-up-stagger">' . $dest_html . '</div>
  </div>
</section>'
);

$tes = array(
	array( 'Tendanya bersih banget, wangi pula. Muncak ke Ungaran jadi tenang.', 'Rina', 'Tembalang' ),
	array( 'Paket berdua lengkap, tinggal berangkat. Adminnya fast response!', 'Dimas', 'Banyumanik' ),
	array( 'Diantar ke kos, pas balik juga dijemput. Mantap!', 'Sinta', 'Gunungpati' ),
);
$tes_html = '';
foreach ( $tes as $t ) {
	$tes_html .= '<figure class="bagus-quote">' . bg_stars() . '<blockquote><p>&ldquo;' . $t[0] . '&rdquo;</p></blockquote><figcaption><strong>' . $t[1] . '</strong><span>' . $t[2] . '</span></figcaption></figure>';
}
$home .= bg_html(
	'<section class="bagus-section">
  <div class="bagus-wrap">
    <div class="bagus-section-head fade-up"><h2>Kata Mereka</h2><p>Cerita dari penyewa yang sudah lebih dulu berpetualang bersama BAGUS.</p></div>
    <div class="bagus-grid bagus-grid--3 fade-up-stagger">' . $tes_html . '</div>
  </div>
</section>'
);

$home .= bg_html(
	'<section class="bagus-section bagus-cta" style="background-image:url(' . esc_url( $cta_bg ) . ')">
  <div class="bagus-wrap fade-up">
    <h2>Siap Jelajah Akhir Pekan Ini?</h2>
    <p>Pesan alatmu sekarang, atau tanya dulu ke CS kalau masih bingung pilih yang mana.</p>
    <div class="bagus-btn-row">
      <a class="wp-block-button__link" href="/katalog/">Sewa Sekarang</a>
      <a class="button bagus-btn-wa" href="' . esc_url( bagus_wa_link( 'Halo BAGUS, saya mau tanya tentang sewa alat camping.' ) ) . '" target="_blank" rel="noopener">' . bg_icon( 'chat' ) . 'Tanya Dulu via WA</a>
    </div>
  </div>
</section>'
);
bg_set_page( 'beranda', $home );

/* =============================================================================
 * PAKET CAMPING
 * ========================================================================== */
$paket = bg_html(
	'<section class="bagus-hero bagus-hero--sm" style="background-image:url(' . esc_url( bg_url( 'hero-paket.webp' ) ) . ')">
  <div class="bagus-wrap bagus-hero__inner fade-up">
    <h1>Paket Camping Hemat</h1>
    <p class="lead">Satu klik, semua alat lengkap. Hemat hingga Rp 27.000/hari dibanding sewa satuan.</p>
  </div>
</section>'
);
$paket .= bg_products_section(
	'Lengkap, Tinggal Berangkat',
	'Setiap paket sudah termasuk alat tidur dan—untuk paket berdua &amp; keluarga—alat masak. Paket Berdua adalah yang paling laris.',
	'[product_category category="paket" columns="3" orderby="menu_order"]'
);
$paket .= bg_html(
	'<section class="bagus-section bagus-section--cream">
  <div class="bagus-wrap">
    <div class="bagus-section-head fade-up"><h2>Isi Tiap Paket</h2><p>Bandingkan isi dan penghematan tiap paket di bawah ini.</p></div>
    <div class="bagus-table-wrap fade-up">
      <table class="bagus-table">
        <thead><tr><th>Paket</th><th>Isi</th><th>Harga/hari</th><th>Hemat</th></tr></thead>
        <tbody>
          <tr><td><strong>Pendaki Solo</strong></td><td>Tenda 2 Orang, Carrier 45L, 1 Sleeping Bag, 1 Matras, 1 Headlamp</td><td>Rp 75.000</td><td class="is-save">Rp 13.000</td></tr>
          <tr><td><strong>Camping Ceria Berdua</strong> <span class="badge badge--accent">Terlaris</span></td><td>Tenda 2 Orang, 2 Sleeping Bag, 2 Matras, Kompor, Nesting, 2 Headlamp</td><td>Rp 99.000</td><td class="is-save">Rp 19.000</td></tr>
          <tr><td><strong>Keluarga Glamping</strong></td><td>Tenda 4 Orang, 4 Sleeping Bag, 4 Matras, Kompor, Nesting, Flysheet</td><td>Rp 150.000</td><td class="is-save">Rp 27.000</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</section>'
);
$paket .= bg_html(
	'<section class="bagus-section">
  <div class="bagus-wrap">
    <div class="bagus-section-head fade-up"><h2>Pertanyaan Seputar Paket</h2></div>
    <div class="bagus-faq fade-up">
      <details><summary>Bisa tambah alat di luar paket?</summary><div>Bisa. Tambahkan saja alat lain ke keranjang bersama paketmu — semuanya dihitung dalam satu pesanan.</div></details>
      <details><summary>Ukuran tendanya berapa?</summary><div>Tenda 2 orang muat 2 dewasa + ransel; tenda 4 orang muat 4 dewasa dan punya teras depan. Detail ada di masing-masing produk.</div></details>
      <details><summary>Bagaimana kalau alat rusak?</summary><div>Kerusakan wajar karena pemakaian normal tidak dikenakan biaya. Kerusakan atau kehilangan diganti sesuai biaya perbaikan/harga pasar. Tenang, kami jelaskan di awal kok.</div></details>
      <details><summary>Tabung gas termasuk paket?</summary><div>Belum. Tabung gas butane tidak termasuk demi keamanan, tapi bisa dibeli di basecamp saat pengambilan.</div></details>
    </div>
    <div class="bagus-center" style="margin-top:var(--bagus-space-6)"><a class="button bagus-btn-wa" href="' . esc_url( bagus_wa_link( 'Halo BAGUS, saya mau tanya paket camping custom.' ) ) . '" target="_blank" rel="noopener">' . bg_icon( 'chat' ) . 'Butuh Paket Custom? Chat Kami</a></div>
  </div>
</section>'
);
bg_set_page( 'paket-camping', $paket );

/* =============================================================================
 * CARA SEWA
 * ========================================================================== */
$cara = bg_html(
	'<section class="bagus-hero bagus-hero--sm" style="background-image:url(' . esc_url( bg_url( 'hero-cara-sewa.webp' ) ) . ')">
  <div class="bagus-wrap bagus-hero__inner fade-up">
    <h1>Cara Sewa di BAGUS</h1>
    <p class="lead">Dari pilih alat sampai berangkat, prosesnya cuma lima langkah mudah.</p>
  </div>
</section>'
);
$cara_steps = array(
	array( '01', 'Daftar atau Masuk', 'Buat akun cepat di halaman Akun Saya — cukup email dan password. Sudah punya akun? Tinggal masuk.' ),
	array( '02', 'Pilih Alat &amp; Durasi', 'Telusuri katalog, pilih durasi sewa (1–5 hari), tentukan jumlah, lalu tambahkan ke keranjang.' ),
	array( '03', 'Checkout &amp; Isi Tanggal', 'Isi data diri dan tanggal mulai sewa (paling cepat besok). Tujuan pendakian opsional.' ),
	array( '04', 'Bayar &amp; Konfirmasi WA', 'Pilih Transfer Bank atau Bayar di Tempat (COD), lalu konfirmasi pesanan ke CS via WhatsApp.' ),
	array( '05', 'Ambil / Diantar &amp; Kembalikan', 'Ambil di basecamp atau kami antar. Kembalikan tepat waktu sesuai durasi. Selesai!' ),
);
$cara_html = '';
foreach ( $cara_steps as $s ) {
	$cara_html .= '<div class="bagus-step"><span class="bagus-step__num">' . $s[0] . '</span><div><h3>' . $s[1] . '</h3><p>' . $s[2] . '</p></div></div>';
}
$cara .= bg_html(
	'<section class="bagus-section">
  <div class="bagus-wrap bagus-wrap--narrow">
    <div class="bagus-steps fade-up-stagger">' . $cara_html . '</div>
  </div>
</section>'
);
$cara .= bg_html(
	'<section class="bagus-section bagus-section--cream">
  <div class="bagus-wrap">
    <div class="bagus-grid bagus-grid--2" style="gap:var(--bagus-space-7)">
      <div class="bagus-panel fade-up">
        <h2>Ketentuan Sewa</h2>
        <ul class="bagus-checklist">
          <li>Jaminan <strong>KTP/KTM asli</strong> saat pengambilan alat.</li>
          <li>Durasi dihitung <strong>per 24 jam</strong> sejak pengambilan.</li>
          <li>Keterlambatan dikenakan denda <strong>1 hari sewa per hari</strong>.</li>
          <li>Kerusakan/kehilangan diganti sesuai biaya perbaikan atau harga pasar.</li>
          <li>Pembatalan gratis maksimal <strong>H-1</strong> sebelum tanggal sewa.</li>
        </ul>
      </div>
      <div class="bagus-panel fade-up">
        <h2>Bayar &amp; Terima Alat</h2>
        <p><strong>Transfer Bank (BCA):</strong> 1234567890 a.n. Bagus Pratama. Kirim bukti transfer via WhatsApp.</p>
        <p><strong>Bayar di Tempat (COD):</strong> tunai saat alat diambil atau diantar.</p>
        <p><strong>Ambil di Basecamp (Tembalang):</strong> gratis.<br><strong>Antar Area Kota Semarang:</strong> Rp 15.000.</p>
      </div>
    </div>
  </div>
</section>'
);
$cara .= bg_html(
	'<section class="bagus-section">
  <div class="bagus-wrap">
    <div class="bagus-section-head fade-up"><h2>Sering Ditanyakan</h2></div>
    <div class="bagus-faq fade-up">
      <details><summary>Apakah harus punya akun untuk menyewa?</summary><div>Ya, cukup daftar cepat dengan email dan password. Ini memudahkanmu melihat riwayat pesanan di halaman Akun Saya.</div></details>
      <details><summary>Jam berapa saya bisa ambil alat?</summary><div>Basecamp buka Senin–Jumat 08.00–21.00 dan Sabtu–Minggu 06.00–22.00 WIB. Untuk pengambilan pagi buta, kabari CS dulu ya.</div></details>
      <details><summary>Berapa lama durasi sewa dihitung?</summary><div>Per 24 jam sejak waktu pengambilan. Misalnya ambil Sabtu pukul 07.00, sewa 1 hari berarti kembali Minggu pukul 07.00.</div></details>
      <details><summary>Apa yang terjadi kalau telat mengembalikan?</summary><div>Ada denda sebesar 1 hari sewa untuk setiap hari keterlambatan. Kalau ada kendala, hubungi CS secepatnya agar bisa kami bantu.</div></details>
      <details><summary>Bisakah alat diantar ke luar Kota Semarang?</summary><div>Untuk saat ini pengantaran hanya melayani area Kota Semarang. Di luar itu, silakan ambil di basecamp atau tanyakan opsinya ke CS.</div></details>
    </div>
  </div>
</section>'
);
bg_set_page( 'cara-sewa', $cara );

/* =============================================================================
 * TENTANG KAMI
 * ========================================================================== */
$tentang = bg_html(
	'<section class="bagus-hero bagus-hero--sm" style="background-image:url(' . esc_url( bg_url( 'hero-tentang.webp' ) ) . ')">
  <div class="bagus-wrap bagus-hero__inner fade-up">
    <h1>Dari Pendaki, untuk Pendaki.</h1>
    <p class="lead">BAGUS lahir dari kecintaan pada gunung dan keinginan membuat petualangan alam terjangkau untuk semua.</p>
  </div>
</section>'
);
$tentang .= bg_html(
	'<section class="bagus-section">
  <div class="bagus-wrap">
    <div class="bagus-grid bagus-grid--2 bagus-story" style="gap:var(--bagus-space-7);align-items:center">
      <div class="fade-up bagus-story__media">' . bg_img( 'about-story.webp', 'large' ) . '</div>
      <div class="fade-up">
        <h2>Berawal dari Tiga Tenda</h2>
        <p>BAGUS didirikan <strong>Bagus Pratama</strong>, alumni mapala di Semarang, pada tahun 2021. Semua bermula dari tiga tenda pribadi yang sering dipinjam teman-teman untuk mendaki.</p>
        <p>Melihat banyaknya pendaki muda yang ingin ke gunung tapi terganjal mahalnya membeli alat, Bagus memutuskan menyewakan perlengkapannya secara serius. Kini BAGUS menjadi basecamp dengan <strong>lebih dari 150 alat</strong> siap pakai yang melayani ribuan pendaki setiap tahun.</p>
      </div>
    </div>
  </div>
</section>'
);
$tentang .= bg_html(
	'<section class="bagus-section bagus-section--cream">
  <div class="bagus-wrap">
    <div class="bagus-section-head fade-up"><h2>Apa Itu BAGUS?</h2><p>Lima huruf, satu misi.</p></div>
    <ul class="bagus-acronym fade-up-stagger">
      <li><b>B</b><span>Basecamp</span></li>
      <li><b>A</b><span>Alat</span></li>
      <li><b>G</b><span>Gunung</span></li>
      <li><b>U</b><span>Untuk</span></li>
      <li><b>S</b><span>Semua</span></li>
    </ul>
  </div>
</section>'
);
$visi = array(
	array( 'mountain', 'Petualangan Terjangkau', 'Membuat alam bisa dinikmati siapa saja tanpa harus membeli alat mahal.' ),
	array( 'badge-check', 'Alat Bersih &amp; Aman', 'Setiap alat dirawat, dicuci, dan dicek agar selalu layak dan aman dipakai.' ),
	array( 'leaf', 'Mendaki Bertanggung Jawab', 'Mengedukasi prinsip <em>Leave No Trace</em> — bawa turun kembali semua sampahmu.' ),
);
$visi_html = '';
foreach ( $visi as $v ) {
	$visi_html .= '<div class="bagus-feature"><span class="bagus-feature__icon">' . bg_icon( $v[0] ) . '</span><h3>' . $v[1] . '</h3><p>' . $v[2] . '</p></div>';
}
$tentang .= bg_html(
	'<section class="bagus-section">
  <div class="bagus-wrap">
    <div class="bagus-section-head fade-up"><h2>Yang Kami Perjuangkan</h2></div>
    <div class="bagus-grid bagus-grid--3 fade-up-stagger">' . $visi_html . '</div>
  </div>
</section>'
);
$tentang .= bg_html(
	'<section class="bagus-section bagus-trust">
  <div class="bagus-wrap">
    <div class="bagus-trust__grid">
      <div class="bagus-stat"><span class="bagus-stat__num" data-count-to="2500" data-count-suffix="+">2.500+</span><span class="bagus-stat__label">Penyewa Puas</span></div>
      <div class="bagus-stat"><span class="bagus-stat__num" data-count-to="150" data-count-suffix="+">150+</span><span class="bagus-stat__label">Alat Siap Pakai</span></div>
      <div class="bagus-stat"><span class="bagus-stat__num">4,9</span><span class="bagus-stat__label">Rating Pelanggan</span></div>
      <div class="bagus-stat"><span class="bagus-stat__num">2021</span><span class="bagus-stat__label">Melayani Sejak</span></div>
    </div>
  </div>
</section>'
);
$tentang .= bg_html(
	'<section class="bagus-section bagus-cta" style="background-image:url(' . esc_url( $cta_bg ) . ')">
  <div class="bagus-wrap fade-up">
    <h2>Yuk, Mulai Petualanganmu</h2>
    <p>Pilih alatnya, kami yang urus sisanya. Gunung sudah menunggu.</p>
    <div class="bagus-btn-row"><a class="wp-block-button__link" href="/katalog/">Lihat Katalog Alat</a></div>
  </div>
</section>'
);
bg_set_page( 'tentang-kami', $tentang );

/* =============================================================================
 * KONTAK
 * ========================================================================== */
$cf7_shortcode = '';
if ( defined( 'WPCF7_VERSION' ) ) {
	$form = get_posts(
		array(
			'post_type'   => 'wpcf7_contact_form',
			'numberposts' => 1,
			'orderby'     => 'ID',
			'order'       => 'ASC',
			'fields'      => 'ids',
		)
	);
	if ( ! empty( $form ) ) {
		$cf7_shortcode = '[contact-form-7 id="' . (int) $form[0] . '"]';
	}
}
$form_block = $cf7_shortcode
	? '<!-- wp:shortcode -->' . "\n" . $cf7_shortcode . "\n" . '<!-- /wp:shortcode -->'
	: '<p>Form kontak sedang disiapkan. Sementara itu, hubungi kami via WhatsApp.</p>';

$info = array(
	array( 'map-pin', 'Basecamp', 'Jl. Banjarsari Raya No. 17, Tembalang, Kota Semarang, Jawa Tengah 50275' ),
	array( 'phone', 'WhatsApp', '0857-7759-8395' ),
	array( 'mail', 'Email', 'halo@bagus-outdoor.id' ),
	array( 'clock', 'Jam Operasional', 'Senin–Jumat 08.00–21.00<br>Sabtu–Minggu 06.00–22.00 WIB' ),
);
$info_html = '';
foreach ( $info as $i ) {
	$info_html .= '<li><span class="ic">' . bg_icon( $i[0] ) . '</span><div><strong>' . $i[1] . '</strong>' . $i[2] . '</div></li>';
}
$kontak = bg_html(
	'<section class="bagus-hero bagus-hero--sm" style="background-image:url(' . esc_url( bg_url( 'hero-kontak.webp' ) ) . ')">
  <div class="bagus-wrap bagus-hero__inner fade-up">
    <h1>Hubungi BAGUS</h1>
    <p class="lead">Ada pertanyaan soal alat, rute, atau pesanan? Tim kami siap membantu.</p>
  </div>
</section>'
);
$kontak .= bg_html(
	'<section class="bagus-section">
  <div class="bagus-wrap">
    <div class="bagus-contact-grid">
      <div class="fade-up">
        <div class="bagus-info-card">
          <ul>' . $info_html . '</ul>
          <a class="button bagus-btn-wa" href="' . esc_url( bagus_wa_link( 'Halo BAGUS, saya ingin konsultasi.' ) ) . '" target="_blank" rel="noopener" style="width:100%">' . bg_icon( 'chat' ) . 'Chat CS Sekarang</a>
        </div>
      </div>
      <div class="fade-up">
        <h2>Tulis ke Kami</h2>
        ' . $form_block . '
      </div>
    </div>
  </div>
</section>'
);
$kontak .= bg_html(
	'<section class="bagus-section bagus-section--cream">
  <div class="bagus-wrap bagus-map fade-up">
    <iframe title="Peta lokasi basecamp BAGUS di Tembalang, Semarang" src="https://www.google.com/maps?q=Tembalang,+Semarang,+Jawa+Tengah&output=embed" height="420" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
  </div>
</section>'
);
bg_set_page( 'kontak', $kontak );

/* =============================================================================
 * Katalog / Keranjang / Checkout / Akun — header solid + judul Kadence tampil.
 * ========================================================================== */
foreach ( array( 'katalog', 'keranjang', 'checkout', 'akun-saya' ) as $slug ) {
	bg_solid_header( $slug );
}
foreach ( array( 'beranda', 'paket-camping', 'cara-sewa', 'tentang-kami', 'kontak' ) as $slug ) {
	$id = bagus_page_id( $slug );
	if ( $id ) {
		update_post_meta( $id, '_kad_post_title', 'hide' );
	}
}

WP_CLI::success( 'Konten halaman siap.' );
