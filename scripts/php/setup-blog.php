<?php
/**
 * Seed 3 artikel blog BAGUS (Tips & Destinasi). Idempoten (cari by slug).
 * Dijalankan via: wp eval-file setup-blog.php
 *
 * Tiap artikel 500–800 kata + gambar unggulan + CTA box ke paket terkait.
 *
 * @package bagus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once __DIR__ . '/_helpers.php';

// Kategori post.
$cats = array(
	'destinasi' => 'Destinasi',
	'tips'      => 'Tips',
);
$cat_ids = array();
foreach ( $cats as $slug => $name ) {
	$term = get_term_by( 'slug', $slug, 'category' );
	if ( ! $term ) {
		$res               = wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
		$cat_ids[ $slug ]  = is_wp_error( $res ) ? 0 : (int) $res['term_id'];
	} else {
		$cat_ids[ $slug ] = (int) $term->term_id;
	}
}

/** CTA box penutup artikel. */
function bagus_article_cta( $text, $label, $url ) {
	return '<!-- wp:html --><div class="bagus-article-cta"><p>' . $text . '</p><a class="wp-block-button__link" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></div><!-- /wp:html -->';
}

$articles = array(

	/* ===================================================================== */
	array(
		'slug'     => 'panduan-mendaki-gunung-ungaran-via-basecamp-mawar',
		'title'    => 'Panduan Mendaki Gunung Ungaran via Basecamp Mawar untuk Pemula',
		'excerpt'  => 'Gunung Ungaran (2.050 mdpl) adalah pilihan ideal untuk pendakian pertamamu. Dekat dari Semarang, jalurnya jelas, dan pemandangannya juara. Simak panduan lengkapnya.',
		'cat'      => 'destinasi',
		'img'      => 'blog-ungaran-mawar.webp',
		'cta'      => array( 'Butuh alat untuk ke Ungaran? Paket Pendaki Solo sudah lengkap untuk satu orang — tenda, carrier, sleeping bag, matras, dan headlamp.', 'Lihat Paket Pendaki Solo →', '/produk/paket-pendaki-solo/' ),
		'content'  => <<<'HTML'
<!-- wp:paragraph --><p>Gunung Ungaran (2.050 mdpl) adalah salah satu gunung paling bersahabat untuk pendaki pemula di sekitar Semarang. Lokasinya dekat, jalurnya relatif jelas, dan pemandangan dari puncaknya—lautan awan dengan latar Gunung Sindoro dan Sumbing—sepadan dengan usaha mendakinya. Lewat jalur <strong>Basecamp Mawar</strong>, Ungaran bisa diselesaikan dalam waktu yang masuk akal untuk trip akhir pekan.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>Lokasi &amp; Akses dari Semarang</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Basecamp Mawar berada di kawasan Jimbaran, Bandungan, Kabupaten Semarang. Dari pusat Kota Semarang, perjalanan menuju basecamp memakan waktu sekitar <strong>1 jam</strong> berkendara ke arah Bandungan. Jalurnya sudah beraspal hingga dekat basecamp, jadi mudah diakses baik dengan motor maupun mobil. Tersedia area parkir dan warung di sekitar basecamp untuk mengisi perut sebelum berangkat.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>Estimasi Waktu &amp; Pos-Pos Pendakian</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Pendakian dari Basecamp Mawar ke puncak umumnya memakan waktu <strong>3–4 jam</strong> untuk pendaki pemula, tergantung ritme dan cuaca. Jalur melewati beberapa titik yang bisa dijadikan patokan istirahat:</p><!-- /wp:paragraph -->
<!-- wp:list --><ul>
<li><strong>Basecamp → Pos 1 (Premdeveloped):</strong> jalur landai menembus kebun dan hutan pinus, sekitar 45 menit.</li>
<li><strong>Pos 1 → Pos 2:</strong> mulai menanjak, banyak bonus datar, sekitar 1 jam.</li>
<li><strong>Pos 2 → Pos 3:</strong> tanjakan lebih serius, vegetasi makin rapat, sekitar 1 jam.</li>
<li><strong>Pos 3 → Puncak:</strong> tanjakan akhir berbatu, sekitar 45 menit, dengan pemandangan mulai terbuka.</li>
</ul><!-- /wp:list -->

<!-- wp:heading --><h2>Tips untuk Pendaki Pemula</h2><!-- /wp:heading -->
<!-- wp:list --><ul>
<li><strong>Berangkat pagi atau tektok dini hari.</strong> Jika ingin mengejar sunrise, mulai mendaki sekitar pukul 02.00–03.00. Untuk camping, berangkat siang agar sampai puncak sebelum gelap.</li>
<li><strong>Bawa air cukup.</strong> Sumber air terbatas di jalur, jadi siapkan minimal 1,5–2 liter per orang.</li>
<li><strong>Cek cuaca.</strong> Kawasan Bandungan sering berkabut dan hujan sore hari. Bawa jas hujan atau flysheet.</li>
<li><strong>Jaga kebersihan.</strong> Terapkan prinsip <em>Leave No Trace</em>—semua sampah yang kamu bawa naik, bawa turun kembali.</li>
<li><strong>Gunakan alat yang tepat.</strong> Sepatu dengan grip bagus, headlamp, dan jaket windproof sangat membantu di jalur Ungaran yang kadang licin dan berangin.</li>
</ul><!-- /wp:list -->

<!-- wp:heading --><h2>Perkiraan Biaya</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Salah satu alasan Ungaran ramah di kantong adalah biayanya yang terjangkau. Perkiraan pengeluaran untuk satu orang (trip 1 malam):</p><!-- /wp:paragraph -->
<!-- wp:list --><ul>
<li>Tiket masuk &amp; registrasi basecamp: ± Rp 15.000–20.000</li>
<li>Parkir kendaraan: ± Rp 10.000</li>
<li>Sewa alat (tenda, sleeping bag, matras, dll.) via BAGUS: mulai Rp 75.000/hari untuk paket solo</li>
<li>Logistik makan &amp; air: ± Rp 50.000</li>
</ul><!-- /wp:list -->
<!-- wp:paragraph --><p>Dengan menyewa alat, kamu tidak perlu mengeluarkan ratusan ribu hingga jutaan rupiah untuk membeli perlengkapan yang mungkin hanya dipakai sesekali. Ini membuat Ungaran jadi pilihan tepat untuk mencoba dunia pendakian tanpa beban biaya besar.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>Persiapan Fisik &amp; Waktu Terbaik</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Meski tergolong ramah pemula, Ungaran tetap menuntut kesiapan fisik dasar. Mulailah berjalan kaki atau jogging ringan 2–3 kali seminggu sejak dua minggu sebelum pendakian agar napas dan kaki terbiasa. Latihan naik-turun tangga juga membantu menyiapkan otot untuk tanjakan dan turunan.</p><!-- /wp:paragraph -->
<!-- wp:paragraph --><p>Soal waktu, musim kemarau (sekitar April hingga September) umumnya menawarkan cuaca paling bersahabat dan peluang <em>sunrise</em> cerah yang lebih besar. Hindari mendaki saat hujan deras karena jalur tanah di Ungaran bisa menjadi sangat licin dan berisiko. Selalu pantau prakiraan cuaca beberapa hari sebelum berangkat, dan jangan ragu menunda jika kondisi tidak mendukung—gunung tidak akan ke mana-mana.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>Penutup</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Gunung Ungaran via Basecamp Mawar menawarkan kombinasi ideal: akses mudah, jalur yang ramah pemula, dan pemandangan yang memukau. Dengan persiapan fisik secukupnya dan alat yang memadai, pendakian pertamamu bisa jadi pengalaman yang menyenangkan—bukan menyiksa. Siapkan tanggalnya, ajak teman, dan jadikan Ungaran gerbang petualanganmu di dunia mendaki.</p><!-- /wp:paragraph -->
HTML,
	),

	/* ===================================================================== */
	array(
		'slug'     => 'checklist-alat-camping-wajib-pemula',
		'title'    => 'Checklist Alat Camping Wajib untuk Pemula (Plus Estimasi Biaya Sewa)',
		'excerpt'  => 'Bingung harus bawa apa saja untuk camping pertama? Ini checklist alat wajib beserta fungsinya, plus perbandingan biaya sewa vs beli yang bikin kamu berpikir ulang.',
		'cat'      => 'tips',
		'img'      => 'blog-checklist-alat.webp',
		'cta'      => array( 'Daripada beli satu per satu, ambil Paket Camping Ceria Berdua—tenda, alat tidur, dan alat masak lengkap untuk dua orang, hemat Rp 19.000/hari.', 'Lihat Paket Camping Ceria Berdua →', '/produk/paket-camping-ceria-berdua/' ),
		'content'  => <<<'HTML'
<!-- wp:paragraph --><p>Camping pertama selalu terasa membingungkan: apa saja yang harus dibawa? Jangan sampai ketinggalan barang penting, tapi juga jangan sampai ranselmu kelebihan beban. Artikel ini merangkum <strong>checklist alat camping wajib</strong> untuk pemula, lengkap dengan fungsinya, lalu membandingkan biaya sewa versus beli agar kamu bisa mengambil keputusan yang masuk akal.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>1. Alat Tidur &amp; Berlindung</h2><!-- /wp:heading -->
<!-- wp:list --><ul>
<li><strong>Tenda</strong> — rumah sementaramu di gunung. Pilih kapasitas sesuai jumlah orang. Tenda dome mudah didirikan dan tahan angin.</li>
<li><strong>Sleeping bag</strong> — menjaga tubuh tetap hangat saat suhu turun di malam hari. Wajib, apalagi di atas 1.500 mdpl.</li>
<li><strong>Matras</strong> — alas tidur yang menahan dingin dan lembapnya tanah. Matras foil ringan dan memantulkan panas tubuh.</li>
<li><strong>Flysheet</strong> — opsional tapi berguna sebagai atap tambahan atau pelindung logistik dari hujan.</li>
</ul><!-- /wp:list -->

<!-- wp:heading --><h2>2. Alat Masak &amp; Makan</h2><!-- /wp:heading -->
<!-- wp:list --><ul>
<li><strong>Kompor portable</strong> — untuk memasak air dan makanan. Pilih yang ringkas dan hemat gas.</li>
<li><strong>Nesting cooking set</strong> — panci, wajan, dan ketel yang menyatu rapi. Satu set cukup untuk kebutuhan dapur gunung.</li>
<li><strong>Tabung gas, korek, sendok, dan gelas</strong> — jangan lupa barang-barang kecil ini.</li>
</ul><!-- /wp:list -->

<!-- wp:heading --><h2>3. Tas &amp; Navigasi</h2><!-- /wp:heading -->
<!-- wp:list --><ul>
<li><strong>Carrier</strong> — ransel besar (45–60 liter) untuk membawa semua perlengkapan. Pilih yang punya sistem punggung nyaman dan rain cover.</li>
<li><strong>Headlamp</strong> — penerangan yang membebaskan kedua tanganmu. Wajib untuk summit dini hari.</li>
<li><strong>Trekking pole</strong> — membantu keseimbangan dan mengurangi beban lutut di turunan.</li>
</ul><!-- /wp:list -->

<!-- wp:heading --><h2>4. Pakaian &amp; Perlindungan</h2><!-- /wp:heading -->
<!-- wp:list --><ul>
<li><strong>Jaket gunung windproof</strong> — menahan angin dingin dan gerimis.</li>
<li><strong>Baju ganti, kaos kaki, dan sarung tangan</strong> — bawa secukupnya dalam kantong anti-air.</li>
<li><strong>Jas hujan</strong> — cuaca gunung bisa berubah drastis.</li>
</ul><!-- /wp:list -->

<!-- wp:heading --><h2>5. Perlengkapan Pribadi &amp; P3K</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Obat pribadi, plester, antiseptik, air minum minimal 2 liter, makanan berenergi, dan kantong sampah untuk membawa turun sampahmu. Jangan pernah meninggalkan jejak selain tapak kaki.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>Tips Packing yang Efisien</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Membawa alat yang lengkap percuma jika packing-nya berantakan. Beberapa prinsip sederhana bisa membuat ranselmu nyaman di punggung: letakkan barang berat (seperti tenda dan logistik air) dekat punggung dan setinggi bahu agar titik beban dekat dengan tubuh. Simpan sleeping bag di dasar carrier karena baru dipakai saat tiba di lokasi, dan taruh jas hujan, headlamp, serta P3K di kantong yang mudah dijangkau.</p><!-- /wp:paragraph -->
<!-- wp:paragraph --><p>Gunakan kantong anti-air atau <em>trash bag</em> sebagai pelapis dalam carrier untuk melindungi barang dari hujan. Kelompokkan barang sejenis dalam kantong terpisah—misalnya satu kantong untuk pakaian, satu untuk alat masak—agar tidak perlu membongkar seluruh isi hanya untuk mencari satu benda. Terakhir, timbang kembali: jika ragu apakah suatu barang benar-benar dibutuhkan, kemungkinan besar kamu bisa meninggalkannya.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>Sewa vs Beli: Mana yang Lebih Masuk Akal?</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Membeli perlengkapan camping lengkap bisa menghabiskan <strong>jutaan rupiah</strong>: tenda bagus mulai Rp 500.000, carrier Rp 400.000, sleeping bag Rp 150.000, dan seterusnya. Untuk pemula yang baru mencoba atau yang mendaki beberapa kali setahun, angka ini sulit dijustifikasi.</p><!-- /wp:paragraph -->
<!-- wp:paragraph --><p>Sebagai perbandingan, menyewa satu set alat lengkap untuk berdua lewat BAGUS hanya <strong>Rp 99.000/hari</strong> (Paket Camping Ceria Berdua). Artinya, kamu bisa camping belasan kali dengan biaya sewa sebelum menyamai harga membeli satu set baru—tanpa pusing soal perawatan, penyimpanan, dan penyusutan alat.</p><!-- /wp:paragraph -->
<!-- wp:paragraph --><p>Kesimpulannya: jika kamu mendaki rutin setiap bulan, membeli bisa jadi investasi. Tapi jika kamu pemula atau pendaki musiman, <strong>menyewa jauh lebih hemat dan praktis</strong>. Mulai dari menyewa, kenali dulu alat mana yang benar-benar cocok untukmu sebelum memutuskan membeli.</p><!-- /wp:paragraph -->
HTML,
	),

	/* ===================================================================== */
	array(
		'slug'     => 'camping-ceria-di-gunung-andong',
		'title'    => 'Camping Ceria di Gunung Andong: Spot Sunrise Terbaik Dekat Semarang',
		'excerpt'  => 'Gunung Andong (1.726 mdpl) adalah surga camping ramah keluarga dengan sunrise memukau. Jalurnya pendek, puncaknya lapang. Ini panduan lengkapnya.',
		'cat'      => 'destinasi',
		'img'      => 'blog-andong-sunrise.webp',
		'cta'      => array( 'Mau camping keluarga di Andong? Paket Keluarga Glamping muat untuk empat orang—tenda lapang, alat tidur, dan alat masak lengkap.', 'Lihat Paket Keluarga Glamping →', '/produk/paket-keluarga-glamping/' ),
		'content'  => <<<'HTML'
<!-- wp:paragraph --><p>Jika kamu mencari gunung yang ramah untuk camping keluarga sekaligus menyuguhkan sunrise kelas satu, <strong>Gunung Andong</strong> (1.726 mdpl) adalah jawabannya. Terletak di Magelang dan mudah dijangkau dari Semarang, Andong terkenal dengan jalurnya yang pendek, puncaknya yang lapang berbentuk punggungan, dan panorama matahari terbit yang dikelilingi deretan gunung lain.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>Akses Menuju Basecamp</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Dari Kota Semarang, perjalanan ke basecamp Gunung Andong (umumnya via Sawit atau Pendem) memakan waktu sekitar <strong>1,5–2 jam</strong> berkendara ke arah Magelang–Kopeng. Jalur menuju basecamp sudah bagus dan banyak penunjuk arah. Tersedia area parkir luas, warung, dan toilet di basecamp, sehingga nyaman untuk keluarga yang membawa anak.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>Jalur Pendakian</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Salah satu daya tarik Andong adalah waktu tempuhnya yang singkat—hanya sekitar <strong>1,5–2 jam</strong> dari basecamp ke puncak. Jalurnya cukup jelas dengan beberapa pos dan warung di tengah perjalanan. Meski pendek, tetap ada tanjakan yang lumayan, jadi tetap siapkan fisik dan jangan lupa pemanasan.</p><!-- /wp:paragraph -->
<!-- wp:paragraph --><p>Karena jalurnya ramah, Andong cocok untuk pendaki keluarga, termasuk anak-anak yang sudah terbiasa jalan jauh. Tetap dampingi anak di bagian tanjakan dan dekat punggungan puncak yang bertebing di kedua sisi.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>Spot Camping &amp; Sunrise Terbaik</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Puncak Andong berupa punggungan memanjang yang terdiri dari beberapa titik: Puncak Jiwa, Puncak Makam, dan Puncak Andong. Area datar di sekitar punggungan ini menjadi lokasi favorit mendirikan tenda. Dari sini, saat cuaca cerah, kamu bisa menyaksikan matahari terbit dengan latar <strong>Gunung Merbabu, Merapi, Telomoyo, dan Sumbing</strong> yang berjajar megah.</p><!-- /wp:paragraph -->
<!-- wp:list --><ul>
<li>Datang lebih awal agar kebagian spot tenda terbaik, terutama saat akhir pekan yang ramai.</li>
<li>Dirikan tenda di tempat datar dan tidak terlalu dekat dengan tepi punggungan demi keamanan.</li>
<li>Siapkan kamera atau ponsel dengan baterai penuh—sunrise di sini sayang untuk dilewatkan.</li>
</ul><!-- /wp:list -->

<!-- wp:heading --><h2>Tips Camping Keluarga di Andong</h2><!-- /wp:heading -->
<!-- wp:list --><ul>
<li><strong>Bawa tenda berkapasitas cukup.</strong> Untuk keluarga, tenda 4 orang dengan teras depan membuat aktivitas lebih nyaman.</li>
<li><strong>Siapkan lapisan hangat.</strong> Suhu malam di Andong bisa cukup dingin. Sleeping bag dan matras untuk setiap anggota keluarga itu wajib.</li>
<li><strong>Bawa makanan hangat.</strong> Dengan kompor dan nesting, kamu bisa memasak mi, menyeduh cokelat panas, dan menghangatkan suasana.</li>
<li><strong>Kelola sampah.</strong> Ajari anak membawa turun sampah sendiri—pelajaran berharga sejak dini tentang menjaga alam.</li>
</ul><!-- /wp:list -->

<!-- wp:heading --><h2>Etika &amp; Keselamatan di Puncak</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Karena puncak Andong berupa punggungan sempit dengan tebing di kedua sisi, keselamatan adalah prioritas. Jangan mendirikan tenda terlalu dekat dengan tepi, dan awasi anak-anak setiap saat, terutama saat gelap. Angin kencang kadang melanda di malam hari, jadi pastikan pasak dan tali tenda terpasang kuat sejak awal.</p><!-- /wp:paragraph -->
<!-- wp:paragraph --><p>Andong adalah gunung yang ramai, maka etika pendakian sangat penting agar kenyamanan tetap terjaga bersama. Jaga volume suara di malam hari, hormati pendaki lain yang beristirahat, dan antre dengan sabar di titik foto populer. Dan yang paling utama: bawa turun seluruh sampahmu. Puncak yang bersih adalah warisan yang kita tinggalkan untuk pendaki berikutnya.</p><!-- /wp:paragraph -->

<!-- wp:heading --><h2>Penutup</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Gunung Andong membuktikan bahwa pengalaman camping yang berkesan tidak harus melewati pendakian yang berat. Dengan jalur pendek, fasilitas memadai, dan sunrise yang menakjubkan, Andong adalah pilihan sempurna untuk memperkenalkan keluarga pada keindahan camping di gunung. Siapkan alatnya, pilih akhir pekan yang cerah, dan ciptakan kenangan bersama orang-orang tersayang.</p><!-- /wp:paragraph -->
HTML,
	),
);

