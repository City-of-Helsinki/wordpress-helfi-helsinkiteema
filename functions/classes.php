<?php

/**
  * Body
  */
function helsinki_append_body_classes( array $body, $class ) {
	if ( is_array( $class ) ) {
		return array_merge( $body, $class );
	} else {
		$body[] = (string) $class;
		return $body;
	}
}

function helsinki_add_body_class_has_n( array $body, string $class ) {
	return helsinki_append_body_classes( $body, 'has-' . $class );
}

/**
  * Element
  */
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
