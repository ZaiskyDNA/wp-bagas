# IMAGE-PROMPTS — Aset Gambar BAGUS

Daftar semua gambar website BAGUS beserta prompt AI-nya. Semua gambar dibuat pemilik proyek dengan AI image generator.

Cara pakai:
1. Generate gambar **Wajib** dulu (Bagian B), lalu Opsional (Bagian C).
2. Simpan hasilnya di `content/images/` dengan **nama dasar yang sama** dan format PNG/JPG, misalnya `tnd-02.png` atau `hero-home.jpg`. Nanti saya konversi ke `.webp` (≤ 200 KB), saya crop ke resolusi final, lalu saya pasang di Media Library.
3. Resolusi di tabel adalah **ukuran final**. Generate di ukuran yang sama atau lebih besar dengan rasio yang sama.
4. Setiap prompt sudah lengkap dan siap disalin. Kalau generator kamu punya kolom *negative prompt*, isi dengan negative prompt yang tertulis. Kalau tidak ada kolomnya, tambahkan `Avoid: ...` di akhir prompt.

---

## A. Style Guide Prompt (dipakai di semua gambar)

Arah visual diambil dari `design-references/hiking website design inspiration.jpeg`: fotografi editorial yang sinematik dan moody, bayangan biru-teal gelap, highlight emas hangat, serta banyak ruang kosong gelap untuk teks. Gunung bersalju di referensi **diganti** dengan gunung vulkanik tropis Jawa Tengah.

Palet yang harus terasa di foto (sama dengan token desain):
| Warna | Hex | Peran di foto |
|---|---|---|
| Ink teal-navy | `#0F1D22` | bayangan, langit sebelum fajar, area teks |
| Pine green | `#24483E` | hutan pinus, vegetasi |
| Sand gold | `#D8B573` | cahaya matahari terbit/terbenam, highlight |
| Cream | `#F1EDE4` | kabut, awan, latar foto produk |

### STYLE-L (lanskap & lifestyle), sudah disisipkan di setiap prompt lanskap
```
cinematic editorial outdoor photography, full-frame camera, natural light, golden-hour warm sunlight with deep teal-blue shadows, muted earthy color palette of deep pine green, slate teal, warm sand-gold and soft cream, gentle atmospheric haze, subtle film grain, natural dynamic range, tropical volcanic mountains of Central Java Indonesia, montane pine forest and grassy savanna, no snow, premium travel magazine quality, highly detailed
```

### STYLE-P (foto produk), sudah disisipkan di setiap prompt produk
```
professional e-commerce product photography, single subject centered occupying about 70 percent of the frame, three-quarter front view from 30 degrees above eye level, seamless warm cream studio backdrop (#EFEBE3) with continuous floor and wall, large softbox key light from upper left, soft fill light from right, gentle natural contact shadow beneath the product, crisp focus, true-to-life fabric and metal textures, unbranded generic outdoor gear, earthy colors (olive green, pine green, sand beige, charcoal grey with small burnt-orange accents), clean minimal composition, square 1:1
```

### NEG-L (negative prompt lanskap & lifestyle)
```
text, letters, words, watermark, logo, brand name, signature, caption, frame, border, snow, glacier, ice, snowy alps, european architecture, oversaturated, neon colors, HDR halo, cartoon, illustration, anime, 3d render, CGI, plastic skin, distorted hands, extra fingers, deformed face, extra limbs, blurry, low resolution, jpeg artifacts, litter, trash, crowd
```

### NEG-P (negative prompt produk)
```
text, letters, logo, brand name, label, tag, watermark, people, hands, visible mannequin, cluttered props, colored background, gradient background, outdoor scene, harsh shadow, strong reflections, cropped product, multiple angles, collage, blurry, low resolution, plastic toy look, 3d render look
```

### Aturan komposisi
- **Hero:** subjek di sepertiga kanan (± 60–70% dari kiri). Sisi kiri lebih gelap atau kosong untuk judul. Horizon di tengah-bawah. Gambar akan di-*center crop* di HP, jadi subjek jangan terlalu mepet ke tepi kanan.
- **Orang:** pendaki muda Indonesia/Asia Tenggara, pakaian outdoor sopan, sebagian perempuan berhijab. Lebih baik terlihat dari belakang atau samping (wajah dan tangan lebih jarang cacat).
- **Produk:** latar, sudut kamera, dan pencahayaan sama persis di 15 foto. Usahakan pakai seed atau *style reference* yang sama.

---

## B. WAJIB (33 gambar)

### B1. Hero halaman (7)

#### hero-home.jpg → `hero-home.webp`
- **Pemakaian:** Beranda, section 1 (Hero full-screen, overlay gelap 40%)
- **Rasio & resolusi:** 16:9, 1920×1080
- **Prompt:**
```
A lone young Indonesian hiker with a large trekking backpack standing on a rocky summit ridge, seen from behind, positioned at the right third of the frame, looking out over a vast sea of clouds at sunrise, twin volcanic cones of Mount Sindoro and Sumbing rising above the clouds in the distance, first warm sand-gold sunlight on the hiker's shoulders and rocks, deep teal-blue pre-dawn sky fading to gold at the horizon, left side of the frame darker with open sky for headline text, sense of freedom and calm achievement, cinematic editorial outdoor photography, full-frame camera, natural light, golden-hour warm sunlight with deep teal-blue shadows, muted earthy color palette of deep pine green, slate teal, warm sand-gold and soft cream, gentle atmospheric haze, subtle film grain, natural dynamic range, tropical volcanic mountains of Central Java Indonesia, montane pine forest and grassy savanna, no snow, premium travel magazine quality, highly detailed
```
- **Negative:** NEG-L
- **Alt:** Pendaki berdiri di puncak berbatu menatap lautan awan saat matahari terbit dengan Gunung Sindoro dan Sumbing di kejauhan

