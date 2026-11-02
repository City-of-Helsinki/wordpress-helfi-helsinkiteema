<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Element classes
  */
if ( ! function_exists('helsinki_topbar_body_class') ) {
	function helsinki_topbar_body_class( array $classes ): array {
		return helsinki_add_body_class_has_n( $classes, 'topbar' );
	}
}

/**
  * Partials
  */
if ( ! function_exists('helsinki_topbar') ) {
	function helsinki_topbar(): void {
		$lang = substr( get_locale(), 0, 2 );

		$name = apply_filters( 'helsinki_topbar_name', null, $lang );

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

		$args['display_branding'] = helsinki_is_topbar_link_visible( $args, 'branding' );
		$args['display_feedback'] = helsinki_is_topbar_link_visible( $args, 'feedback' );

		get_template_part( 'partials/header/topbar', $name, $args );
	}
}

if ( ! function_exists('helsinki_header_mobile_links') ) {
	function helsinki_header_mobile_links(): void {
		$lang = substr( get_locale(), 0, 2 );

		$name = apply_filters( 'helsinki_topbar_name', null );

		$args = apply_filters(
			'helsinki_topbar_args',
			array(
				'branding' => helsinki_topbar_branding( $lang ),
				'feedback' => helsinki_topbar_feedback( $lang ),
				'menu' => helsinki_mobile_topbar_menu(),
			),
			$name,
			$lang
		);

		$args['display_branding'] = helsinki_is_topbar_link_visible( $args, 'branding' );
		$args['display_feedback'] = helsinki_is_topbar_link_visible( $args, 'feedback' );

		get_template_part( 'partials/header/mobile-links', null, $args );
	}
}

function helsinki_is_topbar_link_visible( array $args, string $key ): bool {
	return ! empty( $args[$key]['url'] )
		&& ! empty( $args[$key]['title'] );
}

function helsinki_topbar_enabled(): bool {
	$disabled = (bool) helsinki_theme_mod(
		'helsinki_header_topbar',
		'disable_topbar',
		false
	);

	return ! $disabled;
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

function helsinki_topbar_branding( string $language = 'fi' ): array {
	$i18n = array(
		'fi' => 'https://www.hel.fi/fi',
		'sv' => 'https://www.hel.fi/sv',
		'en' => 'https://www.hel.fi/en',
	);

	return apply_filters(
		'helsinki_topbar_branding',
		array(
			'title' => __( 'City of Helsinki', 'helsinki-universal' ),
			'url' => $i18n[$language] ?? $i18n['fi'],
		),
		$language,
		$i18n
	);
}

function helsinki_topbar_feedback( string $language = 'fi' ): array {
	$feedback_url = (string) helsinki_theme_mod(
		'helsinki_header_topbar',
		'feedback_url',
		''
	);

	$i18n = array(
		'fi' => 'https://palautteet.hel.fi/fi',
		'sv' => 'https://palautteet.hel.fi/sv',
		'en' => 'https://palautteet.hel.fi/en',
	);

	return apply_filters(
		'helsinki_topbar_feedback',
		array(
			'title' => __( 'Give feedback', 'helsinki-universal' ),
			'url' => $feedback_url ?: ($i18n[$language] ?? $i18n['fi']),
		),
		$language,
		$i18n
	);
}
