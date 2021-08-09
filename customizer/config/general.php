<?php

function helsinki_customizer_general_sections() {
  $config = array(

	'style' => array(

		'config' => array(
			'title'          => esc_html_x( 'Style', 'Customizer section title', 'helsinki-universal' ),
			'capability'     => 'edit_theme_options',
		),

		'section_settings' => array(), // section_settings

	), // style

	'koros' => array(

		'config' => array(
			'title'          => esc_html_x( 'Koros', 'Customizer section title', 'helsinki-universal' ),
			'capability'     => 'edit_theme_options',
		),

		'section_settings' => array(
			'type' => helsinki_setting_select(
				__('Type', 'helsinki-universal'),
				'',
				helsinki_customizer_choices_koros(),
				helsinki_koros_type_basic()
			),
		), // section_settings

	), // koros

	'breadcrumbs' => array(

		'config' => array(
			'title'          => esc_html_x( 'Breadcrumbs', 'Customizer section title', 'helsinki-universal' ),
			'capability'     => 'edit_theme_options',
		),

		'section_settings' => helsinki_merge_section_settings(
			helsinki_customizer_setting_enabled(
				esc_html_x( 'Required Yoast SEO to be installed', 'Customizer setting description', 'helsinki-universal' )
			)
		), // section_settings

	), // breadcrumbs

	'social_share' => array(

		'config' => array(
			'title'          => esc_html_x( 'Social share', 'Customizer section title', 'helsinki-universal' ),
			'capability'     => 'edit_theme_options',
		),

		'section_settings' => array(
			'medias' => helsinki_setting_multicheckbox(
				__('Media', 'helsinki-universal'),
				'',
				helsinki_customizer_choices_social_share(),
				false,
				array()
			),
		), // section_settings

	), // social_share

  );

	if ( apply_filters( 'helsinki_scheme_selection_enabled', true ) ) {
		$config['style']['section_settings']['scheme'] = helsinki_setting_select(
			__('Scheme', 'helsinki-universal'),
			'',
			helsinki_customizer_choices_style_schemes(),
			''
		);
	}

  return $config;
}
