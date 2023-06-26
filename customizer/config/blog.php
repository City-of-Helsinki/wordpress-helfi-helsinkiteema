<?php

function helsinki_customizer_blog_sections() {
	return array(
		'entry' => array(

			'config' => array(
				'title'          => esc_html_x( 'Entries', 'Customizer section title', 'helsinki-universal' ),
				'capability'     => 'edit_theme_options',
			),

			'section_settings' => array(

				'placeholder_icon' => helsinki_setting_select(
					__('Placeholder Icon', 'helsinki-universal'),
					'',
					helsinki_customizer_choices_placeholder_icon(),
					'abstract-3'
				),

			), // section_settings

		), // entry

		'single' => array(

			'config' => array(
				'title'          => esc_html_x( 'Single Article', 'Customizer section title', 'helsinki-universal' ),
				'capability'     => 'edit_theme_options',
			),

			'section_settings' => array(
				'social_share' => helsinki_setting_checkbox(
					esc_html__('Display social share buttons', 'helsinki-universal')
				),
				'categories' => helsinki_setting_checkbox(
					esc_html__('Display categories', 'helsinki-universal')
				),
				'author' => helsinki_setting_checkbox(
					esc_html__('Display author', 'helsinki-universal')
				),
				'updated' => helsinki_setting_checkbox(
					esc_html__('Display modified date', 'helsinki-universal')
				),
				'tags' => helsinki_setting_checkbox(
					esc_html__('Display tags', 'helsinki-universal')
				),
				'related' => helsinki_setting_checkbox(
					esc_html__('Display related posts', 'helsinki-universal')
				),
			), // section_settings

		), // single
	);
}
