<?php

/**
  * Element
  */
if ( ! function_exists('helsinki_content_article') ) {
	function helsinki_content_article() {
		get_template_part('partials/content/article');
	}
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
  * Header
  */
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

/**
  * Koros
  */
function helsinki_content_article_koros() {
	helsinki_koros(
		'content',
		apply_filters( 'helsinki_content_article_koros_flipped', true )
	);
}

/**
  * Title
  */
function helsinki_content_article_title() {
	get_template_part('partials/content/parts/title');
}

/**
  * Excerpt
  */
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

/**
  * Meta
  */
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

function helsinki_post_first_category( int $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	$categories = get_the_category( $post_id );
	return $categories[0] ?? null;
}

function helsinki_content_article_author() {
	get_template_part('partials/content/parts/author');
}

function helsinki_content_article_tags() {
	get_template_part('partials/content/parts/tags');
}

/**
  * Social
  */
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

/**
  * Body
  */
function helsinki_content_article_body() {
	get_template_part('partials/content/parts/body');
}