$done = 0;
foreach ( $articles as $a ) {
	$existing = get_page_by_path( $a['slug'], OBJECT, 'post' );
	$content  = $a['content'] . "\n" . bagus_article_cta( $a['cta'][0], $a['cta'][1], $a['cta'][2] );

	$postarr = array(
		'post_type'    => 'post',
		'post_status'  => 'publish',
		'post_name'    => $a['slug'],
		'post_title'   => $a['title'],
		'post_excerpt' => $a['excerpt'],
		'post_content' => $content,
	);
	if ( $existing ) {
		$postarr['ID'] = $existing->ID;
	}
	$post_id = wp_insert_post( $postarr, true );
	if ( is_wp_error( $post_id ) ) {
		WP_CLI::warning( "Artikel {$a['slug']}: " . $post_id->get_error_message() );
		continue;
	}

	// Kategori.
	if ( ! empty( $cat_ids[ $a['cat'] ] ) ) {
		wp_set_post_categories( $post_id, array( $cat_ids[ $a['cat'] ] ) );
	}

	// Gambar unggulan.
	$img_id = bagus_import_image( $a['img'] );
	if ( $img_id ) {
		set_post_thumbnail( $post_id, $img_id );
	}

	++$done;
	WP_CLI::log( "  ✓ {$a['title']}" );
}

// Hapus kategori default "Uncategorized" dari daftar jika kosong (opsional, abaikan error).
WP_CLI::success( "Blog siap ({$done} artikel)." );
