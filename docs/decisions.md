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

## Catatan / tindak lanjut
- **Fase 2:** separator judul `Judul — BAGUS` (saat ini `Judul – BAGUS`, PRD F-01 AC3).
- **Fase 3:** `aria-label` tombol melayang saat ini mengikuti teks CTA ("Chat CS"). PRD F-03 AC4 meminta `aria-label="Chat WhatsApp CS BAGUS"`, jadi akan disesuaikan lewat mu-plugin.
- Email lokal tidak terkirim (`sendmail: can't connect`). Ini sesuai PRD 10.6 (SMTP opsional) dan tidak mengganggu.
