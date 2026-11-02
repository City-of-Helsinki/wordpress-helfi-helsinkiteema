<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Image;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use WP_Post;

final class Page_Featured_Image
{
	public function __construct(
		private WP_Post $post,
		private Content_Image $image,
		private Image_Visibility $visibility
	) {}

	public function enabled(): bool
	{
		return ((int) get_option( 'page_for_posts', 0 ) !== $this->post->ID)
			&& ! helsinki_is_landing_page()
			&& ! $this->visibility->hidden
			&& ($this->image->id > 0);
	}

	public function display(): void
	{
		echo (new Image_Renderer($this->image, 'content__thumbnail'));
	}
}
