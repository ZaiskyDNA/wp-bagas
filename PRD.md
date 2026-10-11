# PRD — BAGUS: Website Rental Alat Camping & Hiking

> **BAGUS** = **B**asecamp **A**lat **G**unung **U**ntuk **S**emua
> Tagline: ***"Mendaki Jadi Lebih BAGUS."***

| Atribut | Nilai |
|---|---|
| Versi dokumen | 1.0 |
| Tanggal | 10 Oktober 2026 |
| Pemilik produk | Bagus (pemilik usaha, fiktif) |
| Jenis proyek | Tugas kuliah: website produk/jasa berbasis CMS di atas PaaS/IaaS |
| CMS | WordPress + WooCommerce |
| Hosting | AWS Lightsail (WordPress blueprint by Bitnami) |
| Bahasa website | Bahasa Indonesia |
| Lokasi usaha | Semarang, Jawa Tengah (fiktif) |

---

## 0. Instruksi untuk AI Agent (WAJIB DIBACA PERTAMA)

Dokumen ini adalah **sumber kebenaran utama (single source of truth)** proyek. Aturan kerja agent:

1. **Baca seluruh PRD ini** sebelum menulis kode atau konten apa pun.
2. **Desain:** sebelum mengerjakan tampilan, **baca folder `design-references/`** (screenshot, `README.md`, `links.md`). Jika ada konflik antara referensi di folder tersebut dan Bagian 8 (Design System sementara), **referensi di folder yang menang**. Jika folder masih kosong, gunakan Bagian 8 sebagai default.
3. **Hanya gunakan plugin/tema GRATIS** yang tercantum di Bagian 9. Jangan menambah plugin lain tanpa persetujuan pemilik.
4. **Utamakan otomasi dengan WP-CLI** dan kode di repo (child theme + mu-plugin). Konfigurasi manual lewat wp-admin hanya jika tidak bisa dilakukan via WP-CLI, dan catat langkahnya di `docs/`.
5. Konten halaman ditulis sebagai **block markup Gutenberg** (bukan Elementor) agar bisa disimpan di repo dan di-import otomatis.
6. **Semua teks UI dalam Bahasa Indonesia** yang santai tapi sopan (sapaan "Kamu").
7. **Jangan commit rahasia:** password admin, kredensial DB, kunci SSH, dan file `.env` harus masuk `.gitignore`.
8. Setiap fitur harus memenuhi **Acceptance Criteria** di Bagian 6 dan lolos **checklist pengujian** di Bagian 14.
9. Jika ada keputusan yang tidak tercakup di PRD, pilih solusi **paling sederhana, gratis, dan ringan**, lalu catat di `docs/decisions.md`.

---

## 1. Ringkasan Produk

**BAGUS** adalah usaha rental alat camping dan hiking di Semarang. Pelanggan bisa menyewa tenda, carrier, sleeping bag, alat masak, dan paket bundling secara online. Caranya: pilih alat, masukkan ke keranjang, checkout dengan tanggal mulai sewa, lalu konfirmasi ke CS via WhatsApp.

### 1.1 Masalah
- Peralatan outdoor mahal, padahal hanya dipakai beberapa kali setahun.
- Rental offline merepotkan: harus datang langsung, stok tidak jelas, harga tidak transparan.
- Pendaki pemula tidak tahu alat apa saja yang perlu dibawa.

### 1.2 Solusi
- Katalog online dengan **harga sewa transparan per durasi** (1/2/3/5 hari).
- **Paket bundling** siap pakai untuk pemula, berdua, dan keluarga.
- **Checkout online** (keranjang WooCommerce) dengan pilihan ambil di basecamp atau diantar.
- **Tombol WhatsApp** di semua halaman untuk tanya stok atau konsultasi rute.
- Konten **Tips & Destinasi** sekitar Semarang (Ungaran, Andong, Merbabu, Prau).

### 1.3 Target Pengguna
| Segmen | Deskripsi | Kebutuhan utama |
|---|---|---|
| Mahasiswa | Mahasiswa Undip/Unnes/Polines, anggota mapala | Harga murah, paket hemat |
| Pekerja muda | 22–30 tahun, *weekend trip* | Proses cepat, alat terawat, bisa diantar |
| Keluarga | Camping santai / glamping | Paket lengkap, mudah dipakai |
| Pendaki pemula | Pertama kali naik gunung | Panduan alat, konsultasi via WA |

### 1.4 Persona Utama
**Rina, 21 tahun, mahasiswi di Tembalang.** Ingin mendaki Gunung Ungaran bersama 1 teman di akhir pekan. Tidak punya alat, budget terbatas, dan sering belanja lewat HP.
> Tujuan: dalam < 5 menit dapat paket alat lengkap untuk 2 orang dan tahu kapan bisa mengambilnya.

---

## 2. Tujuan & Rubrik Penilaian

### 2.1 Pemetaan Rubrik → Fitur
| # | Kriteria Penilaian | Bobot | Fitur yang memenuhi | Referensi |
|---|---|---|---|---|
| 1 | Minimal 5 halaman website | 15% | 10 halaman (lihat Sitemap) | Bagian 4 |
| 2 | User dapat Register & Login | 15% | Halaman **Akun Saya** WooCommerce, register wajib sebelum checkout | F-02 |
| 3 | User dapat menghubungi CS via WA | 15% | Tombol WA melayang, tombol "Tanya via WA" di produk, tombol konfirmasi pesanan, tombol di halaman Kontak | F-03 |
| 4 | User dapat transaksi / checkout | 15% | Keranjang + Checkout WooCommerce + field tanggal sewa | F-04 |
| 5 | Desain UI/UX | 40% | Design system konsisten, responsif, CTA jelas, mikro-interaksi | Bagian 8 |

### 2.2 Tujuan Keberhasilan (demo)
- Penguji bisa menjalankan alur **Register → pilih produk → keranjang → checkout → pesanan diterima → konfirmasi WA** tanpa error, di desktop maupun HP.
- Website online di AWS Lightsail selama ± 1 bulan dengan **biaya total < $10**.
- Skor Lighthouse mobile: Performance ≥ 70, Accessibility ≥ 90.

### 2.3 Di Luar Ruang Lingkup (Out of Scope)
- Payment gateway nyata (Midtrans/Xendit). Pembayaran hanya **Transfer Bank (manual)** dan **Bayar di Tempat**.
- Pengecekan ketersediaan stok per tanggal (kalender booking). Stok hanya dikelola sebagai jumlah unit.
- Ongkir otomatis berbasis jarak. Diganti tarif flat.
- Pengiriman email transaksional yang andal (SMTP). Opsional, lihat Bagian 10.6.
- Aplikasi mobile native dan multi-bahasa.

---

## 3. Profil Bisnis (Data Fiktif — gunakan persis)

| Data | Nilai |
|---|---|
| Nama brand | BAGUS |
| Kepanjangan | Basecamp Alat Gunung Untuk Semua |
| Tagline | Mendaki Jadi Lebih BAGUS. |
| Pemilik | Bagus Pratama (fiktif) |
| Berdiri | 2021 |
| Alamat basecamp | Jl. Banjarsari Raya No. 17, Tembalang, Kota Semarang, Jawa Tengah 50275 (fiktif) |
| WhatsApp CS | `+62 857-7759-8395` → format link: `6285777598395` (**placeholder, ganti sebelum demo**) |
| Email | `halo@bagus-outdoor.id` (fiktif) |
| Instagram | `@bagus.outdoor` (fiktif) |
| Jam operasional | Senin–Jumat 08.00–21.00, Sabtu–Minggu 06.00–22.00 WIB |
| Area antar | Kota Semarang (Tembalang, Banyumanik, Gunungpati, Semarang Tengah, dll.) |
| Syarat sewa | Jaminan KTP/KTM asli saat pengambilan, keterlambatan dikenakan denda 1 hari sewa per hari |

> Nomor WA disimpan di **satu tempat saja** (konstanta `BAGUS_WA_NUMBER` di mu-plugin dan pengaturan plugin Click to Chat) agar mudah diganti.

---

## 4. Sitemap & Struktur Navigasi

