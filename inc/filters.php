<?php

/**
  * Clean up the archive title
  */
function helsinki_get_the_archive_title_prefix( $prefix ) {
  return '<span class="prefix">' . $prefix . '</span>';
}
add_filter( 'get_the_archive_title_prefix', 'helsinki_get_the_archive_title_prefix' );

/**
  * Format view description
  */
add_filter( 'helsinki_view_description', 'do_blocks', 9 );
add_filter( 'helsinki_view_description', 'wptexturize' );
add_filter( 'helsinki_view_description', 'convert_smilies', 20 );
add_filter( 'helsinki_view_description', 'wpautop' );
add_filter( 'helsinki_view_description', 'shortcode_unautop' );
add_filter( 'helsinki_view_description', 'prepend_attachment' );
add_filter( 'helsinki_view_description', 'wp_filter_content_tags' );
add_filter( 'helsinki_view_description', 'do_shortcode', 11 ); // AFTER wpautop().
add_filter( 'helsinki_view_description', 'capital_P_dangit', 11 );

/**
  * Excerpts
  */
function helsinki_excerpt_more_html() {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'helsinki_excerpt_more_html' );

function helsinki_excerpt_character_length( $text, $raw_excerpt ) {
	return substr(
		$raw_excerpt,
		0,
		apply_filters( 'helsinki_excerpt_character_length', 195 )
	);
}
add_filter( 'wp_trim_excerpt', 'helsinki_excerpt_character_length', 999, 2 );

/**
  * Comment Form
  */
function helsinki_comment_form_default_fields( $fields ) {
  unset( $fields['url'] );
  return $fields;
}
add_filter('comment_form_default_fields', 'helsinki_comment_form_default_fields');

/**
  * Widgets
  */
function helsinki_widget_tag_cloud_args( $default ) {
  $edit = array(
    'smallest'  => '13',
    'largest'   => '13',
    'unit'      => 'px',
    'separator' => '',
    'number'    => 20,
    'orderby'   => 'count',
    'order'     => 'DESC',
  );
  return array_merge( $default, $edit );
}
add_filter( 'widget_tag_cloud_args', 'helsinki_widget_tag_cloud_args');

/**
  * Blocks
  */
function helsinki_alignfull_block_hds_customizations( $block_content, $block ) {
	if (
		$block_content &&
		isset( $block['attrs']['align'] ) &&
		'full' === $block['attrs']['align']
	) {
		$search = $replace = array();

		$hasKoros = in_array( $block['blockName'], array('core/cover', 'core/group') );
		if ( $hasKoros ) {
			$search[] = 'alignfull';
			$replace[] = 'alignfull has-koros';
		}

		$search[] = 'inner-container';
		$replace[] = 'inner-container hds-container';

		$block_content = str_replace( $search, $replace, $block_content );

		if ( $hasKoros ) {
			$block_content .= helsinki_block_koros(
				'core/cover' !== $block['blockName']
			);
		}
	}
	return $block_content;
}
add_filter('render_block', 'helsinki_alignfull_block_hds_customizations', 10, 2);
