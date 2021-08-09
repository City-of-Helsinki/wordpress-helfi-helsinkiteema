<?php

add_action( 'wp_enqueue_scripts', 'helsinki_disable_cmplz_cookiebanner_styles', PHP_INT_MAX - 49 );
function helsinki_disable_cmplz_cookiebanner_styles() {
    wp_dequeue_style( 'cmplz-cookie' );

    wp_dequeue_style( 'cmplz-document' );
    wp_dequeue_style( 'cmplz-document-grid' );
	add_filter( 'cmplz_custom_document_css', '__return_empty_string' );
}

add_filter('cmplz_cookiebanner_settings', 'helsinki_cmplz_cookiebanner_settings', 9999, 1);
function helsinki_cmplz_cookiebanner_settings( $settings ) {
	$settings = array_merge(
		$settings,
		helsinki_complianz_cookiebanner_styles()
	);

	$settings['categories'] = helsinki_complianz_cookiebanner_categories_wrap(
		$settings['categories'] ?? ''
	);
	$settings['message_optout'] = helsinki_complianz_cookiebanner_message_wrap(
		$settings['message_optout'] ?? ''
	);
	$settings['message_optin'] = helsinki_complianz_cookiebanner_message_wrap(
		$settings['message_optin'] ?? ''
	);

	return $settings;
}

function helsinki_complianz_cookiebanner_categories_wrap(string $categories = '') {
	if ( $categories ) {
		$parts = explode('<style>', $categories);
		if ( $parts ) {
			$parts = array_filter(
				$parts,
				function($part){
					return substr( $part, 0, 4 ) === "<div";
				}
			);
			$categories = implode('', $parts);
		}
		return '<div class="cookie-categories-wrap">' . $categories . '</div>';
	} else {
		return '';
	}
}

function helsinki_complianz_cookiebanner_message_wrap(string $message = '') {
	return sprintf(
		'<div class="cookie-notice">
			<h2 class="cookie-notice__title">%s</h2>
			%s
		</div>',
		sprintf(
			'%s %s',
			get_bloginfo( 'name' ),
			esc_html_x('uses cookies', 'cookie notice title prefix', 'helsinki-universal')
		),
		wpautop( $message )
	);
}

function helsinki_complianz_cookiebanner_styles() {
	return array(
		'position' => 'bottom',
		'theme' => 'block',
		'custom_css' => '',
		'colorpalette_background_color' => 'inherit',
		'colorpalette_background_border' => 'inherit',
		'colorpalette_text_color' => 'inherit',
		'colorpalette_text_hyperlink_color' => 'inherit',
		'colorpalette_toggles_background' => 'inherit',
		'colorpalette_toggles_bullet' => 'inherit',
		'colorpalette_toggles_inactive' => 'inherit',
		'colorpalette_border_radius' => '0px',
		'border_width' => '0px',
		'colorpalette_button_accept_background' => 'inherit',
		'colorpalette_button_accept_border' => 'inherit',
		'colorpalette_button_accept_text' => 'inherit',
		'colorpalette_button_deny_background' => 'inherit',
		'colorpalette_button_deny_border' => 'inherit',
		'colorpalette_button_deny_text' => 'inherit',
		'colorpalette_button_settings_background' => 'inherit',
		'colorpalette_button_settings_border' => 'inherit',
		'colorpalette_button_settings_text' => 'inherit',
		'buttons_border_radius' => '0px',
		'box_shadow' => 'none',
	);
}
