<?php

add_action( 'init', 'helsinki_block_editor_meta' );
function helsinki_block_editor_meta() {
	register_post_meta(
		'page',
		'hero_cta_url',
		array(
	    'show_in_rest' => true,
	    'single' => true,
	    'type' => 'string',
			'sanitize_callback' => function($meta_value, $meta_key, $meta_type) {
				return esc_url_raw( $meta_value );
			},
		)
	);
	register_post_meta(
		'page',
		'hero_cta_text',
		array(
	    'show_in_rest' => true,
	    'single' => true,
	    'type' => 'string',
			'sanitize_callback' => function($meta_value, $meta_key, $meta_type) {
				return sanitize_text_field( $meta_value );
			},
		)
	);
	register_post_meta(
		'page',
		'hero_cta_2_url',
		array(
	    'show_in_rest' => true,
	    'single' => true,
	    'type' => 'string',
			'sanitize_callback' => function($meta_value, $meta_key, $meta_type) {
				return esc_url_raw( $meta_value );
			},
		)
	);
	register_post_meta(
		'page',
		'hero_cta_2_text',
		array(
	    'show_in_rest' => true,
	    'single' => true,
	    'type' => 'string',
			'sanitize_callback' => function($meta_value, $meta_key, $meta_type) {
				return sanitize_text_field( $meta_value );
			},
		)
	);

	register_post_meta(
		'page',
		'hero_layout_full',
		array(
	    'show_in_rest' => true,
	    'single' => true,
	    'type' => 'boolean',
			'sanitize_callback' => function($meta_value, $meta_key, $meta_type) {
				return boolval( $meta_value );
			},
		)
	);

	register_post_meta(
		'page',
		'hide_featured_image',
		array(
	    'show_in_rest' => true,
	    'single' => true,
	    'type' => 'boolean',
			'sanitize_callback' => function($meta_value, $meta_key, $meta_type) {
				return boolval( $meta_value );
			},
		)
	);
}

add_action('enqueue_block_editor_assets', 'helsinki_block_editor_scripts');
function helsinki_block_editor_scripts() {
	global $post;
	if ( ! isset($post->post_type) || 'page' !== $post->post_type ) {
		return;
	}

	$scripts = get_template_directory_uri() . '/block-editor/scripts/';
	wp_enqueue_script(
		'helsinki-sidebar-plugin',
		$scripts . 'sidebar-plugin.js',
		array(
			'wp-plugins',
			'wp-edit-post',
			'wp-element',
			'wp-components',
			'wp-data',
			'wp-compose',
    )
	);

	$front_page_id = function_exists('pll_get_post') && function_exists('pll_current_language') ?
	pll_get_post( get_option('page_on_front'), pll_current_language() ) :
	get_option('page_on_front');

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
	global $post;
	if ( ! isset($post->post_type) || 'page' !== $post->post_type ) {
		return;
	}

	$styles = get_template_directory_uri() . '/block-editor/styles/';
	wp_enqueue_style(
		'helsinki-sidebar-plugin',
		$styles . 'sidebar-plugin.css'
	);
}
