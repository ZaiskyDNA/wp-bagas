# Akun Demo & Data Contoh — BAGUS

Dokumen untuk penguji/pemilik. Berisi akun demo dan cara mengisi data contoh.

> ⚠️ **Jangan simpan password admin di repo.** Password admin WordPress hanya ada di
> `.env` lokal (tidak di-commit) dan di server produksi. Dokumen ini hanya memuat akun
> **pelanggan demo** yang memang sengaja dibagikan ke penguji.

---

## Akun pelanggan demo

| Field | Nilai |
|---|---|
| Halaman login | `/(akun-saya)/` → `http://<host>/akun-saya/` |
| Email / username | `demo@bagus-outdoor.id` (username: `demo`) |
| Password | `DemoBagus123!` *(default; ganti via env `BAGUS_DEMO_PASSWORD` saat seeding)* |
| Role | Customer |

Akun ini dibuat oleh `scripts/php/seed-demo.php`. Ganti password demo bila perlu dengan
menjalankan seeding memakai env var:

```bash
docker compose run --rm -e BAGUS_DEMO_PASSWORD='PasswordDemoKamu' wpcli \
  wp eval-file /scripts/php/seed-demo.php
```

---

## Mengisi data contoh (akun + 2 pesanan)

PRD 12.4 meminta minimal 2 pesanan contoh agar halaman **Pesanan** (Akun Saya & wp-admin)
tidak kosong saat demo. Jalankan sekali (idempoten — tidak membuat duplikat):

```bash
# dari root repo (lokal)
docker compose run --rm wpcli wp eval-file /scripts/php/seed-demo.php
```

Ini membuat:

| Pesanan | Isi | Pembayaran | Status | Pengiriman | Tanggal Sewa | Tujuan |
|---|---|---|---|---|---|---|
| #1 | Tenda Dome 2 Orang (2 Hari) + 2× Sleeping Bag (2 Hari) | Transfer Bank | On hold | Ambil di Basecamp | H+2 | Gunung Ungaran via Mawar |
| #2 | Paket Camping Ceria Berdua (3 Hari) | Bayar di Tempat (COD) | Processing | Antar Kota Semarang (Rp 15.000) | H+5 | Gunung Andong |

> Catatan: membuat pesanan contoh **mengurangi stok** produk terkait (perilaku normal
> WooCommerce). Untuk mengembalikan stok ke nilai seed awal, jalankan ulang
> `wp eval-file /scripts/php/setup-products.php`.

---

## Akun admin (JANGAN di-commit)

- Username/password admin ada di `.env` lokal (`WP_ADMIN_USER` / `WP_ADMIN_PASSWORD`).
- Di produksi, ganti dengan password kuat setelah import (lihat `docs/deployment.md` §9).
- Email tidak terkirim di lingkungan demo tanpa SMTP (PRD 10.6) — ini normal dan tidak
  memengaruhi penilaian; bukti transaksi cukup dari halaman Pesanan Diterima, wp-admin →
  WooCommerce → Orders, dan Flamingo.