```
BAGUS (bagus-outdoor)
├── /                    Beranda               (Front page, statis)
├── /katalog/            Katalog Alat          (WooCommerce Shop page)
│   └── /produk/{slug}/  Detail Produk         (WooCommerce single product)
├── /paket-camping/      Paket Camping         (Halaman berisi produk kategori "Paket")
├── /cara-sewa/          Cara Sewa & Syarat    (Halaman statis)
├── /tips-destinasi/     Tips & Destinasi      (Posts page / blog)
│   └── /{slug-post}/    Artikel
├── /tentang-kami/       Tentang Kami          (Halaman statis)
├── /kontak/             Kontak                (Halaman statis + form + WA + peta)
├── /keranjang/          Keranjang             (WooCommerce Cart)
├── /checkout/           Checkout              (WooCommerce Checkout)
└── /akun-saya/          Akun Saya             (WooCommerce My Account: Login/Register/Pesanan)
```

**Total halaman yang dinilai: 10** (Beranda, Katalog, Paket Camping, Cara Sewa, Tips & Destinasi, Tentang Kami, Kontak, Keranjang, Checkout, Akun Saya).

### 4.1 Menu Utama (header)
`Beranda` · `Katalog` · `Paket Camping` · `Cara Sewa` · `Tips & Destinasi` · `Tentang Kami` · `Kontak`
Di kanan: ikon 🔍 Cari, 👤 Akun Saya (atau "Masuk" jika belum login), 🛒 Keranjang + badge jumlah item.
**Mobile:** hamburger menu (off-canvas). Ikon keranjang & akun tetap terlihat.

### 4.2 Menu Footer
- Kolom 1: Logo BAGUS, tagline, deskripsi singkat 1 kalimat, ikon sosmed.
- Kolom 2 **Jelajahi:** Katalog, Paket Camping, Tips & Destinasi.
- Kolom 3 **Bantuan:** Cara Sewa, Kontak, Akun Saya.
- Kolom 4 **Basecamp:** alamat, jam operasional, nomor WA (link `wa.me`).
- Bar bawah: `© 2026 BAGUS — Basecamp Alat Gunung Untuk Semua. Dibuat untuk keperluan demo/tugas.`

---

## 5. User Flow

### 5.1 Alur Utama (Happy Path): Sewa Alat
```
[Beranda] → klik "Sewa Sekarang" / "Lihat Paket"
   → [Katalog / Paket Camping] → pilih produk
   → [Detail Produk] → pilih "Durasi Sewa" (1/2/3/5 Hari) → atur jumlah → "Tambah ke Keranjang"
   → [Keranjang] → cek item & subtotal → "Lanjut ke Checkout"
   → Belum login? → diarahkan Login / Daftar (di halaman checkout atau Akun Saya)
   → [Checkout] → isi data penagihan, Tanggal Mulai Sewa, Tujuan Pendakian (opsional)
                → pilih pengiriman (Ambil di Basecamp / Antar Area Semarang)
                → pilih pembayaran (Transfer Bank / Bayar di Tempat)
                → "Buat Pesanan"
   → [Pesanan Diterima] → ringkasan pesanan + tombol "Konfirmasi via WhatsApp"
   → WhatsApp terbuka dengan pesan otomatis berisi nomor pesanan
```

### 5.2 Alur Register & Login
```
Header "Masuk" → [Akun Saya]
  ├── Form Masuk  : email/username + password → Dashboard Akun
  └── Form Daftar : email + password → akun dibuat & langsung login → Dashboard Akun
Dashboard Akun: Dasbor, Pesanan (riwayat sewa), Alamat, Detail Akun, Keluar
```

### 5.3 Alur Hubungi CS
```
Halaman mana pun → tombol WA melayang (kanan bawah) → wa.me dengan pesan default
Detail produk     → "Tanya Stok via WA" → pesan berisi nama produk
Kontak            → tombol besar "Chat CS Sekarang"
Pesanan diterima  → "Konfirmasi via WhatsApp" → pesan berisi no. pesanan, nama, total, tanggal sewa
```

---

## 6. Kebutuhan Fungsional

Format: **ID — Nama**, deskripsi, lalu *Acceptance Criteria (AC)*.

### F-01 — Halaman Website (≥ 5 halaman)
Semua halaman di Bagian 4 harus ada, dapat diakses dari menu, dan memakai header/footer yang konsisten.
- **AC1:** Ke-10 halaman merespons HTTP 200 dan muncul di menu header atau footer.
- **AC2:** Permalink memakai struktur `/%postname%/` (URL rapi, tanpa `?p=`).
- **AC3:** Setiap halaman punya judul (H1) unik dan meta title `Judul — BAGUS`.

### F-02 — Register & Login
Menggunakan halaman **My Account WooCommerce** (`/akun-saya/`).

Pengaturan WooCommerce (Settings → Accounts & Privacy):
| Opsi | Nilai |
|---|---|
| Allow customers to place orders without an account (guest checkout) | **Tidak** (wajib login agar fitur register/login terlihat jelas) |
| Allow customers to log into an existing account during checkout | **Ya** |
| Allow customers to create an account during checkout | **Ya** |
| Allow customers to create an account on the "My account" page | **Ya** |
| Automatically generate username from email | **Ya** |
| Send password setup link (auto-generate password) | **Tidak** (user mengisi password sendiri) |

- **AC1:** Pengunjung bisa mendaftar dengan email + password di `/akun-saya/` dan langsung login.
- **AC2:** User yang sudah terdaftar bisa login dan logout. Header berubah dari "Masuk" menjadi "Akun Saya".
- **AC3:** Pengunjung yang belum login dan membuka checkout bisa login atau daftar di halaman yang sama.
- **AC4:** Halaman Akun Saya menampilkan riwayat pesanan user.
- **AC5:** Fitur "Lupa password" tersedia (bawaan WooCommerce).
- **AC6:** Form login dan register tampil berdampingan di desktop (2 kolom) dan bertumpuk di mobile, sesuai design system.

### F-03 — Hubungi CS via WhatsApp
| Titik kontak | Implementasi | Pesan otomatis (prefilled) |
|---|---|---|
| Tombol melayang (semua halaman) | Plugin **Click to Chat** (HoliThemes) | `Halo BAGUS, saya mau tanya tentang sewa alat camping.` |
| Detail produk | mu-plugin, hook `woocommerce_single_product_summary` | `Halo BAGUS, apakah {nama produk} tersedia untuk tanggal ...?` |
| Halaman Kontak | Tombol (block button) ke `https://wa.me/6285777598395?text=...` | `Halo BAGUS, saya ingin konsultasi.` |
| Pesanan diterima (thank-you) | mu-plugin, hook `woocommerce_thankyou` | `Halo BAGUS, saya ingin konfirmasi pesanan #{no} atas nama {nama}. Total: {total}. Tanggal mulai sewa: {tanggal}.` |

- **AC1:** Tombol WA melayang muncul di kanan bawah semua halaman (desktop & mobile) dan tidak menutupi tombol penting (misalnya "Buat Pesanan" di mobile).
- **AC2:** Semua link memakai format `https://wa.me/{nomor}?text={pesan ter-URL-encode}` dan terbuka di tab baru.
- **AC3:** Pesan konfirmasi pesanan berisi nomor pesanan yang benar.
- **AC4:** Tombol WA memiliki `aria-label="Chat WhatsApp CS BAGUS"`.

### F-04 — Keranjang & Checkout (Transaksi)
**Model harga sewa:** setiap alat adalah **Variable Product** dengan atribut **"Durasi Sewa"** (1 Hari, 2 Hari, 3 Hari, 5 Hari). Harga tiap variasi sudah termasuk diskon durasi (lihat Bagian 7). Field **Jumlah** = jumlah unit alat.

**Field tambahan checkout** (via mu-plugin, lihat Bagian 10.4):
| Field | Tipe | Wajib | Validasi |
|---|---|---|---|
| Tanggal Mulai Sewa | `date` | Ya | Minimal **besok** (zona waktu Asia/Jakarta) |
| Tujuan Pendakian/Camping | `text` | Tidak | Placeholder: `Contoh: Gunung Ungaran via Mawar` |

