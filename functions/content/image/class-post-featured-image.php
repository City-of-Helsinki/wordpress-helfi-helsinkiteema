<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Image;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use WP_Post;

final class Post_Featured_Image implements View_Featured_Image
{
	public function __construct(
		private WP_Post $post,
		private Content_Image $image
	) {}

	public function enabled(): bool
	{
		return \apply_filters(
			'helsinki_blog_single_thumbnail',
			($this->image->id > 0)
		);
	}

	public function display(): void
	{
		echo (new Image_Renderer($this->image, 'content__thumbnail'));
	}
}
