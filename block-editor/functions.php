<?php

/**
  * Sanitize callbacks
  */
function helsinki_block_editor_meta_sanitize_string( $value, $key, $type ) {
	return sanitize_text_field( $value );
}

function helsinki_block_editor_meta_sanitize_url( $value, $key, $type ) {
	return esc_url_raw( $value );
}

function helsinki_block_editor_meta_sanitize_bool( $value, $key, $type ) {
	return boolval( $value );
}

function helsinki_block_editor_meta_sanitize_wp_editor( $value, $key, $type ) {
	return wp_kses_post( $value );
}