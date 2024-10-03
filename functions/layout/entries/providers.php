<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function helsinki_provide_grid_entry( array $args = array() ): void {
	helsinki_grid_entry( $args );
}

function helsinki_provide_feed_entry( array $args = array() ): void {
	helsinki_feed_entry( $args );
}

function helsinki_provide_default_entry_image( WP_Post $post = null, string $type = '', array $args = array() ): void {
	if ( ! $type && has_post_thumbnail( $post ) ) {
		helsinki_entry_image( $post );
	}
}

function helsinki_provide_grid_entry_image( WP_Post $post = null, string $type = '', array $args = array() ): void {
	if ( 'grid' === $type ) {
		helsinki_entry_image( $post, helsinki_entry_has_placeholder_class( $args ) );
	}
}

function helsinki_provide_entry_title( WP_Post $post = null, string $type = '', array $args = array() ): void {
	if ( 'grid' === $type ) {
		echo helsinki_entry_link_with_title( $post );
	} else {
		echo helsinki_entry_title_with_link( $post );
	}
}

function helsinki_provide_entry_excerpt( WP_Post $post = null, string $type = '', array $args = array() ): void {
	if ( ! $type && is_search() && get_the_excerpt( $post ) ) {
		echo helsinki_entry_excerpt( $post );
	}
}

function helsinki_provide_entry_date( WP_Post $post = null, string $type = '', array $args = array() ): void {
	if ( $post && $post->post_type === 'post' ) {
		echo helsinki_entry_published_date( $post );
	}
}

function helsinki_provide_entry_categories( WP_Post $post = null, string $type = '', array $args = array() ): void {
	if ( ! $type && ! empty( get_the_category_list(', ') ) ) {
		echo helsinki_entry_categories( $post );
	}
}
