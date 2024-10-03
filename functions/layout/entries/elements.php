<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
  * Title
  */
if ( ! function_exists('helsinki_entry_title') ) {
	function helsinki_entry_title(): void {
		echo helsinki_get_entry_title();
	}
}

if ( ! function_exists('helsinki_get_entry_title') ) {
	function helsinki_get_entry_title(): string {
		return get_the_title();
	}
}

function helsinki_entry_title_with_link( WP_Post $post = null ): string {
	$level = helsinki_entry_title_heading_level( $post );

	$html = sprintf(
		'<h%1$d class="entry__title">
			<a href="%2$s">%3$s</a>
		</h%1$d>',
		$level,
		esc_url( get_permalink( $post ) ),
		esc_html( get_the_title( $post ) )
	);

	return apply_filters( 'helsinki_entry_title_with_link_html', $html, $level, $post );
}

function helsinki_entry_link_with_title( WP_Post $post = null ): string {
	$level = helsinki_entry_title_heading_level( $post );

	$html = sprintf(
		'<a class="entry__link" href="%2$s">
			<h%1$d class="entry__title">%3$s</h%1$d>
		</a>',
		$level,
		esc_url( get_permalink( $post ) ),
		esc_html( get_the_title( $post ) )
	);

	return apply_filters( 'helsinki_entry_link_with_title_html', $html, $level, $post );
}

/**
  * Excerpt
  */
function helsinki_entry_excerpt( WP_Post $post = null ): string {
	$html = sprintf(
		'<div class="entry__excerpt excerpt size-l">
			%1$s
		</div>',
		esc_html( get_the_excerpt( $post ) )
	);

	return apply_filters( 'helsinki_entry_excerpt_html', $html, $post );
}

/**
  * Date
  */
function helsinki_entry_published_date( WP_Post $post = null ): string {
	$html = sprintf(
		'<time class="date" datetime="%1$s">
			<span class="screen-reader-text">%2$s</span>%3$s
		</time>',
		esc_attr( get_the_date( 'c', $post ) ),
		esc_html__( 'Published:', 'helsinki-universal' ),
		esc_html( get_the_date( '', $post ) )
	);

	return apply_filters( 'helsinki_entry_published_date_html', $html, $post );
}

/**
  * Categories
  */
function helsinki_entry_categories( WP_Post $post = null ): string {
	$html = sprintf(
		'<span class="content__category categories">
			<span class="screen-reader-text">%1$s</span>%2$s
		</span>',
		esc_html__( 'Categories' ),
		get_the_category_list( ', ', '', ( $post ? $post->ID : false ) )
	);

	return apply_filters( 'helsinki_entry_categories_html', $html, $post );
}

/**
  * Thumbnail
  */
function helsinki_entry_image_icon(): string {
	return helsinki_get_svg_placeholder(
		apply_filters('helsinki_entry_image_icon', helsinki_entry_image_icon_name())
	);
}

function helsinki_entry_image( $post = null, $force_placeholder = false ): void {
	echo helsinki_get_entry_image( $post, $force_placeholder );
}

function helsinki_get_entry_image( $post = null, $force_placeholder = false ): string {
	$image = helsinki_get_entry_image_html(
		$post ? $post : get_post(),
		helsinki_entry_image_size(),
		array()
	);

	if ( ! $image || $force_placeholder ) {
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

function helsinki_get_entry_image_with_wrap( string $image, string $class ): string {
	return sprintf(
		'<div class="%s">%s</div>',
		$class,
		helsinki_image_with_wrap( $image, true )
	);
}

function helsinki_get_entry_image_html( WP_Post $post, string $size, array $attr = array() ): string {
	return has_post_thumbnail( $post ) ? get_the_post_thumbnail($post, $size, $attr) : helsinki_get_entry_default_image($size, $attr);
}

if ( ! function_exists('helsinki_entry_default_image') ) {
	function helsinki_entry_default_image( string $size = 'post-thumnbnail', array $attr = array(), int $post_id = 0 ): void {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		echo helsinki_get_entry_default_image($size, $attr, $post_id);
	}
}

if ( ! function_exists('helsinki_get_entry_default_image') ) {
	function helsinki_get_entry_default_image( string $size = 'post-thumnbnail', array $attr = array(), int $post_id = 0 ): string {
		$img_id = helsinki_entry_default_image_id( $post_id ?: get_the_ID() );

		return $img_id ? wp_get_attachment_image( $img_id, $size, false, $attr ): '';
	}
}