#### hero-katalog.jpg → `hero-katalog.webp`
- **Pemakaian:** Katalog (`/katalog/`) dan arsip kategori produk, hero kecil
- **Rasio & resolusi:** 12:5, 1920×800 (generate 21:9 atau 16:9, subjek di pita tengah)
- **Prompt:**
```
A small campsite on a grassy mountain ridge at blue hour, an olive green dome tent glowing warmly from a lantern inside, a trekking backpack, a compact camping stove and a cooking pot neatly placed in front, placed on the right side of the frame, misty pine forest slopes and distant volcanic silhouettes behind, darker open space on the left, calm and inviting mood, cinematic editorial outdoor photography, full-frame camera, natural light, deep teal-blue shadows with warm sand-gold lantern glow, muted earthy color palette of deep pine green, slate teal, warm sand-gold and soft cream, gentle atmospheric haze, subtle film grain, tropical volcanic mountains of Central Java Indonesia, no snow, premium travel magazine quality, highly detailed, wide panoramic composition
```
- **Negative:** NEG-L
- **Alt:** Tenda hijau menyala hangat di punggung bukit saat senja dengan carrier dan kompor di depannya

#### hero-paket.jpg → `hero-paket.webp`
- **Pemakaian:** Paket Camping (`/paket-camping/`), hero
- **Rasio & resolusi:** 12:5, 1920×800
- **Prompt:**
```
Two young Indonesian friends, a man and a woman wearing a hijab, pitching a dome tent together on a golden savanna ridge of Mount Merbabu at late afternoon, seen from the side and slightly behind, placed on the right side of the frame, two backpacks and rolled sleeping mats beside them, rolling green-gold hills and distant volcanic peaks under soft clouds, warm low sunlight, joyful teamwork mood, darker open area on the left for text, cinematic editorial outdoor photography, full-frame camera, natural light, golden-hour warm sunlight with deep teal-blue shadows, muted earthy color palette of deep pine green, slate teal, warm sand-gold and soft cream, gentle atmospheric haze, subtle film grain, tropical volcanic mountains of Central Java Indonesia, no snow, premium travel magazine quality, highly detailed, wide panoramic composition
```
- **Negative:** NEG-L
- **Alt:** Dua sahabat mendirikan tenda bersama di sabana Gunung Merbabu saat sore hari

#### hero-cara-sewa.jpg → `hero-cara-sewa.webp`
- **Pemakaian:** Cara Sewa (`/cara-sewa/`), hero
- **Rasio & resolusi:** 12:5, 1920×800
- **Prompt:**
```
Interior of a cozy outdoor gear rental basecamp, a staff member handing a packed olive green trekking backpack across a wooden counter to a young customer, hands shown naturally, wooden shelves behind neatly stocked with folded tents, backpacks, sleeping bags and cooking sets, warm tungsten lights mixed with soft window light, shallow depth of field, focus on the handover on the right side of the frame, friendly trustworthy mood, cinematic editorial photography, full-frame camera, deep teal shadows and warm sand-gold highlights, muted earthy color palette of pine green, slate teal, sand and cream, subtle film grain, premium magazine quality, highly detailed, wide panoramic composition
```
- **Negative:** NEG-L, tambahkan `price tags, signage, readable labels`
- **Alt:** Petugas basecamp BAGUS menyerahkan carrier kepada penyewa di meja kayu dengan rak alat camping di belakangnya

#### hero-tips.jpg → `hero-tips.webp`
- **Pemakaian:** Tips & Destinasi (`/tips-destinasi/`), hero
- **Rasio & resolusi:** 12:5, 1920×800
- **Prompt:**
```
A narrow hiking trail winding through a misty montane pine forest on the slopes of Mount Ungaran in early morning, a single small hiker with a backpack walking away from the camera on the right side of the frame, sunbeams piercing through the tall pine trees and fog, ferns along the path, quiet adventurous mood, cinematic editorial outdoor photography, full-frame camera, natural light, warm sand-gold sun rays with deep teal-blue shadows, muted earthy color palette of deep pine green, slate teal, warm sand-gold and soft cream, thick atmospheric haze, subtle film grain, tropical Central Java Indonesia, no snow, premium travel magazine quality, highly detailed, wide panoramic composition
```
- **Negative:** NEG-L
- **Alt:** Jalur pendakian di hutan pinus berkabut Gunung Ungaran dengan sinar matahari pagi

#### hero-tentang.jpg → `hero-tentang.webp`
- **Pemakaian:** Tentang Kami (`/tentang-kami/`), hero "Dari Pendaki, untuk Pendaki."
- **Rasio & resolusi:** 12:5, 1920×800
- **Prompt:**
```
A small group of four young Indonesian hikers walking in a line along a grassy mountain ridge at sunrise, small figures with backpacks partly silhouetted, positioned in the right half of the frame, vast layers of misty hills and a distant volcano behind, warm golden backlight, spirit of community and shared adventure, cinematic editorial outdoor photography, full-frame camera, natural light, golden-hour warm sunlight with deep teal-blue shadows, muted earthy color palette of deep pine green, slate teal, warm sand-gold and soft cream, gentle atmospheric haze, subtle film grain, tropical volcanic mountains of Central Java Indonesia, no snow, premium travel magazine quality, highly detailed, wide panoramic composition
```
- **Negative:** NEG-L
- **Alt:** Rombongan pendaki berjalan beriringan di punggung bukit saat matahari terbit

#### hero-kontak.jpg → `hero-kontak.webp`
- **Pemakaian:** Kontak (`/kontak/`), hero
- **Rasio & resolusi:** 12:5, 1920×800
- **Prompt:**
```
A peaceful campsite at dusk in a pine forest clearing, a young Indonesian hiker sitting at the entrance of an olive green dome tent holding a smartphone, face softly lit by the screen and a warm hanging lantern, seen from the side, placed on the right side of the frame, mountains fading into teal twilight behind, steam rising from a small cooking pot, calm connected mood, cinematic editorial outdoor photography, full-frame camera, deep teal-blue twilight shadows with warm sand-gold lantern glow, muted earthy color palette of deep pine green, slate teal, warm sand-gold and soft cream, gentle atmospheric haze, subtle film grain, tropical Central Java Indonesia, no snow, premium travel magazine quality, highly detailed, wide panoramic composition
```
- **Negative:** NEG-L, tambahkan `readable screen content`
- **Alt:** Pendaki duduk di depan tenda saat senja sambil memegang ponsel di bawah cahaya lentera