Field bawaan yang **disembunyikan/dibuat opsional** agar form ringkas: `billing_company` (hapus), `billing_address_2` (opsional), `billing_state` (default Jawa Tengah), `billing_postcode` (opsional).

**Metode pengiriman** (Shipping zone "Indonesia"):
| Metode | Tipe WooCommerce | Biaya |
|---|---|---|
| Ambil di Basecamp (Tembalang) | Local pickup | Rp 0 |
| Antar Area Kota Semarang | Flat rate | Rp 15.000 |

**Metode pembayaran:**
| Metode | Gateway WooCommerce | Instruksi |
|---|---|---|
| Transfer Bank | Direct bank transfer (BACS) | Bank BCA 1234567890 a.n. Bagus Pratama (fiktif). Kirim bukti via WA. |
| Bayar di Tempat | Cash on delivery (COD) | Bayar tunai saat ambil/antar alat. |

**Penting:** gunakan **Cart & Checkout klasik (shortcode)** `[woocommerce_cart]` dan `[woocommerce_checkout]`, **bukan** block Cart/Checkout. Alasannya, hook `woocommerce_checkout_fields` untuk field tambahan hanya berfungsi di checkout klasik.

- **AC1:** User bisa menambah, mengubah jumlah, dan menghapus item di keranjang. Subtotal dan total ter-update.
- **AC2:** Tombol "Tambah ke Keranjang" tidak aktif sebelum Durasi Sewa dipilih.
- **AC3:** Checkout menolak tanggal mulai sewa < besok dengan pesan `Tanggal mulai sewa paling cepat besok.`
- **AC4:** Setelah "Buat Pesanan", user diarahkan ke halaman Pesanan Diterima yang menampilkan nomor pesanan, ringkasan, instruksi pembayaran, tanggal sewa, dan tombol konfirmasi WA.
- **AC5:** Pesanan tercatat di wp-admin → WooCommerce → Orders dengan status *On hold* (BACS) atau *Processing* (COD). Tanggal Mulai Sewa dan Tujuan tampil di detail pesanan admin.
- **AC6:** Stok produk berkurang sesuai jumlah yang dipesan.
- **AC7:** Mata uang tampil sebagai `Rp 35.000` (IDR, pemisah ribuan titik, tanpa desimal).

### F-05 — Katalog & Detail Produk
- Halaman Katalog menampilkan grid produk dengan filter kategori (Tenda, Tas & Carrier, Perlengkapan Tidur, Alat Masak, Aksesoris, Paket) dan pengurutan (terbaru, harga termurah, harga termahal).
- Kartu produk: foto (rasio 1:1), badge kategori, nama, **"Mulai Rp X / hari"**, tombol "Pilih Durasi".
- Detail produk: galeri foto, nama, rentang harga, pilihan Durasi Sewa, jumlah, tombol Tambah ke Keranjang, tombol "Tanya Stok via WA", deskripsi singkat (spesifikasi poin-poin), tab Deskripsi (cara pakai & perawatan), produk terkait.
- **AC1:** Grid 4 kolom (desktop ≥ 1200px), 3 kolom (tablet), 2 kolom (mobile).
- **AC2:** Filter kategori berfungsi tanpa error.
- **AC3:** Harga di kartu tampil "Mulai Rp X / hari", bukan rentang mentah "Rp X – Rp Y" (gunakan filter `woocommerce_variable_price_html`).

### F-06 — Paket Camping
- Halaman `/paket-camping/` berisi hero kecil, penjelasan keuntungan paket ("Hemat hingga 30%"), lalu grid produk kategori `paket`, dan tabel isi tiap paket.
- **AC1:** Setiap kartu paket menampilkan daftar isi paket dan label hemat (misalnya "Hemat Rp 19.000").

### F-07 — Tips & Destinasi (Blog)
- Halaman posts page dengan kartu artikel (gambar, kategori, judul, ringkasan, tanggal).
- Minimal **3 artikel** (outline di Bagian 11.3).
- **AC1:** Setiap artikel diakhiri CTA box: "Butuh alat untuk ke {destinasi}? Lihat Paket Camping →".

### F-08 — Kontak
- Info kontak (alamat, WA, email, jam operasional), embed Google Maps (iframe, `loading="lazy"`) ke area Tembalang, dan form kontak (**Contact Form 7**: Nama, Email, No. WA, Pesan) dengan **Flamingo** agar pesan tersimpan di database.
- **AC1:** Form kontak bisa dikirim dan pesan tampil di wp-admin → Flamingo → Inbound Messages.
- **AC2:** Tombol besar "Chat CS Sekarang" ke WA.

### F-09 — Pencarian
- Pencarian produk dari header (bawaan WooCommerce/tema).
- **AC1:** Mencari "tenda" menampilkan produk tenda.

---

## 7. Data Produk (Seed Data)

**Aturan harga variasi:** `1 Hari = P`, `2 Hari = 2P`, `3 Hari = 3P × 0,90` (hemat 10%), `5 Hari = 5P × 0,85` (hemat 15%), dibulatkan ke Rp 1.000 terdekat. Nilai di tabel sudah final, **gunakan apa adanya**.

### 7.1 Kategori Produk
| Nama | Slug |
|---|---|
| Tenda | `tenda` |
| Tas & Carrier | `tas-carrier` |
| Perlengkapan Tidur | `perlengkapan-tidur` |
| Alat Masak | `alat-masak` |
| Aksesoris | `aksesoris` |
| Paket | `paket` |

### 7.2 Daftar Produk & Harga (Rupiah)
| SKU | Nama Produk | Kategori | Stok | 1 Hari | 2 Hari | 3 Hari | 5 Hari |
|---|---|---|---|---|---|---|---|
| TND-02 | Tenda Dome 2 Orang | tenda | 8 | 35.000 | 70.000 | 95.000 | 149.000 |
| TND-04 | Tenda Dome 4 Orang | tenda | 5 | 55.000 | 110.000 | 149.000 | 234.000 |
| FLY-01 | Flysheet 3x4 m | tenda | 6 | 15.000 | 30.000 | 41.000 | 64.000 |
| CRR-45 | Carrier 45L | tas-carrier | 8 | 25.000 | 50.000 | 68.000 | 106.000 |
| CRR-60 | Carrier 60L | tas-carrier | 6 | 35.000 | 70.000 | 95.000 | 149.000 |
| SLB-01 | Sleeping Bag Polar | perlengkapan-tidur | 15 | 12.000 | 24.000 | 32.000 | 51.000 |
| MTR-01 | Matras Foil | perlengkapan-tidur | 15 | 8.000 | 16.000 | 22.000 | 34.000 |
| KMP-01 | Kompor Portable | alat-masak | 8 | 15.000 | 30.000 | 41.000 | 64.000 |
| NST-01 | Nesting Cooking Set | alat-masak | 8 | 12.000 | 24.000 | 32.000 | 51.000 |
| HDL-01 | Headlamp LED | aksesoris | 12 | 8.000 | 16.000 | 22.000 | 34.000 |
| TRK-01 | Trekking Pole (Sepasang) | aksesoris | 6 | 15.000 | 30.000 | 41.000 | 64.000 |
| JKT-01 | Jaket Gunung Windproof | aksesoris | 10 | 20.000 | 40.000 | 54.000 | 85.000 |
| PKT-SOLO | Paket Pendaki Solo | paket | 4 | 75.000 | 150.000 | 203.000 | 319.000 |
| PKT-DUO | Paket Camping Ceria Berdua | paket | 4 | 99.000 | 198.000 | 267.000 | 421.000 |
| PKT-FAM | Paket Keluarga Glamping | paket | 3 | 150.000 | 300.000 | 405.000 | 638.000 |

Stok dikelola di **level produk induk** (Manage stock = Ya pada parent).

### 7.3 Isi Paket
| Paket | Isi | Harga satuan/hari | Harga paket/hari | Hemat |
|---|---|---|---|---|
| Paket Pendaki Solo | Tenda 2 Orang, Carrier 45L, 1 Sleeping Bag, 1 Matras, 1 Headlamp | Rp 88.000 | Rp 75.000 | Rp 13.000 |
| Paket Camping Ceria Berdua ⭐ (Terlaris) | Tenda 2 Orang, 2 Sleeping Bag, 2 Matras, Kompor, Nesting, 2 Headlamp | Rp 118.000 | Rp 99.000 | Rp 19.000 |
| Paket Keluarga Glamping | Tenda 4 Orang, 4 Sleeping Bag, 4 Matras, Kompor, Nesting, Flysheet | Rp 177.000 | Rp 150.000 | Rp 27.000 |

