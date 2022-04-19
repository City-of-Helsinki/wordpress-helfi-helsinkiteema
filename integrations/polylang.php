<?php

add_action('after_setup_theme', 'helsinki_register_polylang_strings', 10);
function helsinki_register_polylang_strings() {
	if ( ! apply_filters('helsinki_polylang_active', false) ) {
		return;
	}

	$config = array(
		'customizer' => array(
			'header' => array(
				'highlight-url' => helsinki_theme_mod('helsinki_header_highlight', 'url'),
				'highlight-text' => helsinki_theme_mod('helsinki_header_highlight', 'text'),
			),
			'front-page' => array(
				'recent-posts' => helsinki_theme_mod('helsinki_front_page_recent-posts', 'title'),
				'social' => helsinki_theme_mod('helsinki_front_page_social', 'title'),
			),
		),
	);

	$notifications = array();
	$notification_fields = array( 'title', 'text', 'link_text', 'link_url', );
	for ( $i = 1; $i <= helsinki_customizer_notification_count(); $i++ ) {
		$data = helsinki_theme_mod( 'helsinki_notification_notice_' . $i, '' );

		foreach ( $notification_fields as $field ) {
			$key = $i . '-' . $field;
			$notifications[$key] = $data[$field] ?? '';
		}
	}
	$config['customizer']['notification'] = $notifications;

	foreach ($config as $group => $subgroups) {
		foreach ($subgroups as $subgroup => $items) {
			foreach ($items as $item => $text) {
				pll_register_string( "{$group}-{$subgroup}-{$item}", $text, 'Helsinki Universal', false );
			}
		}
	}
}

add_filter('language_attributes', 'helsinki_polylang_filter_html_attributes', 10, 2);

function helsinki_polylang_filter_html_attributes($output, $doctype) {
	$replacables = array(
		'lang="en-US"',
		'lang="en-GB"',
		'lang="en-AU"',
		'lang="en-CA"',
		'lang="sv-SE"',
	);
	$replacees = array(
		'lang="en"',
		'lang="en"',
		'lang="en"',
		'lang="en"',
		'lang="sv"',
	);
	$output = str_replace($replacables, $replacees, $output);
	return $output;
}