<?php

remove_action('load_custom_style', 'mtnc_add_custom_style', 20);

add_action( 'template_include', 'helsinki_maintenance_template', 999999 );
function helsinki_maintenance_template( $template ) {
	if ( false === strpos( $template, 'plugins/maintenance/load/index.php' ) ) {
		return $template;
	}
	return trailingslashit( get_template_directory() ) . 'maintenance/index.php';
}

add_filter( 'mtnc_get_default_array', 'helsinki_maintenance_defaults' );
function helsinki_maintenance_defaults( $defaults ) {
	return array_merge(
		$defaults,
		array(
	      'state'             => true,
	      'page_title'        => 'Sivusto on rakenteilla',
	      'heading'           => 'Sivusto on rakenteilla',
	      'description'       => 'Rakennamme uutta sivustoa ja se on pian saatavilla. Kiitos kärsivällisyydestäsi!',
	      'footer_text'       => '&copy; ' . get_bloginfo('name') . ' ' . date('Y'),
	      'body_bg'           => '',
	      'bg_image_portrait' => '',
	      'preloader_img'     => '',
	      '503_enabled'       => false,
	      'is_login'          => false,
	      'default_settings'  => true,
	    )
	);
}

function helsinki_maintenance_page_data() {
	$mt_options = mtnc_get_plugin_options( true );

	$logo = ! empty( $mt_options['logo'] ) ? $mt_options['logo'] : '';
	if ( $logo ) {
		$logo = wp_get_attachment_image_src( $logo, 'full' );
		$logo = $logo[0] ?? '';
	}

	$site_title       = get_bloginfo( 'title' );
	$site_description = get_bloginfo( 'description' );

	return array(
		'site_url' => site_url(),
		'site_title' => $site_title,
		'site_description' => $site_description,
		'page_title' => ! empty( $mt_options['page_title'] ) ? $mt_options['page_title'] : $site_title,
		'page_description' => ! empty( $mt_options['description'] ) ? $mt_options['description'] : $site_description,
		'logo' => $logo,
		'logo_ext' => $logo ? pathinfo( $logo, PATHINFO_EXTENSION ) : '',
	);
}

add_action( 'helsinki_maintenance_head', 'wp_enqueue_scripts', 1 );
add_action( 'helsinki_maintenance_head', 'wp_resource_hints', 2 );
add_action( 'helsinki_maintenance_head', 'locale_stylesheet' );
add_action( 'helsinki_maintenance_head', 'wp_print_styles', 7 );
add_action( 'helsinki_maintenance_head', 'wp_print_head_scripts', 8 );
add_action( 'helsinki_maintenance_head', 'wp_site_icon', 99 );

add_action( 'helsinki_maintenance_header', 'helsinki_maintenance_site_title' );
add_action( 'helsinki_maintenance_main', 'helsinki_maintenance_content', 10 );
add_action( 'helsinki_maintenance_footer_top', 'helsinki_maintenance_koros' );
add_action( 'helsinki_maintenance_footer', 'helsinki_footer_logo' );

function helsinki_maintenance_site_title( $data ) {
	printf(
		'<div class="site-title">%s</div>',
		sprintf(
			'<span>%s</span>',
			esc_attr( $data['site_title'] )
		)
	);
}

function helsinki_maintenance_content( $data ) {
	$parts = array();

	if ( $data['page_title'] ) {
		$parts[] = '<h1>' . esc_html( $data['page_title'] ) . '</h1>';
	}

	if ( $data['page_description'] ) {
		$parts[] = wp_kses_post( wpautop( $data['page_description'] ) );
	}

	$parts[] = helsinki_maintenance_button();

	printf(
		'<div class="grid m-up-2">
			<div class="grid__column">%s</div>
			<div class="grid__column">%s</div>
		</div>',
		implode( '', $parts ),
		helsinki_maintenance_image()
	);
}

function helsinki_maintenance_button() {
	return sprintf(
		'<a class="button hds-button" href="%s">%s</a>',
		'https://www.hel.fi',
		esc_html__( 'Go to hel.fi', 'helsinki-universal' )
	);
}

function helsinki_maintenance_image() {
	return sprintf(
		'<figure><img class="decoration" alt="" src="%s" width="823" height="1168"><figcaption class="wp-caption-text">%s</figcaption></figure>',
		trailingslashit( get_template_directory_uri() ) . 'assets/images/maintenance.png',
		__( 'Image: ', 'helsinki-universal') . 'Lille Santanen'
	);
}

function helsinki_maintenance_koros( $data ) {
	echo helsinki_koros( 'maintenance' );
}
