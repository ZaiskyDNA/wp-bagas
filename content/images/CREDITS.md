# Kredit Gambar

Semua foto dan gambar di website BAGUS (hero, foto produk, destinasi, artikel, banner, Open Graph) **dibuat dengan AI image generator oleh pemilik proyek** (Zaisky) untuk keperluan tugas kuliah. Prompt lengkapnya ada di `IMAGE-PROMPTS.md`.

- Orang, tempat usaha, dan produk di gambar bersifat fiktif dan tidak mewakili merek atau orang sungguhan.
- Logo BAGUS dan ikon UI berupa SVG buatan sendiri. Ikon mengikuti gaya [Lucide](https://lucide.dev) (lisensi ISC).
- Gambar ini menggantikan sumber Unsplash/Pexels yang disebut di PRD Bagian 7.5.
- File asli (PNG/JPG/WebP dari generator) disimpan lokal di `content/images/` dan tidak di-commit. Versi web dihasilkan `scripts/optimize-images.sh` ke `content/images/optimized/`.

| File | Sumber | Tanggal | Catatan |
|---|---|---|---|
| 7 hero (`hero-*.webp`) + `cta-bg.webp` | AI, pemilik proyek | 2026-10-11 | Sumber 1168×784, di-crop & upscale ke 1920×1080 / 1920×800 |
| 15 produk (`tnd-02` … `pkt-fam`) | AI, pemilik proyek | 2026-10-11 | Sumber 784×1168, dijadikan 1:1 800×800 (latar studio diperluas) |
| 4 destinasi (`dest-*.webp`) | AI, pemilik proyek | 2026-10-11 | Sumber 784×1168, di-crop 4:5 1080×1350 |
| 3 thumbnail blog (`blog-*.webp`) | AI, pemilik proyek | 2026-10-11 | Sumber 1168×784, di-crop 16:9 1200×675 |
| `banner-paket-duo.webp`, `about-story.webp` | AI, pemilik proyek | 2026-10-11 | Sumber 784×1168, di-crop 4:5 |
| 3 langkah (`step-*.webp`) | AI, pemilik proyek | 2026-10-11 | Opsional, di-crop 4:3 1200×900 |
| `og-image.jpg` | AI, pemilik proyek | 2026-10-11 | 1200×630 JPG, logo ditambahkan di Fase 4 |
