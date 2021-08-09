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
  if (is_singular() && comments_open() && get_option('thread_comments')) {
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

function helsinki_scheme_root_styles(string $scheme) {
	$colors = apply_filters(
		'helsinki_scheme_root_styles_colors',
		array(
			'--primary-color' => '--color-' . $scheme,
			'--primary-color-light' => '--color-' . $scheme . '-light',
			'--primary-color-medium' => '--color-' . $scheme . '-medium-light',
			'--primary-color-dark' => '--color-' . $scheme . '-dark',
		),
		$scheme
	);

	$use_hex = apply_filters( 'helsinki_scheme_root_styles_use_hex', false );

	$properties = array();
	foreach ($colors as $key => $value) {
		$properties[] = sprintf(
			'%s: %s;',
			esc_attr($key),
			$use_hex ? sanitize_hex_color( $value ) : 'var(' . esc_attr($value) . ')'
		);
	}

	echo '<style>:root {' . implode( ' ', $properties ) . '}</style>';
}

function helsinki_scheme_body_class($classes) {
	$scheme = apply_filters(
		'helsinki_scheme',
		helsinki_default_scheme()
	);
	return array_merge( $classes, array( 'has-scheme-' . $scheme ) );
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
	return array_merge(
		$classes,
		array( 'has-invert-color' )
	);
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
	if ( ! empty( $config['color'] ) ) {
		$palette[] = array(
            'name' => esc_attr_x( 'Primary', 'Editor palette','helsinki-universal' ),
            'slug' => 'primary',
            'color' => $config['color'],
        );
	}

	if ( ! empty( $config['light'] ) ) {
		$palette[] = array(
            'name' => esc_attr_x( 'Light', 'Editor palette','helsinki-universal' ),
            'slug' => 'light',
            'color' => $config['light'],
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
	$colors = apply_filters(
		'helsinki_colors',
		array(
			'brick' => '#bd2719',
			'brick-light' => '#ffeeed',
			'brick-medium-light' => '#facbc8',
			'brick-dark' => '#800e04',
			'bus' => '#0000bf',
			'bus-light' => '#f0f0ff',
			'bus-medium-light' => '#ccccff',
			'bus-dark' => '#00005e',
			'coat-of-arms' => '#0072c6',
			'coat-of-arms-light' => '#e6f4ff',
			'coat-of-arms-medium-light' => '#b5daf7',
			'coat-of-arms-dark' => '#005799',
			'copper' => '#00d7a7',
			'copper-light' => '#cffaf1',
			'copper-medium-light' => '#9ef0de',
			'copper-dark' => '#00a17d',
			'engel' => '#ffe977',
			'engel-light' => '#fff9db',
			'engel-medium-light' => '#fff3b8',
			'engel-dark' => '#dbc030',
			'fog' => '#9fc9eb',
			'fog-light' => '#e8f3fc',
			'fog-medium-light' => '#d0e6f7',
			'fog-dark' => '#72a5cf',
			'gold' => '#c2a251',
			'gold-light' => '#f7f2e4',
			'gold-medium-light' => '#e8d7a7',
			'gold-dark' => '#9e823c',
			'metro' => '#fd4f00',
			'metro-light' => '#ffeee6',
			'metro-medium-light' => '#ffcab3',
			'metro-dark' => '#bd2f00',
			'silver' => '#dedfe1',
			'silver-light' => '#f7f7f8',
			'silver-medium-light' => '#efeff0',
			'silver-dark' => '#b0b8bf',
			'summer' => '#ffc61e',
			'summer-light' => '#fff4d4',
			'summer-medium-light' => '#ffe49c',
			'summer-dark' => '#cc9200',
			'suomenlinna' => '#f5a3c7',
			'suomenlinna-light' => '#fff0f7',
			'suomenlinna-medium-light' => '#ffdbeb',
			'suomenlinna-dark' => '#e673a5',
			'tram' => '#008741',
			'tram-light' => '#dff7eb',
			'tram-medium-light' => '#a3e3c2',
			'tram-dark' => '#006631',
		)
	);

	if ( $name ) {
		return array(
			'color' => $colors[$name] ?? '',
			'light' => $colors[$name . '-light'] ?? '',
			'medium' => $colors[$name . '-medium-light'] ?? '',
			'dark' => $colors[$name . '-dark'] ?? '',
		);
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
