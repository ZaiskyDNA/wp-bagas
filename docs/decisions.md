# Catatan Keputusan (Decision Log)

Format: tanggal — keputusan — alasan. Keputusan yang disetujui pemilik ditandai ✅.

## Desain

| Tanggal | Keputusan | Alasan |
|---|---|---|
| 2026-10-11 | ✅ Folder `reference/` di-rename menjadi `design-references/` (sesuai PRD) + `README.md` & `links.md` | Menyamakan struktur dengan PRD Bagian 0 & 10.1 |
| 2026-10-11 | ✅ Arah visual mengikuti `design-references/hiking website design inspiration.jpeg` (editorial gelap, aksen emas), menggantikan palet hijau/oranye Bagian 8 | PRD: referensi di folder menang atas Bagian 8 |
| 2026-10-11 | ✅ Font: **Playfair Display** (heading) + **Plus Jakarta Sans** (body), di-host lokal | Mendekati serif referensi; maks. 2 keluarga font |
| 2026-10-11 | ✅ Trust bar ditempel di bawah hero (seperti statistik referensi) | Disetujui pemilik |
| 2026-10-11 | ✅ Kartu destinasi menampilkan mdpl + estimasi durasi + tingkat kesulitan | Disetujui pemilik |
| 2026-10-11 | ✅ Cara Sewa memakai layout split angka besar "01/02/03" + foto (fallback ikon) | Disetujui pemilik |
| 2026-10-11 | ✅ Gambar dibuat pemilik dengan AI (`content/images/IMAGE-PROMPTS.md`), menggantikan Unsplash/Pexels di PRD 7.5 | Instruksi pemilik |
| 2026-10-11 | Tombol WA (Click to Chat) memakai teks/ikon ink `#0F1D22` di atas `#25D366` | Teks putih di hijau WA hanya 1,98:1 (gagal AA), ink 8,68:1 |

### Design tokens (draf, difinalkan di Fase 2)
| Token | Nilai | Kontras utama |
|---|---|---|
| `--bagus-ink` | `#0F1D22` | teks cream di atasnya 14,74:1 |
| `--bagus-pine` | `#24483E` | teks putih 10,14:1 |
| `--bagus-sand` (CTA) | `#D8B573` | teks ink 8,84:1 (teks putih 1,95:1 ✗) |
| `--bagus-sand-ink` | `#7A5B22` | di atas cream 5,37:1 |
| `--bagus-cream` | `#F1EDE4` | — |
| `--bagus-paper` | `#FAF8F3` | — |
| `--bagus-text` | `#1B2326` | di atas cream 13,67:1 |
| `--bagus-muted` | `#5E676A` | di atas cream 4,96:1 |
| `--bagus-wa` | `#25D366` | teks ink 8,68:1 |
| Font | Playfair Display / Plus Jakarta Sans | — |
| Radius | tombol pil `999px`, kartu `14px`, input `10px` | — |

## Teknis

| Tanggal | Keputusan | Alasan |
|---|---|---|
| 2026-10-11 | Port lokal default **8088** (bisa diubah via `WP_PORT` di `.env`) | Port 8080 sudah dipakai container proyek lain di mesin pemilik |
| 2026-10-11 | Image `wordpress:6-php8.3-apache`, `mariadb:11`, `wordpress:cli-php8.3` (PRD: php8.2 / mariadb 10.11) | Image sudah ada di mesin (disk tinggal ± 5 GB). PHP 8.3 juga didukung blueprint Bitnami Lightsail |
| 2026-10-11 | `setup.sh` menjalankan `wp core update` sebelum memasang plugin | WooCommerce terbaru (11.x) mensyaratkan WordPress ≥ 7.0, sedangkan image masih membawa 6.9. Hasil: WP 7.1.3 + WC 11.2.1 |
| 2026-10-11 | `setup.sh` bisa dijalankan dari host; script otomatis menjalankan dirinya sendiri di container `wpcli` (`docker compose run`) | Satu perintah, tanpa perlu WP-CLI di host |
| 2026-10-11 | Logika konfigurasi kompleks (halaman, shipping, payment, menu, Click to Chat) ditulis sebagai PHP di `scripts/php/*.php` dan dijalankan via `wp eval-file` | Lebih mudah dibuat idempoten daripada `wp wc ...` REST (cek-lalu-buat, tanpa duplikat) |
| 2026-10-11 | Halaman WooCommerce bawaan (shop/cart/checkout/my-account) **dipakai ulang** dan di-rename ke `katalog`/`keranjang`/`checkout`/`akun-saya`. Isi cart/checkout dipaksa ke shortcode klasik | WooCommerce baru membuat halaman block Cart/Checkout. Field checkout kustom butuh checkout klasik (PRD F-04) |
| 2026-10-11 | Halaman konten dibuat dengan isi placeholder dan **tidak ditimpa** oleh `setup.sh`. Konten final di-import `seed-content.sh` (Fase 4) | Memisahkan setup dari konten |
| 2026-10-11 | Permalink kategori produk `/kategori-alat/`, tag `/tag-alat/`, produk `/produk/` | URL berbahasa Indonesia |
| 2026-10-11 | Menu footer dipecah menjadi **Footer Jelajahi** & **Footer Bantuan** (PRD menyebut "Menu Footer") | Sesuai kolom footer di PRD 4.2 |
| 2026-10-11 | Zona "Locations not covered" tanpa metode pengiriman; gateway Cek/PayPal dimatikan | Hanya Indonesia, hanya BACS + COD |
| 2026-10-11 | Opsi onboarding WooCommerce (coming soon, task list, tracking, saran marketplace) dimatikan via `setup.sh` | Situs langsung tampil publik, admin lebih bersih |
| 2026-10-11 | Nomor WA hanya didefinisikan di konstanta `BAGUS_WA_NUMBER` (`mu-plugins/bagus-core.php`). `setup-ctc.php` membacanya untuk Click to Chat | Satu sumber kebenaran (PRD Bagian 3) |
| 2026-10-11 | `DISALLOW_FILE_EDIT` aktif di lokal | Hardening ringan |

