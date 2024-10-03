<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
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

function helsinki_entry_excerpt( WP_Post $post = null ): string {
	$html = sprintf(
		'<div class="entry__excerpt excerpt size-l">
			%1$s
		</div>',
		esc_html( get_the_excerpt( $post ) )
	);

	return apply_filters( 'helsinki_entry_excerpt_html', $html, $post );
}

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
