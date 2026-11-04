<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Renderers;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Stringable;
use WP_Term;

final class Term_Text implements Content_Renderer, Stringable
{
	public function __construct(
		private WP_Term $term,
		private array $classes = array()
	) {}

	public function __toString(): string
	{
		return $this->render();
	}

	public function render(): string
	{
		return sprintf(
			'<span class="%1$s">%2$s</span>',
			esc_attr( implode(' ', $this->classes ) ),
			esc_html( $this->term->name )
		);
	}
}
