<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load files
 *
 * Theme file configuration and autoloader
 *
 */
require_once get_template_directory() . '/setup/loader.php';
spl_autoload_register( __NAMESPACE__ . '\\helsinki_class_autoloader' );

add_action('after_setup_theme', 'helsinki_load_files', 0);

/**
 * Setup theme
 *
 * Register theme supports, etc.
 *
 */
add_action('after_setup_theme', 'helsinki_setup_theme', 5);
add_action('widgets_init', 'helsinki_register_sidebars', 10);
add_action('widgets_init', 'helsinki_disable_default_widgets');

/**
 * Setup site
 *
 * Apply filters based on theme mods
 *
 */
add_action('wp_loaded', 'helsinki_setup_site', 10);

/**
 * Setup templates
 *
 * Add actions based on filters
 *
 */
add_action('template_redirect', 'helsinki_setup_templates', 10);

/**
 * Load assets
 *
 * Scripts, styles, etc.
 *
 */
add_action('wp_enqueue_scripts', 'helsinki_enqueue_assets', 10);
add_action('admin_enqueue_scripts', 'helsinki_enqueue_admin_assets', 10);
add_action('widgets_init', 'helsinki_remove_recent_comments_widget_styles', 10);

remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
