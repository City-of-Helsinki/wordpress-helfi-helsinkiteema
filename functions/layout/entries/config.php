<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function helsinki_entry_title_heading_level( WP_Post $post = null ): int {
	$level = apply_filters( 'helsinki_entry_title_heading_level', 3, $post );

	return max( 1, min( 6, $level ) );
}

function helsinki_entry_image_icon_name(): string {
	return helsinki_theme_mod( 'helsinki_general_icon', 'placeholder_icon', 'abstract-3' );
}

function helsinki_entry_default_image_id( int $post_id ): int {
	$img_id = 0;
	foreach ( get_the_category( $post_id ) as $category ) {
		$img_id = (int) helsinki_category_featured_image( $category->term_id );

		if ( $img_id ) {
			break;
		}
	}

	if ( ! $img_id ) {
		$img_id = (int) helsinki_category_featured_image( (int) get_option( 'default_category', 0 ) );
	}

	return apply_filters( 'helsinki_entry_default_image_id', $img_id, $post_id );
}
