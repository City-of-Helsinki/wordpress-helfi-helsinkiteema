<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Renderers;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

interface Content_Renderer
{
	public function render(): string;
}
