<?php

function helsinki_block_editor_hero_style_options() {
	return array(
		'diagonal' => esc_html__( 'Diagonal', 'helsinki-universal' ),
		'background-image' => esc_html__( 'Background image', 'helsinki-universal' ),
		'image-right' => esc_html__( 'Image on right', 'helsinki-universal' ),
		'image-left' => esc_html__( 'Image on left', 'helsinki-universal' ),
	);
}

function helsinki_block_editor_meta_config() {
	return apply_filters(
		'helsinki_block_editor_meta_config',
		array(
			array(
				'type' => 'page',
				'key' => 'disable_page_hero',
				'args' => array(
					'show_in_rest' => true,
					'single' => true,
					'type' => 'boolean',
					'sanitize_callback' => 'helsinki_block_editor_meta_sanitize_bool',
				),
			),
			array(
				'type' => 'page',
				'key' => 'hero_cta_url',
				'args' => array(
					'show_in_rest' => true,
					'single' => true,
					'type' => 'string',
					'sanitize_callback' => 'helsinki_block_editor_meta_sanitize_url',
				),
			),
			array(
				'type' => 'page',
				'key' => 'hero_cta_text',
				'args' => array(
					'show_in_rest' => true,
					'single' => true,
					'type' => 'string',
					'sanitize_callback' => 'helsinki_block_editor_meta_sanitize_string',
				),
			),
			array(
				'type' => 'page',
				'key' => 'hero_cta_2_url',
				'args' => array(
					'show_in_rest' => true,
					'single' => true,
					'type' => 'string',
					'sanitize_callback' => 'helsinki_block_editor_meta_sanitize_url',
				),
			),
			array(
				'type' => 'page',
				'key' => 'hero_cta_2_text',
				'args' => array(
					'show_in_rest' => true,
					'single' => true,
					'type' => 'string',
					'sanitize_callback' => 'helsinki_block_editor_meta_sanitize_string',
				),
			),
			// array(
			// 	'type' => 'page',
			// 	'key' => 'hero_layout_full',
			// 	'args' => array(
			// 		'show_in_rest' => true,
			// 		'single' => true,
			// 		'type' => 'boolean',
			// 		'sanitize_callback' => 'helsinki_block_editor_meta_sanitize_bool',
			// 	),
			// ),
			array(
				'type' => 'page',
				'key' => 'hero_layout_style',
				'args' => array(
					'show_in_rest' => true,
					'single' => true,
					'type' => 'string',
					'sanitize_callback' => 'helsinki_block_editor_meta_sanitize_string',
				),
			),
			array(
				'type' => 'page',
				'key' => 'hide_featured_image',
				'args' => array(
					'show_in_rest' => true,
					'single' => true,
					'type' => 'boolean',
					'sanitize_callback' => 'helsinki_block_editor_meta_sanitize_bool',
				),
			),
			array(
				'type' => 'page',
				'key' => 'table_of_contents_enabled',
				'args' => array(
					'show_in_rest' => true,
					'single' => true,
					'type' => 'boolean',
					'sanitize_callback' => 'helsinki_block_editor_meta_sanitize_bool',
				),
			),
			array(
				'type' => 'page',
				'key' => 'table_of_contents_title',
				'args' => array(
					'show_in_rest' => true,
					'single' => true,
					'type' => 'string',
					'sanitize_callback' => 'helsinki_block_editor_meta_sanitize_string',
				),
			),
		)
	);
}
