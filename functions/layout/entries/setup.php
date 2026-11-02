<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Layout\Entries\Entry_Image;
use CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Layout\Entries\Entry_Setup;

function helsinki_create_entry_image( mixed $post = null, bool $fixed_size = false ): Entry_Image {
	return new Entry_Image(
		apply_filters(
			'helsinki_entry_thumbnail_id',
			(int) get_post_thumbnail_id( $post ),
			$post
		),
		apply_filters(
			'helsinki_entry_image_size',
			'post-thumbnail',
			$post
		),
		apply_filters(
			'helsinki_entry_image_icon',
			helsinki_entry_image_icon_name(),
			$post
		),
		$fixed_size
	);
}

function helsinki_create_entry_setup( WP_Post $post, array $classes = array() ): Entry_Setup {
	$setup = new Entry_Setup(
		$post,
		helsinki_create_entry_image( $post, true ),
		$classes
	);

	do_action( 'helsinki_entry_setup', $setup );

	return $setup;
}

/**
  * Filter elements
  */
add_filter( 'helsinki_entry_title_heading_level', 'helsinki_filter_entry_title_heading_level', 10, 2 );
function helsinki_filter_entry_title_heading_level( int $level, WP_Post $post = null ): int {
	return ( is_archive() || is_home() ) ? 2 : $level;
}

/**
  * Render elements
  */
add_action( 'helsinki_entry_content_before', 'helsinki_provide_default_entry_image', 10, 3 );

add_action( 'helsinki_entry_content', 'helsinki_provide_grid_entry_image', 10, 3 );
add_action( 'helsinki_entry_content', 'helsinki_provide_entry_title', 20, 3 );
add_action( 'helsinki_entry_content', 'helsinki_provide_entry_excerpt', 30, 3 );

add_action( 'helsinki_entry_meta', 'helsinki_provide_entry_categories', 10, 3 );
add_action( 'helsinki_entry_meta', 'helsinki_provide_entry_date', 20, 3 );

/**
  * Integrations
  */
add_action( 'helsinki_wp_recent_posts_feed_entry', 'helsinki_provide_feed_entry', 10, 1 );
add_action( 'helsinki_wp_recent_posts_grid_entry', 'helsinki_provide_grid_entry', 10, 1 );
