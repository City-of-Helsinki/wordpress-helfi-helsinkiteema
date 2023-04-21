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

function helsinki_sidebar_post_meta() {
	$sidebar_heading = get_post_meta( get_the_ID(), 'sidebar_heading', true );
	$sidebar_content = get_post_meta( get_the_ID(), 'sidebar_content', true );

	if ( $sidebar_heading || $sidebar_content ) {
		get_template_part( 'partials/sidebar/post-meta', null, array(
			'sidebar_heading' => $sidebar_heading,
			'sidebar_content' => $sidebar_content,
		) );
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

function helsinki_sidebar_params( $params ) {
	$params[0]['before_title'] = '<h2 class="widget__title">';
	$params[0]['after_title'] = '</h2>';

	return $params;
}
add_filter( 'dynamic_sidebar_params', 'helsinki_sidebar_params' );
