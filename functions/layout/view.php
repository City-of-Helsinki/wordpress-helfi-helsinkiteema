<?php

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
		if ( is_front_page() && is_home()) {
			$title = get_the_title(get_option('page_for_posts'));
		} else if (is_front_page()) {
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

if ( ! function_exists('helsinki_view_description_content') ) {
	function helsinki_view_description_content() {
		if ( is_front_page() && is_home()) {
			$description = get_the_excerpt(get_option('page_for_posts'));
		} else if (is_front_page()) {
			$description = get_the_excerpt(get_option('page_on_front'));
		} else if ( is_home() ) {
			$description = get_the_excerpt(get_option('page_for_posts'));
		} else if ( is_archive() ) {
			$description = get_the_archive_description();
		} else {
			$description = get_the_excerpt();
		}
		return apply_filters('helsinki_view_description', $description);
	}
}


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
