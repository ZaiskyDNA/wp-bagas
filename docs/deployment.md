# Panduan Deployment — BAGUS ke AWS Lightsail

Dokumen ini adalah langkah detail untuk men-deploy situs BAGUS dari lingkungan lokal
(Docker, `http://localhost:8088`) ke **Amazon Lightsail** (blueprint WordPress/Bitnami).
Target biaya: **< $10/bulan** (lihat PRD Bagian 12).

> Ringkasan alur: ekspor `.wpress` dari lokal → buat instance Lightsail → naikkan batas
> upload PHP → import `.wpress` → refresh permalink → hardening → smoke test → snapshot.

---

## 0. Prasyarat (di lokal, sebelum ekspor)

- [ ] Semua item **Checklist Pengujian (PRD Bagian 14)** lolos di `http://localhost:8088`.
- [ ] **Ganti nomor WA asli:** edit `BAGUS_WA_NUMBER` di `wp-content/mu-plugins/bagus-core.php`,
      lalu jalankan ulang `wp eval-file /scripts/php/setup-ctc.php` (atau `./scripts/setup.sh`)
      agar tombol melayang Click to Chat ikut diperbarui.
- [ ] **Ganti password admin** WordPress dengan yang kuat (jangan pakai nilai `.env` demo).
- [ ] (Opsional) Jalankan `wp eval-file /scripts/php/seed-demo.php` untuk membuat akun demo
      pelanggan + 2 pesanan contoh (lihat `docs/demo-accounts.md`).

---

## 1. Ekspor situs lokal (.wpress)

Plugin **All-in-One WP Migration** sudah terpasang.

1. wp-admin lokal → **All-in-One WP Migration → Export → Export to → File**.
2. Tunggu proses selesai, unduh file `.wpress` (disimpan di luar repo; sudah di-`.gitignore`).

Alternatif via WP-CLI (dari host):
```bash
docker compose run --rm wpcli wp ai1wm backup
# File tersimpan di dalam volume wp_data: wp-content/ai1wm-backups/
```

---

## 2. Buat instance Lightsail

1. Konsol Lightsail → **Create instance**.
2. Region: **Asia Pacific (Singapore) `ap-southeast-1`** (atau Jakarta bila tersedia).
3. Platform: **Linux/Unix** → Blueprint: **WordPress** (Bitnami).
4. Paket: **1 GB RAM / 2 vCPU / 40 GB SSD** (± $7/bulan). **Jangan** pilih 512 MB
   (WooCommerce bisa kehabisan memori).
5. Nama instance: `bagus-wp` → **Create instance**. Tunggu status *Running*.

### Firewall
Networking instance → pastikan terbuka: **22 (SSH), 80 (HTTP), 443 (HTTPS)**.

---

## 3. Static IP

1. Lightsail → **Networking → Create static IP**.
2. Attach ke instance `bagus-wp`. Catat IP-nya (mis. `XX.XX.XX.XX`).
3. Static IP **gratis selama terpasang** — jangan biarkan ter-detach (akan ditagih).

---

## 4. Ambil kredensial admin Bitnami

SSH via tombol **Connect using SSH** di konsol Lightsail:
```bash
cat /home/bitnami/bitnami_application_password
# Username admin bawaan Bitnami: user
```
Login sementara: `http://<STATIC_IP>/wp-admin` (user: `user`, password di atas).

---

## 5. Naikkan batas upload PHP (agar `.wpress` bisa di-import)

```bash
sudo nano /opt/bitnami/php/etc/php.ini
# Ubah:
#   upload_max_filesize = 512M
#   post_max_size = 512M
#   memory_limit = 512M
#   max_execution_time = 300
sudo /opt/bitnami/ctlscript.sh restart php-fpm
sudo /opt/bitnami/ctlscript.sh restart apache
```

---

## 6. Import `.wpress`

1. Login `http://<STATIC_IP>/wp-admin`.
2. Plugins → Add New → cari **All-in-One WP Migration** → install & activate.
   (Jika batas import plugin masih 300 MB, pakai ekstensi gratis "Unlimited" dari ai1wm
   atau pastikan langkah 5 sudah menaikkan limit.)
3. **All-in-One WP Migration → Import → Import from → File** → unggah `.wpress`.
4. Setelah selesai, situs akan memakai **kredensial admin dari situs lokal**
   (bukan lagi `user`/Bitnami). Login ulang dengan akun admin lokal.

---

## 7. Refresh permalink

Settings → **Permalinks → Save Changes** (klik **dua kali**) agar rewrite rules
`/%postname%/`, `/produk/`, `/kategori-alat/` aktif. Uji beberapa URL produk & halaman.

---

## 8. (Opsional) HTTPS dengan domain