### 7.4 Template Deskripsi Produk
**Deskripsi singkat** (poin-poin, maks. 5):
```
- Kapasitas: 2 orang
- Bahan: Polyester 190T, lapisan anti-air 2000mm
- Berat: ± 2,2 kg
- Cocok untuk: Ungaran, Andong, Prau
- Kondisi: dicuci & dicek setelah setiap penyewaan
```
**Deskripsi panjang:** 1 paragraf pengantar, lalu subjudul "Yang Kamu Dapatkan", "Cara Pakai Singkat", dan "Tips Perawatan Selama Sewa".

### 7.5 Gambar
- Sumber: **Unsplash / Pexels** (lisensi gratis). Catat URL sumber di `content/images/CREDITS.md`.
- Format **WebP**, produk 800×800 px (1:1), hero 1920×1080 px, ukuran ≤ 200 KB per file.
- Penamaan: `{sku-lowercase}.webp` (contoh `tnd-02.webp`), `hero-home.webp`, `hero-paket.webp`, dst.

---

## 8. Design System (SEMENTARA — akan disesuaikan dengan `design-references/`)

> ⚠️ **Agent:** bagian ini adalah **default**. Jika `design-references/` berisi referensi, sesuaikan warna, tipografi, dan layout dengan referensi tersebut, lalu perbarui token di child theme (`style.css` → `:root`). Jangan mengubah struktur halaman, fitur, atau konten tanpa persetujuan.

### 8.1 Prinsip Desain
1. **Mobile-first:** mayoritas pengguna (mahasiswa) mengakses dari HP.
2. **Nuansa alam yang modern:** warna earthy, foto alam berkualitas, banyak ruang kosong (whitespace).
3. **CTA selalu jelas:** satu aksi utama per section, warna aksen hanya untuk CTA.
4. **Kepercayaan:** tampilkan testimoni, jumlah penyewa, jaminan alat bersih, dan syarat sewa yang jelas.
5. **Konsisten:** semua komponen memakai token yang sama (warna, radius, bayangan, jarak).

### 8.2 Warna (CSS Custom Properties)
| Token | Hex | Penggunaan |
|---|---|---|
| `--bagus-primary` | `#2D5A3D` | Hijau hutan: header aktif, judul, ikon, footer |
| `--bagus-primary-dark` | `#1F3F2B` | Hover primary, background footer |
| `--bagus-accent` | `#E8833A` | Oranye senja: **khusus CTA** (tombol utama, badge "Terlaris") |
| `--bagus-accent-dark` | `#C96A24` | Hover CTA |
| `--bagus-bg` | `#F5F1E8` | Krem: background section selang-seling |
| `--bagus-surface` | `#FFFFFF` | Kartu, form |
| `--bagus-text` | `#2B2B2B` | Teks utama |
| `--bagus-muted` | `#6B6B6B` | Teks sekunder, caption |
| `--bagus-border` | `#E3DED3` | Garis kartu, input |
| `--bagus-success` | `#2E7D32` | Notifikasi sukses |
| `--bagus-error` | `#C62828` | Error form |
| `--bagus-wa` | `#25D366` | Tombol WhatsApp |

Kontras teks putih di atas `--bagus-accent` harus **≥ 4,5:1**. Jika tidak lolos, gunakan teks `--bagus-text` atau `--bagus-accent-dark` sebagai background.

### 8.3 Tipografi (Google Fonts, di-host lokal oleh tema)
| Elemen | Font | Ukuran desktop / mobile | Weight |
|---|---|---|---|
| H1 (hero) | Montserrat | 56px / 36px | 800 |
| H2 (judul section) | Montserrat | 40px / 28px | 700 |
| H3 (judul kartu) | Montserrat | 22px / 20px | 700 |
| Body | Inter | 17px / 16px, line-height 1.65 | 400 |
| Small / caption | Inter | 14px | 400 |
| Tombol | Inter | 16px | 600 |

### 8.4 Spasi, Radius, Bayangan
- Skala spasi: `4, 8, 12, 16, 24, 32, 48, 64, 96` px. Padding vertikal section: **96px desktop / 56px mobile**.
- Lebar konten maks.: **1200px**.
- Radius: tombol & input `12px`, kartu `16px`, badge `999px`.
- Bayangan kartu: `0 4px 20px rgba(0,0,0,.06)`, saat hover: `0 10px 30px rgba(0,0,0,.10)` + `translateY(-4px)`.
- Transisi: `all .25s ease`.

### 8.5 Komponen
| Komponen | Spesifikasi |
|---|---|
| Tombol Primary | Background accent, teks putih, padding 14×28px, radius 12px, hover accent-dark |
| Tombol Secondary | Border 2px primary, teks primary, background transparan, hover isi primary + teks putih |
| Tombol WA | Background `#25D366`, ikon WhatsApp + teks |
| Kartu Produk | Gambar 1:1, badge kategori kiri atas, nama (H3), "Mulai Rp X / hari", tombol full-width |
| Kartu Fitur | Ikon garis (Lucide/Phosphor SVG) 40px dalam lingkaran krem, judul, deskripsi 1–2 kalimat |
| Kartu Testimoni | Kutipan, ⭐ 5, foto avatar bulat (ilustrasi/inisial), nama + destinasi |
| Step "Cara Sewa" | Angka besar dalam lingkaran + garis penghubung (horizontal di desktop, vertikal di mobile) |
| Header | Sticky, putih, bayangan halus saat di-scroll, tinggi 72px |
| Badge | "Terlaris" (accent), "Hemat X%" (primary), "Stok Habis" (muted) |
| Form input | Tinggi 48px, border `--bagus-border`, fokus border primary + outline 3px primary 20% |

### 8.6 Responsif
| Breakpoint | Lebar |
|---|---|
| Mobile | < 768px |
| Tablet | 768–1199px |
| Desktop | ≥ 1200px |

### 8.7 Aksesibilitas & Mikro-interaksi
- Semua gambar memiliki `alt` deskriptif dalam Bahasa Indonesia.
- Fokus keyboard terlihat jelas, area sentuh minimal 44×44px.
- Animasi fade-up ringan saat scroll (CSS / Kadence Blocks), hormati `prefers-reduced-motion`.
- Notifikasi "Produk ditambahkan ke keranjang" jelas, mini-cart di header ter-update.

---

## 9. Tech Stack

| Lapisan | Pilihan | Catatan |
|---|---|---|
| CMS | WordPress 6.x (terbaru) | Bahasa `id_ID`, zona waktu `Asia/Jakarta` |
| E-commerce | **WooCommerce** (terbaru) | Checkout klasik (shortcode) |
| Tema | **Kadence** (gratis) + child theme `bagus-child` | Ringan, header builder bawaan, integrasi Woo bagus |
| Page builder | **Gutenberg + Kadence Blocks** (gratis) | Bukan Elementor, agar konten bisa disimpan sebagai block markup di repo |
| WhatsApp | **Click to Chat** (HoliThemes) | Tombol melayang |
| Form kontak | **Contact Form 7** + **Flamingo** | Flamingo menyimpan pesan di DB |
| Keamanan | **Limit Login Attempts Reloaded** | Proteksi brute-force login |
| Migrasi | **All-in-One WP Migration** | Pindah dari lokal ke Lightsail |
| Ikon | SVG inline (Lucide, lisensi ISC) | Tanpa icon font yang berat |
| Lokal dev | Docker Compose (WordPress + MariaDB + WP-CLI) | Alternatif: LocalWP |
| Hosting | AWS Lightsail, blueprint WordPress (Bitnami) | Lihat Bagian 12 |

**Plugin yang dilarang:** plugin berbayar/pro, Elementor, page builder lain, plugin cache yang berat. Tidak perlu plugin SEO.

---

## 10. Arsitektur & Implementasi Teknis

