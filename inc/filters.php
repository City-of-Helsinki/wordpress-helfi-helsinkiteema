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
function helsinki_full_width_block_customizations($parsed_block, $source_block) {
	if ( is_admin() ) {
		return $parsed_block;
	}

	$align = $parsed_block['attrs']['align'] ?? '';
	if ( 'full' === $align ) {
		$id = time() . rand(1,100) . rand(1,100);
		ob_start();
		helsinki_koros($id, false);
		$koros = ob_get_clean();
		$parsed_block['innerContent'][] = $koros;

		$parsed_block['innerContent'][0] = str_replace(
			'inner-container',
			'inner-container hds-container',
			$parsed_block['innerContent'][0]
		);
	}
	return $parsed_block;
}
add_filter('render_block_data', 'helsinki_full_width_block_customizations', 10, 2);
