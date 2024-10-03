<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( ! function_exists('helsinki_entry') ) {
	function helsinki_entry(): void {
		get_template_part('partials/loop/entry');
	}
}

if ( ! function_exists('helsinki_grid_entry') ) {
	function helsinki_grid_entry( $args = array() ): void {
		get_template_part( 'partials/loop/entry', 'grid', $args );
	}
}

if ( ! function_exists('helsinki_feed_entry') ) {
	function helsinki_feed_entry( $args = array() ): void {
		get_template_part( 'partials/loop/entry', 'feed', $args );
	}
}

if ( ! function_exists('helsinki_entries_load_more') ) {
	function helsinki_entries_load_more(): void {
		get_template_part( 'partials/loop/load-more' );
	}
}
