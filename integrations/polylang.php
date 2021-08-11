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

	foreach ($config as $group => $subgroups) {
		foreach ($subgroups as $subgroup => $items) {
			foreach ($items as $item => $text) {
				pll_register_string( "{$group}-{$subgroup}-{$item}", $text, 'Helsinki Universal', false );
			}
		}
	}
}
