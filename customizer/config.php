<?php

function helsinki_customizer_config() {
	return apply_filters(
		'helsinki_customizer_config',
		array(

		    // General
		    'helsinki_general' => array(

		      'config' => array(
		        'title'          => esc_html_x( 'General', 'Customizer panel title', 'helsinki-universal' ),
		        'priority'       => 35,
		        'capability'     => 'edit_theme_options',
		      ),

		      'panel_sections' => helsinki_customizer_general_sections(),

		    ), // helsinki_general

		    // Notifications
		    'helsinki_notification' => array(

		      'config' => array(
		        'title'          => esc_html_x( 'Notifications', 'Customizer panel title', 'helsinki-universal' ),
		        'priority'       => 35,
		        'capability'     => 'edit_theme_options',
		      ),

		      'panel_sections' => helsinki_customizer_notification_sections(),

		  ), // helsinki_notification

		    // Front page
		    'helsinki_front_page' => array(

		      'config' => array(
		        'title'          => esc_html_x( 'Front Page', 'Customizer panel title', 'helsinki-universal' ),
		        'priority'       => 35,
		        'capability'     => 'edit_theme_options',
		      ),

		      'panel_sections' => helsinki_customizer_front_page_sections(),

		    ), // helsinki_front_page

		    // Blog
		    'helsinki_blog' => array(

		      'config' => array(
		        'title'          => esc_html_x( 'Blog', 'Customizer panel title', 'helsinki-universal' ),
		        'priority'       => 35,
		        'capability'     => 'edit_theme_options',
		      ),

		      'panel_sections' => helsinki_customizer_blog_sections(),

		    ), // helsinki_blog

			// Header
		    'helsinki_header' => array(

		      'config' => array(
		        'title'          => esc_html_x( 'Header', 'Customizer panel title', 'helsinki-universal' ),
		        'priority'       => 35,
		        'capability'     => 'edit_theme_options',
		      ),

		      'panel_sections' => helsinki_customizer_header_sections(),

			), // helsinki_header

		    // Sidebar
		    'helsinki_sidebar' => array(

		      'config' => array(
		        'title'          => esc_html_x( 'Sidebar', 'Customizer panel title', 'helsinki-universal' ),
		        'priority'       => 35,
		        'capability'     => 'edit_theme_options',
		      ),

		      'panel_sections' => helsinki_customizer_sidebar_sections(),

		    ), // helsinki_sidebar

		    // Footer
		    'helsinki_footer' => array(

		      'config' => array(
		        'title'          => esc_html_x( 'Footer', 'Customizer panel title', 'helsinki-universal' ),
		        'priority'       => 35,
		        'capability'     => 'edit_theme_options',
		      ),

		      'panel_sections' => helsinki_customizer_footer_sections(),

		    ), // helsinki_footer

		) // array

	); // return
}
