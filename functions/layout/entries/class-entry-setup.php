<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Layout\Entries;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use WP_Post;

final class Entry_Setup
{
	private Entry_Classes $classes;
	private bool $placeholder = false;

	public function __construct(
		private WP_Post $post,
		private Entry_Image $image,
		array $classes = array()
	) {
		$this->classes = new Entry_Classes( $post->post_type );

		$this->classes->add_class(
			'entry',
			'entry--' . $post->post_type,
			...$classes,
		);

		if ( $image->id ) {
			$this->classes->add_class( 'has-thumbnail' );
		}
	}

	public function post(): WP_Post
	{
		return $this->post;
	}

	public function thumbnail(): string
	{
		$image = new Entry_Image_Renderer( $this->image );

		if ( $this->has_placeholder() ) {
			$image->with_placeholder();
		}

		return $image->render();
	}

	public function has_thumbnail(): int
	{
		return $this->image->id;
	}

	public function has_placeholder(): bool
	{
		return $this->placeholder;
	}

	public function with_placeholder(): void
	{
		$this->placeholder = true;
		$this->classes->add_class( 'has-thumbnail', 'has-placeholder' );
	}

	public function add_class( string|array $classes ): void
	{
		$this->classes->add_class( $classes );
	}

	public function classes(): array
	{
		return $this->classes->classes();
	}
}
