<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Image\Page_Featured_Image;
use CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Image\Post_Featured_Image;
use CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Image\Content_Image;
use CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Image\Image_Renderer;
use CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Image\Image_Visibility;

add_action( 'helsinki_single_post_template', 'helsinki_setup_single_post_featured_image', 20 );
function helsinki_setup_single_post_featured_image(): void {
	$image = helsinki_create_post_featured_image( get_post() );

	if ( $image->enabled() ) {
		add_filter( 'body_class', 'helsinki_featured_image_body_class', 10 );
		add_action( 'helsinki_content_article', array( $image, 'display' ), 30 );
	}
}

add_action( 'helsinki_single_page_template', 'helsinki_setup_single_page_featured_image', 20 );
function helsinki_setup_single_page_featured_image(): void {
	$image = helsinki_create_page_featured_image( get_post() );

	if ( $image->enabled() ) {
		add_filter( 'body_class', 'helsinki_featured_image_body_class', 10 );
		add_action( 'helsinki_content_article', array( $image, 'display' ), 15 );
	}
}

/**
  * Configuration
  */
function helsinki_featured_image_is_hidden(): bool {
	return (new Image_Visibility(get_queried_object_id()))->hidden;
}

function helsinki_has_featured_image(): bool {
	return has_post_thumbnail() && ! helsinki_featured_image_is_hidden();
}

/**
  * Classes
  */
function helsinki_featured_image_body_class( array $classes ) {
	return helsinki_add_body_class_has_n( $classes, 'post-thumbnail' );
}

/**
  * Posts & Pages
  */
function helsinki_content_article_thumbnail($post_type = null) {
	helsinki_deprecation_notice(
		__FUNCTION__,
		'helsinki_setup_single_post_featured_image or helsinki_setup_single_page_featured_image'
	);

	$image = helsinki_create_post_image( get_post() );

	if ( $image->id ) {
		echo (new Image_Renderer($image, 'content__thumbnail'));
	}
}

function helsinki_create_post_featured_image( WP_Post $post, bool $fixed_size = false ): Post_Featured_Image {
	return new Post_Featured_Image(
		$post,
		helsinki_create_post_image( $post, $fixed_size )
	);
}

function helsinki_create_page_featured_image( WP_Post $post, bool $fixed_size = false ): Page_Featured_Image {
	return new Page_Featured_Image(
		$post,
		helsinki_create_post_image( $post, $fixed_size ),
		new Image_Visibility( $post->ID )
	);
}

function helsinki_create_post_image( mixed $post = null, bool $fixed_size = false ): Content_Image {
	$thumbnail_id = apply_filters(
		'helsinki_post_thumbnail_id',
		(int) get_post_thumbnail_id( $post ),
		$post
	);

	$caption = '';
	$credit = '';
	if ( $thumbnail_id ) {
		$caption = wp_get_attachment_caption( $thumbnail_id );
		$credit = helsinki_base_image_credit( $thumbnail_id );
	}

	return new Content_Image(
		$thumbnail_id,
		apply_filters(
			'helsinki_content_article_thumbnail_size',
			'large',
			$post
		),
		$fixed_size,
		$caption,
		$credit
	);
}
