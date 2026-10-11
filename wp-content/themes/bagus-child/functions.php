<?php
/**
 * BAGUS Child — functions.
 * Hanya urusan tampilan (enqueue, dukungan tema). Logika bisnis ada di mu-plugins/bagus-core.php.
 *
 * @package bagus-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BAGUS_CHILD_VERSION', '0.1.0' );

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style(
			'bagus-child',
			get_stylesheet_uri(),
			array( 'kadence-global' ),
			BAGUS_CHILD_VERSION
		);
	},
	20
);