Jika punya domain:
1. Arahkan **A record** domain ke Static IP (bisa via DNS zone Lightsail, gratis).
2. SSH → `sudo /opt/bitnami/bncert-tool` → ikuti wizard (Let's Encrypt).
3. Perbarui **WordPress Address & Site Address** (Settings → General) ke `https://domain`.

Tanpa domain, demo cukup memakai `http://<STATIC_IP>` (browser akan menandai "Not secure";
ini diterima untuk demo).

---

## 9. Hardening

- [ ] Ganti password admin dengan yang kuat (jika belum).
- [ ] Pastikan **Limit Login Attempts Reloaded** aktif.
- [ ] Hapus plugin yang tidak dipakai; jangan pasang plugin berat (Elementor, dll.).
- [ ] `DISALLOW_FILE_EDIT` — tambahkan di `wp-config.php` bila ingin menonaktifkan editor tema/plugin.
- [ ] (Opsional) Pasang **WP Mail SMTP** (Gmail App Password) bila email perlu benar-benar terkirim
      (PRD 10.6 — opsional, minta persetujuan pemilik dulu).

---

## 10. Smoke test di server

Ulangi **Checklist PRD Bagian 14** di `http://<STATIC_IP>` (desktop + HP):
- 10 halaman tampil, tanpa 404 di menu/footer/CTA.
- Register → login → logout di `/akun-saya/`.
- Tombol WA melayang muncul; "Tanya Stok via WA", "Chat CS", "Konfirmasi via WhatsApp" berfungsi.
- Flow sewa: pilih durasi → keranjang → checkout (tanggal besok diterima, hari ini ditolak) →
  Pesanan Diterima → cek Orders & stok di wp-admin.
- Responsif di 360 / 768 / 1366.

---

## 11. Snapshot & pengendalian biaya

1. Lightsail → instance → **Snapshots → Create snapshot** (cadangan sebelum demo).
2. **AWS Budgets:** buat budget bulanan **$10** dengan alert email di **50% / 80% / 100%**.
3. Jangan pakai RDS, Load Balancer, CDN, atau paket instance lebih besar.

---

## 12. Teardown (SETELAH penilaian selesai)

Agar tidak ada tagihan berjalan:
1. **Hapus instance** `bagus-wp`.
2. **Detach & delete Static IP** (Static IP yang tidak terpasang tetap ditagih).
3. **Hapus snapshot** yang tidak diperlukan.
4. Cek **Billing** memastikan tidak ada resource tersisa.

---

## Catatan Deployment Aktual — 12 Okt 2026 (Lightsail "WordPress")

Blueprint Lightsail "WordPress" versi ini **BUKAN Bitnami `/opt/bitnami`**, melainkan
**LAMP Debian biasa**. Perbedaan penting dari panduan di atas:

| Item | Nilai aktual |
|---|---|
| User SSH | `admin` (bukan `bitnami`) |
| Kredensial app | `~/application_credentials` (user `user` + password) |
| Stack | Apache2 (mod_php) + MariaDB 10.11, native Debian |
| WordPress | `/var/www/html`; `wp-config.php` di **`/var/www/wp-config.php`** (di luar webroot) |
| php.ini web | `/etc/php/8.X/apache2/php.ini` |
| Restart | `sudo systemctl restart apache2` |
| URL | `WP_HOME`/`WP_SITEURL` di wp-config = `http://$_SERVER['HTTP_HOST']` → otomatis ikut host (ramah domain) |

Langkah nyata yang dijalankan:

1. **Static IP** di-attach → `47.131.180.107`.
2. **PHP mismatch:** server bawa PHP 8.2, tetapi Contact Form 7 (dan dev kita) butuh **PHP 8.3**
   → fatal `platform_check.php` di tiap request (500). Solusi: pasang PHP 8.3 via repo **Sury**,
   `a2dismod php8.2 && a2enmod php8.3`, lalu `php8.3-mysql` + `update-alternatives --set php /usr/bin/php8.3`
   agar WP-CLI juga jalan.
3. **Naikkan limit** `/etc/php/8.3/apache2/php.ini` → upload/post 512M, memory 512M, max_exec 600.
4. **Import** `.wpress` (173 MB) via wp-admin → All-in-One WP Migration → Import → File.
   (Import file sukses walau progress bar browser sempat "stuck 98%" karena 500 dari CF7.)
5. **HTTPS self-signed:** vhost `000-default.conf` memaksa http→https (snakeoil) → error sertifikat.
   Untuk demo IP tanpa domain, **3 baris Rewrite redirect di-comment** → sajikan http bersih.
6. **Permalink:** `.htaccess` kosong → ditulis blok standar WordPress + `AllowOverride All`
   sudah aktif di `<Directory /var/www/html>` → produk/halaman 200.
7. **Smoke test** (otomatis) semua halaman + alur sewa lengkap → lolos.

### Saat memasang DOMAIN nanti
1. Arahkan **A record** domain → `47.131.180.107`.
2. Aktifkan kembali redirect https di `000-default.conf` **setelah** punya sertifikat asli.
3. Pasang **Let's Encrypt**: `sudo apt-get install -y certbot python3-certbot-apache && sudo certbot --apache -d domainanda.com`.
4. wp-config memakai `HTTP_HOST`, jadi situs otomatis menyesuaikan ke domain (untuk HTTPS penuh,
   ganti `'http://'` → `'https://'` pada `WP_HOME`/`WP_SITEURL` di `/var/www/wp-config.php`).

### HTTPS + domain (selesai 13 Okt 2026)
- Domain **bagus.ramzco.my.id** → A record → 47.131.180.107 (propagasi global OK).
- **Let's Encrypt** via `certbot --apache` (sertifikat s/d 2027-01-10, auto-renew aktif).
- `wp-config` `WP_HOME`/`WP_SITEURL` → `https://$_SERVER['HTTP_HOST']`; redirect http→https aktif.
- Mixed-content (URL gambar http://IP yang ter-generate) hilang setelah `wp cache flush` dgn https aktif; diverifikasi 0 mixed-content + `ssl_verify_result=0` di semua halaman.
- **URL kanonik untuk demo: `https://bagus.ramzco.my.id`** (akses via IP langsung akan kena redirect https/snakeoil — pakai domain).