### B2. Foto produk (15)
- **Pemakaian:** kartu produk (Katalog, Beranda "Produk Terlaris", Paket Camping, produk terkait), gambar utama Detail Produk, thumbnail keranjang & checkout
- **Rasio & resolusi:** 1:1, final 800×800 (generate 1024×1024)
- **Negative (semua produk):** NEG-P

#### tnd-02.jpg → `tnd-02.webp`: Tenda Dome 2 Orang
```
A fully pitched two-person dome camping tent with an olive green rainfly and sand beige panels, front door half unzipped showing a grey mesh inner, taut guy lines with small stakes, compact and sturdy, professional e-commerce product photography, single subject centered occupying about 70 percent of the frame, three-quarter front view from 30 degrees above eye level, seamless warm cream studio backdrop (#EFEBE3) with continuous floor and wall, large softbox key light from upper left, soft fill light from right, gentle natural contact shadow beneath the product, crisp focus, true-to-life fabric and metal textures, unbranded generic outdoor gear, earthy colors (olive green, pine green, sand beige, charcoal grey with small burnt-orange accents), clean minimal composition, square 1:1
```
- **Alt:** Tenda dome 2 orang warna hijau zaitun berdiri utuh dengan pintu setengah terbuka

#### tnd-04.jpg → `tnd-04.webp`: Tenda Dome 4 Orang
```
A fully pitched large four-person family dome camping tent with a pine green rainfly, charcoal grey lower panels and a front vestibule, door rolled open showing a spacious mesh interior, taut guy lines, professional e-commerce product photography, single subject centered occupying about 70 percent of the frame, three-quarter front view from 30 degrees above eye level, seamless warm cream studio backdrop (#EFEBE3) with continuous floor and wall, large softbox key light from upper left, soft fill light from right, gentle natural contact shadow beneath the product, crisp focus, true-to-life fabric and metal textures, unbranded generic outdoor gear, earthy colors (olive green, pine green, sand beige, charcoal grey with small burnt-orange accents), clean minimal composition, square 1:1
```
- **Alt:** Tenda dome 4 orang warna hijau tua dengan teras depan dan pintu terbuka

#### fly-01.jpg → `fly-01.webp`: Flysheet 3x4 m
```
A sand beige 3 by 4 meter camping flysheet tarp pitched as an A-frame shelter on two charcoal aluminium poles with taut guy lines and stakes, smooth waterproof ripstop fabric, professional e-commerce product photography, single subject centered occupying about 70 percent of the frame, three-quarter front view from 30 degrees above eye level, seamless warm cream studio backdrop (#EFEBE3) with continuous floor and wall, large softbox key light from upper left, soft fill light from right, gentle natural contact shadow beneath the product, crisp focus, true-to-life fabric and metal textures, unbranded generic outdoor gear, earthy colors (olive green, pine green, sand beige, charcoal grey with small burnt-orange accents), clean minimal composition, square 1:1
```
- **Alt:** Flysheet 3x4 meter warna krem terpasang model segitiga dengan dua tiang

#### crr-45.jpg → `crr-45.webp`: Carrier 45L
```
A 45 liter trekking backpack standing upright, olive green body with charcoal grey straps, padded hip belt, side mesh bottle pockets, front daisy chain and small burnt-orange zipper pulls, professional e-commerce product photography, single subject centered occupying about 70 percent of the frame, three-quarter front view from 30 degrees above eye level, seamless warm cream studio backdrop (#EFEBE3) with continuous floor and wall, large softbox key light from upper left, soft fill light from right, gentle natural contact shadow beneath the product, crisp focus, true-to-life fabric and metal textures, unbranded generic outdoor gear, earthy colors (olive green, pine green, sand beige, charcoal grey with small burnt-orange accents), clean minimal composition, square 1:1
```
- **Alt:** Carrier 45 liter warna hijau zaitun dengan tali bahu abu-abu gelap

#### crr-60.jpg → `crr-60.webp`: Carrier 60L
```
A large 60 liter expedition trekking backpack standing upright, charcoal grey body with pine green panels and burnt-orange accents, top lid pocket, compression straps, padded hip belt, trekking pole loops, professional e-commerce product photography, single subject centered occupying about 70 percent of the frame, three-quarter front view from 30 degrees above eye level, seamless warm cream studio backdrop (#EFEBE3) with continuous floor and wall, large softbox key light from upper left, soft fill light from right, gentle natural contact shadow beneath the product, crisp focus, true-to-life fabric and metal textures, unbranded generic outdoor gear, earthy colors (olive green, pine green, sand beige, charcoal grey with small burnt-orange accents), clean minimal composition, square 1:1
```
- **Alt:** Carrier 60 liter warna abu-abu gelap dengan aksen hijau dan oranye

#### slb-01.jpg → `slb-01.webp`: Sleeping Bag Polar
```
A rectangular envelope sleeping bag half unrolled with the zipper partly open, sage green outer shell and a soft grey polar fleece lining visible inside, a matching compression stuff sack lying beside it, professional e-commerce product photography, single subject centered occupying about 70 percent of the frame, three-quarter front view from 30 degrees above eye level, seamless warm cream studio backdrop (#EFEBE3) with continuous floor and wall, large softbox key light from upper left, soft fill light from right, gentle natural contact shadow beneath the product, crisp focus, true-to-life fabric and metal textures, unbranded generic outdoor gear, earthy colors (olive green, pine green, sand beige, charcoal grey with small burnt-orange accents), clean minimal composition, square 1:1
```
- **Alt:** Sleeping bag polar warna hijau sage setengah terbuka dengan lapisan fleece abu-abu

