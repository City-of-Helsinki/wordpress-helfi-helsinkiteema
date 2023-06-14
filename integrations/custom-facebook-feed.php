<?php
function helsinki_cff_check_feed_settings() {
    global $wpdb;
    $feeds_table_name = $wpdb->prefix . 'cff_feeds';
    $feeds = $wpdb->get_results("SELECT * FROM $feeds_table_name", ARRAY_A);

    foreach ($feeds as $feed) {
        $settings = json_decode($feed['settings'], true);
        if (!isset($settings['helsinki_theme_modified']) || strtotime($settings['helsinki_theme_modified']) < strtotime($feed['last_modified'])) {
            $settings = helsinki_cff_override_feed_settings($settings);

            $wpdb->update(
                $feeds_table_name,
                array(
                    'settings' => json_encode($settings)
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

    $settings['feedtemplate'] = 'simple_masonry';
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
    $settings['include'] = array("text","desc","sharedlinks","date","media","medialink","eventtitle","eventdetails","social","link","likebox","author");
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
    $settings['showlikebox'] = 'off';
    $settings['disablelightbox'] = 'on';
    $settings['helsinki_theme_modified'] = date( 'Y-m-d H:i:s' );

    return $settings;
}
