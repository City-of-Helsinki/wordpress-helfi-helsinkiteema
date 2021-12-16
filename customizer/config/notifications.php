<?php

function helsinki_customizer_notification_count() {
	return 3;
}

function helsinki_customizer_notification_sections() {

	$config = array();

	for ( $i = 1; $i <= helsinki_customizer_notification_count(); $i++ ) {
		$config['notice_' . $i] = array(
			'config' => array(
				'title'          => sprintf(
					'%s %d',
					esc_html_x( 'Notification', 'Customizer section title', 'helsinki-universal' ),
					$i
				),
				'capability'     => 'edit_theme_options',
			),

			'section_settings' => array(
				'enabled' => helsinki_setting_checkbox(
					__( 'Enabled', 'helsinki-universal' )
				),

				'lang' => helsinki_setting_select(
					__( 'Language', 'helsinki-universal' ),
					implode( ' ', array(
						__( 'The notice will be displayed only, when the site is viewed on the selected language.', 'helsinki-universal' ),
						__( 'If Polylang is active and "All" is selected, use String translations to translate the notice.', 'helsinki-universal' ),
					) ),
					helsinki_customizer_choices_language(),
					''
				),

				'type' => helsinki_setting_select(
					__( 'Type', 'helsinki-universal' ),
					'',
					helsinki_customizer_choices_notice_type(),
					''
				),

				'title' => helsinki_setting_text(
					__( 'Title', 'helsinki-universal' )
				),

				'text' => helsinki_setting_text(
					__( 'Text', 'helsinki-universal' )
				),

				'link_text' => helsinki_setting_text(
					__( 'Link text', 'helsinki-universal' )
				),

				'link_url' => helsinki_setting_url(
					__( 'Link url', 'helsinki-universal' )
				),

				'is_external' => helsinki_setting_checkbox(
					__( 'Is external?', 'helsinki-universal' )
				),
			),
		);
	}

	return $config;
}
