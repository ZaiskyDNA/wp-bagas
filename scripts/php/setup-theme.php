<?php
/**
 * Kadence theme_mods & palette BAGUS (idempoten).
 * Dijalankan via: wp eval-file setup-theme.php
 *
 * Palet Kadence menggunakan slot 1-9 + slot 10-15 extended.
 * Kadence membaca semua opsi via get_theme_mod() / 'kadence_settings' option.
 *
 * @package bagus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// =========================================================================
// 1. Global Palette (JSON, disimpan di option 'kadence_global_palette')
// =========================================================================
$p = function ( $hex, $slug, $name ) {
	return array( 'color' => $hex, 'slug' => $slug, 'name' => $name );
};
$pal = array(
	$p( '#D8B573', 'palette1', 'Sand (Accent/CTA)' ),       // Aksen utama
	$p( '#E6CB94', 'palette2', 'Sand Light (Hover)' ),       // Hover aksen
	$p( '#0F1D22', 'palette3', 'Ink (Strong headings)' ),    // Judul, header gelap
	$p( '#1B2326', 'palette4', 'Text' ),                     // Teks utama
	$p( '#5E676A', 'palette5', 'Muted' ),                    // Teks sekunder
	$p( '#A9B4B6', 'palette6', 'Subtle' ),                   // Di atas gelap
	$p( '#F1EDE4', 'palette7', 'Cream (Alternate BG)' ),     // Latar selang-seling
	$p( '#FAF8F3', 'palette8', 'Paper (Site BG)' ),          // Latar situs
	$p( '#FFFFFF', 'palette9', 'White (Surface)' ),           // Kartu / form
	$p( '#24483E', 'palette10', 'Pine (Secondary)' ),        // Komplementer
	$p( '#2E7D32', 'palette11', 'Success' ),
	$p( '#24483E', 'palette12', 'Info' ),
	$p( '#B3261E', 'palette13', 'Error' ),
	$p( '#E8833A', 'palette14', 'Warning' ),
	$p( '#D8B573', 'palette15', 'Rating' ),
);
$palette_json = wp_json_encode(
	array(
		'palette'        => $pal,
		'second-palette' => $pal,
		'third-palette'  => $pal,
		'active'         => 'palette',
	)
);
update_option( 'kadence_global_palette', $palette_json );
WP_CLI::log( '  ✓ Kadence palette (15 warna)' );

// =========================================================================
// 2. Theme Mods — semua pengaturan Kadence Customizer
//    Font di Kadence disimpan sebagai theme_mod (array), bukan Google Fonts
//    external. Kita set google => false agar Kadence TIDAK memuat dari CDN.
// =========================================================================
$mods = array(

	// --- Lebar konten ---
	'content_width'        => array( 'size' => 1200, 'unit' => 'px' ),
	'content_narrow_width' => array( 'size' => 842, 'unit' => 'px' ),
	'site_background'      => array( 'desktop' => array( 'color' => 'palette8' ) ),
	'content_background'   => array( 'desktop' => array( 'color' => '' ) ),

	// --- Font ---
	'load_fonts_local'   => true,
	'preload_fonts_local' => true,
	'base_font'          => array(
		'size'       => array( 'desktop' => 17 ),
		'lineHeight' => array( 'desktop' => 1.65 ),
		'family'     => '"Plus Jakarta Sans", system-ui, -apple-system, "Segoe UI", sans-serif',
		'google'     => false,
		'weight'     => '400',
		'variant'    => 'regular',
		'color'      => 'palette4',
	),
	'heading_font'       => array(
		'family' => '"Playfair Display", Georgia, serif',
		'google' => false,
		'weight' => '700',
		'variant' => '700',
		'color'  => 'palette3',
	),
	'h1_font' => array(
		'size'       => array( 'desktop' => 48, 'tablet' => 36, 'mobile' => 32 ),
		'lineHeight' => array( 'desktop' => 1.12 ),
		'family'     => 'inherit',
		'google'     => false,
		'weight'     => '800',
		'variant'    => '800',
		'color'      => 'palette3',
	),
	'h2_font' => array(
		'size'       => array( 'desktop' => 38, 'tablet' => 30, 'mobile' => 26 ),
		'lineHeight' => array( 'desktop' => 1.15 ),
		'family'     => 'inherit',
		'google'     => false,
		'weight'     => '700',
		'variant'    => '700',
		'color'      => 'palette3',
	),
	'h3_font' => array(
		'size'       => array( 'desktop' => 22, 'tablet' => 20, 'mobile' => 20 ),
		'lineHeight' => array( 'desktop' => 1.3 ),
		'family'     => 'inherit',
		'google'     => false,
		'weight'     => '700',
		'variant'    => '700',
		'color'      => 'palette3',
	),
	'h4_font' => array(
		'size'       => array( 'desktop' => 18 ),
		'lineHeight' => array( 'desktop' => 1.4 ),
		'family'     => 'inherit',
		'google'     => false,
		'weight'     => '600',
		'variant'    => '600',
		'color'      => 'palette3',
	),

	// --- Link ---
	'link_color' => array(
		'color'       => 'palette1',
		'hover'       => 'palette2',
		'active'      => 'palette2',
		'style'       => 'no-underline',
		'underline'   => '',
	),

	// --- Tombol global ---
	'buttons_color'          => array( 'color' => 'palette3', 'hover' => 'palette3' ),
	'buttons_background'     => array( 'color' => 'palette1', 'hover' => 'palette2' ),
	'buttons_border_colors'  => array( 'color' => '', 'hover' => '' ),
	'buttons_border'         => array(),
	'buttons_border_radius'  => array(
		'size' => array( 'desktop' => 999, 'tablet' => 999, 'mobile' => 999 ),
		'unit' => array( 'desktop' => 'px', 'tablet' => 'px', 'mobile' => 'px' ),
	),
	'buttons_typography' => array(
		'size'       => array( 'desktop' => 16 ),
		'lineHeight' => array( 'desktop' => '' ),
		'family'     => '"Plus Jakarta Sans", system-ui, sans-serif',
		'google'     => false,
		'weight'     => '600',
		'variant'    => '600',
	),
	'buttons_padding' => array(
		'size'   => array( 'desktop' => array( '14', '28', '14', '28' ) ),
		'unit'   => array( 'desktop' => 'px' ),
		'locked' => array( 'desktop' => false ),
	),
	'buttons_shadow' => array(
		'color' => 'rgba(0,0,0,0)', 'hOffset' => 0, 'vOffset' => 0,
		'blur' => 0, 'spread' => 0, 'inset' => false, 'disabled' => true,
	),

	// --- Breadcrumb ---
	'breadcrumb_engine' => 'default',

	// --- Scroll to top ---
	'scroll_up'         => 'enable',
	'scroll_up_side'    => 'right',
	'scroll_up_icon'    => 'arrow-up',
	'scroll_up_style'   => 'filled',
	'scroll_up_color'   => array( 'color' => 'palette9', 'hover' => 'palette9' ),
	'scroll_up_background' => array( 'color' => 'palette3', 'hover' => 'palette1' ),
	'scroll_up_border_colors' => array( 'color' => '', 'hover' => '' ),
	'scroll_up_radius'  => array(
		'size' => array( 'desktop' => 999, 'tablet' => 999, 'mobile' => 999 ),
		'unit' => array( 'desktop' => 'px', 'tablet' => 'px', 'mobile' => 'px' ),
	),

	// =====================================================================
	// HEADER BUILDER
	// =====================================================================
	'header_desktop_items' => array(
		'top'    => array(
			'top_left' => array(), 'top_left_center' => array(), 'top_center' => array(),
			'top_right_center' => array(), 'top_right' => array(),
		),
		'main'   => array(
			'main_left'         => array( 'logo' ),
			'main_left_center'  => array(),
			'main_center'       => array(),
			'main_right_center' => array( 'navigation' ),
			'main_right'        => array( 'search', 'cart' ),
		),
		'bottom' => array(
			'bottom_left' => array(), 'bottom_left_center' => array(), 'bottom_center' => array(),
			'bottom_right_center' => array(), 'bottom_right' => array(),
		),
	),
	'header_mobile_items' => array(
		'popup' => array( 'popup_content' => array( 'mobile-navigation' ) ),
		'top'   => array( 'top_left' => array(), 'top_center' => array(), 'top_right' => array() ),
		'main'  => array(
			'main_left'   => array( 'mobile-logo' ),
			'main_center' => array(),
			'main_right'  => array( 'cart', 'popup-toggle' ),
		),
		'bottom' => array( 'bottom_left' => array(), 'bottom_center' => array(), 'bottom_right' => array() ),
	),

	// --- Header Main ---
	'header_main_height' => array(
		'size' => array( 'mobile' => 64, 'tablet' => 72, 'desktop' => 72 ),
		'unit' => array( 'mobile' => 'px', 'tablet' => 'px', 'desktop' => 'px' ),
	),
	'header_main_layout' => array( 'mobile' => '', 'tablet' => '', 'desktop' => 'standard' ),
	'header_main_background' => array(
		'desktop' => array( 'color' => 'palette9' ),
	),
	'header_main_bottom_border' => array(
		'desktop' => array( 'width' => 1, 'unit' => 'px', 'style' => 'solid', 'color' => 'palette7' ),
	),

	// --- Logo ---
	'logo_layout' => array(
		'include' => array( 'mobile' => 'logo_title', 'tablet' => 'logo_title', 'desktop' => 'logo_title' ),
		'layout'  => array( 'mobile' => 'standard', 'tablet' => 'standard', 'desktop' => 'standard' ),
	),
	'logo_width' => array(
		'size' => array( 'mobile' => 120, 'tablet' => 140, 'desktop' => 160 ),
		'unit' => array( 'mobile' => 'px', 'tablet' => 'px', 'desktop' => 'px' ),
	),
	'brand_typography' => array(
		'size'   => array( 'desktop' => 22, 'tablet' => 20, 'mobile' => 18 ),
		'family' => '"Playfair Display", Georgia, serif',
		'google' => false,
		'weight' => '700',
		'variant' => '700',
		'color'  => 'palette3',
	),
	'brand_typography_color' => array(
		'color' => 'palette3',
		'hover' => 'palette1',
	),
	'brand_tag_typography' => array(
		'size' => array( 'desktop' => 0 ),
	),

	// --- Transparent header ---
	'transparent_header_enable' => true,
	'transparent_header_page'   => true,
	'transparent_header_post'   => false,
	'transparent_header_archive' => false,
	'transparent_header_product' => false,
	'transparent_header_device' => 'all',
	'transparent_header_background' => array(
		'desktop' => array( 'color' => 'rgba(15, 29, 34, 0)' ),
	),
	'transparent_header_navigation_color' => array(
		'color'  => '#F1EDE4',
		'hover'  => '#D8B573',
		'active' => '#D8B573',
	),
	'transparent_header_site_title_color' => array(
		'color' => '#F1EDE4',
		'hover' => '#D8B573',
	),
	'transparent_header_custom_logo'   => false,
	'transparent_header_custom_mobile_logo' => false,
	'transparent_header_social_color'  => array( 'color' => '#F1EDE4', 'hover' => '#D8B573' ),
	'transparent_header_html_color'    => array( 'color' => '#F1EDE4', 'link' => '#D8B573' ),
	'transparent_header_bottom_border' => array(),

	// --- Sticky header ---
	'header_sticky'         => 'main',
	'header_sticky_shrink'  => false,
	'header_sticky_main_shrink' => 60,
	'mobile_header_sticky'  => 'main',
	'header_sticky_background' => array(
		'desktop' => array( 'color' => '#0F1D22' ),
	),
	'header_sticky_navigation_color' => array(
		'color'  => '#F1EDE4',
		'hover'  => '#D8B573',
		'active' => '#D8B573',
	),
	'header_sticky_site_title_color' => array(
		'color' => '#F1EDE4',
		'hover' => '#D8B573',
	),
	'header_sticky_logo_icon_color'  => array( 'color' => '#F1EDE4' ),
	'header_sticky_custom_logo'      => false,
	'header_sticky_custom_mobile_logo' => false,
	'header_sticky_box_shadow' => array(
		'color' => 'rgba(0,0,0,.18)', 'hOffset' => 0, 'vOffset' => 6,
		'blur' => 24, 'spread' => 0, 'inset' => false,
	),

	// --- Navigation ---
	'primary_navigation_typography' => array(
		'size'       => array( 'desktop' => 15 ),
		'lineHeight' => array( 'desktop' => '' ),
		'family'     => '"Plus Jakarta Sans", system-ui, sans-serif',
		'google'     => false,
		'weight'     => '500',
		'variant'    => '500',
		'transform'  => 'none',
	),
	'primary_navigation_color' => array(
		'color'  => 'palette4',
		'hover'  => 'palette1',
		'active' => 'palette1',
	),
	'dropdown_navigation_reveal' => 'fade-down',

	// --- Header cart ---
	'header_cart_style'       => 'link',
	'header_cart_show_total'  => true,
	'header_cart_icon'        => 'shopping-bag',
	'header_cart_icon_size'   => array(
		'size' => array( 'desktop' => 20 ),
		'unit' => array( 'desktop' => 'px' ),
	),
	'header_cart_color' => array(
		'color' => 'palette4',
		'hover' => 'palette1',
	),
	'header_cart_total_color' => array( 'color' => 'palette9' ),
	'header_cart_total_background' => array( 'color' => 'palette1' ),
	'header_mobile_cart_style' => 'link',
	'header_mobile_cart_show_total' => true,
	'header_mobile_cart_icon' => 'shopping-bag',
	'header_mobile_cart_popup_side' => 'right',

	// --- Header search ---
	'header_search_style' => 'modal',
	'header_search_icon'  => 'search',
	'header_search_woo'   => true,
	'header_search_color' => array(
		'color' => 'palette4',
		'hover' => 'palette1',
	),
	'header_search_modal_background' => array( 'color' => 'rgba(15, 29, 34, 0.96)' ),
	'header_search_modal_color'      => array( 'color' => '#F1EDE4' ),

	// --- Mobile trigger ---
	'mobile_trigger_style' => 'default',
	'mobile_trigger_icon'  => 'menu',
	'mobile_trigger_label' => '',
	'mobile_trigger_color' => array(
		'color' => 'palette4',
		'hover' => 'palette1',
	),
	'mobile_trigger_icon_size' => array(
		'size' => array( 'desktop' => 24, 'mobile' => 24 ),
		'unit' => array( 'desktop' => 'px', 'mobile' => 'px' ),
	),

	// --- Mobile popup ---
	'header_popup_layout'    => 'sidepanel',
	'header_popup_side'      => 'right',
	'mobile_navigation_reveal' => 'none',
	'header_popup_background' => array( 'color' => '#0F1D22' ),
	'header_popup_close_color' => array( 'color' => '#F1EDE4', 'hover' => '#D8B573' ),
	'header_popup_content_align' => 'left',

	// =====================================================================
	// FOOTER BUILDER
	// =====================================================================
	'footer_items' => array(
		'top'    => array(
			'top_1' => array( 'footer-widget1' ),
			'top_2' => array( 'footer-widget2' ),
			'top_3' => array( 'footer-widget3' ),
			'top_4' => array( 'footer-widget4' ),
			'top_5' => array(),
		),
		'middle' => array(
			'middle_1' => array(), 'middle_2' => array(), 'middle_3' => array(),
			'middle_4' => array(), 'middle_5' => array(),
		),
		'bottom' => array(
			'bottom_1' => array( 'footer-html' ),
			'bottom_2' => array(), 'bottom_3' => array(), 'bottom_4' => array(), 'bottom_5' => array(),
		),
	),

	// Footer Top (4-column widget area)
	'footer_top_columns' => '4',
	'footer_top_layout'  => array( 'mobile' => 'full', 'tablet' => 'row', 'desktop' => 'row' ),
	'footer_top_direction' => array( 'mobile' => '', 'tablet' => '', 'desktop' => '' ),
	'footer_top_height' => array(
		'size' => array( 'mobile' => '', 'tablet' => '', 'desktop' => '' ),
		'unit' => array( 'mobile' => 'px', 'tablet' => 'px', 'desktop' => 'px' ),
	),
	'footer_top_background' => array(
		'desktop' => array( 'color' => '#0F1D22' ),
	),
	'footer_top_top_border'  => array(
		'desktop' => array( 'width' => 1, 'unit' => 'px', 'style' => 'solid', 'color' => '#213840' ),
	),
	'footer_top_link_style'  => 'plain',

	// Footer Top widgets → styling
	'footer_widget1_align' => array( 'mobile' => '', 'tablet' => '', 'desktop' => '' ),
	'footer_widget2_align' => array( 'mobile' => '', 'tablet' => '', 'desktop' => '' ),
	'footer_widget3_align' => array( 'mobile' => '', 'tablet' => '', 'desktop' => '' ),
	'footer_widget4_align' => array( 'mobile' => '', 'tablet' => '', 'desktop' => '' ),

	// Footer Bottom (copyright bar)
	'footer_bottom_columns'    => '1',
	'footer_bottom_layout'     => array( 'mobile' => '', 'tablet' => '', 'desktop' => 'row' ),
	'footer_bottom_background' => array( 'desktop' => array( 'color' => '#0A1418' ) ),
	'footer_bottom_top_border' => array(
		'desktop' => array( 'width' => 1, 'unit' => 'px', 'style' => 'solid', 'color' => '#213840' ),
	),
	'footer_bottom_link_style' => 'plain',
	'footer_html_content'      => '{copyright} {year} BAGUS — Basecamp Alat Gunung Untuk Semua. Dibuat untuk keperluan demo/tugas.',
	'footer_html_typography'   => array(
		'size'   => array( 'desktop' => 13 ),
		'family' => 'inherit',
		'google' => false,
		'weight' => '400',
		'color'  => '#A9B4B6',
	),
	'footer_html_link_color'   => array( 'color' => '#D8B573', 'hover' => '#E6CB94' ),

	// Footer wrap
	'footer_wrap_background' => array( 'desktop' => array( 'color' => '#0F1D22' ) ),

	// =====================================================================
	// PAGE / PRODUCT ARCHIVE
	// =====================================================================
	'page_layout'             => 'fullwidth',
	'page_content_style'      => 'unboxed',
	'page_vertical_padding'   => 'show',
	'page_title_layout'       => 'normal',

	// WooCommerce archive
	'product_archive_style'           => 'action-on-hover',
	'product_archive_image_hover_switch' => 'none',
	'product_archive_mobile_columns'  => 'twocolumn',
	'product_archive_title_layout'    => 'above',
	'product_archive_title_inner_layout' => 'standard',
	'product_archive_show_results_count' => true,
	'product_archive_show_order'      => true,
	'product_archive_toggle'          => false,

	// Product single
	'product_layout'          => 'normal',
	'product_content_style'   => 'unboxed',
	'custom_quantity'         => true,

	// WooCommerce misc
	'woo_account_navigation_layout' => 'left',
);

foreach ( $mods as $key => $value ) {
	set_theme_mod( $key, $value );
}
WP_CLI::log( '  ✓ Kadence theme_mods (' . count( $mods ) . ' pengaturan)' );

// =========================================================================
// 3. Separator judul: "Judul — BAGUS" (PRD F-01 AC3)
// =========================================================================
update_option( 'blogname', 'BAGUS' );
update_option( 'blogdescription', 'Mendaki Jadi Lebih BAGUS.' );
WP_CLI::success( 'Kadence theme config siap.' );
