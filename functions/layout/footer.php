<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Element classes
  */
function helsinki_footer_classes() {
	$classes = array(
		'footer',
	);

	if ( is_active_sidebar( 'sidebar-footer' ) ) {
		$classes[] = 'has-widgets';
	}

	helsinki_element_classes(
		'footer',
		$classes
    );
}

/**
  * Partials
  */
if ( ! function_exists('helsinki_footer_koros') ) {
	function helsinki_footer_koros() {
		helsinki_koros('footer', false);
	}
}

if ( ! function_exists('helsinki_footer_widgets') ) {
	function helsinki_footer_widgets() {
		if ( is_active_sidebar( 'sidebar-footer' ) ) {
			get_template_part('partials/footer/widgets');
		}
	}
}

if ( ! function_exists('helsinki_sidebar_widgets') ) {
	function helsinki_footer_widget_area() {
		dynamic_sidebar( 'sidebar-footer' );
	}
}

if ( ! function_exists('helsinki_footer_bottom') ) {
	function helsinki_footer_bottom() {
		get_template_part('partials/footer/bottom');
	}
}

if ( ! function_exists('helsinki_footer_logo') ) {
	function helsinki_footer_logo() {
		get_template_part('partials/footer/logo');
	}
}

if ( ! function_exists('helsinki_footer_copyright') ) {
	function helsinki_footer_copyright() {
		get_template_part('partials/footer/copyright');
	}
}

if ( ! function_exists('helsinki_footer_menu') ) {
	function helsinki_footer_menu() {
		get_template_part('partials/footer/menu');
	}
}

if ( ! function_exists('helsinki_footer_back_top') ) {
	function helsinki_footer_back_top() {
		get_template_part('partials/footer/back-top');
	}
}