### 10.1 Struktur Repository
```
bagus-project/
├── PRD.md                          ← dokumen ini
├── design-references/              ← referensi desain dari pemilik (baca dulu!)
│   ├── README.md
│   └── links.md
├── docker-compose.yml              ← lingkungan lokal
├── .env.example                    ← contoh variabel (tanpa rahasia asli)
├── .gitignore
├── wp-content/
│   ├── themes/bagus-child/
│   │   ├── style.css               ← header child theme + design tokens + CSS kustom
│   │   ├── functions.php           ← enqueue style, font, dukungan tema
│   │   ├── assets/
│   │   │   ├── img/                ← logo (SVG), ikon
│   │   │   └── js/main.js          ← (opsional) mikro-interaksi kecil
│   │   └── screenshot.png
│   └── mu-plugins/
│       └── bagus-core.php          ← logika bisnis: field checkout, tombol WA, format harga
├── content/
│   ├── pages/                      ← block markup tiap halaman (*.html)
│   │   ├── beranda.html
│   │   ├── paket-camping.html
│   │   ├── cara-sewa.html
│   │   ├── tentang-kami.html
│   │   └── kontak.html
│   ├── posts/                      ← 3 artikel blog (*.html)
│   ├── products.json               ← seed data produk (dari Bagian 7)
│   └── images/                     ← gambar WebP + CREDITS.md
├── scripts/
│   ├── setup.sh                    ← instalasi & konfigurasi via WP-CLI (idempoten)
│   ├── seed-products.sh            ← membuat kategori, produk, variasi
│   └── seed-content.sh             ← membuat halaman, posts, menu
└── docs/
    ├── deployment.md               ← langkah deploy ke Lightsail
    ├── decisions.md                ← catatan keputusan teknis
    └── demo-accounts.md            ← akun demo untuk penguji (tanpa password admin)
```

### 10.2 Lingkungan Lokal (Docker Compose)
```yaml
services:
  db:
    image: mariadb:10.11
    restart: unless-stopped
    environment:
      MARIADB_DATABASE: wordpress
      MARIADB_USER: wp
      MARIADB_PASSWORD: ${DB_PASSWORD:-wp_local_pw}
      MARIADB_ROOT_PASSWORD: ${DB_ROOT_PASSWORD:-root_local_pw}
    volumes:
      - db_data:/var/lib/mysql

  wordpress:
    image: wordpress:php8.2-apache
    restart: unless-stopped
    depends_on: [db]
    ports:
      - "8080:80"
    environment:
      WORDPRESS_DB_HOST: db
      WORDPRESS_DB_NAME: wordpress
      WORDPRESS_DB_USER: wp
      WORDPRESS_DB_PASSWORD: ${DB_PASSWORD:-wp_local_pw}
    volumes:
      - wp_data:/var/www/html
      - ./wp-content/themes/bagus-child:/var/www/html/wp-content/themes/bagus-child
      - ./wp-content/mu-plugins:/var/www/html/wp-content/mu-plugins
      - ./content:/content:ro

  wpcli:
    image: wordpress:cli-php8.2
    user: "33:33"            # samakan UID dengan www-data di image apache
    depends_on: [db, wordpress]
    environment:
      WORDPRESS_DB_HOST: db
      WORDPRESS_DB_NAME: wordpress
      WORDPRESS_DB_USER: wp
      WORDPRESS_DB_PASSWORD: ${DB_PASSWORD:-wp_local_pw}
    volumes:
      - wp_data:/var/www/html
      - ./wp-content/themes/bagus-child:/var/www/html/wp-content/themes/bagus-child
      - ./wp-content/mu-plugins:/var/www/html/wp-content/mu-plugins
      - ./content:/content:ro
      - ./scripts:/scripts:ro

volumes:
  db_data:
  wp_data:
```
Jalankan: `docker compose up -d`, lalu perintah WP-CLI via `docker compose run --rm wpcli wp <perintah>`. Situs lokal: `http://localhost:8080`.

### 10.3 Konfigurasi via WP-CLI (`scripts/setup.sh`) — wajib idempoten
```bash
wp core install --url="http://localhost:8080" --title="BAGUS" \
  --admin_user="$WP_ADMIN_USER" --admin_password="$WP_ADMIN_PASSWORD" \
  --admin_email="$WP_ADMIN_EMAIL" --skip-email
wp language core install id_ID --activate
wp option update blogdescription "Mendaki Jadi Lebih BAGUS."
wp option update timezone_string "Asia/Jakarta"
wp option update date_format "j F Y"
wp rewrite structure '/%postname%/' --hard

wp theme install kadence
wp theme activate bagus-child
wp plugin install woocommerce kadence-blocks click-to-chat-for-whatsapp contact-form-7 flamingo \
  limit-login-attempts-reloaded all-in-one-wp-migration --activate
wp plugin delete hello akismet

# WooCommerce: toko & mata uang
wp option update woocommerce_store_address "Jl. Banjarsari Raya No. 17, Tembalang"
wp option update woocommerce_store_city "Semarang"
wp option update woocommerce_store_postcode "50275"
wp option update woocommerce_default_country "ID:JT"
wp option update woocommerce_currency "IDR"
wp option update woocommerce_currency_pos "left_space"
wp option update woocommerce_price_thousand_sep "."
wp option update woocommerce_price_decimal_sep ","
wp option update woocommerce_price_num_decimals "0"
wp option update woocommerce_allowed_countries "specific"
wp option update woocommerce_specific_allowed_countries '["ID"]' --format=json

# WooCommerce: akun (F-02)
wp option update woocommerce_enable_guest_checkout "no"
wp option update woocommerce_enable_checkout_login_reminder "yes"
wp option update woocommerce_enable_signup_and_login_from_checkout "yes"
wp option update woocommerce_enable_myaccount_registration "yes"
wp option update woocommerce_registration_generate_username "yes"
wp option update woocommerce_registration_generate_password "no"
```
Lanjutan yang harus dikerjakan script:
- Membuat/menyetel halaman WooCommerce: `katalog` (shop), `keranjang` (`[woocommerce_cart]`), `checkout` (`[woocommerce_checkout]`), `akun-saya` (`[woocommerce_my_account]`), lalu set `woocommerce_shop_page_id`, `woocommerce_cart_page_id`, `woocommerce_checkout_page_id`, `woocommerce_myaccount_page_id`.
- Set halaman depan statis: `show_on_front=page`, `page_on_front={ID beranda}`, `page_for_posts={ID tips-destinasi}`.
- Set permalink produk ke `/produk/` (`woocommerce_permalinks`).
- Membuat shipping zone, metode pengiriman, dan mengaktifkan BACS + COD (via `wp wc shipping_zone ...`, `wp wc payment_gateway update bacs --enabled=true --user=1`, dll.).
- Membuat menu `Menu Utama` & `Menu Footer` dan menetapkannya ke lokasi menu tema Kadence.
- Mengatur Click to Chat: nomor `6285777598395`, pesan default, posisi kanan bawah, style ikon + teks "Chat CS".

**Seed produk (`scripts/seed-products.sh`)**, contoh untuk 1 produk variable:
```bash
PID=$(wp wc product create --user=1 --porcelain \
  --name="Tenda Dome 2 Orang" --type=variable --sku=TND-02 \
  --categories='[{"id":<ID_TENDA>}]' --manage_stock=true --stock_quantity=8 \
  --attributes='[{"name":"Durasi Sewa","variation":true,"visible":true,"options":["1 Hari","2 Hari","3 Hari","5 Hari"]}]')
wp wc product_variation create $PID --user=1 --regular_price=35000  --attributes='[{"name":"Durasi Sewa","option":"1 Hari"}]'
wp wc product_variation create $PID --user=1 --regular_price=70000  --attributes='[{"name":"Durasi Sewa","option":"2 Hari"}]'
wp wc product_variation create $PID --user=1 --regular_price=95000  --attributes='[{"name":"Durasi Sewa","option":"3 Hari"}]'
wp wc product_variation create $PID --user=1 --regular_price=149000 --attributes='[{"name":"Durasi Sewa","option":"5 Hari"}]'
```
Script membaca `content/products.json` dan harus **melewati produk yang SKU-nya sudah ada** (idempoten). Variasi default di form produk: `1 Hari`.

