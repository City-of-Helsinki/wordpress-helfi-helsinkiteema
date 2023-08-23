<?php

function helsinki_front_page_section( string $section, int $key = 0, $attributes = null) {
	$data = helsinki_front_page_section_data($section, $attributes);
	if ( $data ) {
		switch ( $section ) {
			case 'recent-posts':
				if ( ! $data['query']->posts ) {
					return;
				}
				break;

			case 'content':
				if ( ! $data['content'] ) {
					return;
				}
				break;

			default:
				break;
		}
	}

	get_template_part( "partials/front-page/{$section}", null, $data );
}

function helsinki_front_page_section_data( string $section ) {
	switch ( $section ) {

		case 'content':
			return array(
				'content' => helsinki_front_page_post_content(),
			);
			break;

		default:
			return array();
			break;
	}
}

function helsinki_front_page_section_title( string $section, string $default = '', $attributes = null) {
  $title = helsinki_get_front_page_section_title($section, $default, $attributes);
  if ( $title ) {
    helsinki_heading( 2, $title, '', array('container__heading') );
  }
}

function helsinki_get_front_page_section_title( string $section, string $default = '', $attributes = null ) {
	$title;
	if ($attributes != null && isset($attributes['title'])) {
		$title = $attributes['title'];
	}else {
		$title = helsinki_theme_mod('helsinki_front_page_' . $section, 'title');
	}
	if ( function_exists('pll__') ) {
		return pll__($title ?: $default);
	} else {
		return $title ?: $default;
	}
}

/**
  * Sections
  */
function helsinki_front_page_available_sections() {
$sections = array_keys(helsinki_front_page_default_sections());
  $sections = apply_filters( 'helsinki_front_page_available_sections', $sections );

  array_walk($sections, 'helsinki_front_page_section');
}

/**
  * Hero
  */
function helsinki_front_page_hero() {
	helsinki_front_page_section( 'hero' );
}

/**
  * Post Content
  */
function helsinki_front_page_post_content() {
	$front_page_id = get_option('page_on_front', 0);
	if ( ! $front_page_id ) {
		return;
	}

	return apply_filters(
		'the_content',
		get_the_content(
			null,
			false,
			get_post(
				$front_page_id,
				'OBJECT',
				'raw'
			)
		)
	);
}

function helsinki_front_page_content_title($args = array()) {
	helsinki_front_page_section_title(
		'content',
		''
	);
}

function helsinki_front_page_content_text($args = array()) {
	echo $args['content'];
}

function helsinki_front_page_archives($args = array()) {
	get_template_part(
		'partials/front-page/archives',
		null,
		$args
	);
}

function helsinki_front_page_load_post() {
	$front_page_id = get_option('page_on_front', 0);
	if ( ! $front_page_id ) {
		return;
	}
	$query = new WP_Query( array( 'page_id' => $front_page_id ) );
	if ($query->have_posts()) {
		$query->the_post();
	}
}

function helsinki_front_page_load_latest_posts_page() {
	$latest_posts_page_id = get_option('page_for_posts', 0);
	if ( ! $latest_posts_page_id ) {
		return;
	}
	$query = new WP_Query( array( 'page_id' => $latest_posts_page_id ) );
	if ($query->have_posts()) {
		$query->the_post();
	}
}

function helsinki_has_front_page_set() {
	$front_page_id = get_option('page_on_front', 0);
	if ( ! $front_page_id ) {
		return false;
	}
	return true;
}

function helsinki_front_page_unload_post() {
	wp_reset_postdata();
}