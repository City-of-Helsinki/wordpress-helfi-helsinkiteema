<?php

/**
  * Content article
  */
if ( ! function_exists('helsinki_content_article') ) {
	function helsinki_content_article() {
		get_template_part('partials/content/article');
	}
}

function helsinki_content_article_header() {
	get_template_part('partials/content/parts/header');
}

function helsinki_content_article_header_class() {
	$class = 'content__header';

	if ( is_page() ) {
		$class .= ' hero';
	}

	helsinki_hero_classes($class);
}

function helsinki_content_article_header_container_class() {
	$class = array();

	if ( is_page() ) {
		$class[] = 'hds-container';
		$class[] = 'hero__content';
	}

	helsinki_element_classes(
    'content_article_header_container',
    $class
  );
}

function helsinki_content_article_koros() {
	helsinki_koros(
		'content',
		apply_filters( 'helsinki_content_article_koros_flipped', true )
	);
}

function helsinki_content_article_title() {
	get_template_part('partials/content/parts/title');
}

function helsinki_content_article_excerpt() {
	get_template_part('partials/content/parts/excerpt');
}

function helsinki_content_excerpt( $post = null ) {
	echo helsinki_get_content_excerpt( $post );
}

function helsinki_get_content_excerpt( $post = null ) {
	$excerpt = get_the_excerpt( $post );
	$max_length = apply_filters( 'helsinki_content_excerpt_length', 195 );
	return mb_strlen($excerpt) > $max_length ? mb_substr($excerpt, 0, $max_length) : $excerpt;
}

function helsinki_content_article_thumbnail($post_type = null) {
	$img_html = '';
	$caption = '';
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
	}

	$data = array(
		'image' => $img_html,
		'caption' => $caption,
		'fixed_size' => $fixed_size,
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

function helsinki_featured_image_is_hidden() {
	return get_post_meta( get_queried_object_id(), 'hide_featured_image', true ) ? true : false;
}

function helsinki_content_article_meta() {
	get_template_part('partials/content/parts/meta');
}

function helsinki_content_article_date() {
	get_template_part('partials/content/parts/date');
}

function helsinki_content_article_updated() {
	$u_time = get_the_time('U');
	$u_modified_time = get_the_modified_time('U');
	if ( $u_modified_time > $u_time ) {
		get_template_part('partials/content/parts/updated');
	}
}

function helsinki_content_article_categories() {
	get_template_part('partials/content/parts/categories');
}

function helsinki_content_article_author() {
	get_template_part('partials/content/parts/author');
}

function helsinki_content_article_tags() {
	get_template_part('partials/content/parts/tags');
}

function helsinki_content_article_social_share() {
	$links = helsinki_social_share_links();
	if ( ! $links ) {
		return;
	}
	get_template_part(
		'partials/content/parts/social-share',
		null,
		$links
	);
}

function helsinki_content_article_body() {
	get_template_part('partials/content/parts/body');
}

function helsinki_content_article_container_class() {
	$class = array(
		'content__container',
		'hds-container',
	);

	helsinki_element_classes(
      'content_article_container',
      $class
    );
}

/**
  * Categories
  */
if ( ! function_exists('helsinki_blog_filter') ) {
	function helsinki_blog_filter() {
		get_template_part('partials/loop/filter');
	}
}

if ( ! function_exists('helsinki_category_featured_image') ) {
	function helsinki_category_featured_image( int $id ) {
		return get_term_meta( $id, 'featured_image', true );
	}
}

function helsinki_post_first_category( int $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	$categories = get_the_category( $post_id );
	return $categories[0] ?? null;
}
