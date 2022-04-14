<?php

add_action( 'wp_enqueue_scripts', 'helsinki_disable_cmplz_cookiebanner_styles', PHP_INT_MAX - 49 );
function helsinki_disable_cmplz_cookiebanner_styles() {
  wp_dequeue_style( 'cmplz-cookie' );

  wp_dequeue_style( 'cmplz-document' );
  wp_dequeue_style( 'cmplz-document-grid' );
	add_filter( 'cmplz_custom_document_css', '__return_empty_string' );
}

add_filter( 'cmplz_template_file', 'helsinki_cmplz_templates', 11, 2 );
function helsinki_cmplz_templates( $path, $file ) {
  // defined files only
  if (
    'cookiepolicy_services.php' !== $file &&
    'cookiepolicy_cookies_row.php' !== $file &&
    'cookiepolicy_purpose_row.php' !== $file &&
	'cookiebanner.php' !== $file
  ) {
    return $path;
  }

  // child themes only
  if ( get_template_directory() !== get_stylesheet_directory() ) {
	$childPath = implode(
		DIRECTORY_SEPARATOR,
		array(
		  get_stylesheet_directory(),
		  'complianz-gdpr-premium',
		  'templates',
		  $file
		)
	);
	if (file_exists($childPath)) {
		return $childPath;
	}
  }

  return implode(
    DIRECTORY_SEPARATOR,
    array(
      get_template_directory(),
      'complianz-gdpr-premium',
      'templates',
      $file
    )
  );
}

add_filter('cmplz_cookiebanner_settings', 'helsinki_cmplz_cookiebanner_settings', 9999, 1);
function helsinki_cmplz_cookiebanner_settings( $settings ) {
	$settings = array_merge(
		$settings,
		helsinki_complianz_cookiebanner_styles()
	);
	if (cmplz_version < '6.0.0') {
		$settings['categories'] = helsinki_complianz_cookiebanner_categories_wrap(
			$settings['categories'] ?? ''
		);
		$settings['message_optout'] = helsinki_complianz_cookiebanner_message_wrap(
			$settings['message_optout'] ?? ''
		);
		$settings['message_optin'] = helsinki_complianz_cookiebanner_message_wrap(
			$settings['message_optin'] ?? ''
		);
	}

	//deleting the transient here ensures that theme overrides are applied in CSS generation
	delete_transient("helsinki_cmplz_banner_regeneration");

	return $settings;
}

function helsinki_complianz_cookiebanner_categories_wrap(string $categories = '') {
	if ( $categories ) {
		$parts = explode('<style>', $categories);
		if ( $parts ) {
			$parts = array_filter(
				$parts,
				function($part){
					return substr( $part, 0, 4 ) === "<div";
				}
			);
			$categories = implode('', $parts);
		}
		return '<div class="cookie-categories-wrap">' . $categories . '</div>';
	} else {
		return '';
	}
}

function helsinki_complianz_cookiebanner_message_wrap(string $message = '') {
	return sprintf(
		'<div class="cookie-notice">
			<h2 class="cookie-notice__title">%s</h2>
			%s
		</div>',
		sprintf(
			'%s %s',
			get_bloginfo( 'name' ),
			esc_html_x('uses cookies', 'cookie notice title prefix', 'helsinki-universal')
		),
		wpautop( $message )
	);
}

function helsinki_complianz_cookiebanner_styles() {
	if (cmplz_version >= '6.0.0') {
		return array(
			"banner_background_color" => "inherit",
			"banner_border_color" => "inherit",
			"banner_border_width" => "inherit",
			"banner_width" => "inherit",
			"text_font_size" => "inherit",
			"link_font_size" => "inherit",
			"category_body_font_size" => "inherit",
			"banner_border_radius" => "0px",
			"text_color" => "inherit",
			"hyperlink_color" => "inherit",
			"category_header_always_active_color" => "inherit",
			"button_accept_background_color" => "inherit",
			"button_accept_border_color" => "inherit",
			"button_accept_text_color" => "inherit",
			"button_deny_background_color" => "inherit",
			"button_deny_border_color" => "inherit",
			"button_deny_text_color" => "inherit",
			"button_settings_background_color" => "inherit",
			"button_settings_border_color" => "inherit",
			"button_settings_text_color" => "inherit",
			"button_border_radius" => "0px",
			"slider_active_color" => "inherit",
			"slider_inactive_color" => "inherit",
			"slider_bullet_color" => "inherit",
			"category_open_icon_url" => "inherit",
		);
	}
	else {
		return array(
			'position' => 'bottom',
			'theme' => 'block',
			'custom_css' => '',
			'colorpalette_background_color' => 'inherit',
			'colorpalette_background_border' => 'inherit',
			'colorpalette_text_color' => 'inherit',
			'colorpalette_text_hyperlink_color' => 'inherit',
			'colorpalette_toggles_background' => 'inherit',
			'colorpalette_toggles_bullet' => 'inherit',
			'colorpalette_toggles_inactive' => 'inherit',
			'colorpalette_border_radius' => '0px',
			'border_width' => '0px',
			'colorpalette_button_accept_background' => 'inherit',
			'colorpalette_button_accept_border' => 'inherit',
			'colorpalette_button_accept_text' => 'inherit',
			'colorpalette_button_deny_background' => 'inherit',
			'colorpalette_button_deny_border' => 'inherit',
			'colorpalette_button_deny_text' => 'inherit',
			'colorpalette_button_settings_background' => 'inherit',
			'colorpalette_button_settings_border' => 'inherit',
			'colorpalette_button_settings_text' => 'inherit',
			'buttons_border_radius' => '0px',
			'box_shadow' => 'none',
		);
	}
}

function helsinki_regenerate_banner(){
	//regenerate banner every 24 hours or plugin version change
	if (get_transient("helsinki_cmplz_banner_regeneration") != cmplz_version) {
		$banners = cmplz_get_cookiebanners();
		if ( $banners ) {
			foreach ( $banners as $banner_item ) {
				$banner = new CMPLZ_COOKIEBANNER( $banner_item->ID );
				$banner->save();
			}
		}
		set_transient("helsinki_cmplz_banner_regeneration", cmplz_version, 60*60*24);
	}
}
add_action('init', 'helsinki_regenerate_banner');
