<?php
/**
 * Konfigurasi form Contact Form 7 BAGUS (idempoten).
 * Form: Nama, Email, No. WA, Pesan (PRD F-08). Pesan tersimpan via Flamingo.
 * Dijalankan via: wp eval-file setup-contact-form.php
 *
 * @package bagus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
	WP_CLI::warning( 'Contact Form 7 tidak aktif — dilewati.' );
	return;
}

// Ambil form pertama (default "Contact form 1") atau buat baru.
$existing = get_posts(
	array(
		'post_type'   => 'wpcf7_contact_form',
		'numberposts' => 1,
		'orderby'     => 'ID',
		'order'       => 'ASC',
		'fields'      => 'ids',
	)
);
$form = ! empty( $existing ) ? wpcf7_contact_form( (int) $existing[0] ) : WPCF7_ContactForm::get_template();

$form->set_title( 'Form Kontak BAGUS' );

$body = <<<'FORM'
<div class="bagus-cf7">
<p class="cf7-row">
  <label>Nama Lengkap<br>
  [text* nama placeholder "Nama kamu"] </label>
</p>
<div class="cf7-two">
<p class="cf7-row">
  <label>Email<br>
  [email* email placeholder "nama@email.com"] </label>
</p>
<p class="cf7-row">
  <label>No. WhatsApp<br>
  [tel* no-wa placeholder "08xx xxxx xxxx"] </label>
</p>
</div>
<p class="cf7-row">
  <label>Pesan<br>
  [textarea* pesan placeholder "Tulis pertanyaan atau kebutuhanmu di sini..."] </label>
</p>
<p>[submit "Kirim Pesan"]</p>
</div>
FORM;

$mail = array(
	'subject'            => '[BAGUS] Pesan baru dari [nama]',
	'sender'             => 'BAGUS <wordpress@bagus-outdoor.id>',
	'recipient'          => 'halo@bagus-outdoor.id',
	'additional_headers' => "Reply-To: [email]",
	'body'               => "Pesan dari form kontak situs BAGUS:\n\nNama: [nama]\nEmail: [email]\nNo. WA: [no-wa]\n\nPesan:\n[pesan]\n\n-- \nDikirim dari form kontak bagus-outdoor.id",
	'attachments'        => '',
	'use_html'           => 0,
	'exclude_blank'      => 0,
);

$messages = array();
foreach ( wpcf7_messages() as $key => $arr ) {
	$messages[ $key ] = isset( $arr['default'] ) ? $arr['default'] : '';
}
$messages['mail_sent_ok'] = 'Terima kasih! Pesanmu sudah terkirim. Tim kami akan membalas secepatnya.';
$messages['mail_sent_ng'] = 'Maaf, pesan gagal terkirim. Silakan hubungi kami langsung via WhatsApp.';
$messages['validation_required'] = 'Kolom ini wajib diisi.';
$messages['invalid_email']       = 'Alamat email belum benar.';
$messages['invalid_tel']         = 'Nomor telepon belum benar.';

// Pemetaan field ke Flamingo (judul & kontak yang rapi di Inbound Messages).
$additional = "flamingo_name: \"[nama]\"\nflamingo_email: \"[email]\"\nflamingo_subject: \"Pesan dari [nama] via situs BAGUS\"";

$form->set_properties(
	array(
		'form'                => $body,
		'mail'                => $mail,
		'messages'            => $messages,
		'additional_settings' => $additional,
	)
);
$id = $form->save();

WP_CLI::success( "Form kontak CF7 siap (#{$id})." );
