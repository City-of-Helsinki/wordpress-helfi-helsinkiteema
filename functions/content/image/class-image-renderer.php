<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Image;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Renderers\Content_Renderer;
use CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Renderers\Wrap_Image;
use Stringable;

final class Image_Renderer implements Content_Renderer, Stringable
{
	public function __construct(
		private Content_Image $image,
		private string $wrap_class = ''
	) {}

	public function __toString(): string
	{
		return $this->render();
	}

	public function render(): string
	{
		$html = $this->image_html();

		if ( $html ) {
			$html .= $this->figcaption();
		}

		return $html ? sprintf(
			'<figure class="%s">%s</figure>',
			\esc_attr( $this->wrap_class ),
			$html
		) : '';
	}

	private function image_html(): string
	{
		$img = \wp_get_attachment_image(
			$this->image->id,
			$this->image->size,
			false,
			$this->image->attributes,
		);

		return $img ? (string) new Wrap_Image( $img, $this->image->fixed_size ) : '';
	}

	private function figcaption(): string
	{
		$content = array();

		if ( $this->image->caption ) {
			$content[] = $this->image->caption;
		}

		if ( $this->image->credit ) {
			$content[] = $this->image->credit;
		}

		return $content ? sprintf(
			'<figcaption>%s</figcaption>',
			\esc_html( implode( ' ', $content ) )
		) : '';
	}
}
