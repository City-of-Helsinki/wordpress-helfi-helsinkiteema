<?php

function helsinki_customizer_blog_sections() {
	return array(
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
