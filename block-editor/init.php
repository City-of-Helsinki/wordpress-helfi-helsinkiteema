<?php

add_action( 'init', 'helsinki_block_editor_meta' );
function helsinki_block_editor_meta() {
	foreach ( helsinki_block_editor_meta_config() as $config ) {
		register_post_meta(	$config['type'], $config['key'], $config['args'] );
	}
}

add_action('enqueue_block_editor_assets', 'helsinki_block_editor_scripts');
function helsinki_block_editor_scripts() {
	if ( ! helsinki_block_editor_assets_enabled() ) {
		return;
	}

	wp_enqueue_script(
		'helsinki-sidebar-plugin',
		get_template_directory_uri() . '/block-editor/scripts/sidebar-plugin.js',
		array(
			'wp-plugins',
			'wp-edit-post',
			'wp-element',
			'wp-components',
			'wp-data',
			'wp-compose',
    	)
	);

	$front_page_id = apply_filters( 'helsinki_polylang_active', false ) ? pll_get_post( get_option('page_on_front'), pll_current_language() ) : get_option('page_on_front');

	wp_add_inline_script(
		'helsinki-sidebar-plugin',
		'const HelsinkiUniversalSidebar = ' . json_encode( array(
	    'isFrontPage' => ! empty( $_GET['post'] ) ? absint($front_page_id) === absint($_GET['post']) : false,
		) ),
		'before'
	);
}

add_action( 'enqueue_block_assets', 'helsinki_block_editor_styles' );
function helsinki_block_editor_styles() {
	if ( ! helsinki_block_editor_assets_enabled() ) {
		return;
	}

	$styles = get_template_directory_uri() . '/block-editor/styles/';
	wp_enqueue_style(
		'helsinki-sidebar-plugin',
		$styles . 'sidebar-plugin.css'
	);
}

function helsinki_block_editor_assets_enabled() {
	global $post;
	return apply_filters(
		'helsinki_block_editor_assets_enabled',
		isset( $post->post_type ) && 'page' === $post->post_type,
		$post
	);
}
