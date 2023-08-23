<?php

add_filter('sbsw_use_theme_templates', 'helsinki_sbsw_use_theme_templates', 10, 1);
function helsinki_sbsw_use_theme_templates($use_theme_templates) {
    return true;
}

function helsinki_sbsw_override_feed_settings($settings) {
    $settings['layout'] = 'masonry';
    $settings['itemspacing'] = 24;
    $settings['itemspacingvertical'] = 24;
    $settings['cols'] = '3';
    $settings['colsmobile'] = '1';
    $settings['masonrycols'] = '3';
    $settings['masonrycolsmobile'] = '1';
    $settings['masonrycolstablet'] = '3';
    $settings['minnum'] = 6;
    $settings['num'] = '6';
    $settings['numdesktop'] = '6';
    $settings['numtablet'] = '6';
    $settings['nummobile'] = '3';
    $settings['showfilter'] = false;
    $settings['masonryshowfilter'] = false;
    $settings['theme'] = 'inherit';
    $settings['background'] = '';
    $settings['cardborder'] = '';
    $settings['text1'] = '';
    $settings['text2'] = '';
    $settings['postElements'] = array(
        'avatar',
        'username',
        'text',
        'media',
        'date',
        'summary',
    );
    $settings['dateformat'] = 'custom';
    $settings['customdate'] = 'j.n.Y H:i';
    $settings['dateFont'] = array(
        'family' => 'inherit',
        'weight' => '400',
        'size' => '16',
        'height' => '',
    );
    $settings['dateBeforeText'] = '';
    $settings['dateAfterText'] = '';
    $settings['showbutton'] = true;
    $settings['loadButtonColor'] = '';
    $settings['loadButtonBg'] = '';
    $settings['loadButtonHoverColor'] = '';
    $settings['loadButtonHoverBg'] = '';
    $settings['textlength'] = 10000;
    $settings['helsinki_theme_modified'] = date( 'Y-m-d H:i:s' );

    return $settings;
}

function helsinki_sbsw_check_feed_settings() {
    global $wpdb;
    $feeds_table_name = $wpdb->prefix . 'sw_feeds';
    $feeds = $wpdb->get_results("SELECT * FROM $feeds_table_name", ARRAY_A);

    foreach ($feeds as $feed) {
        $settings = json_decode($feed['settings'], true);
        if (!isset($settings['helsinki_theme_modified']) || strtotime($settings['helsinki_theme_modified']) < strtotime($feed['last_modified'])) {
            $settings = helsinki_sbsw_override_feed_settings($settings);

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
add_action('init', 'helsinki_sbsw_check_feed_settings');
