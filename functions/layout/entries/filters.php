<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function helsinki_filter_entry_title_heading_level( int $level, WP_Post $post = null ): int {
	return ( is_archive() || is_home() ) ? 2 : $level;
}
