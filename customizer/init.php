<?php
add_action( 'customize_register', 'helsinki_customizer_init' );
function helsinki_customizer_init( $wp_customize ) {

  wp_enqueue_style(
    'customize-general-styles',
    get_template_directory_uri() . '/customizer/' . 'styles.css',
    array(),
    wp_get_theme()->get('Version'),
    'all'
  );


	/**
	  * Custom Controls
		*/
	require_once trailingslashit(__DIR__) . '/controls/multi-checkbox/control.php';

	/**
		* Setup config
		*/
  foreach ( helsinki_customizer_config() as $panel_id => $panel ) {
    if ( count($panel['panel_sections']) > 1 ) {
      $wp_customize->add_panel( $panel_id, $panel['config'] );
    }

    foreach ( $panel['panel_sections'] as $section_id => $section ) {
      $section_id                 = $panel_id . '_' . $section_id;
      $section['config']['panel'] = $panel_id;

      if ( count($panel['panel_sections']) > 1 ) {
        $wp_customize->add_section( $section_id, $section['config'] );
      } else {
        $wp_customize->add_section( $section_id, $panel['config'] );
      }

      foreach ( $section['section_settings'] as $setting_id => $setting ) {

        $section_setting = "{$section_id}[{$setting_id}]";

        $wp_customize->add_setting( $section_setting, $setting['config'] );

        $control             = $setting['setting_control'];
        $control['section']  = $section_id;
        $control['settings'] = $section_setting;

        switch ( $control['type'] ) {
          case 'color':
            unset($control['type']);
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $section_setting, $control ) );
            break;

          case 'media':
            unset($control['type']);
            $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $section_setting, $control ) );
            break;

          case 'multi-checkbox':
						unset($control['type']);
						$wp_customize->add_control( new Theme_Multi_Checkbox_Customize_Control( $wp_customize, $section_setting, $control ) );
            break;

          default:
            $wp_customize->add_control($section_setting, $control );
            break;
        }

      } // settings

    } // sections

  } // panels

}
