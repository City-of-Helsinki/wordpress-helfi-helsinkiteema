<?php
/**
  * Asset loading
  */
function helsinki_enqueue_assets()
{
	$debug = defined('WP_DEBUG') && WP_DEBUG;
	$assets = get_template_directory_uri() . '/assets/';

	/**
	  * Theme version
	  */
  	$version = $debug ? time() : wp_get_theme()->get('Version');

	/**
	  * Styles
	  */
	$default_css = $debug ? 'default.css': 'default.min.css';
	wp_enqueue_style(
		'theme',
		$assets . $default_css,
		array(
			'helsinki-wp-styles',
			'wp-block-library',
		),
		$version,
		'all'
	);

	/**
	  * Scripts
	  */
	$theme_footer_js = $debug ? 'scripts/footer/scripts.js': 'scripts/footer/scripts.min.js';
  	wp_enqueue_script(
		'theme-footer',
		$assets . $theme_footer_js,
		array('jquery'),
		$version,
		true
	);

	wp_localize_script(
		'theme-footer',
		'helsinkiTheme',
		helsinki_script_localization()
	);

	$hyphenopoly_js = 'scripts/header/libraries/hyphenopoly/Hyphenopoly_Loader.js';
  	wp_enqueue_script(
		'hyphenopoly',
		$assets . $hyphenopoly_js,
		array(),
		$version,
		false
	);

	$theme_header_js = $debug ? 'scripts/header/scripts.js': 'scripts/header/scripts.min.js';
  	wp_enqueue_script(
		'theme-header',
		$assets . $theme_header_js,
		array(),
		$version,
		false
	);

	wp_localize_script(
		'theme-header',
		'helsinkiTheme',
		helsinki_script_localization()
	);

	/**
	  * Comments
	  */
	if ( is_singular() && comments_open() && get_option('thread_comments') ) {
		wp_enqueue_script('comment-reply');
	}
}

function helsinki_enqueue_admin_assets($hook_suffix) {
	$debug = defined('WP_DEBUG') && WP_DEBUG;
	$assets = get_template_directory_uri() . '/assets/';

	/**
	  * Theme version
	  */
  	$version = $debug ? time() : wp_get_theme()->get('Version');

	/**
	  * Styles
	  */
	  $admin_css = $debug ? 'admin/styles/admin.css': 'admin/styles/admin.min.css';
	  wp_enqueue_style(
		  'theme-admin-styles',
		  $assets . $admin_css,
		  array(
			  'wp-block-library',
		  ),
		  $version,
		  'all'
	  );


	$theme_admin_js = $debug ? 'scripts/admin/scripts.js': 'scripts/admin/scripts.min.js';
	wp_enqueue_script(
		'theme-admin',
		$assets . $theme_admin_js,
		array(
			'wp-edit-post',
		),
		$version,
		true
	);

	wp_localize_script(
		'theme-admin',
		'helsinkiTheme',
		helsinki_script_localization()
	);
}

function helsinki_script_localization() {
	return apply_filters(
		'helsinki_script_localization',
		array(
			'strings' => array(
				'close' => esc_html__( 'Close', 'helsinki-universal' ),
				'next' => esc_html__( 'Next', 'helsinki-universal' ),
				'prev' => esc_html__( 'Previous', 'helsinki-universal' ),
				'lightboxTitle' => esc_html__( 'Gallery images', 'helsinki-universal' ),
			),
			'icons' => array(
				'close' => helsinki_get_svg_icon( 'cross' ),
				'next' => helsinki_get_svg_icon( 'angle-right' ),
				'prev' => helsinki_get_svg_icon( 'angle-left' ),
				'arrowRight' => helsinki_get_svg_icon( 'arrow-right' ),
				'faceSmile' => helsinki_get_svg_icon( 'face-smile' ),
				'faceSad' => helsinki_get_svg_icon( 'face-sad' ),
				'faceNeutral' => helsinki_get_svg_icon( 'face-neutral' ),
				'whatsapp' => helsinki_get_svg_icon( 'whatsapp' ),
				'facebook' => helsinki_get_svg_icon( 'facebook' ),
				'twitter' => helsinki_get_svg_icon( 'twitter' ),
				'email' => helsinki_get_svg_icon( 'envelope' ),
			),
		)
	);
}

/**
  * Theme schemes
  */
function helsinki_set_current_scheme( string $scheme ): void {
	trigger_error(
		__FUNCTION__ . '() is deprecated. Use helsinki_set_current_scheme action instead.',
		E_USER_DEPRECATED
	);

	error_log( print_r( debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 1 ), true ) );

	do_action( 'helsinki_set_current_scheme', $scheme );
}

function helsinki_scheme_root_styles( string $scheme ): void {
	trigger_error(
		__FUNCTION__ . '() is deprecated. Get scheme root styles via helsinki_scheme_root_styles filter.',
		E_USER_DEPRECATED
	);

	error_log( print_r( debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 1 ), true ) );
}

function helsinki_scheme_body_class( $classes ) {
	$scheme = apply_filters(
		'helsinki_scheme',
		helsinki_default_scheme()
	);
	return helsinki_add_body_class_has_n( $classes, 'scheme-' . $scheme );
}

function helsinki_scheme_has_invert_color() {
	return in_array(
		apply_filters(
			'helsinki_scheme',
			helsinki_default_scheme()
		),
		array(
			'bus',
			'brick',
			'coat-of-arms',
			'tram'
		)
	);
}

function helsinki_scheme_invert_color_body_class($classes) {
	return helsinki_add_body_class_has_n( $classes, 'invert-color' );
}

/**
  * Editor palettes
  */
function helsinki_scheme_editor_palette() {
	helsinki_deprecation_notice( __FUNCTION__, 'nothing' );
	return array();
}

function helsinki_colors(string $name ='') {
	$colors = apply_filters( 'helsinki_colors', helsinki_config_colors() );
	if ( $name ) {
		return $colors[$name] ?? $colors[ helsinki_default_scheme() ];
	} else {
		return $colors;
	}
}

function helsinki_default_scheme() {
	return apply_filters( 'helsinki_default_scheme', 'coat-of-arms' );
}

/**
  * Widgets
  */
function helsinki_remove_recent_comments_widget_styles() {
    global $wp_widget_factory;
    remove_action(
		'wp_head',
		[
			$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
			'recent_comments_style'
		]
	);
}
