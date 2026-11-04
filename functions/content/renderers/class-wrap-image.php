<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Renderers;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Stringable;

final class Wrap_Image implements Content_Renderer, Stringable
{
	private string $classes;

	public function __construct(
		private string $image,
		bool $fixed
	) {
		$this->classes = 'image-wrap';

		if ( $fixed ) {
			$this->classes .= ' image-wrap--fixed-size';
		}
	}

	public function __toString(): string
	{
		return $this->render();
	}

	public function render(): string
	{
		return sprintf(
			'<div class="%s">%s</div>',
			$this->classes,
			$this->image
		);
	}
}