#### mtr-01.jpg → `mtr-01.webp`: Matras Foil
```
A closed-cell foam camping sleeping mat with a silver reflective aluminium foil side, accordion folded and partially unfolded to show both the silver foil and the olive green foam side, egg-crate texture, professional e-commerce product photography, single subject centered occupying about 70 percent of the frame, three-quarter front view from 30 degrees above eye level, seamless warm cream studio backdrop (#EFEBE3) with continuous floor and wall, large softbox key light from upper left, soft fill light from right, gentle natural contact shadow beneath the product, crisp focus, true-to-life foam and foil textures, unbranded generic outdoor gear, earthy colors (olive green, pine green, sand beige, charcoal grey with small burnt-orange accents), clean minimal composition, square 1:1
```
- **Alt:** Matras foil lipat dengan sisi perak dan sisi busa hijau

#### kmp-01.jpg → `kmp-01.webp`: Kompor Portable
```
A compact portable camping gas stove with foldable pot supports screwed on top of a matte sand beige gas canister, small burnt-orange control valve, brushed stainless steel burner head, professional e-commerce product photography, single subject centered occupying about 70 percent of the frame, three-quarter front view from 30 degrees above eye level, seamless warm cream studio backdrop (#EFEBE3) with continuous floor and wall, large softbox key light from upper left, soft fill light from right, gentle natural contact shadow beneath the product, crisp focus, true-to-life metal textures, unbranded generic outdoor gear, earthy colors (olive green, pine green, sand beige, charcoal grey with small burnt-orange accents), clean minimal composition, square 1:1
```
- **Alt:** Kompor portable lipat terpasang di atas tabung gas warna krem

#### nst-01.jpg → `nst-01.webp`: Nesting Cooking Set
```
A camping nesting cookware set of anodized aluminium in graphite grey and olive green, two pots with lids, a frying pan and a small kettle partially nested and stacked, folding handles, a mesh carry bag beside it, professional e-commerce product photography, single subject centered occupying about 70 percent of the frame, three-quarter front view from 30 degrees above eye level, seamless warm cream studio backdrop (#EFEBE3) with continuous floor and wall, large softbox key light from upper left, soft fill light from right, gentle natural contact shadow beneath the product, crisp focus, true-to-life metal textures, unbranded generic outdoor gear, earthy colors (olive green, pine green, sand beige, charcoal grey with small burnt-orange accents), clean minimal composition, square 1:1
```
- **Alt:** Set alat masak nesting berisi panci, wajan, dan ketel aluminium warna abu-abu dan hijau

#### hdl-01.jpg → `hdl-01.webp`: Headlamp LED
```
A compact LED headlamp with a matte charcoal grey housing and a single round lens angled toward the camera, adjustable charcoal elastic headband with a thin burnt-orange stripe looped neatly behind it, professional e-commerce product photography, single subject centered occupying about 70 percent of the frame, three-quarter front view from 30 degrees above eye level, seamless warm cream studio backdrop (#EFEBE3) with continuous floor and wall, large softbox key light from upper left, soft fill light from right, gentle natural contact shadow beneath the product, crisp focus, true-to-life plastic and fabric textures, unbranded generic outdoor gear, earthy colors (olive green, pine green, sand beige, charcoal grey with small burnt-orange accents), clean minimal composition, square 1:1
```
- **Alt:** Headlamp LED warna abu-abu gelap dengan tali elastis

#### trk-01.jpg → `trk-01.webp`: Trekking Pole (Sepasang)
```
A pair of telescopic trekking poles crossed diagonally in an X shape, matte charcoal aluminium shafts, natural cork grips, olive green wrist straps, small trekking baskets and carbide tips, both poles fully inside the frame, professional e-commerce product photography, subject centered occupying about 75 percent of the frame, three-quarter front view from 30 degrees above eye level, seamless warm cream studio backdrop (#EFEBE3) with continuous floor and wall, large softbox key light from upper left, soft fill light from right, gentle natural contact shadow beneath the product, crisp focus, true-to-life metal and cork textures, unbranded generic outdoor gear, earthy colors (olive green, pine green, sand beige, charcoal grey with small burnt-orange accents), clean minimal composition, square 1:1
```
- **Alt:** Sepasang trekking pole aluminium dengan pegangan gabus disilangkan

#### jkt-01.jpg → `jkt-01.webp`: Jaket Gunung Windproof
```
A windproof hiking shell jacket displayed with an invisible ghost mannequin effect, pine green fabric with sand beige zipper and drawcords, adjustable hood up, chest zip pocket, slight natural fabric folds, professional e-commerce apparel product photography, single subject centered occupying about 70 percent of the frame, three-quarter front view from slightly above eye level, seamless warm cream studio backdrop (#EFEBE3), large softbox key light from upper left, soft fill light from right, soft shadow, crisp focus, true-to-life nylon fabric texture, unbranded generic outdoor apparel, earthy colors, clean minimal composition, square 1:1
```
- **Alt:** Jaket gunung windproof warna hijau tua dengan tudung dan resleting krem

#### pkt-solo.jpg → `pkt-solo.webp`: Paket Pendaki Solo
```
A neatly arranged solo hiking gear bundle: an olive green 45 liter backpack standing upright in the back, a packed two-person tent in its stuff sack, a sage green sleeping bag in a compression sack, a rolled silver foil sleeping mat and a charcoal LED headlamp arranged in front, all items fully visible and evenly spaced as one cohesive group, professional e-commerce product photography, group centered occupying about 75 percent of the frame, three-quarter front view from 30 degrees above eye level, seamless warm cream studio backdrop (#EFEBE3) with continuous floor and wall, large softbox key light from upper left, soft fill light from right, gentle natural contact shadows, crisp focus, unbranded generic outdoor gear, earthy colors (olive green, pine green, sand beige, charcoal grey with small burnt-orange accents), clean minimal composition, square 1:1
```
- **Alt:** Isi Paket Pendaki Solo: carrier 45 liter, tenda, sleeping bag, matras foil, dan headlamp

