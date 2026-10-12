# Peta Gambar → Lokasi Pemakaian

Semua file ada di `content/images/optimized/` (hasil `scripts/optimize-images.sh`). Alt text lengkap ada di `content/images/IMAGE-PROMPTS.md`.

| File | Ukuran | Halaman / section | Dipasang oleh |
|---|---|---|---|
| `hero-home.webp` | 1920×1080 | Beranda: hero | `seed-content.sh` (Fase 4) |
| `hero-katalog.webp` | 1920×800 | Katalog + arsip kategori: hero kecil | child theme (Fase 2) |
| `hero-paket.webp` | 1920×800 | Paket Camping: hero | Fase 4 |
| `hero-cara-sewa.webp` | 1920×800 | Cara Sewa: hero | Fase 4 |
| `hero-tips.webp` | 1920×800 | Tips & Destinasi: hero | Fase 5 |
| `hero-tentang.webp` | 1920×800 | Tentang Kami: hero | Fase 4 |
| `hero-kontak.webp` | 1920×800 | Kontak: hero | Fase 4 |
| `cta-bg.webp` | 1920×800 | Beranda: CTA penutup (juga Tentang Kami) | Fase 4 |
| `banner-paket-duo.webp` | 1080×1350 | Beranda: Banner Paket | Fase 4 |
| `about-story.webp` | 1080×1350 | Tentang Kami: Cerita | Fase 4 |
| `step-01-pilih.webp` | 1200×900 | Beranda & Cara Sewa: langkah 01 | Fase 4 |
| `step-02-checkout.webp` | 1200×900 | Beranda & Cara Sewa: langkah 02 | Fase 4 |
| `step-03-jelajah.webp` | 1200×900 | Beranda & Cara Sewa: langkah 03 | Fase 4 |
| `dest-ungaran.webp` | 1080×1350 | Beranda: Destinasi (Ungaran) | Fase 4 |
| `dest-andong.webp` | 1080×1350 | Beranda: Destinasi (Andong) | Fase 4 |
| `dest-prau.webp` | 1080×1350 | Beranda: Destinasi (Prau) | Fase 4 |
| `dest-merbabu.webp` | 1080×1350 | Beranda: Destinasi (Merbabu) | Fase 4 |
| `blog-ungaran-mawar.webp` | 1200×675 | Artikel "Panduan Mendaki Gunung Ungaran via Basecamp Mawar" | Fase 5 |
| `blog-checklist-alat.webp` | 1200×675 | Artikel "Checklist Alat Camping Wajib untuk Pemula" | Fase 5 |
| `blog-andong-sunrise.webp` | 1200×675 | Artikel "Camping Ceria di Gunung Andong" | Fase 5 |
| `og-image.jpg` | 1200×630 | Meta `og:image` semua halaman | Fase 4 |

## Produk (gambar utama, `seed-products.sh` Fase 3)
| File | SKU | Produk |
|---|---|---|
| `tnd-02.webp` | TND-02 | Tenda Dome 2 Orang |
| `tnd-04.webp` | TND-04 | Tenda Dome 4 Orang |
| `fly-01.webp` | FLY-01 | Flysheet 3x4 m |
| `crr-45.webp` | CRR-45 | Carrier 45L |
| `crr-60.webp` | CRR-60 | Carrier 60L |
| `slb-01.webp` | SLB-01 | Sleeping Bag Polar |
| `mtr-01.webp` | MTR-01 | Matras Foil |
| `kmp-01.webp` | KMP-01 | Kompor Portable |
| `nst-01.webp` | NST-01 | Nesting Cooking Set |
| `hdl-01.webp` | HDL-01 | Headlamp LED |
| `trk-01.webp` | TRK-01 | Trekking Pole (Sepasang) |
| `jkt-01.webp` | JKT-01 | Jaket Gunung Windproof |
| `pkt-solo.webp` | PKT-SOLO | Paket Pendaki Solo |
| `pkt-duo.webp` | PKT-DUO | Paket Camping Ceria Berdua |
| `pkt-fam.webp` | PKT-FAM | Paket Keluarga Glamping |

Produk juga dipakai di Beranda "Produk Terlaris" (TND-02, CRR-45, SLB-01, KMP-01) dan Paket Camping (PKT-*), via WooCommerce.

## Belum ada (Opsional, memakai fallback)
| File | Fallback |
|---|---|
| `cat-*.webp` (6) | ikon SVG di kartu kategori |
| `avatar-rina/dimas/sinta.webp` | lingkaran inisial |
| `hero-akun.webp` | blok ink + pola kontur SVG (Keranjang/Checkout/Akun) |
| `hero-home-mobile.webp` | crop tengah `hero-home.webp` |
| `about-basecamp.webp`, `kontak-basecamp.webp`, `bg-404.webp` | tidak ditampilkan / blok ink |
