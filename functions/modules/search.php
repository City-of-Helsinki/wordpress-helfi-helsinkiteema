<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Modules\Search_Form_Builder;

if ( ! function_exists('helsinki_search_form') ) {
	function helsinki_search_form() {
		do_action( 'helsinki_search_form', '' );
	}
}

function helsinki_provide_search_form( string $name ): void {
	$config = helsinki_search_form_config( $name );

	(new Search_Form_Builder())
		->set_form_id( $name )
		->set_title( $config['title'] )
		->set_title_level( $config['title_level'] )
		->set_title_classes( ...$config['title_classes'] )
		->render_form();
}

function helsinki_search_form_config( string $name ): array {
	$config = match( $name ) {
		'header' => array(
			'title' => _x( 'Search the site', 'search title', 'helsinki-universal' ),
			'title_level' => 2,
			'title_classes' => array(),
		),
		'search-page' => array(
			'title' => _x( 'Search the site', 'search title', 'helsinki-universal' ),
			'title_level' => 1,
			'title_classes' => array( 'view-title' ),
		),
		default => array(
			'title' => '',
			'title_level' => 2,
			'title_classes' => array(),
		),
	};

	return apply_filters( 'helsinki_search_form_config', $config, $name );
}

function helsinki_search_page_search_form(): void {
	do_action( 'helsinki_search_form', 'search-page' );
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
	/*
	 * @since 4.38.0
	 */
	helsinki_deprecation_notice( __FUNCTION__, 'helsinki_provide_search_form' );
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