#### pkt-duo.jpg → `pkt-duo.webp`: Paket Camping Ceria Berdua
```
A neatly arranged camping gear bundle for two people: a small pitched olive green two-person dome tent in the back, two sage green sleeping bags rolled, two rolled silver foil sleeping mats, a compact gas camping stove, a graphite nesting cookware set and two charcoal LED headlamps arranged in front, all items fully visible and evenly spaced as one cohesive group, professional e-commerce product photography, group centered occupying about 80 percent of the frame, three-quarter front view from 30 degrees above eye level, seamless warm cream studio backdrop (#EFEBE3) with continuous floor and wall, large softbox key light from upper left, soft fill light from right, gentle natural contact shadows, crisp focus, unbranded generic outdoor gear, earthy colors (olive green, pine green, sand beige, charcoal grey with small burnt-orange accents), clean minimal composition, square 1:1
```
- **Alt:** Isi Paket Camping Ceria Berdua: tenda 2 orang, 2 sleeping bag, 2 matras, kompor, nesting, dan 2 headlamp

#### pkt-fam.jpg → `pkt-fam.webp`: Paket Keluarga Glamping
```
A neatly arranged family glamping gear bundle: a large pitched pine green four-person dome tent in the back, a folded sand beige flysheet, four sleeping bags stacked, four rolled silver foil sleeping mats, a compact gas camping stove and a graphite nesting cookware set arranged in front, all items fully visible and evenly spaced as one cohesive group, cozy but tidy, professional e-commerce product photography, group centered occupying about 80 percent of the frame, three-quarter front view from 30 degrees above eye level, seamless warm cream studio backdrop (#EFEBE3) with continuous floor and wall, large softbox key light from upper left, soft fill light from right, gentle natural contact shadows, crisp focus, unbranded generic outdoor gear, earthy colors (olive green, pine green, sand beige, charcoal grey with small burnt-orange accents), clean minimal composition, square 1:1
```
- **Alt:** Isi Paket Keluarga Glamping: tenda 4 orang, flysheet, 4 sleeping bag, 4 matras, kompor, dan nesting

### B3. Beranda: banner paket & CTA (2)

#### banner-paket-duo.jpg → `banner-paket-duo.webp`
- **Pemakaian:** Beranda, section 6 (Banner Paket, gambar di kanan, dengan kartu kaca "Hemat Rp 19.000" di atasnya)
- **Rasio & resolusi:** 4:3, 1200×900
- **Prompt:**
```
Two young Indonesian friends, a man and a woman wearing a hijab, sitting relaxed at the open entrance of an olive green dome tent on a misty mountain meadow in the early morning, laughing together, sleeping bags and foil mats inside the tent, a small gas stove boiling water for coffee in front, warm sunrise light from the side, first-time camping joy, cinematic editorial outdoor photography, full-frame camera, natural light, golden-hour warm sunlight with deep teal-blue shadows, muted earthy color palette of deep pine green, slate teal, warm sand-gold and soft cream, gentle atmospheric haze, subtle film grain, tropical Central Java Indonesia, no snow, premium travel magazine quality, highly detailed
```
- **Negative:** NEG-L
- **Alt:** Dua sahabat tertawa di depan tenda sambil menyeduh kopi di pagi hari

#### cta-bg.jpg → `cta-bg.webp`
- **Pemakaian:** Beranda, section 10 (CTA Penutup "Siap Jelajah Akhir Pekan Ini?"), kartu lebar dengan overlay gelap. Bisa dipakai ulang untuk CTA di Tentang Kami.
- **Rasio & resolusi:** 12:5, 1920×800
- **Prompt:**
```
Panoramic view of a small hiker standing on a rocky outcrop at the right third of the frame at dusk, facing layered misty mountain ranges and a distant volcano, wide calm dark teal sky with a thin warm sand-gold glow along the horizon, large dark empty area on the left and center for text, quiet inspiring mood, cinematic editorial outdoor photography, full-frame camera, natural light, deep teal-blue shadows with warm sand-gold highlights, muted earthy color palette of deep pine green, slate teal, warm sand-gold and soft cream, gentle atmospheric haze, subtle film grain, tropical volcanic mountains of Central Java Indonesia, no snow, premium travel magazine quality, highly detailed, wide panoramic composition
```
- **Negative:** NEG-L
- **Alt:** Pendaki berdiri di batu karang menatap jajaran pegunungan berkabut saat senja

### B4. Destinasi favorit (4)
- **Pemakaian:** Beranda, section 8 (kartu destinasi bergaya "Curated Hiking Experiences" di referensi: overlay gradasi, badge, nama, mdpl). Bisa dipakai ulang di artikel.
- **Rasio & resolusi:** 4:5, 1080×1350
- **Negative:** NEG-L
- **Catatan:** sisakan sepertiga bawah gambar lebih gelap/sederhana untuk teks kartu.

#### dest-ungaran.jpg → `dest-ungaran.webp`
```
Vertical view from the rocky grassy summit of Mount Ungaran Central Java at sunrise, foreground of volcanic rocks and wild grasses, steep montane forest slopes dropping into a sea of morning clouds, distant volcanic cones on the horizon, warm golden first light on the top half, darker calmer lower third, cinematic editorial outdoor photography, full-frame camera, natural light, golden-hour warm sunlight with deep teal-blue shadows, muted earthy color palette of deep pine green, slate teal, warm sand-gold and soft cream, gentle atmospheric haze, subtle film grain, no snow, premium travel magazine quality, highly detailed, portrait 4:5
```
- **Alt:** Puncak Gunung Ungaran berbatu dengan lautan awan saat matahari terbit

#### dest-andong.jpg → `dest-andong.webp`
```
Vertical view of the narrow grassy summit ridge of Mount Andong Central Java at sunrise, a footpath running along the ridge with a few small colorful-muted dome tents, the massive silhouettes of Mount Merbabu and Mount Merapi rising behind under a gold and teal sky, low mist in the valleys, darker calmer lower third, cinematic editorial outdoor photography, full-frame camera, natural light, golden-hour warm sunlight with deep teal-blue shadows, muted earthy color palette of deep pine green, slate teal, warm sand-gold and soft cream, gentle atmospheric haze, subtle film grain, no snow, premium travel magazine quality, highly detailed, portrait 4:5
```
- **Alt:** Punggung puncak Gunung Andong dengan deretan tenda dan Gunung Merbabu di belakangnya

