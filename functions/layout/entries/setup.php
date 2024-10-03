<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

add_filter( 'helsinki_entry_title_heading_level', 'helsinki_filter_entry_title_heading_level', 10, 2 );

add_action( 'helsinki_entry_content_before', 'helsinki_provide_default_entry_image', 10, 3 );

add_action( 'helsinki_entry_content', 'helsinki_provide_grid_entry_image', 10, 3 );
add_action( 'helsinki_entry_content', 'helsinki_provide_entry_title', 20, 3 );
add_action( 'helsinki_entry_content', 'helsinki_provide_entry_excerpt', 30, 3 );

add_action( 'helsinki_entry_meta', 'helsinki_provide_entry_categories', 10, 3 );
add_action( 'helsinki_entry_meta', 'helsinki_provide_entry_date', 20, 3 );
