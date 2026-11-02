<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Image;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

final readonly class Content_Image
{
	public function __construct(
		public int $id,
		public string $size,
		public bool $fixed_size,
		public string $caption = '',
		public string $credit = '',
		public array $attributes = array()
	) {}
}
