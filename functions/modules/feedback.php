<?php

function helsinki_feedback_buttons() {
    $apiKeys = array(
        'fi' => 'gjhfvh3m4xcvnred',
        'sv' => 'mwft0afec1l7d6g1',
        'en' => '7zfblho0j7sm0url',
    );
    $current_lang = function_exists('pll_current_language') ? pll_current_language('slug') : substr( get_bloginfo('language'), 0, 2 );

    if ( ! isset($apiKeys[$current_lang]) ) {
        return;
    }

    $args = array(
        'apiKey' => $apiKeys[$current_lang],
        'title' => get_the_title(),
        'postId' => get_the_ID(),
        'category' => preg_replace('/^https?:\/\//', '', get_option('home')),
        'disableFonts' => true,
    );
    $args = apply_filters('helsinki_feedback_buttons_args', $args);

    get_template_part(
        'partials/feedback/feedback',
        null,
        $args,
    );
}

function helsinki_feedback_buttons_body_class( $classes ) {
	return helsinki_add_body_class_has_n( $classes, 'rns' );
}