<?php

/**
  * Configuration
  */
function helsinki_featured_image_is_hidden() {
	return get_post_meta( get_queried_object_id(), 'hide_featured_image', true ) ? true : false;
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
	$img_html = '';
	$caption = '';
	$credit = '';
	$fixed_size = false;
	$thumbnail_id = get_post_thumbnail_id();

	if ( $thumbnail_id ) {
		$img_html = wp_get_attachment_image(
			$thumbnail_id,
			apply_filters( 'helsinki_content_article_thumbnail_size', 'large' ),
			false,
			array()
		);
		$caption = wp_get_attachment_caption( $thumbnail_id );
		$credit = helsinki_base_image_credit( $thumbnail_id );
	}

	$data = array(
		'image' => $img_html,
		'caption' => $caption,
		'fixed_size' => $fixed_size,
		'credit' => $credit,
	);

	if ( ! $data['image'] ) {
		return;
	}

	get_template_part(
		'partials/content/parts/thumbnail',
		$post_type,
		$data
	);
}

/**
  * Categories
  */
if ( ! function_exists('helsinki_category_featured_image') ) {
	function helsinki_category_featured_image( int $id ) {
		return get_term_meta( $id, 'featured_image', true );
	}
}
