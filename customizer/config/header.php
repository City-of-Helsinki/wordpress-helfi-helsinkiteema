<?php

function helsinki_customizer_header_sections()
{
	return array(
		'general' => array(

			'config' => array(
				'title'          => esc_html_x('Helsinki logo', 'Customizer section title', 'helsinki-universal'),
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
				'title'          => esc_html_x('Search', 'Customizer section title', 'helsinki-universal'),
				'capability'     => 'edit_theme_options',
			),

			'section_settings' => helsinki_merge_section_settings(
				helsinki_customizer_setting_enabled(
					esc_html_x('Display search field in site header', 'Customizer setting description', 'helsinki-universal')
				)
			), // section_settings

		), // search

		'languages' => array(

			'config' => array(
				'title'          => esc_html_x('Language selector', 'Customizer section title', 'helsinki-universal'),
				'capability'     => 'edit_theme_options',
			),

			'section_settings' => helsinki_merge_section_settings(
				helsinki_customizer_setting_enabled(
					esc_html_x('Display language selector in site header', 'Customizer setting description', 'helsinki-universal')
				)
			), // section_settings

		), // languages

		'breadcrumbs' => array(

			'config' => array(
				'title'          => esc_html_x('Breadcrumbs', 'Customizer section title', 'helsinki-universal'),
				'capability'     => 'edit_theme_options',
			),

			'section_settings' => helsinki_merge_section_settings(
				helsinki_customizer_setting_enabled(
					esc_html_x('Required Yoast SEO to be installed', 'Customizer setting description', 'helsinki-universal')
				)
			), // section_settings

		), // breadcrumbs

		'primary_menu' => array(

			'config' => array(
				'title'          => esc_html_x('Primary menu', 'Customizer section title', 'helsinki-universal'),
				'capability'     => 'edit_theme_options',
			),

			'section_settings' => array_merge(
				array(
					'menu-items' => helsinki_setting_radio(
						esc_html__('Main menu information hierarchy levels', 'helsinki-universal'),
						esc_html__('Select two levels of hierarchy on large screens and five levels of hierarchy on small screens only if the sites pages have a side menu. Otherwise, select three hierarchy levels.', 'helsinki-universal'),
						array(
							'menu-depth-3' => esc_html_x('Three levels of hierarchy on large and small screens', 'Customizer setting description', 'helsinki-universal'),
							'menu-depth-3-5' => esc_html_x('Two levels of hierarchy for large screens and five levels of hierarchy for small screens', 'Customizer setting description', 'helsinki-universal'),
						),
						'menu-depth-3'
					),
				)
			), // section_settings

		), // primary_menu

	); // return
}
