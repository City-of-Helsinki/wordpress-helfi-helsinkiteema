<?php

function helsinki_customizer_header_sections() {
	return array(
		'general' => array(

			'config' => array(
			'title'          => esc_html_x( 'General', 'Customizer section title', 'helsinki-universal' ),
			'capability'     => 'edit_theme_options',
			),

			'section_settings' => array(
				'disable_default_logo' => helsinki_setting_checkbox(
					esc_html__('Disable default city logo', 'helsinki-universal')
				),
			), // section_settings

		), // general

		'search' => array(

			'config' => array(
				'title'          => esc_html_x( 'Search', 'Customizer section title', 'helsinki-universal' ),
				'capability'     => 'edit_theme_options',
			),

			'section_settings' => helsinki_merge_section_settings(
				helsinki_customizer_setting_enabled(
					esc_html_x( 'Display search field in site header', 'Customizer setting description', 'helsinki-universal' )
				)
			), // section_settings

		), // search

		'languages' => array(

			'config' => array(
				'title'          => esc_html_x( 'Languages', 'Customizer section title', 'helsinki-universal' ),
				'capability'     => 'edit_theme_options',
			),

			'section_settings' => helsinki_merge_section_settings(
				helsinki_customizer_setting_enabled(
					esc_html_x( 'Display language selector in site header', 'Customizer setting description', 'helsinki-universal' )
				)
			), // section_settings

		), // languages
    );
}
