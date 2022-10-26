<?php

add_filter( 'the_content', 'helsinki_add_links_symbols', 100, 1 );
add_filter( 'helsinki_header_output', 'helsinki_add_links_symbols', 100, 1 );
add_filter( 'helsinki_footer_output', 'helsinki_add_links_symbols', 100, 1 );

function helsinki_add_links_symbols($content = '') {
    preg_match_all('/(?<link><a href="(?<href>[^"]*)"[^>]*>)(?<content>[^<]*)(?<endtag><\/a>)(?<svgafter><svg)?/s', $content, $matches);
    $url = get_site_url();
    for($i = 0; $i < count($matches[0]); $i++) {
        if ( str_starts_with( $matches['href'][$i], 'mailto:' ) ) {
            $content = str_replace($matches[0][$i], helsinki_build_replacement_link($matches['link'][$i], $matches['content'][$i], $matches['endtag'][$i], $matches['svgafter'][$i], 'mail'), $content);
        }
        else if ( str_starts_with( $matches['href'][$i], 'tel:' ) ) {
            $content = str_replace($matches[0][$i], helsinki_build_replacement_link($matches['link'][$i], $matches['content'][$i], $matches['endtag'][$i], $matches['svgafter'][$i], 'phone'), $content);
        }
        else if (!str_contains($matches['href'][$i], $url)) {
            $content = str_replace($matches[0][$i], helsinki_build_replacement_link($matches['link'][$i], $matches['content'][$i], $matches['endtag'][$i], $matches['svgafter'][$i], 'external'), $content);
        }
    }
    return $content;
}

function helsinki_build_replacement_link($begintag, $content, $endtag, $svgafter, $linkType) {
    $ariaLabel = '';
    $extra_attrs = '';
    $icon = '';
    if ($linkType == 'mail') {
        $ariaLabel = sprintf('aria-label="%s"', __('(Link opens default mail program)', 'helsinki-universal'));
        $extra_attrs = 'data-protocol="mailto"';
        if (empty($svgafter)) {
            $icon = helsinki_get_svg_icon('envelope', 'inline-icon');
        }
    }
    else if ($linkType == 'phone') {
        $ariaLabel = sprintf('aria-label="%s"', __('(Link starts a phone call)', 'helsinki-universal'));
        $extra_attrs = 'data-protocol="tel"';
        if (empty($svgafter)) {
            $icon = helsinki_get_svg_icon('phone', 'inline-icon');
        }
    }
    else if ($linkType == 'external') {
        $ariaLabel = sprintf('aria-label="%s"', __('(Link leads to external service)', 'helsinki-universal'));
        $extra_attrs = 'data-is-external="true"';
        if (empty($svgafter)) {
            $icon = helsinki_get_svg_icon('link-external', 'inline-icon');
        }
    }

    $newBeginTag = str_replace('>', $ariaLabel . ' ' . $extra_attrs . '>', $begintag );

    return sprintf('%s%s%s%s',
        $newBeginTag,
        $content . $icon,
        $endtag,
        $svgafter
    );
}
