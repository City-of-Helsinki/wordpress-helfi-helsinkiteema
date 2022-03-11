<?php

/**
  * Configuration
  */
function helsinki_post_table_of_contents_enabled() {
	$enabled = get_post_meta( get_queried_object_id(), 'table_of_contents_enabled', true );
	return apply_filters(
		'helsinki_post_table_of_contents_enabled',
		! empty( $enabled ),
		get_queried_object_id()
	);
}

function helsinki_post_table_of_contents_default_title() {
	return apply_filters(
		'helsinki_post_table_of_contents_default_title',
		__( 'Table of Contents', 'helsinki-universal' )
	);
}

function helsinki_post_table_of_contents_title() {
	$title = get_post_meta( get_queried_object_id(), 'table_of_contents_title', true );
	return apply_filters(
		'helsinki_post_table_of_contents_title',
		! empty( $title ) ? $title : helsinki_post_table_of_contents_default_title(),
		get_queried_object_id()
	);
}

/**
  * Filter
  */
function helsinki_add_ids_to_heading_blocks( $block_content, $block ) {
	if ( 'core/heading' !== $block['blockName'] ) {
		return $block_content;
	}
	if ( false !== strpos( $block_content, ' id="' ) ) {
		return $block_content;
	}
	// h[1-6] to match all levels
	return preg_replace_callback(
		"#<(h2)>(.*?)</\\1>#",
		"helsinki_add_id_to_heading_block",
		$block_content
	);
}

function helsinki_add_id_to_heading_block( $match ) {
	return sprintf(
		'<%1$s id="%2$s">%3$s</%1$s>',
		$match[1],
		sanitize_title_with_dashes( $match[2] ),
		$match[2]
	);
}

/**
  * Classes
  */
function helsinki_table_of_contents_body_class( array $classes ) {
	return helsinki_add_body_class_has_n( $classes, 'table-of-contents' );
}

/**
  * Element
  */
function helsinki_post_table_of_contents() {
	$post = get_post();

	$items = helsinki_post_content_heading_link_list_items(
		parse_blocks( $post->post_content )
	);

	if ( ! $items ) {
		return;
	}

	get_template_part(
		'partials/content/parts/table-of-contents',
		apply_filters( 'helsinki_post_table_of_contents_name', null ),
		apply_filters(
			'helsinki_post_table_of_contents_args',
			array(
				'title' => helsinki_post_table_of_contents_title(),
				'items' => $items,
			)
		)
	);
}

function helsinki_post_content_heading_link_list_items( $blocks ) {
	$out = array();

	foreach ( $blocks as $index => $block ) {

		if ( 'core/heading' === $block['blockName']  ) {
			$level = $block['attrs']['level'] ?? '';
			if ( $level && 2 !== $level ) {
				continue;
			}

			// Heading content
			$text = strip_tags( $block['innerHTML'] );

			// Heading ID
			preg_match( '/id="([^"]*)"/', $block['innerHTML'], $id );
			$out[] = sprintf(
				'<li><a href="#%s">%s</a></li>',
				$id[1] ?? sanitize_title_with_dashes( $text ),
				$text
			);

        } else if ( ! empty( $block['innerBlocks'] ) ) {
            $out = array_merge( $out,
				helsinki_post_content_heading_link_list_items( $block['innerBlocks'] )
			);
        }

	}

	return $out;
}
