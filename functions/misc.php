<?php

function helsinki_deprecation_notice( string $deprecated, string $new ) {
	trigger_error(
		"The {$deprecated} function is deprecated. Please use {$new} instead.",
	    defined( 'E_USER_DEPRECATED' ) ? E_USER_DEPRECATED : E_USER_WARNING
	);
}

if ( ! function_exists('helsinki_heading') ) {
  function helsinki_heading(int $level, string $text, string $id = '', $classes = array()) {
    if ( $level < 1 ) {
      $level = 1;
    } else if ( $level > 6 ) {
      $level = 6;
    }
    $id_attr = '';
    if ( $id ) {
      $id_attr = ' id="' . esc_attr($id) . '"';
    }
    $class_attr = '';
    if ( $classes ) {
      $class_attr = ' class="' . esc_attr(implode(' ', $classes)) . '"';
    }
    echo sprintf(
      '<h%1$d%3$s%4$s><span>%2$s</span></h%1$d>',
      absint($level),
      esc_html($text),
      $id_attr,
      $class_attr
    );
  }
}

function helsinki_image_with_wrap( string $image = '', bool $fixed = false ) {
	$class = array(
		'image-wrap'
	);

	if ( $fixed ) {
		$class[] = 'image-wrap--fixed-size';
	}

	return sprintf(
		'<div class="%s">%s</div>',
		implode(' ', $class),
		$image
	);
}

function helsinki_trim_title( string $title ) {
	return helsinki_trim_text(
		$title,
		apply_filters( 'helsinki_entry_title_length', 85 )
	);
}

function helsinki_trim_text( string $text, int $max_length ) {
	return strlen($text) > $max_length ? mb_substr($text, 0, $max_length) . '&hellip;' : $text;
}

function helsinki_first_image_from_string( string $text = '' ) {
	preg_match_all('/<img.*\/>/i', $text, $matches);
	return ! empty( $matches[0][0] ) ? $matches[0][0] : '';
}

function helsinki_first_paragraph_from_string( string $text = '' ) {
	preg_match_all('/<p.*>.*<\/p>/i', $text, $matches);
	return ! empty( $matches[0][0] ) ? $matches[0][0] : '';
}

/**
  * Conditionals
  */
function helsinki_id_is_front_page( $id = null ) {
	if ( $id ) {
		$front_page_id = apply_filters(
			'helsinki_polylang_active', false ) ?
			pll_get_post( get_option('page_on_front'), pll_current_language() )
			: get_option('page_on_front');
		return absint( $front_page_id ) === absint( $id );
	}
	return false;
}

function helsinki_is_landing_page() {
	return is_page_template( 'template/landing-page.php' );
}

function helsinki_is_static_front_page() {
	$type = get_option("show_on_front", false);
	if ($type == "page") {
		return true;
	}
	else {
		return false;
	}
}

/**
  * Element attributes
  */
function helsinki_element_styles( array $styles, bool $with_style = false ) {
	if ( ! $styles ) {
		return;
	}

	$css = array();
	foreach ($styles as $key => $value) {
		$css[] = sprintf(
			'%s: %s;',
			sanitize_key( $key ),
			filter_var( $key, FILTER_VALIDATE_URL ) ? esc_url( $value ) : esc_attr( $value )
		);
	}

	return $with_style ? 'style="' . implode(' ', $css) . '"' : implode(' ', $css);
}

/**
  * Image sizes
  */
function helsinki_image_size_large() {
	return 'large';
}

function helsinki_image_size_full() {
	return 'full';
}
