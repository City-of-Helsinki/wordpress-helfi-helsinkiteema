<?php

/**
  * View header
  */
if ( ! function_exists('helsinki_view_header') ) {
	function helsinki_view_header() {
		get_template_part('partials/view/header');
	}
}

if ( ! function_exists('helsinki_view_heading') ) {
	function helsinki_view_heading() {
		$title = apply_filters(
			'helsinki_view_heading_title',
			helsinki_view_title()
		);

		$tag = apply_filters(
			'helsinki_view_heading_tag',
			'h1'
		);

		echo sprintf(
	      '<%1$s class="view-header__title">%2$s</%1$s>',
	      $tag,
	      wp_kses_post( $title )
	    );
	}
}

if ( ! function_exists('helsinki_view_title') ) {
	function helsinki_view_title() {
		if ( is_front_page() ) {
			$title = get_the_title(get_option('page_on_front'));
		} else if ( is_home() ) {
			$title = get_the_title(get_option('page_for_posts'));
		} else if ( is_archive() ) {
			$title = get_the_archive_title();
		} else if ( is_author() ) {
			$title = __('Author', 'helsinki-universal');
		} else if ( is_search() ) {
			$title = __('Search', 'helsinki-universal');
		} else if ( is_404() ) {
			$title = __('Not Found', 'helsinki-universal');
		} else {
			$title = get_the_title();
		}

		return apply_filters( 'helsinki_view_title', $title );
	}
}

if ( ! function_exists('helsinki_view_description') ) {
	function helsinki_view_description() {
		get_template_part('partials/view/description');
	}
}

/**
  * Breadcrumbs
  */
if ( ! function_exists('helsinki_content_breadcrumbs') ) {
	function helsinki_content_breadcrumbs() {
		if ( function_exists('yoast_breadcrumb') ) {
			yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs"><div class="hds-container hds-container--wide">','</div></div>' );
		}
	}
}

/**
  * Search
  */
if ( ! function_exists('helsinki_search_form') ) {
  function helsinki_search_form() {
    get_search_form();
  }
}

/**
  * Content article
  */
if ( ! function_exists('helsinki_content_article') ) {
	function helsinki_content_article() {
		get_template_part('partials/content/article');
	}
}

function helsinki_content_article_header() {
	get_template_part('partials/content/parts/header');
}

function helsinki_content_article_header_class() {
	$class = 'content__header';

	if ( is_page() ) {
		$class .= ' hero';
	}

	helsinki_hero_classes($class);
}

function helsinki_content_article_header_container_class() {
	$class = array();

	if ( is_page() ) {
		$class[] = 'hds-container';
		$class[] = 'hero__content';
	}

	helsinki_element_classes(
    'content_article_header_container',
    $class
  );
}

function helsinki_content_article_koros() {
	helsinki_koros(
		'content',
		apply_filters( 'helsinki_content_article_koros_flipped', true )
	);
}

function helsinki_content_article_title() {
	get_template_part('partials/content/parts/title');
}

function helsinki_content_article_has_call_to_action() {
	$meta = helsinki_content_article_call_to_action_data();
	$button_1_exists = $meta['button_1']['text'] && $meta['button_1']['url'];
	$button_2_exists = $meta['button_2']['text'] && $meta['button_2']['url'];
	return $button_1_exists || $button_2_exists;
}

function helsinki_content_article_call_to_action_data() {
	$post_id = get_the_ID();
	return array(
		'button_1' => array(
			'text' => get_post_meta( $post_id, 'hero_cta_text', true ),
			'url' => get_post_meta( $post_id, 'hero_cta_url', true ),
		),
		'button_2' => array(
			'text' => get_post_meta( $post_id, 'hero_cta_2_text', true ),
			'url' => get_post_meta( $post_id, 'hero_cta_2_url', true ),
		),
	);
}

function helsinki_content_article_call_to_action() {
	get_template_part(
		'partials/content/parts/call-to-action',
		null,
		array(
			'cta' => helsinki_content_article_call_to_action_data(),
		)
	);
}

function helsinki_content_article_excerpt() {
	get_template_part('partials/content/parts/excerpt');
}

function helsinki_content_excerpt( $post = null ) {
	echo helsinki_get_content_excerpt( $post );
}

function helsinki_get_content_excerpt( $post = null ) {
	$excerpt = get_the_excerpt( $post );
	$max_length = apply_filters( 'helsinki_content_excerpt_length', 195 );
	return mb_strlen($excerpt) > $max_length ? mb_substr($excerpt, 0, $max_length) : $excerpt;
}

function helsinki_content_article_thumbnail($post_type = null) {
	$img_html = '';
	$caption = '';
	$fixed_size = false;
	$thumbnail_id = get_post_thumbnail_id();

	if ( $thumbnail_id ) {
		$img_html = wp_get_attachment_image(
			$thumbnail_id,
			apply_filters( 'helsinki_content_article_thumbnail_size', 'large' ),
			false,
			array()
		);
		$caption = wp_get_attachment_caption( $thumbnail_id );
	}

	$data = array(
		'image' => $img_html,
		'caption' => $caption,
		'fixed_size' => $fixed_size,
	);

	if ( ! $data['image'] ) {
		return;
	}

	get_template_part(
		'partials/content/parts/thumbnail',
		$post_type,
		$data
	);
}

