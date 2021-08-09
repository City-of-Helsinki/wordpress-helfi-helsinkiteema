<?php

function helsinki_element_classes( string $type, array $classes = array() ) {
  $classes = apply_filters(
	"helsinki_{$type}_classes",
	array_filter( $classes )
  );
  if ( $classes && is_array($classes) ) {
    echo esc_attr( implode( ' ', $classes ) );
  }
}

function helsinki_sidebar_classes() {
  helsinki_element_classes(
    'sidebar',
    array(
      'sidebar',
    )
  );
}

/**
  * Hero
  */
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

	helsinki_element_classes(
		'hero',
		$classes
  );
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
