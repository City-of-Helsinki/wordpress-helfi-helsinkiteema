<?php

function helsinki_setup_site() {
	$theme_mods = helsinki_theme_mods();
	//var_dump($theme_mods);

	/**
	  * General
	  */
	$current_koros = helsinki_theme_mod('helsinki_general_koros', 'type');
	if ( $current_koros ) {
		helsinki_koros_set_type($current_koros);
	}

	$current_scheme = helsinki_theme_mod('helsinki_general_style', 'scheme');
	helsinki_set_current_scheme(
		$current_scheme ?: helsinki_default_scheme()
	);

	if ( helsinki_theme_mod('helsinki_general_breadcrumbs', 'enabled') ) {
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
	  * Front Page
	  */
	add_filter( 'wp_feed_cache_transient_lifetime', 'helsinki_front_page_lifetime_filter', 10, 2 );

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

	/**
	  * Social share
	  */
	$enabled_social_share_medias = helsinki_theme_mod('helsinki_general_social_share', 'medias');
	if ( $enabled_social_share_medias ) {
		foreach ($enabled_social_share_medias as $enabled_social_share_media) {
			add_filter('helsinki_social_share_media_' . $enabled_social_share_media . '_enabled', '__return_true');
		}
	}
}
