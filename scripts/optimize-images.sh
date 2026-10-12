#!/usr/bin/env bash
# =============================================================================
# BAGUS — optimasi gambar (idempoten).
#
#   ./scripts/optimize-images.sh          # proses yang berubah saja
#   ./scripts/optimize-images.sh --force  # proses ulang semua
#
# Sumber : content/images/<nama>.{png,jpg,jpeg,webp}   (asli dari AI generator, tidak diubah)
# Hasil  : content/images/optimized/<nama>.webp        (og-image → .jpg)
#
# Aturan:
#   - Crop ke rasio target dengan "gravity" per gambar, lalu resize ke resolusi final.
#   - Produk ("product"): latar studio diperluas jadi 1:1 berdasarkan bounding box produk,
#     sehingga produk tidak terpotong dan posisinya seragam.
#   - Kualitas WebP diturunkan bertahap (84 → 60) sampai file ≤ 200 KB.
#   - Gambar Wajib yang belum ada → placeholder SVG dengan nama yang sama.
#
# Butuh: ImageMagick 6/7 dengan dukungan WebP.
# =============================================================================
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
SRC="$ROOT/content/images"
OUT="$SRC/optimized"
MAX_BYTES=$((200 * 1024))
FORCE="${1:-}"
mkdir -p "$OUT"

if command -v magick >/dev/null 2>&1; then IM=(magick); else IM=(convert); fi
"${IM[@]}" -list format | grep -qi 'WEBP.*rw' || { echo "✗ ImageMagick tanpa dukungan WebP" >&2; exit 1; }

# nama | jenis | lebar | tinggi | prioritas | gravity (crop)
# jenis: photo = crop ke rasio, product = perluas latar ke 1:1, og = JPG 1200x630
SPEC=$(cat <<'EOF'
hero-home|photo|1920|1080|wajib|center
hero-katalog|photo|1920|800|wajib|center
hero-paket|photo|1920|800|wajib|center
hero-cara-sewa|photo|1920|800|wajib|center
hero-tips|photo|1920|800|wajib|center
hero-tentang|photo|1920|800|wajib|center
hero-kontak|photo|1920|800|wajib|center
tnd-02|product|800|800|wajib|center
tnd-04|product|800|800|wajib|center
fly-01|product|800|800|wajib|center
crr-45|product|800|800|wajib|center
crr-60|product|800|800|wajib|center
slb-01|product|800|800|wajib|center
mtr-01|product|800|800|wajib|center
kmp-01|product|800|800|wajib|center
nst-01|product|800|800|wajib|center
hdl-01|product|800|800|wajib|center
trk-01|product|800|800|wajib|center
jkt-01|product|800|800|wajib|center
pkt-solo|product|800|800|wajib|center
pkt-duo|product|800|800|wajib|center
pkt-fam|product|800|800|wajib|center
banner-paket-duo|photo|1080|1350|wajib|south
cta-bg|photo|1920|800|wajib|center
dest-ungaran|photo|1080|1350|wajib|south
dest-andong|photo|1080|1350|wajib|south
dest-prau|photo|1080|1350|wajib|south
dest-merbabu|photo|1080|1350|wajib|south
blog-ungaran-mawar|photo|1200|675|wajib|center
blog-checklist-alat|photo|1200|675|wajib|center
blog-andong-sunrise|photo|1200|675|wajib|center
about-story|photo|1080|1350|wajib|north
og-image|og|1200|630|wajib|center
step-01-pilih|photo|1200|900|opsional|center
step-02-checkout|photo|1200|900|opsional|center
step-03-jelajah|photo|1200|900|opsional|center
hero-home-mobile|photo|1080|1350|opsional|center
hero-akun|photo|1920|800|opsional|center
about-basecamp|photo|1500|1000|opsional|center
kontak-basecamp|photo|1500|1000|opsional|center
bg-404|photo|1920|1080|opsional|center
avatar-rina|photo|400|400|opsional|north
avatar-dimas|photo|400|400|opsional|north
avatar-sinta|photo|400|400|opsional|north
cat-tenda|photo|800|800|opsional|center
cat-tas-carrier|photo|800|800|opsional|center
cat-perlengkapan-tidur|photo|800|800|opsional|center
cat-alat-masak|photo|800|800|opsional|center
cat-aksesoris|photo|800|800|opsional|center
cat-paket|photo|800|800|opsional|center
EOF
)

find_src() {
  local n="$1" e
  for e in png jpg jpeg webp PNG JPG JPEG WEBP; do
    [[ -f "$SRC/$n.$e" ]] && { echo "$SRC/$n.$e"; return; }
  done
}

