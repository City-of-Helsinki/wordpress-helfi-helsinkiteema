<?php

/**
  * Element classes
  */
function helsinki_header_classes() {
	helsinki_element_classes(
		'navigation',
		array(
			'navigation',
		)
    );
}

if ( ! function_exists('helsinki_topbar_body_class') ) {
	function helsinki_topbar_body_class($classes) {
		return helsinki_add_body_class_has_n( $classes, 'topbar' );
	}
}

if ( ! function_exists('helsinki_header_highlight_link') ) {
	function helsinki_header_highlight_link() {
		$highlight = helsinki_theme_mod('helsinki_header_highlight', '', array());
		return array(
			'url' => $highlight['url'] ?? '',
			'text' => $highlight['text'] ?? '',
		);
	}
}

/**
  * Partials
  */
if ( ! function_exists('helsinki_header_skip') ) {
	function helsinki_header_skip() {
		get_template_part('partials/header/skip');
	}
}

if ( ! function_exists('helsinki_topbar') ) {
	function helsinki_topbar() {
		$lang = function_exists('pll_current_language') ? pll_current_language('slug') : 'fi';
		$name = apply_filters( 'helsinki_topbar_name', null );
		$args = apply_filters(
			'helsinki_topbar_args',
			array(
				'branding' => helsinki_topbar_branding( $lang ),
				'feedback' => helsinki_topbar_feedback( $lang ),
				'menu' => helsinki_topbar_menu(),
			),
			$name,
			$lang
		);

		get_template_part( 'partials/header/topbar', $name, $args);
	}
}

function helsinki_topbar_menu() {
	if ( has_nav_menu( 'topbar_menu' ) ) {
		return helsinki_menu( 'topbar_menu' );
	}
}

function helsinki_topbar_branding( string $language = 'fi' ) {
	$branding = array(
		'fi' => 'https://www.hel.fi/helsinki/fi',
		'sv' => 'https://www.hel.fi/helsinki/sv',
		'en' => 'https://www.hel.fi/helsinki/en',
	);

	return apply_filters(
		'helsinki_topbar_branding',
		array(
			'title' => 'Hel.fi',
			'url' => $branding[$language] ?? $branding['fi'],
		),
		$language,
		$branding
	);
}

function helsinki_topbar_feedback( string $language = 'fi' ) {
	$feedback = array(
		'fi' => 'https://www.hel.fi/helsinki/fi/kaupunki-ja-hallinto/osallistu-ja-vaikuta/palaute',
		'sv' => 'https://www.hel.fi/helsinki/sv/stad-och-forvaltning/delta/feedback',
		'en' => 'https://www.hel.fi/helsinki/en/administration/participate/feedback',
	);

	return apply_filters(
		'helsinki_topbar_branding',
		array(
			'title' => __( 'Feedback', 'helsinki-universal' ),
			'url' => $feedback[$language] ?? $feedback['fi'],
		),
		$language,
		$feedback
	);
}

if ( ! function_exists('helsinki_header_logo') ) {
	function helsinki_header_logo() {
		$classes = array();
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
		if ( $default_logo ) {
			$classes[] = 'has-icon';
		}

		if ( $custom_logo ) {
			$classes[] = 'custom-logo';

			if ( $default_logo ) {
				$classes[] = 'has-icon--after';
			}
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
	function helsinki_header_main_menu() {
		get_template_part('partials/header/menu');
	}
}

if ( ! function_exists('helsinki_header_mobile_panel') ) {
	function helsinki_header_mobile_panel() {
		get_template_part(
			'partials/header/mobile-panel',
			null,
			array()
		);
	}
}

if ( ! function_exists('helsinki_header_mobile_links') ) {
	function helsinki_header_mobile_links() {
		get_template_part('partials/header/mobile-links');
	}
}

if ( ! function_exists('helsinki_header_mobile_panel_toggle') ) {
	function helsinki_header_mobile_panel_toggle() {
		get_template_part('partials/header/mobile-panel-toggle');
	}
}


if ( ! function_exists('helsinki_header_mobile_menu') ) {
	function helsinki_header_mobile_menu() {
		get_template_part(
			'partials/header/mobile-menu',
			null,
			array()
		);
	}
}

if ( ! function_exists('helsinki_header_content') ) {
	function helsinki_header_content() {
		get_template_part('partials/header/content');
	}
}

if ( ! function_exists('helsinki_header_search') ) {
	function helsinki_header_search() {
		get_template_part('partials/header/search');
	}
}

if ( ! function_exists('helsinki_header_searchform') ) {
	function helsinki_header_searchform() {
		get_template_part('partials/header/searchform');
	}
}

if ( ! function_exists('helsinki_header_highlight') ) {
	function helsinki_header_highlight() {
		get_template_part(
			'partials/header/highlight',
			null,
			array(
				'link' => helsinki_header_highlight_link(),
			)
		);
	}
}

if ( ! function_exists('helsinki_available_languages') ) {
	function helsinki_available_languages() {
		if ( class_exists('Polylang') ) {
			return pll_the_languages(array(
				'echo'                   => 0,
				'hide_if_empty'          => 1,
				'hide_current'           => 0,
				'display_names_as'       => 'name',
				'hide_if_no_translation' => 1,
				'raw'                    => true
			));
		} else {
			return array();
		}
	}
}

if ( ! function_exists('helsinki_header_languages') ) {
	function helsinki_header_languages() {
		$name = apply_filters( 'helsinki_header_languages', null );

		$args = apply_filters(
			'helsinki_header_languages',
			array(
				'languages' => helsinki_available_languages(),
			),
			$name
		);

		if ( empty( $args['languages'] ) ) {
			return;
		}

		get_template_part( 'partials/header/languages', $name, $args);
	}
}

if ( ! function_exists('helsinki_header_koros') ) {
	function helsinki_header_koros() {
		helsinki_koros(
			'header',
			apply_filters( 'helsinki_header_koros_flipped', true )
		);
	}
}
