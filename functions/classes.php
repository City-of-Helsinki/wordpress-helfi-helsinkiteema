<?php

/**
  * Body
  */
function helsinki_append_body_classes( array $body, $class ): array {
	if ( is_array( $class ) ) {
		return array_merge( $body, $class );
	} else {
		$body[] = (string) $class;
		return $body;
	}
}

function helsinki_add_body_class_has_n( array $body, string $class ): array {
	return helsinki_append_body_classes( $body, 'has-' . $class );
}

function helsinki_add_first_block_body_class( array $body ): array {
	if ( is_page() ) {
		$post = get_post( get_queried_object_id() );

		if ( $post instanceof WP_Post ) {
			$processor = new WP_Block_Processor( $post->post_content );

			if ( $processor->next_block() ) {
				$body[] = sprintf(
					'first-block-%s',
					str_replace( '/', '-', $processor->get_block_type() )
				);
			}
		}
	}

	return $body;
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
