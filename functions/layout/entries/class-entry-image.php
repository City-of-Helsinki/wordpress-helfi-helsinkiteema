<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Layout\Entries;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

final readonly class Entry_Image
{
	public function __construct(
		public int $id,
		public string $size,
		public string $icon,
		public bool $fixed_size
	) {}
}
