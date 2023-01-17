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

function helsinki_post_table_of_contents_title() {
	return apply_filters(
		'helsinki_post_table_of_contents_title',
		__( 'On this page', 'helsinki-universal' ),
		get_queried_object_id()
	);
}

/**
  * Filter
  */
function helsinki_add_ids_to_headings( $block_content, $block ) {
	/*if ( 'core/heading' !== $block['blockName'] ) {
		return $block_content;
	}*/
	/*if ( false !== strpos( $block_content, ' id="' ) ) {
		return $block_content;
	}*/
	// h[1-6] to match all levels
	/*return preg_replace_callback(
		"#<(h2)>(.*?)</\\1>#",
		"helsinki_add_id_to_heading_block",
		$block_content
	);*/
	preg_match_all('/(\<h2[^\>]*\>)(.*)(<\/h2>)/sU', $block_content, $matches);
	if (!empty($matches[0])) {
		preg_match( '/id="([^"]*)"/', $matches[1][0], $id );
		if (empty($id)) {
			$text = strip_tags( $matches[2][0] );
			$block_content = str_replace( $block_content, preg_replace_callback(
				"/\<((h2)[^\>]*)\>(.*)(<\/h2>)/sU",
				"helsinki_add_id_to_heading",
				$block_content		
			), $block_content );
			//var_dump($block_content);
		}
	}
	return $block_content;
}

function helsinki_add_id_to_heading( $match ) {
	return sprintf(
		'<%1$s id="%2$s">%3$s</%4$s>',
		$match[1],
		sanitize_title_with_dashes( strip_tags( remove_accents($match[3]) ) ),
		$match[3],
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

function helsinki_post_content_heading_link_list_items( $blocks, $level = 2 ) {
	$out = array();

	//block name => block version
	$multipleHeadings =	
	array(
		'hds-wp/accordion' => 2,
	);

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
				$id[1] ?? sanitize_title_with_dashes( remove_accents( $text  ) ),
				$text
			);

        } else if ( 'core/group' === $block['blockName'] ){
			if ( ! empty( $block['innerBlocks'] ) ) {
				$out = array_unique(array_merge( $out,
					helsinki_post_content_heading_link_list_items( $block['innerBlocks'] )
				));
			}
		} else {
			$rendered_block = render_block( $block ); //server-side rendered blocks require this step for the final HTML...
			preg_match_all('/(<h2[^\>]*>)(.*)(<\/h2>)/sU', $rendered_block, $matches);
			if (!empty($matches[0])) {
				//register multiple heading from block; required for some server-side rendered blocks
				if ((array_key_exists($block['blockName'], $multipleHeadings) && isset($block['attrs']['blockVersion']) && $block['attrs']['blockVersion'] >= $multipleHeadings[$block['blockName']]) || $block['blockName'] == null) {
					for ($i = 0; $i < count($matches[0]); $i++) {
						$text = strip_tags( $matches[2][$i] );
						preg_match( '/id="([^"]*)"/', $matches[1][$i], $id );
						$markup = sprintf(
							'<li><a href="#%s">%s</a></li>',
							$id[1] ?? sanitize_title_with_dashes( remove_accents( $text ) ),
							$text
						);
						if (!in_array($markup, $out)) {
							$out[] = $markup;
						}	
					}
				}
				//register only first heading
				else {
					$text = strip_tags( $matches[2][0] );
					preg_match( '/id="([^"]*)"/', $matches[1][0], $id );
					$markup = sprintf(
						'<li><a href="#%s">%s</a></li>',
						$id[1] ?? sanitize_title_with_dashes( remove_accents( $text ) ),
						$text
					);
					if (!in_array($markup, $out)) {
						$out[] = $markup;
					}
				}
			}

			if ( ! empty( $block['innerBlocks'] ) ) {
				$out = array_unique(array_merge( $out,
					helsinki_post_content_heading_link_list_items( $block['innerBlocks'] )
				));
			}
		}

	}

	return $out;
}
