<?php

/**
  * Element classes
  */
if ( ! function_exists('helsinki_topbar_body_class') ) {
	function helsinki_topbar_body_class($classes) {
		return helsinki_add_body_class_has_n( $classes, 'topbar' );
	}
}

/**
  * Partials
  */
if ( ! function_exists('helsinki_topbar') ) {
	function helsinki_topbar() {
		$lang = function_exists('pll_current_language') ? pll_current_language('slug') : substr( get_bloginfo('language'), 0, 2 );
		$name = apply_filters( 'helsinki_topbar_name', null );
		$args = apply_filters(
			'helsinki_topbar_args',
			array(
				'branding' => helsinki_topbar_branding( $lang ),
				'feedback' => helsinki_topbar_feedback( $lang ),
				'menu' => helsinki_topbar_menu(),
			),
			$name,
			$lang
		);

		get_template_part( 'partials/header/topbar', $name, $args);
	}
}

function helsinki_topbar_menu() {
	if ( has_nav_menu( 'topbar_menu' ) ) {
		return helsinki_menu( 'topbar_menu' );
	}
}

function helsinki_mobile_topbar_menu() {
	if ( has_nav_menu( 'topbar_menu' ) ) {
		return helsinki_menu( 'mobile_topbar_menu' );
	}
}

function helsinki_topbar_branding( string $language = 'fi' ) {
	$branding = array(
		'fi' => 'https://www.hel.fi/fi',
		'sv' => 'https://www.hel.fi/sv',
		'en' => 'https://www.hel.fi/en',
	);

	return apply_filters(
		'helsinki_topbar_branding',
		array(
			'title' => __( 'City of Helsinki', 'helsinki-universal' ),
			'url' => $branding[$language] ?? $branding['fi'],
		),
		$language,
		$branding
	);
}

function helsinki_topbar_feedback( string $language = 'fi' ) {
	$feedback = array(
		'fi' => 'https://palautteet.hel.fi/fi',
		'sv' => 'https://palautteet.hel.fi/sv',
		'en' => 'https://palautteet.hel.fi/en',
	);

	return apply_filters(
		'helsinki_topbar_branding',
		array(
			'title' => __( 'Give feedback', 'helsinki-universal' ),
			'url' => $feedback[$language] ?? $feedback['fi'],
		),
		$language,
		$feedback
	);
}
