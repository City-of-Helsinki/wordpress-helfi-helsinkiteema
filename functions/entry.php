<?php

/**
  * Element classes
  */
function helsinki_entry_classes( string $post_type = '' ) {
  $classes = array(
    'entry',
  );

	if ( has_post_thumbnail() ) {
		$classes[] = 'has-thumbnail';
	}

  if ( $post_type ) {
    $classes[] = 'entry--' . $post_type;
    $classes = apply_filters( "helsinki_{$post_type}_entry_classes", $classes );
  }

  helsinki_element_classes(
    'entry',
    $classes
  );
}

/**
  * Grids
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



/**
  * Entry types
  */
if ( ! function_exists('helsinki_entry') ) {
	function helsinki_entry() {
		get_template_part('partials/loop/entry');
	}
}

if ( ! function_exists('helsinki_grid_entry') ) {
	function helsinki_grid_entry() {
		get_template_part('partials/loop/entry', 'grid');
	}
}

/**
  * Title
  */
if ( ! function_exists('helsinki_entry_title') ) {
	function helsinki_entry_title() {
		echo helsinki_get_entry_title();
	}
}

if ( ! function_exists('helsinki_get_entry_title') ) {
	function helsinki_get_entry_title() {
		return helsinki_trim_title(
			get_the_title()
		);
	}
}

/**
  * Partials
  */
if ( ! function_exists('helsinki_entries_load_more') ) {
	function helsinki_entries_load_more() {
		get_template_part('partials/loop/load-more');
	}
}

/**
  * Thumbnail
  */
function helsinki_entry_image_size() {
	return apply_filters('helsinki_entry_image_size', 'post-thumbnail');
}

function helsinki_entry_image_icon() {
	return helsinki_get_svg_placeholder(
		apply_filters('helsinki_entry_image_icon', helsinki_entry_image_icon_name())
	);
}

function helsinki_entry_image_icon_name() {
	return helsinki_theme_mod('helsinki_blog_entry', 'placeholder_icon', 'abstract-3');
}

function helsinki_entry_image_icon_classes() {
	$classes = array(
		'has-primary-background-color',
		'has-icon',
	);

	if ( helsinki_scheme_has_invert_color() ) {
		$classes[] = 'has-white-color';
	} else {
		$classes[] = 'has-black-color';
	}

	return implode(
		' ',
		apply_filters(
			'helsinki_entry_image_icon_classes',
			$classes
		)
	);
}

function helsinki_entry_image_classes( bool $icon = false ) {
	$class = 'entry__thumbnail';
	if ( $icon ) {
		$class .= ' ' . helsinki_entry_image_icon_classes();
	}
	return $class;
}

function helsinki_entry_image( $post = null ) {
	echo helsinki_get_entry_image( $post );
}

function helsinki_get_entry_image( $post = null ) {
	$image = helsinki_get_entry_image_html(
		$post ? $post : get_post(),
		helsinki_entry_image_size(),
		array()
	);

	if ( ! $image ) {
		return helsinki_get_entry_image_with_wrap(
			helsinki_entry_image_icon(),
			helsinki_entry_image_classes(true)
		);
	} else {
		return helsinki_get_entry_image_with_wrap(
			$image,
			helsinki_entry_image_classes()
		);
	}
}

function helsinki_get_entry_image_with_wrap( string $image, string $class ) {
	return sprintf(
		'<div class="%s">%s</div>',
		$class,
		helsinki_image_with_wrap( $image, true )
	);
}

function helsinki_get_entry_image_html( WP_Post $post, string $size, array $attr = array() ) {
	return has_post_thumbnail( $post ) ? get_the_post_thumbnail($post, $size, $attr) : helsinki_get_entry_default_image($size, $attr);
}

if ( ! function_exists('helsinki_entry_default_image') ) {
	function helsinki_entry_default_image( string $size = 'post-thumnbnail', array $attr = array(), int $post_id = 0 ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}
		echo helsinki_get_entry_default_image($size, $attr, $post_id);
	}
}

if ( ! function_exists('helsinki_get_entry_default_image') ) {
	function helsinki_get_entry_default_image( string $size = 'post-thumnbnail', array $attr = array(), int $post_id = 0 ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}
		$cat_thumb_id = 0;
		foreach (get_the_category( $post_id ) as $category) {
			$cat_thumb_id = helsinki_category_featured_image($category->term_id);
			if ( $cat_thumb_id ) {
				break;
			}
		}

		if ( ! $cat_thumb_id ) {
			$cat_thumb_id = helsinki_category_featured_image( (int) get_option('default_category', 0) );
		}

		return $cat_thumb_id ? wp_get_attachment_image( $cat_thumb_id, $size, false, $attr ): '';
	}
}
