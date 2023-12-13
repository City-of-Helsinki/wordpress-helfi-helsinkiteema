<?php

/**
  * Breadcrumbs
  */
if ( ! function_exists('helsinki_content_breadcrumbs') ) {
	function helsinki_content_breadcrumbs() {
		if ( function_exists('yoast_breadcrumb') ) {
			yoast_breadcrumb( '<div role="navigation" aria-label="'.esc_html__( 'Breadcrumbs', 'helsinki-universal' ).'" id="breadcrumbs" class="breadcrumbs"><div class="hds-container hds-container--wide">','</div></div>' );
		}
	}
}

add_filter('wpseo_breadcrumb_single_link_info', 'helsinki_content_breadcrumbs_single_link_info', 10, 3);
function helsinki_content_breadcrumbs_single_link_info($link_info, $index, $crumbs) {
	if ($index == 0) {
		$link_info['text'] = __('Front page', 'helsinki-universal');
	}

	return $link_info;
}

add_filter('wpseo_breadcrumb_separator', 'helsinki_content_breadcrumbs_separator', 10, 1);
function helsinki_content_breadcrumbs_separator($separator) {
	return '<span aria-hidden="true">' . $separator . '</span>';
}

/**
  * Pagination
  */
if ( ! function_exists('helsinki_loop_pagination') ) {
	function helsinki_loop_pagination( $args = array() ) {
		get_template_part('partials/loop/pagination', null, $args);
	}
}

/**
  * No posts
  */
if ( ! function_exists('helsinki_no_posts_notice') ) {
	function helsinki_no_posts_notice() {
		get_template_part('partials/content/none');
	}
}

/**
  * Not found
  */
if ( ! function_exists('helsinki_not_found_notice') ) {
	function helsinki_not_found_notice() {
		get_template_part('partials/content/not-found', null, array('img' => helsinki_not_found_image()));
	}
}

if ( ! function_exists('helsinki_maintenance_image')) {
	function helsinki_not_found_image() {
		return sprintf(
			'<img class="decoration" alt="" src="%s" width="379" height="566">',
			trailingslashit( get_template_directory_uri() ) . 'assets/images/illustration_error_page_404.svg'
		);
	}
}
