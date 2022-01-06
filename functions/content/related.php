<?php

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
