<?php

function helsinki_customizer_sidebar_sections() {

  $out = array(

    'page' => array(

      'config' => array(
        'title'          => esc_html_x( 'Page sidebar', 'Customizer section title', 'helsinki-universal' ),
        'capability'     => 'edit_theme_options',
      ),

      'section_settings' => array(
        'enabled'  => helsinki_setting_checkbox(__( 'Enabled', 'helsinki-universal' )),
      ), // section_settings

    ), // page

  );
  return $out;
}
