<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Image;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

interface View_Featured_Image
{
	public function enabled(): bool;
	public function display(): void;
}
