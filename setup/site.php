<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\Helsinki\Theme\Setup\Scheme\Theme_Scheme;
use CityOfHelsinki\WordPress\Helsinki\Theme\Setup\Scheme\Theme_Scheme_Styles;
use CityOfHelsinki\WordPress\Helsinki\Theme\Setup\Scheme\Theme_Scheme_Hooks;

function helsinki_setup_site(): void {
	/**
	  * General
	  */
	$current_koros = helsinki_theme_mod('helsinki_general_koros', 'type');
	if ( $current_koros ) {
		helsinki_koros_set_type($current_koros);
	}

	$scheme = helsinki_create_theme_scheme_hooks();

	add_filter( 'helsinki_scheme', array( $scheme, 'current_scheme' ) );
	add_filter( 'helsinki_scheme_root_styles', array( $scheme, 'root_styles' ) );

	add_action( 'wp_head', array( $scheme, 'print_inline_styles' ) );
	add_action( 'admin_head', array( $scheme, 'print_inline_styles' ) );
	add_action( 'helsinki_set_current_scheme', array( $scheme, 'set_scheme' ) );

	if ( helsinki_theme_mod('helsinki_header_breadcrumbs', 'enabled') ) {
		add_filter('helsinki_breadcrumbs_enabled', '__return_true');
	}

	/**
	  * Site header
	  */
	$header_parts = array('search', 'languages');
	foreach ($header_parts as $header_part) {
		if ( helsinki_theme_mod('helsinki_header_' . $header_part, 'enabled') ) {
			add_filter('helsinki_header_' . $header_part . '_enabled', '__return_true');
		}
	}

	if ( helsinki_theme_mod('helsinki_header_general', 'disable_default_logo') ) {
		add_filter('helsinki_header_default_logo_enabled', '__return_false');
	}

	/**
	  * Site sidebar
	  */
	$sidebars = array('page');
	foreach ($sidebars as $sidebar) {
		if ( helsinki_theme_mod('helsinki_sidebar_' . $sidebar, 'enabled') ) {
			add_filter('helsinki_sidebar_' . $sidebar . '_enabled', '__return_true');
		}
	}

	/**
	 * Feedback buttons
	 */
	if ( helsinki_theme_mod('helsinki_feedback_feedback', 'enabled') ) {
		add_filter('helsinki_feedback_enabled', '__return_true');
	}

	/**
	  * Posts Page
	  */
	if ( helsinki_theme_mod('helsinki_blog_filter', 'enabled') ) {
		add_action('helsinki_blog_filter_enabled', '__return_true');
	}

	/**
	  * Single article
	  */
	$single_article_parts = array('social_share', 'categories', 'author', 'date', 'updated', 'tags', 'related');
	$show_single_article_meta = false;
	foreach ($single_article_parts as $single_article_part) {
		if ( helsinki_theme_mod('helsinki_blog_single', $single_article_part) ) {
			add_filter('helsinki_blog_single_' . $single_article_part, '__return_true');
			$show_single_article_meta = true;
		}
	}
	if ( $show_single_article_meta ) {
		add_filter('helsinki_blog_single_meta', '__return_true');
	}

	do_action( 'helsinki_site_setup_ready' );
}

function helsinki_create_theme_scheme_hooks(): Theme_Scheme_Hooks {
	$hooks = helsinki_theme_scheme_hooks(
		helsinki_config_colors(),
		helsinki_customizer_choices_style_schemes(),
		helsinki_default_scheme(),
		helsinki_theme_mod( 'helsinki_general_style', 'scheme' )
	);

	return apply_filters( 'helsinki_theme_scheme_hooks', $hooks );
}

function helsinki_theme_scheme_hooks(
	array $colors,
	array $schemes,
	string $default,
	string $current = ''
): Theme_Scheme_Hooks {
	$scheme = new Theme_Scheme( $schemes, $default );

	try {
		$scheme->set_current( $current );
	} catch (\Exception $e) {
		error_log( $e->getMessage() );
	}

	return new Theme_Scheme_Hooks(
		$scheme,
		new Theme_Scheme_Styles( $colors )
	);
}
