<?php

/**
  * Filtering
  */
if ( ! function_exists('helsinki_blog_filter') ) {
	function helsinki_blog_filter() {
		$categories = helsinki_blog_filter_categories();
		if ( ! $categories ) {
			return;
		}

		get_template_part(
			'partials/loop/filter',
			null,
			array(
				'placeholder' => helsinki_theme_mod(
					'helsinki_blog_filter',
					'placeholder',
					__('Select category', 'helsinki-universal')
				),
				'categories' => $categories,
			)
		);
	}
}

function helsinki_blog_filter_categories() {
	$config = helsinki_theme_mod( 'helsinki_blog_filter', 'categories' );
	return ($config && is_array($config)) ? get_terms( array(
	    'taxonomy' => 'category',
		'object_ids' => array_map( 'intval', $config ),
	    'hide_empty' => false,
	) ) : array();
}

/**
  * Entry grid
  */
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
	$is_search = is_search();
	get_template_part(
		'partials/loop/entry',
		null,
		array(
			'is_search' => $is_search,
		)
	);
}

/**
 * @deprecated Please use helsinki_load_more_button() instead
 * @since 4.0.0 Marked deprecated in favor of helsinki_load_more_button()
 * @see /functions/load-more.php
 */
function helsinki_loop_more() {
	helsinki_deprecation_notice( __FUNCTION__, 'helsinki_load_more_button()' );
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

	ob_start();
	the_widget(
		'WP_Widget_Categories',
		array(
			'title' => __( 'Categories', 'helsinki-universal' ),
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

	$output = ob_get_clean();
	echo apply_filters( 'widget_output', $output, 'categories' );
}

function helsinki_loop_sidebar_tags() {
	$classes = array(
		'widget',
		'widget--%s',
		'widget--sidebar',
	);

	ob_start();
	the_widget(
		'WP_Widget_Tag_Cloud',
		array(
			'title' => __( 'Tags', 'helsinki-universal' ),
			'taxonomy' => 'post_tag',
			'count' => true,
		),
		array(
			'before_widget' => '<div class="' . implode(' ', $classes) . '">',
		    'after_widget'  => '</div>',
		    'before_title'  => '<h3 class="widget__title">',
		    'after_title'   => '</h3>',
		)
	);
	$output = ob_get_clean();
	echo apply_filters( 'widget_output', $output, 'tag_cloud' );
}