#### dest-prau.jpg → `dest-prau.webp`
```
Vertical view of the rolling green hills of the Mount Prau plateau Dieng Central Java at golden sunrise, soft grassy mounds dotted with tiny wildflowers, the twin volcanic cones of Mount Sindoro and Mount Sumbing rising above a sea of clouds in the distance, warm gold light and teal shadows, darker calmer lower third, cinematic editorial outdoor photography, full-frame camera, natural light, muted earthy color palette of deep pine green, slate teal, warm sand-gold and soft cream, gentle atmospheric haze, subtle film grain, no snow, premium travel magazine quality, highly detailed, portrait 4:5
```
- **Alt:** Bukit hijau Gunung Prau dengan Gunung Sindoro dan Sumbing di atas lautan awan

#### dest-merbabu.jpg → `dest-merbabu.webp`
```
Vertical view of the vast golden-green savanna ridges of Mount Merbabu Central Java in late afternoon, a winding trail along the crest with a tiny hiker for scale, the cone of Mount Merapi with a faint plume in the distance, dramatic clouds, warm low sunlight and long teal shadows, darker calmer lower third, cinematic editorial outdoor photography, full-frame camera, natural light, muted earthy color palette of deep pine green, slate teal, warm sand-gold and soft cream, gentle atmospheric haze, subtle film grain, no snow, premium travel magazine quality, highly detailed, portrait 4:5
```
- **Alt:** Sabana luas Gunung Merbabu dengan jalur pendakian dan Gunung Merapi di kejauhan

### B5. Thumbnail artikel blog (3)
- **Pemakaian:** kartu artikel di Tips & Destinasi, featured image di halaman artikel
- **Rasio & resolusi:** 16:9, 1200×675
- **Negative:** NEG-L

#### blog-ungaran-mawar.jpg → `blog-ungaran-mawar.webp`
- **Artikel:** Panduan Mendaki Gunung Ungaran via Basecamp Mawar untuk Pemula
```
Two young Indonesian hikers with daypacks walking up a forest trail through tall pine trees on Mount Ungaran in the morning, glimpses of green tea plantation terraces and misty hills through the trees, soft sun rays, beginner-friendly cheerful mood, cinematic editorial outdoor photography, full-frame camera, natural light, warm sand-gold sun rays with deep teal-blue shadows, muted earthy color palette of deep pine green, slate teal, warm sand-gold and soft cream, gentle atmospheric haze, subtle film grain, tropical Central Java Indonesia, no snow, premium travel magazine quality, highly detailed
```
- **Alt:** Dua pendaki menyusuri jalur hutan pinus Gunung Ungaran via Basecamp Mawar

#### blog-checklist-alat.jpg → `blog-checklist-alat.webp`
- **Artikel:** Checklist Alat Camping Wajib untuk Pemula
```
Top-down knolling flat lay of essential camping gear neatly arranged in a grid on weathered dark wooden planks: packed tent in stuff sack, rolled sleeping bag, foil sleeping mat, compact gas stove, nesting cookware, LED headlamp, water bottle, rain poncho, compass, folded paper map without readable text, first aid pouch, soft warm window light from the top left, organized and helpful mood, editorial product photography, muted earthy color palette of olive green, pine green, sand beige, charcoal and cream, subtle film grain, highly detailed
```
- **Negative:** NEG-L, tambahkan `readable map text, brand labels`
- **Alt:** Susunan alat camping wajib untuk pemula di atas papan kayu dilihat dari atas

#### blog-andong-sunrise.jpg → `blog-andong-sunrise.webp`
- **Artikel:** Camping Ceria di Gunung Andong: Spot Sunrise Terbaik Dekat Semarang
```
Small dome tents pitched along the narrow summit ridge of Mount Andong at sunrise, a young family with a child standing near a tent watching the sun, seen from behind, Mount Merbabu and Mount Merapi silhouettes rising above a sea of mist, warm golden light, family adventure mood, cinematic editorial outdoor photography, full-frame camera, natural light, golden-hour warm sunlight with deep teal-blue shadows, muted earthy color palette of deep pine green, slate teal, warm sand-gold and soft cream, gentle atmospheric haze, subtle film grain, tropical Central Java Indonesia, no snow, premium travel magazine quality, highly detailed
```
- **Alt:** Keluarga menikmati matahari terbit di samping tenda di puncak Gunung Andong

### B6. Tentang Kami (1)

#### about-story.jpg → `about-story.webp`
- **Pemakaian:** Tentang Kami, section 2 (Cerita Bagus Pratama), gambar di samping teks
- **Rasio & resolusi:** 4:5, 1080×1350
- **Prompt:**
```
Environmental portrait of a friendly Indonesian man in his early thirties, a former university mountaineering club member, wearing an olive green fleece jacket, standing with arms relaxed inside his small outdoor gear rental basecamp, wooden shelves behind him neatly stocked with tents, backpacks and sleeping bags, warm tungsten light mixed with soft window light, gentle confident smile, shallow depth of field, cinematic editorial portrait photography, full-frame camera, 50mm lens, deep teal shadows and warm sand-gold highlights, muted earthy color palette, subtle film grain, natural skin texture, highly detailed, portrait 4:5
```
- **Negative:** NEG-L, tambahkan `signage, readable labels`
- **Alt:** Bagus Pratama, pendiri BAGUS, berdiri di basecamp dengan rak tenda dan carrier

### B7. Open Graph (1)

