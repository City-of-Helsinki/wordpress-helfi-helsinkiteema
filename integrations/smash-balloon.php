<?php

add_filter('sbi_use_theme_templates', 'helsinki_sbi_use_theme_templates', 10, 1);
function helsinki_sbi_use_theme_templates($use_theme_templates) {
    return true;
}

function helsinki_sbi_override_feed_settings($settings) {
    $settings['layout'] = 'grid';
    $settings['height'] = '';
    $settings['imagepadding'] = 8;
    $settings['imagepaddingunit'] = 'px';
    $settings['num'] = 8;
    $settings['nummobile'] = 4;
    $settings['cols'] = 4;
    $settings['colsmobile'] = 2;
    $settings['colstablet'] = 2;
    $settings['colorpalette'] = 'inherit';
    $settings['showheader'] = false;
    $settings['showcaption'] = false;
    $settings['captionlength'] = 10000;
    $settings['captioncolor'] = '#666';
    $settings['captionsize'] = 16;
    $settings['showlikes'] = false;
    $settings['disablelightbox'] = true;
    $settings['hovereffect'] = '';

    return $settings;
}

add_filter( 'helsinki_sbi_follow_output', 'helsinki_add_links_symbols', 100, 1 );