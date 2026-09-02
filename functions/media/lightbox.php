<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

add_filter( 'render_block_data', 'helsinki_disable_image_block_lightbox' );
function helsinki_disable_image_block_lightbox( array $parsed_block ) {
	if (
		isset( $parsed_block['blockName'] )
		&& ('core/image' === $parsed_block['blockName'])
	) {
		unset( $parsed_block['attrs']['lightbox'] );
	}

	return $parsed_block;
}