function helsinki_featured_image_is_hidden() {
	return get_post_meta( get_queried_object_id(), 'hide_featured_image', true ) ? true : false;
}

function helsinki_content_article_meta() {
	get_template_part('partials/content/parts/meta');
}

function helsinki_content_article_date() {
	get_template_part('partials/content/parts/date');
}

function helsinki_content_article_updated() {
	$u_time = get_the_time('U');
	$u_modified_time = get_the_modified_time('U');
	if ( $u_modified_time > $u_time ) {
		get_template_part('partials/content/parts/updated');
	}
}

function helsinki_content_article_categories() {
	get_template_part('partials/content/parts/categories');
}

function helsinki_content_article_author() {
	get_template_part('partials/content/parts/author');
}

function helsinki_content_article_tags() {
	get_template_part('partials/content/parts/tags');
}

function helsinki_content_article_related($post_type = null) {
	$posts_per_page = helsinki_theme_mod( 'helsinki_blog_single', 'related_count', 3 );
	$post_id = array(get_the_ID());
	$query = helsinki_content_article_related_posts_query(
		$post_id,
		array_map(
			function($category) {
				return $category->term_id;
			},
			get_the_category()
		),
		$posts_per_page
	);

	$posts = $query->posts;

	if ( $query->post_count < $posts_per_page ) {
		$more = helsinki_content_article_related_posts_query(
			array_merge(
				$post_id,
				array_map(
					function($post) {
						return $post->ID;
					},
					$query->posts
				)
			),
			array(),
			$posts_per_page - $query->post_count
		);

		$posts = array_merge(
			$posts,
			$more->posts
		);
	}

	if ( $posts ) {
		get_template_part(
			'partials/content/parts/related',
			null,
			array(
				'posts' => $posts,
				'per_page' => $posts_per_page,
			)
		);
	}
}

function helsinki_content_article_related_posts_query( array $post_id, array $terms = array(), int $posts_per_page = 4) {
	$args = array(
		'post__not_in' => $post_id,
		'post_type' => 'post',
		'posts_status' => 'publish',
		'posts_per_page' => $posts_per_page,
	);

	if ( $terms ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'category',
				'field' => 'term_id',
				'terms' => $terms,
			),
		);
	}

	return new WP_Query($args);
}

function helsinki_content_article_social_share() {
	$links = helsinki_social_share_links();
	if ( ! $links ) {
		return;
	}
	get_template_part(
		'partials/content/parts/social-share',
		null,
		$links
	);
}

function helsinki_content_article_body() {
	get_template_part('partials/content/parts/body');
}

function helsinki_content_article_container_class() {
	$class = array(
		'content__container',
		'hds-container',
	);

	helsinki_element_classes(
      'content_article_container',
      $class
    );
}

/**
  * Pagination
  */
if ( ! function_exists('helsinki_loop_pagination') ) {
	function helsinki_loop_pagination() {
		get_template_part('partials/loop/pagination');
	}
}

/**
  * No posts
  */
if ( ! function_exists('helsinki_no_posts_notice') ) {
	function helsinki_no_posts_notice() {
		get_template_part('partials/content/none');
	}
}

/**
  * Not found
  */
if ( ! function_exists('helsinki_not_found_notice') ) {
	function helsinki_not_found_notice() {
		get_template_part('partials/content/not-found');
	}
}

/**
  * Categories
  */
if ( ! function_exists('helsinki_blog_filter') ) {
	function helsinki_blog_filter() {
		get_template_part('partials/loop/filter');
	}
}

if ( ! function_exists('helsinki_category_featured_image') ) {
	function helsinki_category_featured_image( int $id ) {
		return get_term_meta( $id, 'featured_image', true );
	}
}

function helsinki_post_first_category( int $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	$categories = get_the_category( $post_id );
	return $categories[0] ?? null;
}

/**
  * Hero
  */
if ( ! function_exists('helsinki_view_hero') ) {
	function helsinki_view_hero() {
		get_template_part('partials/view/hero');
	}
}

if ( ! function_exists('helsinki_view_hero_image') ) {
	function helsinki_view_hero_image_url() {
		$image_id = 0;
		$size = 'full';

		if ( is_front_page() ) {
			$image_id = get_post_thumbnail_id( get_option('page_for_posts') );
			$size = 'large';
		} else if ( is_category() ) {
			$image_id = helsinki_category_featured_image( get_queried_object_id() );
		} else if ( has_post_thumbnail() ) {
			$image_id = get_post_thumbnail_id();
		}

		return apply_filters(
			'helsinki_view_hero_image_url',
			wp_get_attachment_image_url(
				apply_filters('helsinki_view_hero_image_id', $image_id),
				apply_filters('helsinki_view_hero_image_size', $size)
			)
		);
	}
}
