<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Renderers;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Stringable;
use WP_Term;

final class Term_Link implements Content_Renderer, Stringable
{
	private string $rel;

	public function __construct(
		private WP_Term $term,
		private array $classes = array(),
		string $rel = ''
	) {
		if ( $rel ) {
			$this->rel = $rel;
		} else {
			global $wp_rewrite;

			$this->rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() )
				? 'category tag'
				: 'category';
		}
	}

	public function __toString(): string
	{
		return $this->render();
	}

	public function render(): string
	{
		$url = get_term_link( $this->term );

		if ( $url && is_string( $url ) ) {
			global $wp_rewrite;

			return sprintf(
				'<a href="%1$s" class="%2$s" rel="%3$s">%4$s</a>',
				esc_url( $url ),
				esc_attr( implode(' ', $this->classes ) ),
				esc_attr( $this->rel ),
				esc_html( $this->term->name )
			);
		}

		return (new Term_Text( $this->term, $this->term ))->render();
	}
}