### 10.4 mu-plugin `bagus-core.php` — Referensi Implementasi
Agent boleh merapikan kode ini, tetapi perilakunya harus sama.
```php
<?php
/**
 * Plugin Name: BAGUS Core
 * Description: Logika bisnis BAGUS (field sewa di checkout, tombol WhatsApp, format harga).
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'BAGUS_WA_NUMBER', '6285777598395' ); // GANTI dengan nomor asli sebelum demo

function bagus_wa_link( $message ) {
    return 'https://wa.me/' . BAGUS_WA_NUMBER . '?text=' . rawurlencode( $message );
}

/* 1. Field tambahan checkout */
add_filter( 'woocommerce_checkout_fields', function ( $fields ) {
    $fields['order']['bagus_tanggal_mulai'] = array(
        'type'              => 'date',
        'label'             => 'Tanggal Mulai Sewa',
        'required'          => true,
        'priority'          => 5,
        'custom_attributes' => array( 'min' => wp_date( 'Y-m-d', strtotime( '+1 day' ) ) ),
    );
    $fields['order']['bagus_tujuan'] = array(
        'type'        => 'text',
        'label'       => 'Tujuan Pendakian/Camping',
        'required'    => false,
        'priority'    => 6,
        'placeholder' => 'Contoh: Gunung Ungaran via Mawar',
    );
    unset( $fields['billing']['billing_company'] );
    if ( isset( $fields['billing']['billing_postcode'] ) ) {
        $fields['billing']['billing_postcode']['required'] = false;
    }
    return $fields;
} );

/* 2. Validasi tanggal: minimal besok */
add_action( 'woocommerce_checkout_process', function () {
    $tgl   = isset( $_POST['bagus_tanggal_mulai'] ) ? sanitize_text_field( wp_unslash( $_POST['bagus_tanggal_mulai'] ) ) : '';
    $besok = wp_date( 'Y-m-d', strtotime( '+1 day' ) );
    if ( $tgl && $tgl < $besok ) {
        wc_add_notice( 'Tanggal mulai sewa paling cepat besok.', 'error' );
    }
} );

/* 3. Simpan ke order (kompatibel HPOS) */
add_action( 'woocommerce_checkout_create_order', function ( $order, $data ) {
    foreach ( array( 'bagus_tanggal_mulai', 'bagus_tujuan' ) as $key ) {
        if ( ! empty( $data[ $key ] ) ) {
            $order->update_meta_data( '_' . $key, sanitize_text_field( $data[ $key ] ) );
        }
    }
}, 10, 2 );

/* 4. Tampilkan di admin order */
add_action( 'woocommerce_admin_order_data_after_billing_address', function ( $order ) {
    $tgl    = $order->get_meta( '_bagus_tanggal_mulai' );
    $tujuan = $order->get_meta( '_bagus_tujuan' );
    if ( $tgl )    { echo '<p><strong>Tanggal Mulai Sewa:</strong> ' . esc_html( $tgl ) . '</p>'; }
    if ( $tujuan ) { echo '<p><strong>Tujuan:</strong> ' . esc_html( $tujuan ) . '</p>'; }
} );

/* 5. Tombol konfirmasi WA di halaman Pesanan Diterima */
add_action( 'woocommerce_thankyou', function ( $order_id ) {
    $order = wc_get_order( $order_id );
    if ( ! $order ) { return; }
    $total = html_entity_decode( wp_strip_all_tags( wc_price( $order->get_total() ) ) );
    $msg   = sprintf(
        'Halo BAGUS, saya ingin konfirmasi pesanan #%s atas nama %s. Total: %s. Tanggal mulai sewa: %s.',
        $order->get_order_number(),
        $order->get_formatted_billing_full_name(),
        $total,
        $order->get_meta( '_bagus_tanggal_mulai' )
    );
    echo '<div class="bagus-wa-confirm"><p>Pesananmu sudah kami terima! Konfirmasi ke CS agar alat segera disiapkan.</p>';
    echo '<a class="button bagus-btn-wa" href="' . esc_url( bagus_wa_link( $msg ) ) . '" target="_blank" rel="noopener" aria-label="Konfirmasi pesanan via WhatsApp">Konfirmasi via WhatsApp</a></div>';
}, 5 );

/* 6. Tombol "Tanya Stok via WA" di detail produk */
add_action( 'woocommerce_single_product_summary', function () {
    global $product;
    if ( ! $product ) { return; }
    $msg = sprintf( 'Halo BAGUS, apakah %s tersedia untuk tanggal ...?', $product->get_name() );
    echo '<a class="button bagus-btn-wa bagus-btn-wa--outline" href="' . esc_url( bagus_wa_link( $msg ) ) . '" target="_blank" rel="noopener">Tanya Stok via WA</a>';
}, 35 );

/* 7. Harga variable: "Mulai Rp X / hari" */
add_filter( 'woocommerce_variable_price_html', function ( $price, $product ) {
    return 'Mulai ' . wc_price( $product->get_variation_price( 'min', true ) ) . ' <span class="bagus-per-day">/ hari</span>';
}, 10, 2 );
```
Tambahan: tampilkan juga Tanggal Mulai Sewa di email pesanan (filter `woocommerce_email_order_meta_fields`) dan di halaman detail pesanan pelanggan (`woocommerce_order_details_after_order_table`).

### 10.5 Child Theme
- `style.css`: header child theme (`Template: kadence`), blok `:root { --bagus-*: ... }` dari Bagian 8, lalu override style Kadence/WooCommerce (tombol, kartu produk, form, notice, halaman Akun Saya, tombol WA).
- `functions.php`: enqueue `style.css` setelah style parent, preload font, dan `add_theme_support` yang diperlukan. **Logika bisnis tidak boleh di sini** (tempatnya di mu-plugin).
- Pengaturan Customizer Kadence (warna global, font, header, footer) disamakan dengan token Bagian 8 dan didokumentasikan di `docs/decisions.md`.

### 10.6 Email (Opsional)
Email WooCommerce dan CF7 kemungkinan **tidak terkirim** dari Lightsail tanpa SMTP. Untuk demo ini tidak wajib: bukti transaksi cukup dari halaman Pesanan Diterima, wp-admin Orders, dan Flamingo. Jika ingin dikirim, tambahkan plugin **WP Mail SMTP** (gratis) dengan akun Gmail App Password, setelah mendapat persetujuan pemilik.

---

## 11. Spesifikasi Konten per Halaman

Gunakan copy di bawah sebagai dasar. Agent boleh memperhalus kalimat tanpa mengubah makna.

### 11.1 Beranda (`/`)
| # | Section | Konten |
|---|---|---|
| 1 | **Hero** (full-width, foto Gunung Ungaran/Prau saat sunrise, overlay gelap 40%) | H1: **"Mendaki Jadi Lebih BAGUS."** Sub: "Sewa alat camping & hiking yang bersih, terawat, dan terjangkau di Semarang. Ambil di basecamp atau kami antar." CTA primary: **"Sewa Sekarang"** → `/katalog/`. CTA secondary: **"Lihat Paket Hemat"** → `/paket-camping/` |
| 2 | **Trust bar** (4 angka) | `2.500+ Penyewa Puas` · `150+ Alat Siap Pakai` · `4,9★ Rating Pelanggan` · `Sejak 2021` |
| 3 | **Kenapa BAGUS?** (4 kartu fitur) | 🧼 *Alat Bersih & Terawat*: dicuci & dicek tiap selesai sewa · 💰 *Harga Transparan*: mulai Rp 8.000/hari, makin lama makin hemat · 🚚 *Antar ke Lokasimu*: area Kota Semarang Rp 15.000 · 💬 *Konsultasi Gratis*: tanya rute & alat via WhatsApp |
| 4 | **Kategori Alat** (6 kartu ikon) | Tenda, Tas & Carrier, Perlengkapan Tidur, Alat Masak, Aksesoris, Paket → link ke arsip kategori |
| 5 | **Produk Terlaris** (4 produk) | TND-02, CRR-45, SLB-01, KMP-01 + tombol "Lihat Semua Alat" |
| 6 | **Banner Paket** (background krem, gambar kanan) | "Baru pertama kali camping? Ambil **Paket Camping Ceria Berdua** mulai **Rp 99.000/hari**, hemat Rp 19.000!" CTA "Lihat Paket" |
| 7 | **Cara Sewa** (3 langkah) | 1. *Pilih Alat & Durasi* · 2. *Checkout & Konfirmasi WA* · 3. *Ambil / Diantar, Lalu Jelajah!* |
| 8 | **Destinasi Favorit** (4 kartu gambar) | Gunung Ungaran (2.050 mdpl), Gunung Andong (1.726 mdpl), Gunung Prau (2.565 mdpl), Gunung Merbabu (3.145 mdpl), dengan link ke artikel terkait |
| 9 | **Testimoni** (3 kartu) | "Tendanya bersih banget, wangi pula. Muncak ke Ungaran jadi tenang." (Rina, Tembalang) · "Paket berdua lengkap, tinggal berangkat. Adminnya fast response!" (Dimas, Banyumanik) · "Diantar ke kos, pas balik juga dijemput. Mantap!" (Sinta, Gunungpati) |
| 10 | **CTA Penutup** (background primary) | "Siap Jelajah Akhir Pekan Ini?" + tombol "Sewa Sekarang" + tombol WA "Tanya Dulu via WA" |

