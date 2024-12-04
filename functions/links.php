<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

//add_filter( 'helsinki_content_output', 'helsinki_add_links_symbols', 100, 1 );
add_filter( 'helsinki_call_to_action_buttons', 'helsinki_add_links_symbols', 100, 1 );
add_filter( 'helsinki_sidebar_output', 'helsinki_add_links_symbols', 100, 1 );
add_filter( 'render_block', 'helsinki_links_parse_blocks', 100, 2 );
add_filter( 'helsinki_header_output', 'helsinki_add_links_symbols', 100, 1 );
add_filter( 'helsinki_footer_output', 'helsinki_add_links_symbols', 100, 1 );
add_filter( 'helsinki_404_output', 'helsinki_add_links_symbols', 100, 1 );

function helsinki_add_links_symbols( string $content = '', string $custom_classes = 'inline-icon', bool $handle_local = false ): string {
	$handler = new Helsinki_Link_Symbol_Handler( helsinki_get_home_url(), $handle_local );

    return $handler->add_symbols( $content, $custom_classes );
}

function helsinki_get_home_url(): string {
	// get the site url from options, because plugins can change it from get_home_url()
	$url = get_option( 'home', '' );
    return preg_replace('/^https?:\/\//', '', $url);
}

function helsinki_links_parse_blocks( $block_content = '', $block = [] ) {
	$blocksToParse= [
		'core/button',
		'core/paragraph',
		'core/heading',
		'core/list',
		'core/quote',
		'core/table',
		null,
		'helsinki-linkedevents/grid',
		'helsinki-tpr/unit',
        'hds-wp/rss-feed',
        'hds-wp/banner',
        'hds-wp/image-text',
        'hds-wp/image-banner',
        'hds-wp/map',
        'hds-wp/video',
        'hds-wp/links',
        'hds-wp/link-list-cards',
	];

    $custom_classes = [
        'hds-wp/links' => '',
    ];

	if ( ! in_array( $block['blockName'], $blocksToParse, true ) ) {
		return $block_content;
	}

	return helsinki_add_links_symbols( $block_content, in_array( $block['blockName'], $custom_classes, true ) ? $custom_classes[$block['blockName']] : 'inline-icon' );
}