## Fase 3–5 (Produk, Transaksi, Konten, Blog)

| Tanggal | Keputusan | Alasan |
|---|---|---|
| 2026-10-12 | Produk = Variable Product dengan atribut **global** `pa_durasi-sewa` (1/2/3/5 Hari). Seeder `setup-products.php` idempoten (cari by SKU, variasi dibangun ulang) | Satu atribut dipakai 15 produk; harga per durasi sesuai PRD 7.2 |
| 2026-10-12 | **Tidak** menyetel default attribute pada produk | Agar tombol "Tambah ke Keranjang" nonaktif sampai Durasi Sewa dipilih (PRD F-04 AC2) |
| 2026-10-12 | Gambar diimpor ke Media Library sekali saja (meta `_bagus_src`), alt text dari `IMAGE-PROMPTS.md` (helper `scripts/php/_helpers.php`) | Idempoten, alt text konsisten (PRD Rubrik 5) |
| 2026-10-12 | Konten halaman dibangun sebagai blok `wp:html` (section kustom) + `wp:shortcode` (grid Woo), membawa class `.bagus-*` yang di-style di `assets/css/content.css` | Render front-end stabil tanpa masalah validasi blok; styling terpusat |
| 2026-10-12 | Grid produk (Beranda "Terlaris" & Paket) dibungkus `group.bagus-wrap` | Agar shortcode `[products]`/`[product_category]` tidak melebar penuh di layout fullwidth |
| 2026-10-12 | **Transparent header dinonaktifkan** (header solid di semua halaman; sticky ink saat scroll) | Lebih konsisten & aman untuk aksesibilitas; nav selalu terbaca di latar terang maupun hero gelap |
| 2026-10-12 | Judul Kadence disembunyikan di halaman konten (punya H1 di hero sendiri), tetap tampil di Katalog/Keranjang/Checkout/Akun | Hindari judul ganda; Woo pages butuh heading |
| 2026-10-12 | Checkout 2 kolom dibuat pada `form.checkout` (bukan `.woocommerce`); `#customer_details` & `#order_review` dipaksa `width:100%` karena Woo memberi ~48% | Field sewa tampil penuh di kolom kiri, ringkasan sticky di kanan |
| 2026-10-12 | Chip filter kategori ditambah via hook `woocommerce_before_shop_loop` (child theme) | PRD F-05: filter kategori di Katalog & arsip; chip scroll horizontal di mobile |
| 2026-10-12 | `product_archive_style` = `standard` (tombol "Pilih Opsi" selalu tampil) | `action-on-hover` menyembunyikan tombol di layar sentuh |
| 2026-10-12 | Footer top dipaksa 2 kolom (≤767px) / 1 kolom (≤479px) via CSS | Kadence tetap memberi 4 kolom sempit di mobile |
| 2026-10-12 | 3 artikel blog (514–545 kata) via `setup-blog.php`, kategori Destinasi/Tips, tiap artikel diakhiri CTA box ke paket terkait | PRD F-07 (min. 3 artikel 500–800 kata, AC1 CTA) |
| 2026-10-12 | Form kontak CF7 (Nama, Email, No. WA, Pesan) via `setup-contact-form.php`; dipetakan ke Flamingo (`flamingo_subject`) | PRD F-08; pesan tersimpan walau email gagal terkirim |
| 2026-10-12 | Data demo (`seed-demo.php`): akun `demo@bagus-outdoor.id` + 2 pesanan contoh, **terpisah** dari `setup.sh` | PRD 12.4; dijalankan manual sebelum demo, idempoten |

## Catatan / tindak lanjut — RESOLVED
- ✅ Separator judul `Judul — BAGUS` (em dash) — filter `document_title_separator` di `functions.php`.
- ✅ `aria-label="Chat WhatsApp CS BAGUS"` pada tombol melayang Click to Chat — di-set via mu-plugin (`wp_footer`).
- ✅ Tombol konfirmasi WA di Pesanan Diterima memuat nomor pesanan yang benar (diuji: pesanan #243).
- Email lokal tidak terkirim (`sendmail: can't connect`). Ini sesuai PRD 10.6 (SMTP opsional) dan tidak mengganggu.
- **Sebelum demo:** ganti `BAGUS_WA_NUMBER` (mu-plugin) ke nomor asli lalu jalankan ulang `setup-ctc.php`; ganti password admin. Lihat `docs/deployment.md`.
