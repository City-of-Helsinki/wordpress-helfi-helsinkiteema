<?php

function helsinki_sidebar_body_class( $classes ) {
	return helsinki_add_body_class_has_n( $classes, 'sidebar' );
}

function helsinki_sidebar() {
	get_sidebar();
}
function helsinki_sidebar_widgets( $widget_area, $post_id ) {
	if ( is_active_sidebar( $widget_area ) ) {
		dynamic_sidebar( $widget_area );
	}
}

function helsinki_sidebar_compatible_page_template( $post = null ) {
	if ( ! $post ) {
		$post = get_post();
	}

	$template = get_page_template_slug( $post );
	$sidebar_enabled = array_filter(array(
		(is_page() && apply_filters( 'helsinki_sidebar_page_enabled', false )),
		is_single(),
	));

	return apply_filters(
		'helsinki_sidebar_compatible_page_template',
		'template/with-sidebar.php' === $template || ('' === $template && $sidebar_enabled),
		$post
	);
}
