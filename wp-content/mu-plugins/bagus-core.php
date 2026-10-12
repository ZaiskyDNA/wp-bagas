<?php
/**
 * Plugin Name: BAGUS Core
 * Description: Logika bisnis BAGUS — field sewa di checkout, tombol WhatsApp, format harga "Mulai Rp X / hari", meta pesanan di admin/email/akun.
 * Version:     1.0.0
 * Author:      BAGUS
 *
 * Catatan arsitektur: hanya LOGIKA bisnis di sini. Styling ada di child theme
 * (assets/css/*). Nomor WA didefinisikan sekali di sini sebagai satu-satunya
 * sumber kebenaran; scripts/php/setup-ctc.php & footer widgets membacanya.
 *
 * @package bagus-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Satu-satunya sumber nomor WA CS. GANTI dengan nomor asli sebelum demo.
define( 'BAGUS_WA_NUMBER', '6285777598395' );

// Key meta pesanan (dengan prefix underscore = tersembunyi dari UI meta box standar).
const BAGUS_META_TANGGAL = '_bagus_tanggal_mulai';
const BAGUS_META_TUJUAN  = '_bagus_tujuan';

/**
 * Bangun link wa.me dengan pesan ter-URL-encode.
 *
 * @param string $message Pesan prefilled.
 * @return string
 */
function bagus_wa_link( $message ) {
	return 'https://wa.me/' . BAGUS_WA_NUMBER . '?text=' . rawurlencode( $message );
}

/**
 * Tanggal paling awal yang boleh dipilih (besok, zona waktu situs).
 *
 * @return string Format Y-m-d.
 */
function bagus_min_rental_date() {
	return wp_date( 'Y-m-d', strtotime( '+1 day' ) );
}

/*
 * =============================================================================
 * 1. Field tambahan di checkout: Tanggal Mulai Sewa (wajib) + Tujuan (opsional).
 *    Juga merampingkan field bawaan agar form pendek (PRD F-04).
 * =============================================================================
 */
add_filter(
	'woocommerce_checkout_fields',
	function ( $fields ) {
		$fields['order']['bagus_tanggal_mulai'] = array(
			'type'              => 'date',
			'label'             => 'Tanggal Mulai Sewa',
			'required'          => true,
			'priority'          => 5,
			'class'             => array( 'form-row-wide' ),
			'custom_attributes' => array( 'min' => bagus_min_rental_date() ),
		);
		$fields['order']['bagus_tujuan'] = array(
			'type'        => 'text',
			'label'       => 'Tujuan Pendakian/Camping',
			'required'    => false,
			'priority'    => 6,
			'class'       => array( 'form-row-wide' ),
			'placeholder' => 'Contoh: Gunung Ungaran via Mawar',
		);

		// Rampingkan field billing.
		unset( $fields['billing']['billing_company'] );
		if ( isset( $fields['billing']['billing_address_2'] ) ) {
			$fields['billing']['billing_address_2']['required'] = false;
		}
		if ( isset( $fields['billing']['billing_postcode'] ) ) {
			$fields['billing']['billing_postcode']['required'] = false;
		}
		if ( isset( $fields['billing']['billing_state'] ) ) {
			$fields['billing']['billing_state']['required'] = false;
		}

		return $fields;
	}
);

/*
 * =============================================================================
 * 2. Validasi: tanggal mulai sewa minimal besok (PRD F-04 AC3).
 * =============================================================================
 */
