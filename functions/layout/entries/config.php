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

function helsinki_entry_image_size(): string {
	return apply_filters( 'helsinki_entry_image_size', 'post-thumbnail' );
}

function helsinki_entry_default_image_id( int $post_id ): int {
	return apply_filters( 'helsinki_entry_default_image_id', 0, $post_id );
}

function helsinki_entry_image_icon_classes(): string {
	return implode(
		' ',
		apply_filters(
			'helsinki_entry_image_icon_classes',
			array( 'has-icon', helsinki_scheme_has_invert_color() ? 'has-invert-color' : '' )
		)
	);
}

function helsinki_entry_image_classes( bool $icon = false ): string {
	$class = 'entry__thumbnail';

	if ( $icon ) {
		$class .= ' ' . helsinki_entry_image_icon_classes();
	}

	return $class;
}

function helsinki_entry_has_placeholder_class( $args = array() ): bool {
	return isset( $args['attributes']['className'] )
		? strpos( $args['attributes']['className'], 'is-style-without-image' ) !== false
		: false;
}

function helsinki_entry_classes( string|array $classes = '' ): void {
	if ( is_string( $classes ) ) {
		$classes = array( $classes );
	}

	helsinki_element_classes( 'entry', $classes );
}
