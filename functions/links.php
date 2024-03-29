<?php

//add_filter( 'helsinki_content_output', 'helsinki_add_links_symbols', 100, 1 );
add_filter( 'helsinki_call_to_action_buttons', 'helsinki_add_links_symbols', 100, 1 );
add_filter( 'helsinki_sidebar_output', 'helsinki_add_links_symbols', 100, 1 );
add_filter( 'render_block', 'helsinki_links_parse_blocks', 100, 2 );
add_filter( 'helsinki_header_output', 'helsinki_add_links_symbols', 100, 1 );
add_filter( 'helsinki_footer_output', 'helsinki_add_links_symbols', 100, 1 );
add_filter( 'helsinki_404_output', 'helsinki_add_links_symbols', 100, 1 );

function helsinki_add_links_symbols($content = '', $custom_classes = 'inline-icon') {
    preg_match_all('/(?<link>\s*href="(?<href>[^"]*)"[^>]*>)(?<content>(?:(?!<div|<\/a|<\/svg|<img).)*(?<svginner><\/svg>)?)\s*(?<endtag><\/a>)(?<svgafter><svg)?/s', $content, $matches);


    $url = get_option('home'); // get the site url from options, because plugins can change it from get_home_url()
    $url = preg_replace('/^https?:\/\//', '', $url);


    for($i = 0; $i < count($matches[0]); $i++) {
        if ( str_starts_with( $matches['href'][$i], 'mailto:' ) ) {
            $content = str_replace($matches[0][$i], helsinki_build_replacement_link($matches['link'][$i], $matches['content'][$i], $matches['svginner'][$i], $matches['endtag'][$i], $matches['svgafter'][$i], 'mail', $custom_classes), $content);
        }
        else if ( str_starts_with( $matches['href'][$i], 'tel:' ) ) {
            $content = str_replace($matches[0][$i], helsinki_build_replacement_link($matches['link'][$i], $matches['content'][$i], $matches['svginner'][$i], $matches['endtag'][$i], $matches['svgafter'][$i], 'phone', $custom_classes), $content);
        }
        else if (!str_contains(preg_replace('/^https?:\/\//', '', $matches['href'][$i]), $url) && !str_starts_with( $matches['href'][$i], '#' ) && !str_starts_with( $matches['href'][$i], '/' )) {
            $content = str_replace($matches[0][$i], helsinki_build_replacement_link($matches['link'][$i], $matches['content'][$i], $matches['svginner'][$i], $matches['endtag'][$i], $matches['svgafter'][$i], 'external', $custom_classes), $content);
        }
    }
    return $content;
}

function helsinki_build_replacement_link($begintag, $content, $svginner, $endtag, $svgafter, $linkType, $custom_classes = 'inline-icon') {
    $ariaLabel = '';
    $extra_attrs = '';
    $extra_classes = $custom_classes;
    $icon = '';

    if ($linkType == 'mail') {
        $ariaLabel = __('(Link opens default mail program)', 'helsinki-universal');
        $extra_attrs = 'data-protocol="mailto"';
        if (empty($svgafter) && empty($svginner)) {
            $icon = helsinki_get_svg_icon('envelope', $extra_classes, $ariaLabel);
        }
    }
    else if ($linkType == 'phone') {
        $ariaLabel = __('(Link starts a phone call)', 'helsinki-universal');
        $extra_attrs = 'data-protocol="tel"';
        if (empty($svgafter) && empty($svginner)) {
            $icon = helsinki_get_svg_icon('phone', $extra_classes, $ariaLabel);
        }
    }
    else if ($linkType == 'external') {
        $ariaLabel = __('(Link leads to external service)', 'helsinki-universal');
        $extra_attrs = 'data-is-external="true"';
        if (empty($svgafter) && empty($svginner)) {
            $icon = helsinki_get_svg_icon('link-external', $extra_classes, $ariaLabel);
        }
    }

    $newBeginTag = str_replace('>', $extra_attrs . '>', $begintag );

    return sprintf('%s%s%s%s',
        $newBeginTag,
        $content . $icon,
        $endtag,
        $svgafter
    );
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

