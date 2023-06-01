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

function helsinki_cff_check_feed_settings() {
    global $wpdb;
    $feeds_table_name = $wpdb->prefix . 'cff_feeds';
    $feeds = $wpdb->get_results("SELECT * FROM $feeds_table_name", ARRAY_A);

    foreach ($feeds as $feed) {
        if (!isset($feed['settings']['helsinki_theme_modified']) || strtotime($feed['settings']['helsinki_theme_modified']) < strtotime($feed['last_modified'])) {
            $feed['settings'] = helsinki_cff_override_feed_settings($feed['settings']);

            $wpdb->update(
                $feeds_table_name,
                array(
                    'settings' => json_encode($feed['settings'])
                ),
                array(
                    'id' => $feed['id']
                )
            );
        }

        
    }
}
add_action('init', 'helsinki_cff_check_feed_settings');

function helsinki_cff_override_feed_settings($settings) {
    // convert $settings json to array
    $settings = json_decode($settings, true);

    $settings['feedtemplate'] = 'default';
    $settings['feedtype'] = 'timeline';
    $settings['feedlayout'] = 'masonry';
    $settings['height'] = '';
    $settings['num'] = '6';
    $settings['nummobile'] = '3';
    $settings['cols'] = '3';
    $settings['colstablet'] = '3';
    $settings['colsmobile'] = '1';
    $settings['colorpalette'] = 'inherit';
    $settings['showheader'] = '';
    $settings['poststyle'] = 'regular';
    $settings['sepsize'] = '1';
    $settings['sepcolor'] = '#f2f2f2';
    $settings['authorsize'] = '18';
    $settings['authorcolor'] = '#1a1a1a';
    $settings['textlength'] = '10000';
    $settings['textlink'] = '';
    $settings['textsize'] = '16';
    $settings['textcolor'] = '#';
    $settings['dateformat'] = 'custom';
    $settings['datecustom'] = 'j.n.Y H:i';
    $settings['beforedate'] = '';
    $settings['afterdate'] = '';
    $settings['datesize'] = '16';
    $settings['datecolor'] = '#666';
    $settings['oneimage'] = 'on';
    $settings['mediaposition'] = 'above';
    $settings['iconstyle'] = 'auto';
    $settings['socialtextcolor'] = '#666';
    $settings['sociallinkcolor'] = '#666';
    $settings['socialbgcolor'] = '#fff';
    $settings['expandcomments'] = '';
    $settings['showfacebooklink'] = 'false';
    $settings['showsharelink'] = 'false';
    $settings['showlikebox'] = '';
    $settings['helsinki_theme_modified'] = date( 'Y-m-d H:i:s' );

    //$settings = json_encode($settings);

    return $settings;
}
