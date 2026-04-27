<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
  * Element classes
  */
function helsinki_header_classes(): void {
	/*
	 * @since 4.38.0
	 */
	helsinki_deprecation_notice( __FUNCTION__, 'partials/header/element' );
}

/**
  * Partials
  */
if ( ! function_exists( 'helsinki_header_element' ) ) {
	function helsinki_header_element(): void {
		get_template_part( 'partials/header/element' );
	}
}


if ( ! function_exists('helsinki_header_skip') ) {
	function helsinki_header_skip(): void {
		$target = apply_filters( 'helsinki_header_skip_target', 'main' );
		$text   = apply_filters( 'helsinki_header_skip_text', __( 'Skip to content', 'helsinki-universal' ) );

		if ( $target && $text ) {
			printf(
				'<a class="navigation__skip screen-reader-text" href="#%s">%s</a>',
				esc_attr( $target ),
				esc_html( $text )
			);
		}
	}
}

if ( ! function_exists('helsinki_header_skip_target') ) {
	function helsinki_header_skip_target(): void {
		/*
		 * @since 4.39.0
		 */
		helsinki_deprecation_notice( __FUNCTION__, 'helsinki_header_skip' );
	}
}

if ( ! function_exists('helsinki_header_logo') ) {
	function helsinki_header_logo(): void {
		$classes = array( 'home-link' );
		$blog_name = get_bloginfo('name');
		$home_url = home_url('/');

		$custom_logo = '';
		$logo_src = wp_get_attachment_image_src(
			get_theme_mod('custom_logo', 0),
			'full'
		);
		if ( is_array($logo_src) && $logo_src ) {
			$custom_logo = sprintf(
				'<img src="%s" alt="%s" width="%d" height="%d">',
				esc_url($logo_src[0]),
				esc_html($blog_name),
				esc_attr($logo_src[1]),
				esc_attr($logo_src[2])
			);
		}

		$default_logo = apply_filters('helsinki_header_default_logo_enabled', true) ? helsinki_get_svg_logo(): '';
		if ( $default_logo || $custom_logo) {
			$classes[] = 'has-icon';
		}

		if ( $custom_logo ) {
			$classes[] = 'custom-logo';
			$classes[] = 'has-icon--before';
		} else if ( $default_logo ) {
			$classes[] = 'has-icon--before';
		}

		get_template_part(
			'partials/header/logo',
			null,
			array(
				'classes' => $classes,
				'default_logo' => $default_logo,
				'custom_logo' => $custom_logo,
				'blog_name' => $blog_name,
				'home_url' => $home_url,
			)
		);
	}
}

if ( ! function_exists('helsinki_header_main_menu') ) {
	function helsinki_header_main_menu(): void {
		get_template_part('partials/header/menu');
	}
}

if ( ! function_exists('helsinki_header_mobile_panel') ) {
	function helsinki_header_mobile_panel(): void {
		get_template_part(
			'partials/header/mobile-panel',
			null,
			array()
		);
	}
}

if ( ! function_exists('helsinki_header_mobile_links') ) {
	function helsinki_header_mobile_links(): void {
		$lang = function_exists('pll_current_language') ? pll_current_language('slug') : substr( get_bloginfo('language'), 0, 2 );
		$name = apply_filters( 'helsinki_topbar_name', null );
		$args = apply_filters(
			'helsinki_topbar_args',
			array(
				'branding' => helsinki_topbar_branding( $lang ),
				'feedback' => helsinki_topbar_feedback( $lang ),
				'menu' => helsinki_mobile_topbar_menu(),
			),
			$name,
			$lang
		);

		get_template_part('partials/header/mobile-links', null, $args);
	}
}

if ( ! function_exists('helsinki_header_mobile_panel_toggle') ) {
	function helsinki_header_mobile_panel_toggle(): void {
		/*
		 * @since 4.38.0
		 */
		helsinki_deprecation_notice( __FUNCTION__, 'partials/header/mobile-panel' );
	}
}

if ( ! function_exists( 'helsinki_header_mobile_menu' ) ) {
	function helsinki_header_mobile_menu(): void {
		get_template_part(
			'partials/header/mobile-menu',
			null,
			array()
		);
	}
}

if ( ! function_exists('helsinki_header_content') ) {
	function helsinki_header_content():void {
		/*
		 * @since 4.38.0
		 */
		helsinki_deprecation_notice( __FUNCTION__, 'partials/header/element' );
	}
}

if ( ! function_exists('helsinki_header_search') ) {
	function helsinki_header_search(): void {
		get_template_part('partials/header/search');
	}
}

if ( ! function_exists('helsinki_header_searchform') ) {
	function helsinki_header_searchform(): void {
		/*
		 * @since 4.38.0
		 */
		helsinki_deprecation_notice( __FUNCTION__, 'helsinki_header_search' );
	}
}

if ( ! function_exists('helsinki_available_languages') ) {
	function helsinki_available_languages(): array {
		return apply_filters( 'helsinki_available_languages', array() );
	}
}

if ( ! function_exists('helsinki_header_languages') ) {
	function helsinki_header_languages(): void {
		$name = apply_filters( 'helsinki_header_languages', null );

		$args = apply_filters(
			'helsinki_header_languages',
			array( 'languages' => helsinki_available_languages() ),
			$name
		);

		if ( empty( $args['languages'] ) ) {
			return;
		}

		$args['accessibility'] = array(
			'fi' => 'Vaihda sivuston kieleksi ',
			'en' => 'Switch website language to ',
			'sv' => 'Ändra webbplatsens språk till ',
		);

		get_template_part( 'partials/header/languages', $name, $args);
	}
}

if ( ! function_exists('helsinki_header_koros') ) {
	function helsinki_header_koros(): void {
		helsinki_koros(
			'header',
			apply_filters( 'helsinki_header_koros_flipped', true )
		);
	}
}
