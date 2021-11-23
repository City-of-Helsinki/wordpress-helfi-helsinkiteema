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
			'hds-wp-styles',
			'wp-block-library',
		),
		$version,
		'all'
	);

	/**
	  * Scripts
	  */
  	wp_enqueue_script('jquery-core');
	$theme_js = $debug ? 'scripts.js': 'scripts.min.js';
  	wp_enqueue_script(
		'theme',
		$assets . $theme_js,
		array(),
		$version,
		true
	);

	/**
	  * Comments
	  */
	if ( is_singular() && comments_open() && get_option('thread_comments') ) {
		wp_enqueue_script('comment-reply');
	}
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
	$config = helsinki_colors(
		apply_filters(
			'helsinki_scheme',
			helsinki_theme_mod(
				'helsinki_general_style',
				'scheme',
				helsinki_default_scheme()
			)
		)
	);

	$palette = array();
	if ( ! empty( $config['primary']['color'] ) ) {
		$palette[] = array(
            'name' => esc_attr_x( 'Primary', 'Editor palette','helsinki-universal' ),
            'slug' => 'primary',
            'color' => $config['primary']['color'],
        );
	}

	$palette[] = array(
		'name' => esc_attr_x( 'Black', 'Editor palette','helsinki-universal' ),
		'slug' => 'black',
		'color' => '#000000',
	);

	$palette[] = array(
		'name' => esc_attr_x( 'White', 'Editor palette','helsinki-universal' ),
		'slug' => 'white',
		'color' => '#ffffff',
	);

	$palette[] = array(
		'name' => esc_attr_x( 'Light Gray', 'Editor palette','helsinki-universal' ),
		'slug' => 'light-gray',
		'color' => '#f7f7f8',
	);

	return $palette;
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
