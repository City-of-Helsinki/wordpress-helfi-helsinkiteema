<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Layout\Entries;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Renderers\Content_Renderer;
use CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Renderers\Wrap_Image;
use Stringable;

final class Entry_Image_Renderer implements Content_Renderer
{
	private bool $with_placeholder = false;

	public function __construct(
		private Entry_Image $image,
		private array $attributes = array()
	) {}

	public function __toString(): string
	{
		return $this->render();
	}

	public function with_placeholder(): void
	{
		$this->with_placeholder = true;
	}

	public function render(): string
	{
		return $this->render_element( $this->image() ?: $this->placeholder() );
	}

	private function render_element( string $image ): string
	{
		return $image ? sprintf(
			'<div class="%s">%s</div>',
			\esc_attr( implode( ' ', $this->classes() ) ),
			(string) new Wrap_Image( $image, $this->image->fixed_size )
		) : '';
	}

	private function image(): string
	{
		return $this->image->id
			? \wp_get_attachment_image(
				$this->image->id,
				$this->image->size,
				false,
				$this->attributes
			)
			: '';
	}

	private function placeholder(): string
	{
		return ( $this->with_placeholder && $this->image->icon )
			? \helsinki_get_svg_placeholder( $this->image->icon )
			: '';
	}

	private function classes(): array
	{
		$classes = array( 'entry__thumbnail' );

		if ( $this->with_placeholder ) {
			$extra = array( 'has-icon' );

			if ( \helsinki_scheme_has_invert_color() ) {
				$extra[] = 'has-invert-color';
			}

			$classes = array_merge(
				$classes,
				\apply_filters( 'helsinki_entry_image_icon_classes', $extra )
			);
		}

		return $classes;
	}
}