add_action(
	'woocommerce_checkout_process',
	function () {
		// Nonce checkout sudah diverifikasi WooCommerce sebelum hook ini berjalan.
		$tgl = isset( $_POST['bagus_tanggal_mulai'] ) ? sanitize_text_field( wp_unslash( $_POST['bagus_tanggal_mulai'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing

		if ( '' === $tgl ) {
			wc_add_notice( 'Mohon isi Tanggal Mulai Sewa.', 'error' );
			return;
		}
		if ( $tgl < bagus_min_rental_date() ) {
			wc_add_notice( 'Tanggal mulai sewa paling cepat besok.', 'error' );
		}
	}
);

/*
 * =============================================================================
 * 3. Simpan field ke order (kompatibel HPOS lewat $order->update_meta_data).
 * =============================================================================
 */
add_action(
	'woocommerce_checkout_create_order',
	function ( $order, $data ) {
		$map = array(
			'bagus_tanggal_mulai' => BAGUS_META_TANGGAL,
			'bagus_tujuan'        => BAGUS_META_TUJUAN,
		);
		foreach ( $map as $post_key => $meta_key ) {
			if ( ! empty( $data[ $post_key ] ) ) {
				$order->update_meta_data( $meta_key, sanitize_text_field( $data[ $post_key ] ) );
			}
		}
	},
	10,
	2
);

/*
 * =============================================================================
 * 4. Tampilkan meta sewa di detail pesanan admin.
 * =============================================================================
 */
add_action(
	'woocommerce_admin_order_data_after_billing_address',
	function ( $order ) {
		$tgl    = $order->get_meta( BAGUS_META_TANGGAL );
		$tujuan = $order->get_meta( BAGUS_META_TUJUAN );
		if ( $tgl ) {
			echo '<p><strong>' . esc_html__( 'Tanggal Mulai Sewa', 'bagus-child' ) . ':</strong> ' . esc_html( $tgl ) . '</p>';
		}
		if ( $tujuan ) {
			echo '<p><strong>' . esc_html__( 'Tujuan', 'bagus-child' ) . ':</strong> ' . esc_html( $tujuan ) . '</p>';
		}
	}
);

/*
 * =============================================================================
 * 5. Tampilkan meta sewa di detail pesanan pelanggan (akun & thank-you).
 * =============================================================================
 */
add_action(
	'woocommerce_order_details_after_order_table',
	function ( $order ) {
		$tgl    = $order->get_meta( BAGUS_META_TANGGAL );
		$tujuan = $order->get_meta( BAGUS_META_TUJUAN );
		if ( ! $tgl && ! $tujuan ) {
			return;
		}
		echo '<section class="bagus-rental-meta"><h2>' . esc_html__( 'Detail Sewa', 'bagus-child' ) . '</h2><ul>';
		if ( $tgl ) {
			echo '<li><strong>' . esc_html__( 'Tanggal Mulai Sewa', 'bagus-child' ) . ':</strong> ' . esc_html( $tgl ) . '</li>';
		}
		if ( $tujuan ) {
			echo '<li><strong>' . esc_html__( 'Tujuan', 'bagus-child' ) . ':</strong> ' . esc_html( $tujuan ) . '</li>';
		}
		echo '</ul></section>';
	}
);

/*
 * =============================================================================
 * 6. Tampilkan meta sewa di email pesanan.
 * =============================================================================
 */
add_filter(
	'woocommerce_email_order_meta_fields',
	function ( $fields, $sent_to_admin, $order ) {
		$tgl    = $order->get_meta( BAGUS_META_TANGGAL );
		$tujuan = $order->get_meta( BAGUS_META_TUJUAN );
		if ( $tgl ) {
			$fields['bagus_tanggal_mulai'] = array(
				'label' => __( 'Tanggal Mulai Sewa', 'bagus-child' ),
				'value' => $tgl,
			);
		}
		if ( $tujuan ) {
			$fields['bagus_tujuan'] = array(
				'label' => __( 'Tujuan', 'bagus-child' ),
				'value' => $tujuan,
			);
		}
		return $fields;
	},
	10,
	3
);

/*
 * =============================================================================
 * 7. Halaman Pesanan Diterima: tombol konfirmasi WA (PRD F-03).
 * =============================================================================
 */
add_action(
	'woocommerce_thankyou',
	function ( $order_id ) {
		$order = wc_get_order( $order_id );
		if ( ! $order ) {
			return;
		}
		$total = html_entity_decode( wp_strip_all_tags( wc_price( $order->get_total() ) ) );
		$tgl   = $order->get_meta( BAGUS_META_TANGGAL );
		$msg   = sprintf(
			'Halo BAGUS, saya ingin konfirmasi pesanan #%s atas nama %s. Total: %s. Tanggal mulai sewa: %s.',
			$order->get_order_number(),
			$order->get_formatted_billing_full_name(),
			$total,
			$tgl ? $tgl : '-'
		);
		echo '<div class="bagus-wa-confirm">';
		echo '<p>' . esc_html__( 'Pesananmu sudah kami terima! Konfirmasi ke CS agar alat segera disiapkan.', 'bagus-child' ) . '</p>';
		printf(
			'<a class="button bagus-btn-wa" href="%s" target="_blank" rel="noopener" aria-label="%s">%s</a>',
			esc_url( bagus_wa_link( $msg ) ),
			esc_attr__( 'Konfirmasi pesanan via WhatsApp', 'bagus-child' ),
			esc_html__( 'Konfirmasi via WhatsApp', 'bagus-child' )
		);
		echo '</div>';
	},
	5
);

/*
 * =============================================================================
 * 8. Tombol "Tanya Stok via WA" di detail produk (PRD F-03).
 * =============================================================================
 */
add_action(
	'woocommerce_single_product_summary',
	function () {
		global $product;
		if ( ! $product ) {
			return;
		}
		$msg = sprintf( 'Halo BAGUS, apakah %s tersedia untuk tanggal ...?', $product->get_name() );
		printf(
			'<a class="button bagus-btn-wa bagus-btn-wa--outline" href="%s" target="_blank" rel="noopener" aria-label="%s">%s</a>',
			esc_url( bagus_wa_link( $msg ) ),
			esc_attr__( 'Tanya stok via WhatsApp', 'bagus-child' ),
			esc_html__( 'Tanya Stok via WA', 'bagus-child' )
		);
	},
	35
);

/*
 * =============================================================================
 * 9. Harga produk variable: "Mulai Rp X / hari" (PRD F-05 AC3).
 * =============================================================================
 */
add_filter(
	'woocommerce_variable_price_html',
	function ( $price, $product ) {
		$min = $product->get_variation_price( 'min', true );
		return 'Mulai ' . wc_price( $min ) . ' <span class="bagus-per-day">/ hari</span>';
	},
	10,
	2
);

// Harga di kartu katalog memakai variasi termurah juga (sudah ditangani filter di atas
// untuk variable price html; filter ini menjaga konsistensi bila tema memanggil get_price_html).

/*
 * =============================================================================
 * 10. Aksesibilitas tombol WA melayang (Click to Chat) — PRD F-03 AC4.
 *     Plugin tidak selalu memberi aria-label; kita set dari footer.
 * =============================================================================
 */
add_action(
	'wp_footer',
	function () {
		?>
<script>
(function () {
	function labelCTC() {
		var sel = ['.ht-ctc-chat', '.ht_ctc_chat_style a', 'a.ht-ctc', '#ht-ctc-chat'];
		var done = false;
		sel.forEach(function (s) {
			document.querySelectorAll(s).forEach(function (el) {
				if (el.tagName === 'A' || el.getAttribute('role') === 'button') {
					el.setAttribute('aria-label', 'Chat WhatsApp CS BAGUS');
					done = true;
				}
			});
		});
		return done;
	}
	if (!labelCTC()) {
		document.addEventListener('DOMContentLoaded', labelCTC);
		window.setTimeout(labelCTC, 1500);
	}
})();
</script>
		<?php
	},
	99
);
