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
  	wp_enqueue_script('jquery-core');
	$theme_footer_js = $debug ? 'scripts/footer/scripts.js': 'scripts/footer/scripts.min.js';
  	wp_enqueue_script(
		'theme-footer',
		$assets . $theme_footer_js,
		array(),
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
			),
		)
	);
}

/**
  * Theme schemes
  */
function helsinki_set_current_scheme( string $scheme ) {
	$valid = helsinki_customizer_choices_style_schemes();
	if ( ! isset($valid[$scheme]) ) {
		$scheme = helsinki_default_scheme();
	}

	add_filter(
		'helsinki_scheme',
		function() use ($scheme) {
			return $scheme;
		}
	);

	add_action(
		'wp_head',
		function() use ($scheme) {
			helsinki_scheme_root_styles($scheme);
		}
	);

	add_action(
		'admin_head',
		function() use ($scheme) {
			helsinki_scheme_root_styles($scheme);
		}
	);
}

function helsinki_scheme_root_styles( string $scheme ) {
	$config = helsinki_colors( $scheme );

	$colors = apply_filters(
		'helsinki_scheme_root_styles_colors',
		array(
			'--primary-color' => $config['primary']['color'] ?? '--color-' . $scheme,
			'--primary-color-light' => $config['primary']['light'] ?? '--color-' . $scheme . '-light',
			'--primary-color-medium' => $config['primary']['medium'] ?? '--color-' . $scheme . '-medium-light',
			'--primary-color-dark' => $config['primary']['dark'] ?? '--color-' . $scheme . '-dark',
			'--primary-content-color' => $config['primary']['content'] ?? '--color-' . $scheme . '-content',
			'--primary-content-secondary-color' => $config['primary']['content-secondary'] ?? '--color-' . $scheme . '-content-secondary',
			'--secondary-color' => $config['secondary'] ?? '',
			'--accent-color' => $config['accent'] ?? '',
		),
		$scheme,
		$config
	);

	$use_hex = apply_filters(
		'helsinki_scheme_root_styles_use_hex',
		! empty( sanitize_hex_color( $colors['--primary-color'] ) )
	);

	$properties = array();
	foreach ( $colors as $key => $value ) {
		$properties[] = sprintf(
			'%s: %s;',
			esc_attr($key),
			$use_hex ? sanitize_hex_color( $value ) : 'var(' . esc_attr($value) . ')'
		);
	}

	echo '<style>:root {' . implode( ' ', $properties ) . '}</style>';
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
  * Jquery
  */
function helsinki_move_jquery_into_footer($wp_scripts) {
	$wp_scripts->add_data('jquery', 'group', 1);
	$wp_scripts->add_data('jquery-core', 'group', 1);
	$wp_scripts->add_data('jquery-migrate', 'group', 1);
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
