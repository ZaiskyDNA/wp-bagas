#!/usr/bin/env bash
# =============================================================================
# BAGUS — instalasi & konfigurasi WordPress via WP-CLI (idempoten).
#
# Pakai dari host (root repo):   ./scripts/setup.sh
# Script akan menjalankan dirinya sendiri di dalam container `wpcli`.
# Aman dijalankan berulang kali: setiap langkah mengecek kondisi dulu.
# =============================================================================
set -euo pipefail

# --- 1. Re-exec ke dalam container wpcli jika dijalankan dari host -----------
if [[ "${BAGUS_IN_CONTAINER:-}" != "1" ]]; then
  ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
  cd "$ROOT"
  if [[ ! -f .env ]]; then
    echo "✗ File .env belum ada. Jalankan: cp .env.example .env lalu isi nilainya." >&2
    exit 1
  fi
  docker compose up -d db wordpress
  exec docker compose run --rm -T -e BAGUS_IN_CONTAINER=1 wpcli bash /scripts/setup.sh "$@"
fi

cd /var/www/html
PHP_DIR=/scripts/php
log() { printf '\n\033[1;32m==>\033[0m %s\n' "$*"; }

# Tunggu file core WordPress disalin oleh container apache.
for _ in $(seq 1 60); do
  [[ -f wp-includes/version.php && -f wp-config.php ]] && break
  sleep 2
done
[[ -f wp-config.php ]] || { echo "✗ wp-config.php tidak ditemukan." >&2; exit 1; }

# --- 2. Core install ----------------------------------------------------------
WP_URL="${WP_URL:-http://localhost:8088}"
if wp core is-installed 2>/dev/null; then
  log "WordPress sudah terpasang, lewati core install"
else
  : "${WP_ADMIN_USER:?WP_ADMIN_USER belum diisi di .env}"
  : "${WP_ADMIN_PASSWORD:?WP_ADMIN_PASSWORD belum diisi di .env}"
  : "${WP_ADMIN_EMAIL:?WP_ADMIN_EMAIL belum diisi di .env}"
  if [[ "$WP_ADMIN_PASSWORD" == "ganti_dengan_password_kuat" ]]; then
    echo "✗ Ganti WP_ADMIN_PASSWORD di .env dengan password kamu sendiri." >&2
    exit 1
  fi
  log "Instal WordPress"
  wp core install --url="$WP_URL" --title="BAGUS" \
    --admin_user="$WP_ADMIN_USER" --admin_password="$WP_ADMIN_PASSWORD" \
    --admin_email="$WP_ADMIN_EMAIL" --skip-email
fi

# Selalu pakai WordPress terbaru (WooCommerce terbaru mensyaratkan versi core terbaru).
log "Update core WordPress (saat ini $(wp core version))"
wp core update
wp core update-db
wp language core update >/dev/null 2>&1 || true

# --- 3. Bahasa, zona waktu, format -------------------------------------------
log "Bahasa Indonesia & pengaturan umum"
wp language core is-installed id_ID || wp language core install id_ID
wp site switch-language id_ID
wp option update blogname "BAGUS"
wp option update blogdescription "Mendaki Jadi Lebih BAGUS."
wp option update timezone_string "Asia/Jakarta"
wp option update date_format "j F Y"
wp option update time_format "H.i"
wp option update start_of_week 1
wp option update default_comment_status closed
wp option update default_ping_status closed
# .htaccess sudah disediakan image wordpress:apache (rule standar WP), jadi tanpa --hard.
wp rewrite structure '/%postname%/'

# --- 4. Tema ------------------------------------------------------------------
log "Tema Kadence + child theme bagus-child"
wp theme is-installed kadence || wp theme install kadence
[[ "$(wp option get stylesheet)" == "bagus-child" ]] || wp theme activate bagus-child
for t in $(wp theme list --field=name --status=inactive); do
  [[ "$t" == "kadence" ]] || wp theme delete "$t"
done

# --- 5. Plugin ----------------------------------------------------------------
log "Plugin (gratis, sesuai PRD Bagian 9)"
PLUGINS=(woocommerce kadence-blocks click-to-chat-for-whatsapp contact-form-7 flamingo
         limit-login-attempts-reloaded all-in-one-wp-migration)
for p in "${PLUGINS[@]}"; do
  wp plugin is-installed "$p" || wp plugin install "$p"
  wp plugin is-active "$p" || wp plugin activate "$p"
done
for p in hello akismet; do
  if wp plugin is-installed "$p"; then wp plugin delete "$p"; fi
done
wp language plugin install --all id_ID >/dev/null 2>&1 || true
wp language theme install --all id_ID >/dev/null 2>&1 || true

# --- 6. WooCommerce: toko, mata uang, akun -----------------------------------
log "WooCommerce: toko & mata uang"
wp option update woocommerce_store_address "Jl. Banjarsari Raya No. 17, Tembalang"
wp option update woocommerce_store_address_2 ""
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
wp option update woocommerce_ship_to_countries ""
wp option update woocommerce_calc_taxes "no"
wp option update woocommerce_weight_unit "kg"
wp option update woocommerce_dimension_unit "cm"
wp option update woocommerce_manage_stock "yes"
wp option update woocommerce_default_customer_address "base"

log "WooCommerce: akun (F-02)"
wp option update woocommerce_enable_guest_checkout "no"
wp option update woocommerce_enable_checkout_login_reminder "yes"
wp option update woocommerce_enable_signup_and_login_from_checkout "yes"
wp option update woocommerce_enable_myaccount_registration "yes"
wp option update woocommerce_registration_generate_username "yes"
wp option update woocommerce_registration_generate_password "no"

log "WooCommerce: matikan wizard, coming soon, tracking, saran marketplace"
# Opsi non-kritis: beberapa difilter oleh WooCommerce Admin, jadi kegagalan diabaikan.
soft() { wp option update "$@" >/dev/null 2>&1 || echo "  (lewati $1)"; }
soft woocommerce_coming_soon "no"
soft woocommerce_store_pages_only "no"
soft woocommerce_onboarding_profile '{"skipped":true}' --format=json
soft woocommerce_task_list_hidden "yes"
soft woocommerce_extended_task_list_hidden "yes"
soft woocommerce_show_marketplace_suggestions "no"
soft woocommerce_allow_tracking "no"
soft woocommerce_analytics_enabled "no"

# --- 7. Halaman, front page, permalink produk --------------------------------
log "Halaman inti, halaman WooCommerce (shortcode klasik), front page"
wp eval-file "$PHP_DIR/setup-pages.php"

# --- 8. Pengiriman & pembayaran ----------------------------------------------
log "Shipping zone Indonesia + metode bayar BACS & COD"
wp eval-file "$PHP_DIR/setup-commerce.php"

# --- 9. Menu ------------------------------------------------------------------
log "Menu Utama & Menu Footer"
wp eval-file "$PHP_DIR/setup-menus.php"

# --- 10. Click to Chat --------------------------------------------------------
log "Click to Chat (nomor dari konstanta BAGUS_WA_NUMBER)"
wp eval-file "$PHP_DIR/setup-ctc.php"

# --- 11. Selesai --------------------------------------------------------------
wp rewrite flush
wp cache flush >/dev/null
log "Selesai ✓  Buka $WP_URL  (admin: $WP_URL/wp-admin)"
