<?php

/**
 * Util
 */
function helsinki_merge_section_settings(array $settings)
{
  return array_merge(
    array(),
    $settings
  );
}

/**
 * Color
 */
function helsinki_setting_color(string $label, string $description = '', string $default = '')
{
  return array(
    'config' => array(
      'default'           => $default,
      'type'              => 'theme_mod',
      'capability'        => 'manage_options',
      'sanitize_callback' => 'sanitize_hex_color',
    ),
    'setting_control' => array(
      'label'       => esc_html($label),
      'description' => $description ? esc_html($description) : '',
      'type'        => 'color',
    ),
  );
}

/**
 * Checkbox
 */
function helsinki_setting_checkbox(string $label, string $description = '', string $default = '')
{
  return array(
    'config' => array(
      'default'           => $default,
      'type'              => 'theme_mod',
      'capability'        => 'manage_options',
      'sanitize_callback' => 'helsinki_sanitize_checkbox',
    ),
    'setting_control' => array(
      'label'       => esc_html($label),
      'description' => $description ? esc_html($description) : '',
      'type'        => 'checkbox',
    ),
  );
}

function helsinki_sanitize_checkbox($input)
{
  return (isset($input) && true == $input) ? true : false;
}

function helsinki_customizer_setting_enabled(string $description = '', string $default = '')
{
  return array(
    'enabled' => helsinki_setting_checkbox(
      __('Enabled', 'helsinki-universal'),
      $description,
      $default
    ),
  );
}

/**
 * Media
 */
function helsinki_setting_media(string $label, string $description = '', string $mime_type = '', int $default = 0)
{
  return array(
    'config' => array(
      'default'           => $default ? $default : '',
      'type'              => 'theme_mod',
      'capability'        => 'manage_options',
      'sanitize_callback' => 'absint',
    ),
    'setting_control' => array(
      'label'       => esc_html($label),
      'description' => $description ? esc_html($description) : '',
      'type'        => 'media',
      'mime_type'   => $mime_type,
    ),
  );
}

/**
 * Multicheckbox
 */
function helsinki_setting_multicheckbox(string $label, string $description = '', array $choices = array(), bool $sortable = false, array $default = array())
{
  return array(
    'config' => array(
      'default'           => $default,
      'type'              => 'theme_mod',
      'capability'        => 'manage_options',
      'sanitize_callback' => 'helsinki_sanitize_multicheckboxes',
    ),
    'setting_control' => array(
      'label'       => esc_html($label),
      'description' => $description ? esc_html($description) : '',
      'type'        => 'multi-checkbox',
      'choices'     => $choices,
      'sortable'    => $sortable,
    ),
  );
}

function helsinki_sanitize_multicheckboxes($values)
{
  $multi_values = !is_array($values) ? explode(',', $values) : $values;
  return !empty($multi_values) ? array_map('helsinki_sanitize_multicheckbox', $multi_values) : array();
}

function helsinki_sanitize_multicheckbox($value)
{
  return is_numeric($value) ? intval($value) : sanitize_text_field($value);
}

/**
 * Number
 */
function helsinki_setting_number(string $label, string $description = '', $default = 0, array $attr = array())
{
  return array(
    'config' => array(
      'default'           => $default ? floatval($default) : '',
      'type'              => 'theme_mod',
      'capability'        => 'manage_options',
      'sanitize_callback' => 'helsinki_sanitize_number',
    ),
    'setting_control' => array(
      'label'       => esc_html($label),
      'description' => $description ? esc_html($description) : '',
      'type'        => 'number',
      'input_attrs' => $attr,
    ),
  );
}

function helsinki_sanitize_number($value)
{
  return floatval($value);
}

/**
 * Radio
 */
function helsinki_setting_radio(string $label, string $description = '', array $choices = array(), string $default = '')
{
  return array(
    'config' => array(
      'default'           => $default,
      'type'              => 'theme_mod',
      'capability'        => 'manage_options',
      'sanitize_callback' => 'helsinki_sanitize_radio',
    ),
    'setting_control' => array(
      'label'       => esc_html($label),
      'description' => $description ? esc_html($description) : '',
      'type'        => 'radio',
      'choices'     => $choices,
    ),
  );
}

/**
 * Radio
 */

function helsinki_sanitize_radio($input, $setting)
{
  //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
  $input = sanitize_key($input);
  //get the list of possible radio box options
  $choices = $setting->manager->get_control($setting->id)->choices;
  //return input if valid or return default option
  return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Select
 */
function helsinki_setting_select(string $label, string $description = '', array $choices = array(), string $default = '')
{
  return array(
    'config' => array(
      'default'           => $default,
      'type'              => 'theme_mod',
      'capability'        => 'manage_options',
      'sanitize_callback' => 'helsinki_sanitize_select',
    ),
    'setting_control' => array(
      'label'       => esc_html($label),
      'description' => $description ? esc_html($description) : '',
      'type'        => 'select',
      'choices'     => $choices,
    ),
  );
}

function helsinki_sanitize_select($input, $setting)
{
  //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
  $input = sanitize_key($input);
  //get the list of possible select options
  $choices = $setting->manager->get_control($setting->id)->choices;
  //return input if valid or return default option
  return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Text
 */
function helsinki_setting_text(string $label, string $description = '', string $default = '')
{
  return array(
    'config' => array(
      'default'           => $default,
      'type'              => 'theme_mod',
      'capability'        => 'manage_options',
      'sanitize_callback' => 'wp_filter_nohtml_kses',
    ),
    'setting_control' => array(
      'label'       => esc_html($label),
      'description' => $description ? esc_html($description) : '',
      'type'        => 'text',
    ),
  );
}

function helsinki_setting_shortcode(string $label, string $description = '', string $default = '')
{
  return array(
    'config' => array(
      'default'           => $default,
      'type'              => 'theme_mod',
      'capability'        => 'manage_options',
      'sanitize_callback' => 'wp_kses_post',
    ),
    'setting_control' => array(
      'label'       => esc_html($label),
      'description' => $description ? esc_html($description) : '',
      'type'        => 'text',
    ),
  );
}

/**
 * Textarea
 */
function helsinki_setting_textarea(string $label, string $description = '', string $default = '')
{
  return array(
    'config' => array(
      'default'           => $default,
      'type'              => 'theme_mod',
      'capability'        => 'manage_options',
      'sanitize_callback' => 'wp_filter_nohtml_kses',
    ),
    'setting_control' => array(
      'label'       => esc_html($label),
      'description' => $description ? esc_html($description) : '',
      'type'        => 'textarea',
    ),
  );
}

/**
 * Url
 */
function helsinki_setting_url(string $label, string $description = '', string $default = '')
{
  return array(
    'config' => array(
      'default'           => $default,
      'type'              => 'theme_mod',
      'capability'        => 'manage_options',
      'sanitize_callback' => 'esc_url_raw',
    ),
    'setting_control' => array(
      'label'       => esc_html($label),
      'description' => $description ? esc_html($description) : '',
      'type'        => 'url',
    ),
  );
}
