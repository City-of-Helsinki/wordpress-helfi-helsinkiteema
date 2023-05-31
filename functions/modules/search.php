<?php

if ( ! function_exists('helsinki_search_form') ) {
	function helsinki_search_form() {
		get_search_form();
	}
}

function helsinki_search_sidebar() {
	get_sidebar( 'search' );
}

function helsinki_search_title() {
	get_template_part(
		'partials/search/title',
		null,
		array()
	);
}

function helsinki_search_form_title() {
	get_template_part(
		'partials/search/form-title',
		null,
		array()
	);
}

function helsinki_search_links() {
	$lang = function_exists('pll_current_language') ? pll_current_language('slug') : substr( get_bloginfo('language'), 0, 2 );
	$args['feedback'] = helsinki_topbar_feedback( $lang )['url'];
	$args['search_target'] = helsinki_search_helfi_target( $lang );

	get_template_part(
		'partials/search/links',
		null,
		$args
	);
}

function helsinki_search_helfi_target( string $language = 'fi' ) {
	$targets = array(
		'fi' => 'https://www.hel.fi/haku',
		'sv' => 'https://www.hel.fi/sok ',
		'en' => 'https://www.hel.fi/search ',
	);

	return apply_filters(
		'helsinki_topbar_branding',
		$targets[$language] ?? $targets['fi'],
		$language,
		$targets
	);
}
