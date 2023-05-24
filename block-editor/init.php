<?php

add_filter( 'block_editor_settings_all', 'helsinki_block_editor_settings', 10);

add_action( 'init', 'helsinki_block_editor_meta' );
function helsinki_block_editor_meta() {
	foreach ( helsinki_block_editor_meta_config() as $config ) {
		register_post_meta(	$config['type'], $config['key'], $config['args'] );
	}
}

add_action('add_meta_boxes', 'helsinki_block_editor_add_metaboxes');

add_action('enqueue_block_editor_assets', 'helsinki_block_editor_scripts');
function helsinki_block_editor_scripts() {
	if ( ! is_admin() ) {
		return;
	}

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

	wp_enqueue_script(
		'helsinki-editor-metaboxes',
		get_template_directory_uri() . '/block-editor/scripts/metaboxes.js',
		array(
			'jquery',
			'jquery-ui-core',
			'jquery-ui-sortable',
    	), 
		null, 
		true
	);


	wp_add_inline_script(
		'helsinki-sidebar-plugin',
		'const HelsinkiUniversalSidebar = ' . json_encode( array(
	    	'isFrontPage' => helsinki_id_is_front_page( $_GET['post'] ?? 0 ),
			'heroStyleOptions' => helsinki_block_editor_hero_style_options(),
		) ),
		'before'
	);
}

add_action( 'enqueue_block_assets', 'helsinki_block_editor_styles' );
function helsinki_block_editor_styles() {
	if ( ! is_admin() ) {
		return;
	}

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
