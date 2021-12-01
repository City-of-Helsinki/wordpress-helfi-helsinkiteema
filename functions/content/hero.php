<?php

function helsinki_hero_styles() {
	$styles = apply_filters( 'helsinki_hero_styles', array() );
	if ( ! $styles ) {
		return;
	}

	$out = array();
	foreach ($styles as $key => $value) {
		$out[] = sprintf(
			'%s: %s;',
			sanitize_key( $key ),
			filter_var( $key, FILTER_VALIDATE_URL ) ? esc_url( $value ) : esc_attr( $value )
		);
	}

	echo implode(' ', $out);
}

function helsinki_hero_image( string $filter_name, string $size, bool $fixed = false, $post = null, $attr = '' ) {
	echo helsinki_image_with_wrap(
		get_the_post_thumbnail(
			$post,
			apply_filters( $filter_name, $size ),
			$attr
		),
		$fixed
	);
}

function helsinki_hero_classes(string $default = '') {
	$classes = array(
		$default,
	);

	if ( apply_filters( 'helsinki_hero_class_thumbnail', false ) ) {
		$classes[] = 'has-thumbnail';
	}

	if ( apply_filters( 'helsinki_hero_class_excerpt', false ) ) {
		$classes[] = 'has-excerpt';
	}

	if ( apply_filters( 'helsinki_hero_class_koros', false ) ) {
		$classes[] = 'has-koros';
	}

	if ( apply_filters( 'helsinki_hero_class_call_to_action', false ) ) {
		$classes[] = 'has-call-to-action';
	}

	if ( apply_filters( 'helsinki_hero_class_full_width', false ) ) {
		$classes[] = 'is-full-width';
	}

	helsinki_element_classes( 'hero', $classes );
}

function helsinki_hero_container_classes( string $default = '' ) {
	$classes = array(
		$default,
		'hds-container',
		'flex-container',
		'flex-container--align-center',
	);

	if ( apply_filters( 'helsinki_hero_container_class_content_reverse', false ) ) {
		$classes[] = 'flex-container--row-reverse';
	}

	helsinki_element_classes(
		'hero_container',
		$classes
  );
}
