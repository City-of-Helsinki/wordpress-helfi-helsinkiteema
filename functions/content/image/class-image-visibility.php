<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Image;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

final readonly class Image_Visibility
{
	public bool $hidden;

	public function __construct( int $post_id )
	{
		$this->hidden = ! empty( \get_post_meta( $post_id, 'hide_featured_image', true ) );
	}
}