# Tulis WebP dengan kualitas menurun sampai ≤ MAX_BYTES. Argumen: <out> <opsi IM...>
write_webp() {
  local out="$1"; shift
  local q
  for q in 84 80 76 72 68 64 60; do
    "${IM[@]}" "$@" -strip -define webp:method=6 -quality "$q" "$out"
    (( $(stat -c %s "$out") <= MAX_BYTES )) && { echo "$q"; return; }
  done
  echo "$q (>200KB)"
}

placeholder_svg() {
  local n="$1" w="$2" h="$3"
  cat > "$OUT/$n.svg" <<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="$w" height="$h" viewBox="0 0 $w $h" role="img" aria-label="Placeholder $n">
  <rect width="100%" height="100%" fill="#0F1D22"/>
  <path d="M0 $((h*3/4)) L$((w/4)) $((h/2)) L$((w/2)) $((h*2/3)) L$((w*3/4)) $((h*2/5)) L$w $((h*3/5)) V$h H0Z" fill="#24483E"/>
  <text x="50%" y="50%" fill="#D8B573" font-family="sans-serif" font-size="$((w/24))" text-anchor="middle">$n ($w×$h)</text>
</svg>
SVG
}

printf '%-22s %-9s %-11s %-11s %-8s %s\n' NAMA JENIS SUMBER HASIL KB Q
missing=()
while IFS='|' read -r name kind W H prio grav; do
  src="$(find_src "$name" || true)"
  ext=webp; [[ "$kind" == og ]] && ext=jpg
  out="$OUT/$name.$ext"

  if [[ -z "$src" ]]; then
    if [[ "$prio" == wajib ]]; then
      placeholder_svg "$name" "$W" "$H"; missing+=("$name")
      printf '%-22s %-9s %-11s %-11s %-8s %s\n' "$name" "$kind" "-" "placeholder" "-" "svg"
    fi
    continue
  fi
  rm -f "$OUT/$name.svg" # gambar asli sudah ada → buang placeholder lama

  # Idempoten: lewati jika hasil lebih baru dari sumber & script.
  if [[ -z "$FORCE" && -f "$out" && "$out" -nt "$src" && "$out" -nt "${BASH_SOURCE[0]}" ]]; then
    continue
  fi

  read -r sw sh < <("${IM[@]}" "$src" -format '%w %h\n' info:)

  case "$kind" in
    product)
      # Bounding box produk (latar krem polos) → kotak 1:1 dengan margin 9% di tiap sisi.
      read -r bw bh bx by < <("${IM[@]}" "$src" -fuzz 7% -trim -format '%w %h %X %Y\n' info: | tr -d '+')
      side=$(( (bw > bh ? bw : bh) * 118 / 100 ))
      cx=$(( bx + bw / 2 )); cy=$(( by + bh / 2 ))
      x0=$(( cx - side / 2 )); y0=$(( cy - side / 2 ))
      # Area di luar gambar: versi blur kuat dari perpanjangan tepi (gradasi lembut, tanpa
      # garis), lalu foto asli ditumpuk dengan tepi di-feather supaya sambungannya tak terlihat.
      vp="${side}x${side}+${x0}+${y0}"
      q=$(write_webp "$out" \
            \( "$src" -virtual-pixel Edge -set option:distort:viewport "$vp" -distort SRT 0 +repage -blur 0x48 \) \
            \( "$src" -alpha set -virtual-pixel Transparent -set option:distort:viewport "$vp" -distort SRT 0 +repage \
               -channel A -blur 0x14 -level 50%,100% +channel \) \
            -compose over -composite \
            -filter Lanczos -resize "${W}x${H}!" -unsharp 0x0.6+0.5+0.02)
      ;;
    photo|og)
      # Crop rasio target sebesar mungkin, lalu resize (upscale bila sumber lebih kecil).
      if (( sw * H > sh * W )); then cw=$(( sh * W / H )); ch=$sh; else cw=$sw; ch=$(( sw * H / W )); fi
      args=("$src" -gravity "$grav" -crop "${cw}x${ch}+0+0" +repage -filter Lanczos -resize "${W}x${H}!")
      (( W > cw )) && args+=(-unsharp 0x0.8+0.6+0.02) # pertajam ringan saat upscale
      if [[ "$kind" == og ]]; then
        "${IM[@]}" "${args[@]}" -strip -interlace Plane -sampling-factor 4:2:0 -quality 82 "$out"; q=82
      else
        q=$(write_webp "$out" "${args[@]}")
      fi
      ;;
  esac
  printf '%-22s %-9s %-11s %-11s %-8s %s\n' "$name" "$kind" "${sw}x${sh}" "${W}x${H}" "$(( $(stat -c %s "$out") / 1024 ))" "$q"
done <<< "$SPEC"

echo
if ((${#missing[@]})); then
  echo "⚠ Gambar Wajib belum ada (placeholder SVG dibuat): ${missing[*]}"
else
  echo "✓ Semua gambar Wajib tersedia."
fi
