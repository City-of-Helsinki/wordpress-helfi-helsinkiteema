<?php

if ( ! function_exists('helsinki_entries_grid') ) {
	function helsinki_entries_grid() {
		get_template_part('partials/loop/grid');
	}
}

function helsinki_loop_count() {
	global $wp_query;

	get_template_part(
		'partials/loop/count',
		null,
		array(
			'count' => $wp_query->found_posts,
		)
	);
}

function helsinki_loop_grid() {
	get_template_part(
		'partials/loop/grid',
		null,
		array()
	);
}

function helsinki_loop_list() {
	get_template_part(
		'partials/loop/list',
		null,
		array()
	);
}

function helsinki_loop_entry() {
	get_template_part(
		'partials/loop/entry',
		null,
		array()
	);
}

/**
 * @deprecated Please use helsinki_load_more_button() instead
 * @since 4.0.0 Marked deprecated in favor of helsinki_load_more_button()
 * @see /functions/load-more.php
 */
function helsinki_loop_more() {
	trigger_error(
        'The ' . __FUNCTION__ . ' function is deprecated. ' .
        'Please use helsinki_load_more_button() instead.',
        defined( 'E_USER_DEPRECATED' ) ? E_USER_DEPRECATED : E_USER_WARNING
    );

    return helsinki_load_more_button();
}

function helsinki_loop_sidebar() {
	get_sidebar( 'loop' );
}

function helsinki_loop_sidebar_categories() {
	$classes = array(
		'widget',
		'widget--%s',
		'widget--sidebar',
	);

	the_widget(
		'WP_Widget_Categories',
		array(
			'title' => __( 'All categories', 'helsinki-universal' ),
			'count' => 0,
			'hierarchical' => 0,
			'dropdown' => 0,
		),
		array(
			'before_widget' => '<div class="' . implode(' ', $classes) . '">',
		    'after_widget'  => '</div>',
		    'before_title'  => '<h3 class="widget__title">',
		    'after_title'   => '</h3>',
		)
	);
}

function helsinki_loop_sidebar_tags() {
	$classes = array(
		'widget',
		'widget--%s',
		'widget--sidebar',
	);

	the_widget(
		'WP_Widget_Tag_Cloud',
		array(
			'title' => __( 'All tags', 'helsinki-universal' ),
			'taxonomy' => 'post_tag',
		),
		array(
			'before_widget' => '<div class="' . implode(' ', $classes) . '">',
		    'after_widget'  => '</div>',
		    'before_title'  => '<h3 class="widget__title">',
		    'after_title'   => '</h3>',
		)
	);
}