### 11.2 Halaman Lain
**Katalog (`/katalog/`)**: hero kecil "Katalog Alat" + sub "Semua alat dicek sebelum disewa. Pilih durasi, makin lama makin hemat." Sidebar/filter chip kategori (mobile: chip horizontal yang bisa di-scroll), grid produk, pagination.

**Paket Camping (`/paket-camping/`)**:
1. Hero: "Paket Camping Hemat" + sub "Satu klik, semua alat lengkap. Hemat hingga Rp 27.000/hari."
2. Grid 3 paket (block WooCommerce "Products by Category": `paket`). Paket Berdua diberi badge **Terlaris**.
3. Tabel perbandingan isi paket (dari Bagian 7.3).
4. FAQ singkat (accordion): "Bisa tambah alat di luar paket?" (Bisa, tambahkan saja ke keranjang), "Ukuran tenda?", "Bagaimana kalau alat rusak?"
5. CTA WA: "Butuh paket custom? Chat kami."

**Cara Sewa (`/cara-sewa/`)**:
1. Langkah sewa detail (5 langkah: Daftar/Masuk → Pilih alat & durasi → Checkout & isi tanggal → Bayar (Transfer/COD) & konfirmasi WA → Ambil/diantar & kembalikan tepat waktu).
2. **Syarat & Ketentuan Sewa:** jaminan KTP/KTM asli; durasi dihitung per 24 jam sejak pengambilan; keterlambatan didenda 1 hari sewa/hari; kerusakan/kehilangan diganti sesuai harga perbaikan/pasar; pembatalan maks. H-1 gratis.
3. Info pembayaran (rekening fiktif) dan pengiriman (tarif & area).
4. FAQ (accordion, 5 pertanyaan).

**Tips & Destinasi (`/tips-destinasi/`)**: hero kecil, grid kartu artikel 3 kolom.

**Tentang Kami (`/tentang-kami/`)**:
1. Hero: "Dari Pendaki, untuk Pendaki."
2. Cerita: Bagus Pratama, alumni mapala di Semarang, memulai BAGUS pada 2021 dari 3 tenda pribadi yang sering dipinjam teman. Kini menjadi basecamp dengan 150+ alat.
3. Arti nama: **B**asecamp **A**lat **G**unung **U**ntuk **S**emua (tampilkan sebagai 5 huruf besar dengan kepanjangannya).
4. Visi & misi (3 poin): membuat petualangan alam terjangkau, alat selalu bersih & aman, dan mengedukasi pendakian bertanggung jawab (*Leave No Trace*).
5. Angka pencapaian (sama dengan trust bar) dan CTA.

**Kontak (`/kontak/`)**: 2 kolom. Kiri: kartu info (alamat, WA, email, jam operasional) + tombol besar **"Chat CS Sekarang"** (hijau WA). Kanan: form CF7. Di bawahnya peta Google Maps (embed area Tembalang, Semarang).

**Keranjang / Checkout / Akun Saya**: tampilan WooCommerce yang di-styling sesuai design system. Checkout 2 kolom di desktop (form kiri, ringkasan pesanan sticky di kanan) dan 1 kolom di mobile. Tambahkan teks bantuan di atas form checkout: "Belum punya akun? Daftar cepat di bawah, cuma butuh email & password."

### 11.3 Artikel Blog (min. 3, masing-masing 500–800 kata)
| Judul | Kategori | Isi pokok | CTA |
|---|---|---|---|
| Panduan Mendaki Gunung Ungaran via Basecamp Mawar untuk Pemula | Destinasi | Lokasi & akses dari Semarang (± 1 jam), estimasi waktu, pos-pos, tips, perkiraan biaya | Paket Pendaki Solo |
| Checklist Alat Camping Wajib untuk Pemula (Plus Estimasi Biaya Sewa) | Tips | Daftar alat dengan centang, penjelasan fungsi, total biaya sewa vs beli | Paket Camping Ceria Berdua |
| Camping Ceria di Gunung Andong: Spot Sunrise Terbaik Dekat Semarang | Destinasi | Akses, jalur, spot camping, tips keluarga | Paket Keluarga Glamping |

---

## 12. Infrastruktur & Deployment (AWS Lightsail)

### 12.1 Spesifikasi
| Item | Pilihan |
|---|---|
| Layanan | Amazon Lightsail (dikategorikan sebagai IaaS/VPS terkelola) |
| Blueprint | Apps + OS → **WordPress** (Bitnami) |
| Region | **Asia Pacific (Singapore) `ap-southeast-1`** (atau Jakarta jika tersedia di Lightsail) |
| Paket | **1 GB RAM, 2 vCPU, 40 GB SSD, 2 TB transfer**, sekitar **$7/bulan** (IPv4 publik) |
| Static IP | 1 buah, **gratis selama terpasang** ke instance |
| Firewall | Buka port 22 (SSH), 80 (HTTP), 443 (HTTPS) |
| Domain | Opsional. Demo cukup memakai Static IP. Jika punya domain, gunakan DNS zone Lightsail (gratis) + SSL via `bncert-tool` |