#### og-image.jpg → `og-image.jpg` (tetap JPG supaya kompatibel dengan WhatsApp/Facebook)
- **Pemakaian:** pratinjau link saat situs dibagikan (WhatsApp, Instagram, Facebook). Logo dan tagline nanti saya tempel lewat script, jadi **gambarnya harus tanpa teks**.
- **Rasio & resolusi:** 1.91:1, 1200×630
- **Prompt:**
```
Wide view of a lone hiker with a trekking backpack on a rocky ridge at the right third of the frame at sunrise, sea of clouds and twin volcanic cones of Central Java in the distance, the left half of the image a calm dark teal sky with plenty of empty space, cinematic editorial outdoor photography, full-frame camera, natural light, golden-hour warm sunlight with deep teal-blue shadows, muted earthy color palette of deep pine green, slate teal, warm sand-gold and soft cream, gentle atmospheric haze, subtle film grain, no snow, premium travel magazine quality, highly detailed
```
- **Negative:** NEG-L
- **Alt:** BAGUS, Mendaki Jadi Lebih BAGUS: pendaki di punggung bukit saat matahari terbit

---

## C. OPSIONAL

Jika gambar opsional tidak di-generate, fallback-nya sudah dirancang: ikon SVG, inisial, atau blok warna ink dengan pola garis kontur topografi.

### C1. Langkah "Cara Sewa" (3, sangat direkomendasikan)
- **Pemakaian:** Beranda section 7 dan halaman Cara Sewa. Layout split bergaya referensi (angka besar "01/02/03" + gambar). Fallback: ikon.
- **Rasio & resolusi:** 4:3, 1200×900
- **Negative:** NEG-L, tambahkan `readable screen content`

#### step-01-pilih.jpg → `step-01-pilih.webp`
```
Over-the-shoulder view of a young Indonesian woman wearing a hijab sitting on a bench at a cozy outdoor cafe, browsing camping gear on her smartphone, the screen softly blurred and unreadable, a trekking backpack beside her, warm afternoon light, cinematic editorial lifestyle photography, shallow depth of field, deep teal shadows and warm sand-gold highlights, muted earthy palette of pine green, slate teal, sand and cream, subtle film grain, highly detailed
```
- **Alt:** Penyewa memilih alat camping lewat ponsel

#### step-02-checkout.jpg → `step-02-checkout.webp`
```
Close-up of a young Indonesian person's hands holding a smartphone showing a blurred unreadable chat conversation, sitting on the floor next to an open trekking backpack and a camping checklist notebook, warm indoor evening lamp light, cinematic editorial lifestyle photography, shallow depth of field, natural hands with five fingers, deep teal shadows and warm sand-gold highlights, muted earthy palette, subtle film grain, highly detailed
```
- **Alt:** Penyewa mengonfirmasi pesanan lewat WhatsApp

#### step-03-jelajah.jpg → `step-03-jelajah.webp`
```
A young Indonesian hiker with a trekking backpack on a mountain trail stepping onto a viewpoint, seen from behind, arms slightly raised in joy, layered misty green volcanic hills ahead at golden hour, cinematic editorial outdoor photography, full-frame camera, natural light, golden-hour warm sunlight with deep teal-blue shadows, muted earthy color palette of deep pine green, slate teal, warm sand-gold and soft cream, gentle atmospheric haze, subtle film grain, tropical Central Java Indonesia, no snow, highly detailed
```
- **Alt:** Pendaki bergembira tiba di titik pandang pegunungan

### C2. Kategori (6)
- **Pemakaian:** Beranda section 4 (kartu kategori) dan thumbnail kategori WooCommerce. Fallback: ikon Lucide di lingkaran.
- **Rasio & resolusi:** 1:1, 800×800
- **Gaya:** close-up lifestyle yang moody (bukan studio), objek di tengah, latar gelap ber-bokeh, supaya tampil beda dari foto produk.
- **Negative:** NEG-L
- **Prompt dasar** (ganti `{SUBJECT}`):
```
Moody close-up of {SUBJECT} outdoors at a mountain campsite at golden hour, subject centered, dark softly blurred pine forest background with bokeh, warm sand-gold rim light and deep teal shadows, cinematic editorial outdoor photography, shallow depth of field, muted earthy color palette of pine green, slate teal, sand and cream, subtle film grain, unbranded gear, square 1:1, highly detailed
```
| File | `{SUBJECT}` | Alt |
|---|---|---|
| `cat-tenda.webp` | an olive green dome tent entrance with the door zipped half open | Kategori Tenda |
| `cat-tas-carrier.webp` | an olive green trekking backpack leaning on a mossy rock | Kategori Tas & Carrier |
| `cat-perlengkapan-tidur.webp` | a sage green sleeping bag and foil mat rolled out inside a tent | Kategori Perlengkapan Tidur |
| `cat-alat-masak.webp` | a small gas camping stove boiling water in a graphite pot with rising steam | Kategori Alat Masak |
| `cat-aksesoris.webp` | an LED headlamp glowing next to crossed trekking poles on a rock | Kategori Aksesoris |
| `cat-paket.webp` | a complete tidy camp setup with tent, backpack, mats and stove | Kategori Paket |

### C3. Avatar testimoni (3)
- **Pemakaian:** Beranda section 9. Fallback: lingkaran inisial (R, D, S).
- **Rasio & resolusi:** 1:1, 400×400 (ditampilkan bulat)
- **Negative:** NEG-L, tambahkan `harsh flash, studio backdrop`
- **Prompt dasar** (ganti `{PERSON}`):
```
Natural outdoor head-and-shoulders portrait of {PERSON}, soft warm golden-hour light, softly blurred green pine forest background, genuine relaxed smile, looking at the camera, cinematic editorial portrait photography, 85mm lens, shallow depth of field, natural skin texture, muted earthy color palette, subtle film grain, square 1:1
```
| File | `{PERSON}` | Alt |
|---|---|---|
| `avatar-rina.webp` | a 21 year old Indonesian female university student wearing a sage green hijab and a light hiking jacket | Foto Rina, penyewa dari Tembalang |
| `avatar-dimas.webp` | a 25 year old Indonesian young man with short black hair wearing a charcoal fleece jacket | Foto Dimas, penyewa dari Banyumanik |
| `avatar-sinta.webp` | a 23 year old Indonesian young woman with shoulder-length hair wearing an olive outdoor shirt | Foto Sinta, penyewa dari Gunungpati |

