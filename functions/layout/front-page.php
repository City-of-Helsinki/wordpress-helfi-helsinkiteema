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

function helsinki_front_page_section_data( string $section, $attributes = null) {
	switch ( $section ) {
		case 'recent-posts':
			return array(
				'query' => helsinki_front_page_recent_posts_query(array(
					'cat' => $attributes != null ? $attributes['category'] : helsinki_theme_mod('helsinki_front_page_recent-posts', 'category', 0),
					'posts_per_page' => $attributes != null ? $attributes['articles'] : helsinki_theme_mod('helsinki_front_page_recent-posts', 'posts_per_page', 3),
				)),
				'page_for_posts' => get_option('page_for_posts'),
				'attributes' => $attributes,
			);
			break;

		case 'content':
			return array(
				'content' => helsinki_front_page_post_content(),
			);
			break;

		case 'social':
			return array(
				'shortcode' => helsinki_front_page_social_shortcode(),
			);
			break;

		case 'feed-posts':
			$count = helsinki_front_page_feed_posts_count();
			$url = helsinki_front_page_feed_posts_url();
			return array(
				'feed_posts' => helsinki_front_page_feed_rss($url, $count),
				'feed_url' => $url,
				'feed_posts_count' => $count,
				'date_format' => get_option( 'date_format' ),
				'time_format' => get_option( 'time_format' ),
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
	if ($attributes['title'] != null) {
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
  $sections = helsinki_theme_mod('helsinki_front_page_sections', 'visible');
  if ( ! is_array( $sections ) ) {
    $sections = array_keys(helsinki_front_page_default_sections());
  }
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

/**
  * Recent Posts
  */
function helsinki_front_page_recent_posts_query( array $args ) {
  return new WP_Query(
		apply_filters(
			'helsinki_front_page_recent_posts_query_args',
			wp_parse_args(
				$args,
				array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => 3,
					'cat' => 0,
				)
			),
			$args
		)
	);
}

function helsinki_front_page_recent_posts_title($args = array()) {
	helsinki_front_page_section_title(
		'recent-posts',
		get_the_title($args['page_for_posts']),
		$args['attributes']
	);
}

function helsinki_front_page_recent_posts_grid($args = array()) {
	get_template_part(
		'partials/front-page/recent-posts/grid',
		null,
		$args
	);
}

function helsinki_front_page_recent_posts_more($args = array()) {
	get_template_part(
		'partials/front-page/recent-posts/more',
		null,
		$args
	);
}

/**
  * Social media
  */
function helsinki_front_page_social_shortcode() {
  return helsinki_theme_mod('helsinki_front_page_social', 'shortcode', '');
}

function helsinki_front_page_social_title($args = array()) {
	helsinki_front_page_section_title(
		'social',
		''
	);
}

function helsinki_front_page_social_media_feed($args = array()) {
	echo do_shortcode( $args['shortcode'] );
}

/**
  * Posts Feed
  */
function helsinki_front_page_feed_posts_url() {
	return helsinki_theme_mod('helsinki_front_page_feed-posts', 'feed_url', '');
}

function helsinki_front_page_feed_posts_source_text() {
	$url = helsinki_front_page_feed_posts_url();
	if ( $url ) {
		printf(
			'<p class="feed-source">%s</p>',
			sprintf(
				esc_html_x( 'This feed is fetched from %s.', 'RSS feed source(s)', 'helsinki-universal' ),
				sprintf(
					_x( '%s', 'from RSS feed source', 'helsinki-universal' ),
					parse_url( $url, PHP_URL_HOST )
				)
			)
		);
	}
}

function helsinki_front_page_feed_posts_count() {
	return 7;
}

function helsinki_front_page_feed_lifetime() {
	$hours = absint( helsinki_theme_mod('helsinki_front_page_feed-posts', 'feed_lifetime', 12) );
	return $hours > 0 ? HOUR_IN_SECONDS * $hours : HOUR_IN_SECONDS * 12;
}

function helsinki_front_page_lifetime_filter($lifetime, $url) {
	if ( helsinki_front_page_feed_posts_url() === $url ) {
		return helsinki_front_page_feed_lifetime();
	}
	return $lifetime;
}

function helsinki_front_page_feed_posts_title($args = array()) {
	helsinki_front_page_section_title(
		'feed-posts',
		''
	);
}

function helsinki_front_page_feed_rss(string $url = '', int $count = 10) {
	if ( ! $url ) {
		return array();
	}
	$feed = fetch_feed( $url );
	if ( is_wp_error( $feed ) ) {
		return array();
	}
	return $feed->get_items(
		0,
		$feed->get_item_quantity( $count )
	);
}

function helsinki_front_page_feed_posts($args = array()) {
	if ( empty( $args['feed_posts'] ) ) {
		return;
	}
	get_template_part(
		'partials/front-page/feed-posts/grid',
		null,
		$args
	);
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