> Paket 512 MB tidak disarankan karena WooCommerce bisa kehabisan memori. Harga dapat berubah: **cek [halaman harga Lightsail](https://aws.amazon.com/lightsail/pricing/)** sebelum membuat instance. Akun baru kadang mendapat promo gratis beberapa bulan untuk paket tertentu.

### 12.2 Estimasi Biaya (1 bulan)
| Komponen | Biaya |
|---|---|
| Instance Lightsail 1 GB | ± $7,00 |
| Static IP (terpasang) | $0 |
| Transfer data (dalam kuota 2 TB) | $0 |
| 1 snapshot cadangan (± 10–15 GB, opsional) | ± $0,50–0,75 |
| **Total** | **± $7–8 (< $10 ✅)** |

**Pengendalian biaya:**
1. Buat **AWS Budgets** dengan batas $10 dan alert email di 50%, 80%, dan 100%.
2. Jangan memakai RDS, Load Balancer, CDN, atau paket instance yang lebih besar.
3. **Setelah penilaian selesai:** hapus instance, **lepas & hapus Static IP** (Static IP yang tidak terpasang akan dikenai biaya), dan hapus snapshot.

### 12.3 Langkah Deployment (tulis ulang secara detail di `docs/deployment.md`)
1. **Siapkan lokal:** semua fitur lolos checklist Bagian 14 di `http://localhost:8080`.
2. **Ekspor:** wp-admin lokal → All-in-One WP Migration → Export → File (`.wpress`).
3. **Buat instance Lightsail:** Create instance → Linux/Unix → WordPress → paket 1 GB → nama `bagus-wp`.
4. **Static IP:** Networking → Create static IP → attach ke `bagus-wp`.
5. **Ambil password admin Bitnami:** SSH dari browser Lightsail → `cat /home/bitnami/bitnami_application_password` (user: `user`).
6. **Naikkan batas upload PHP** agar file `.wpress` bisa di-import:
   ```bash
   sudo nano /opt/bitnami/php/etc/php.ini
   # upload_max_filesize = 512M
   # post_max_size = 512M
   # memory_limit = 512M
   sudo /opt/bitnami/ctlscript.sh restart
   ```
7. **Import:** login `http://<STATIC_IP>/wp-admin` → install All-in-One WP Migration → Import → upload `.wpress`. Setelah import, login memakai **kredensial admin dari situs lokal**.
8. **Perbarui permalink:** Settings → Permalinks → Save (2x) agar rewrite rules ter-refresh.
9. **(Opsional) HTTPS:** jika punya domain, arahkan A record ke Static IP, lalu `sudo /opt/bitnami/bncert-tool`.
10. **Hardening:** ganti password admin dengan yang kuat, pastikan Limit Login Attempts aktif, hapus plugin yang tidak terpakai.
11. **Smoke test** di server menggunakan checklist Bagian 14 (desktop + HP).
12. **Snapshot** instance setelah semua beres (cadangan sebelum demo).

### 12.4 Akun Demo untuk Penguji (`docs/demo-accounts.md`)
- Akun pelanggan demo: `demo@bagus-outdoor.id` / password ditentukan pemilik. **Jangan simpan password admin di repo.**
- Isi minimal 2 pesanan contoh agar halaman "Pesanan" di Akun Saya dan wp-admin tidak kosong.

---

## 13. Kebutuhan Non-Fungsional

| Aspek | Target |
|---|---|
| Performa | LCP < 3 detik di 4G, Lighthouse mobile Performance ≥ 70. Gambar WebP + lazy-load, maks. 2 keluarga font, tidak memakai slider berat |
| Responsif | Tampil baik di 360px, 768px, 1366px, dan 1920px tanpa scroll horizontal |
| Aksesibilitas | Lighthouse Accessibility ≥ 90, kontras AA, label form lengkap, navigasi keyboard |
| Kompatibilitas browser | Chrome, Edge, Firefox, Safari (2 versi terakhir), Chrome Android, Safari iOS |
| Keamanan | Password admin kuat, Limit Login Attempts aktif, sanitasi/escape di semua kode kustom, tidak ada rahasia di repo, WordPress & plugin versi terbaru |
| Ketersediaan | Online 24/7 selama periode penilaian (± 1 bulan) |
| Biaya | Total AWS < $10 untuk 1 bulan |
| Maintainability | Konfigurasi & konten tersimpan di repo dan bisa di-rebuild via `scripts/*.sh` |
| Lokalisasi | Bahasa Indonesia, IDR, zona waktu Asia/Jakarta, format tanggal `10 Oktober 2026` |

---

## 14. Checklist Pengujian (Definition of Done)

### Rubrik 1 — Halaman (15%)
- [ ] 10 halaman bisa diakses dari menu dan menampilkan konten final (bukan lorem ipsum).
- [ ] Tidak ada link mati (404) di menu, footer, dan tombol CTA.

### Rubrik 2 — Register & Login (15%)
- [ ] Daftar akun baru di `/akun-saya/` → langsung login → dashboard tampil.
- [ ] Logout → login lagi dengan akun yang sama berhasil.
- [ ] Buka checkout saat belum login → bisa login/daftar di halaman checkout.
- [ ] "Lupa password" menampilkan form reset.

### Rubrik 3 — WhatsApp (15%)
- [ ] Tombol WA melayang muncul di semua halaman (desktop & mobile).
- [ ] "Tanya Stok via WA" di detail produk membuka WA berisi nama produk.
- [ ] "Chat CS Sekarang" di Kontak berfungsi.
- [ ] "Konfirmasi via WhatsApp" di halaman Pesanan Diterima berisi nomor pesanan yang benar.

### Rubrik 4 — Transaksi (15%)
- [ ] Pilih durasi → tambah ke keranjang → ubah jumlah → hapus item: semuanya berfungsi.
- [ ] Checkout dengan tanggal hari ini ditolak, dengan tanggal besok diterima.
- [ ] Pesanan dengan Transfer Bank dan COD sama-sama berhasil dibuat.
- [ ] Ongkir: Ambil di Basecamp Rp 0, Antar Rp 15.000. Total benar.
- [ ] Pesanan, Tanggal Mulai Sewa, dan Tujuan tampil di wp-admin. Stok berkurang.
- [ ] Riwayat pesanan tampil di Akun Saya → Pesanan.

### Rubrik 5 — UI/UX (40%)
- [ ] Desain sesuai `design-references/` (atau Bagian 8 jika folder kosong) dan konsisten di semua halaman.
- [ ] Responsif di 360px, 768px, dan 1366px. Tidak ada elemen yang bertumpuk atau terpotong.
- [ ] Hover, focus, dan notifikasi "ditambahkan ke keranjang" terlihat jelas.
- [ ] Semua gambar berkualitas, memiliki alt text, dan tidak pecah.
- [ ] Lighthouse mobile: Performance ≥ 70, Accessibility ≥ 90.
- [ ] Halaman WooCommerce (keranjang, checkout, akun) sudah di-styling, bukan tampilan default polos.

### Deployment
- [ ] Situs dapat diakses publik via Static IP/domain Lightsail.
- [ ] Semua checklist di atas lolos di server produksi.
- [ ] AWS Budgets alert $10 aktif.

---

## 15. Timeline Pengerjaan (± 7 hari)

| Hari | Fase | Output |
|---|---|---|
| 1 | Setup | Repo, `docker-compose.yml`, `scripts/setup.sh`, WordPress + plugin terpasang, pengaturan WooCommerce |
| 2 | Desain dasar | Review `design-references/`, child theme + design tokens, header, footer, Customizer Kadence |
| 3 | Produk & Transaksi | Seed 15 produk + gambar, mu-plugin `bagus-core.php`, shipping & payment, uji checkout |
| 4 | Halaman konten | Beranda, Paket Camping, Cara Sewa, Tentang Kami, Kontak (block markup) |
| 5 | Blog & polish UI | 3 artikel, styling halaman WooCommerce, mikro-interaksi, responsif |
| 6 | QA lokal | Checklist Bagian 14, Lighthouse, perbaikan bug |
| 7 | Deploy | Lightsail, migrasi, smoke test, snapshot, AWS Budgets, `docs/demo-accounts.md` |

---

## 16. Risiko & Mitigasi

| Risiko | Dampak | Mitigasi |
|---|---|---|
| RAM 1 GB kurang saat WooCommerce aktif | Situs lambat/error 500 | Plugin minimal, tanpa Elementor, aktifkan swap 1 GB di instance jika perlu |
| Import `.wpress` gagal karena batas upload | Migrasi tertunda | Naikkan `upload_max_filesize` (12.3 langkah 6), kompres gambar sebelum ekspor |
| Biaya melebihi $10 | Credit terpakai | Paket 1 GB saja, AWS Budgets alert, hapus semua resource setelah penilaian |
| Field checkout kustom tidak muncul | Rubrik transaksi kurang | Wajib pakai checkout **shortcode klasik**, bukan block |
| Email tidak terkirim | Penguji tidak menerima email | Bukti transaksi dari halaman Pesanan Diterima + wp-admin. SMTP opsional |
| Nomor WA masih placeholder saat demo | Fitur WA tampak tidak berfungsi | Checklist pra-demo: ganti `BAGUS_WA_NUMBER` & pengaturan Click to Chat |
| Tidak ada HTTPS (tanpa domain) | Browser menampilkan "Not secure" | Diterima untuk demo. Jika ada domain, pasang SSL via `bncert-tool` |

---

## 17. Lampiran — Template `design-references/`

`design-references/README.md` (diisi oleh pemilik):
```markdown
# Referensi Desain BAGUS
## Kesan yang diinginkan
- (contoh: modern, outdoor, clean, banyak foto alam)
## Referensi & apa yang disukai
| File/URL | Bagian | Yang disukai | Yang TIDAK disukai |
|---|---|---|---|
| homepage-01.png | Hero | foto besar + teks tebal | - |
## Warna & font pilihan (jika ada)
- Warna: ...
- Font: ...
```
`design-references/links.md`: daftar URL referensi (Dribbble, Behance, situs nyata) beserta 1 kalimat catatan per link.
