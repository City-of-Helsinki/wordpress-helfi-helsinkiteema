<?php

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

function helsinki_hero_styles() {
	$styles = apply_filters( 'helsinki_hero_styles', array() );
	if ( ! $styles ) {
		return;
	}

	$out = array();
	foreach ($styles as $key => $value) {
		$out[] = sprintf(
			'%s: %s;',
			sanitize_key( $key ),
			filter_var( $key, FILTER_VALIDATE_URL ) ? esc_url( $value ) : esc_attr( $value )
		);
	}

	echo implode(' ', $out);
}

function helsinki_hero_image( string $filter_name, string $size, bool $fixed = false, $post = null, $attr = '' ) {
	echo helsinki_image_with_wrap(
		get_the_post_thumbnail(
			$post,
			apply_filters( $filter_name, $size ),
			$attr
		),
		$fixed
	);
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
	preg_match_all('/<img.*>/i', $text, $matches);
	return ! empty( $matches[0][0] ) ? $matches[0][0] : '';
}
