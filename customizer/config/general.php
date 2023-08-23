<?php

function helsinki_customizer_general_sections() {
  $config = array(

	'style' => array(

		'config' => array(
			'title'          => esc_html_x( 'Color', 'Customizer section title', 'helsinki-universal' ),
			'capability'     => 'edit_theme_options',
		),

		'section_settings' => array(), // section_settings

	), // style

	'koros' => array(

		'config' => array(
			'title'          => esc_html_x( 'Koroshape', 'Customizer section title', 'helsinki-universal' ),
			'capability'     => 'edit_theme_options',
		),

		'section_settings' => array(
			'type' => helsinki_setting_select(
				__('Koroshape', 'helsinki-universal'),
				'',
				helsinki_customizer_choices_koros(),
				helsinki_koros_type_basic()
			),
		), // section_settings

	), // koros

	'icon' => array(

		'config' => array(
			'title'          => esc_html_x( 'Icon', 'Customizer section title', 'helsinki-universal' ),
			'capability'     => 'edit_theme_options',
		),

		'section_settings' => array(

			'placeholder_icon' => helsinki_setting_select(
				__('Icon', 'helsinki-universal'),
				'',
				helsinki_customizer_choices_placeholder_icon(),
				'abstract-3'
			),

		), // section_settings

	), // icon

  );

	if ( apply_filters( 'helsinki_scheme_selection_enabled', true ) ) {
		$config['style']['section_settings']['scheme'] = helsinki_setting_select(
			__('Color', 'helsinki-universal'),
			'',
			helsinki_customizer_choices_style_schemes(),
			''
		);
	}

  return $config;
}
