<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Renderers;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Stringable;
use WP_Term;

final class Tag implements Content_Renderer, Stringable
{
	private Content_Renderer $renderer;

	public function __construct(
		WP_Term $term,
		bool $as_link = true,
		array $classes = array()
	) {
		$classes = array_merge(
			$classes,
			array(
				'hds-tag',
				'hds-tag--rounded-corners',
			)
		);

		if ( $as_link ) {
			$classes[] = 'hds-tag--link';

			$this->renderer = new Term_Link( $term, $classes, 'tag' );
		} else {
			$this->renderer = new Term_Text( $term, $classes );
		}
	}

	public function __toString(): string
	{
		return $this->render();
	}

	public function render(): string
	{
		return $this->renderer->render();
	}
}
