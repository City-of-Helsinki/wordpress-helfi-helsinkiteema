<?php

/**
 * @since 4.37.0
 */
function helsinki_feedback_buttons() {
    helsinki_deprecation_notice(
		__FUNCTION__,
		'integrations/askem.php'
	);
}

/**
 * @since 4.37.0
 */
function helsinki_feedback_buttons_body_class( $classes ) {
	helsinki_deprecation_notice(
		__FUNCTION__,
		'integrations/askem.php'
	);

	return $classes;
}

/**
 * @since 4.39.0
 */
if ( ! function_exists('helsinki_comments') ) {
	function helsinki_comments() {
		helsinki_deprecation_notice( __FUNCTION__, 'your own template' );
	}
}

if ( ! function_exists('helsinki_comment_form') ) {
	function helsinki_comment_form() {
		helsinki_deprecation_notice( __FUNCTION__, 'your own template' );
	}
}

if ( ! function_exists('helsinki_single_comment') ) {
	function helsinki_single_comment( $comment, $args, $depth ) {
		helsinki_deprecation_notice( __FUNCTION__, 'your own template' );
	}
}

function helsinki_remove_recent_comments_widget_styles() {
    helsinki_deprecation_notice( __FUNCTION__, 'nothing' );
}