### C4. Lain-lain

#### hero-home-mobile.jpg → `hero-home-mobile.webp`
- **Pemakaian:** Hero Beranda di layar < 768px, hanya jika hasil crop `hero-home` kurang bagus
- **Rasio & resolusi:** 4:5, 1080×1350
- **Prompt:** prompt `hero-home` dengan perubahan: `vertical portrait composition, hiker centered in the lower half, open dark teal sky in the upper half for headline text, portrait 4:5`
- **Negative:** NEG-L
- **Alt:** sama dengan `hero-home`

#### hero-akun.jpg → `hero-akun.webp`
- **Pemakaian:** banner tipis di Keranjang, Checkout, dan Akun Saya. Fallback: blok ink dengan pola kontur topografi.
- **Rasio & resolusi:** 12:5, 1920×800
- **Prompt:**
```
Dark moody close-up detail of camping gear at night: the textured olive green fabric of a tent, a coiled guy rope and a warmly glowing lantern on the right side of the frame, most of the frame deep teal shadow with soft bokeh, minimal calm mood, cinematic editorial photography, shallow depth of field, warm sand-gold glow, muted earthy palette, subtle film grain, wide panoramic composition
```
- **Negative:** NEG-L
- **Alt:** (dekoratif, alt kosong)

#### about-basecamp.jpg → `about-basecamp.webp`
- **Pemakaian:** Tentang Kami, section 5 (Angka pencapaian) atau galeri kecil
- **Rasio & resolusi:** 3:2, 1500×1000
- **Prompt:**
```
Wide interior of a tidy outdoor gear rental basecamp shop, wooden shelves and racks neatly stocked with folded tents, hanging trekking backpacks in olive and charcoal colors, rolled sleeping bags, cooking sets and headlamps, a wooden service counter, warm tungsten lights and soft window light, no people, inviting and well organized, cinematic editorial interior photography, deep teal shadows and warm sand-gold highlights, muted earthy palette, subtle film grain, highly detailed
```
- **Negative:** NEG-L, tambahkan `signage, readable labels, price tags`
- **Alt:** Interior basecamp BAGUS dengan rak tenda, carrier, dan sleeping bag yang tertata rapi

#### kontak-basecamp.jpg → `kontak-basecamp.webp`
- **Pemakaian:** Kontak, di atas kartu info atau di samping peta
- **Rasio & resolusi:** 3:2, 1500×1000
- **Prompt:**
```
Exterior of a small cozy outdoor gear rental shop on a quiet Indonesian residential street at dusk, a modest one-storey building with a wooden facade, large glass window showing shelves of tents and backpacks lit warmly inside, a few potted plants, a parked motorbike, no readable signage, welcoming mood, cinematic editorial architectural photography, deep teal twilight sky and warm sand-gold interior glow, muted earthy palette, subtle film grain, highly detailed
```
- **Negative:** NEG-L, tambahkan `signage, readable labels, license plate text`
- **Alt:** Tampak depan basecamp BAGUS di Tembalang saat senja

#### bg-404.jpg → `bg-404.webp`
- **Pemakaian:** halaman 404 ("Sepertinya kamu tersesat...")
- **Rasio & resolusi:** 16:9, 1920×1080
- **Prompt:**
```
A foggy forked hiking trail in a dense misty pine forest, the path splitting into two directions and fading into thick fog, no people, mysterious but calm mood, cinematic editorial outdoor photography, deep teal-blue shadows with a faint warm sand-gold glow, muted earthy palette of pine green, slate teal and cream, heavy atmospheric haze, subtle film grain, tropical Central Java Indonesia, highly detailed
```
- **Negative:** NEG-L
- **Alt:** (dekoratif, alt kosong)

#### Foto galeri produk tambahan: `{sku}-2.webp`
- **Pemakaian:** galeri Detail Produk (foto ke-2)
- **Rasio & resolusi:** 1:1, 800×800
- **Prompt:** prompt produk yang sama, tapi ganti bagian sudut kamera `three-quarter front view from 30 degrees above eye level` menjadi `close-up detail shot of {detail}`. Contoh `{detail}`: tenda → `the mesh door and zipper`, carrier → `the padded back panel and hip belt`, sleeping bag → `the fleece lining and zipper`.
- **Negative:** NEG-P
- **Alt:** `Detail {nama produk}`

---

## D. Logo & ikon (tidak memakai AI)
Logo BAGUS (SVG garis gunung dan wordmark, seperti referensi), favicon, dan ikon UI (Lucide, lisensi ISC) saya buat sebagai SVG di child theme. Kamu tidak perlu men-generate-nya.

## E. Checklist
| Prioritas | Jumlah | File |
|---|---|---|
| Wajib | 7 | hero-home, hero-katalog, hero-paket, hero-cara-sewa, hero-tips, hero-tentang, hero-kontak |
| Wajib | 15 | tnd-02, tnd-04, fly-01, crr-45, crr-60, slb-01, mtr-01, kmp-01, nst-01, hdl-01, trk-01, jkt-01, pkt-solo, pkt-duo, pkt-fam |
| Wajib | 2 | banner-paket-duo, cta-bg |
| Wajib | 4 | dest-ungaran, dest-andong, dest-prau, dest-merbabu |
| Wajib | 3 | blog-ungaran-mawar, blog-checklist-alat, blog-andong-sunrise |
| Wajib | 1 | about-story |
| Wajib | 1 | og-image |
| Opsional | 3 | step-01-pilih, step-02-checkout, step-03-jelajah |
| Opsional | 6 | cat-tenda, cat-tas-carrier, cat-perlengkapan-tidur, cat-alat-masak, cat-aksesoris, cat-paket |
| Opsional | 3 | avatar-rina, avatar-dimas, avatar-sinta |
| Opsional | 5 + n | hero-home-mobile, hero-akun, about-basecamp, kontak-basecamp, bg-404, {sku}-2 |
