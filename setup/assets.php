<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function helsinki_is_debug(): bool {
	return defined( 'WP_DEBUG' ) && WP_DEBUG;
}

function helsinki_assets_version(): string {
	return helsinki_is_debug() ? (string) time() : wp_get_theme()->get( 'Version' );
}

function helsinki_assets_url(): string {
	return get_template_directory_uri() . '/assets/';
}

/**
  * Asset loading
  */
function helsinki_enqueue_assets(): void {
	$debug = helsinki_is_debug();
	$assets = helsinki_assets_url();
  	$version = helsinki_assets_version();

	/**
	  * Styles
	  */
	wp_enqueue_style(
		'theme',
		$assets . ( $debug ? 'public/styles.css': 'public/styles.min.css' ),
		array( 'helsinki-wp-public' ),
		$version,
		'all'
	);

	/**
	  * Vendor
	  */
	wp_enqueue_script(
		'hyphenopoly',
		$assets . 'vendor/hyphenopoly/Hyphenopoly_Loader.js',
		array(),
		$version,
		false
	);

	/**
	  * Scripts
	  */
  	wp_enqueue_script(
		'theme-footer',
		$assets . ( $debug ? 'public/footer/scripts.js': 'public/footer/scripts.min.js' ),
		array( 'jquery' ),
		$version,
		true
	);

	wp_localize_script(
		'theme-footer',
		'helsinkiTheme',
		helsinki_script_localization()
	);

  	wp_enqueue_script(
		'theme-header',
		$assets . ( $debug ? 'public/header/scripts.js': 'public/header/scripts.min.js' ),
		array( 'hyphenopoly' ),
		$version,
		false
	);

	wp_localize_script(
		'theme-header',
		'helsinkiTheme',
		helsinki_script_localization()
	);
}

function helsinki_enqueue_editor_assets(): void {
	if ( is_admin() ) {
		$debug = helsinki_is_debug();
		$assets = helsinki_assets_url();
		$version = helsinki_assets_version();

		wp_enqueue_style(
			'theme-block-editor',
			$assets . ( $debug ? 'editor/css/styles.css': 'editor/css/styles.min.css' ),
			array( 'helsinki-wp' ),
			$version,
			'all'
		);

		wp_enqueue_script(
			'theme-block-editor',
			$assets . ( $debug ? 'editor/js/scripts.js': 'editor/js/scripts.min.js' ),
			array( 'wp-edit-post' ),
			$version,
			true
		);
	}
}

function helsinki_enqueue_admin_assets( string $hook_suffix ): void {
	if ( 'options-reading.php' === $hook_suffix ) {
		wp_enqueue_script(
			'theme-admin',
			helsinki_assets_url() . ( helsinki_is_debug() ? 'admin/js/scripts.js': 'admin/js/scripts.min.js' ),
			array(),
			helsinki_assets_version(),
			true
		);
	}
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
