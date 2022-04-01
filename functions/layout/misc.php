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

/**
  * Pagination
  */
if ( ! function_exists('helsinki_loop_pagination') ) {
	function helsinki_loop_pagination() {
		get_template_part('partials/loop/pagination');
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
		get_template_part('partials/content/not-found');
	}
}
