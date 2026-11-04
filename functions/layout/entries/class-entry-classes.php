<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Layout\Entries;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

final class Entry_Classes
{
	private array $classes;
	private bool $dirty;

	public function __construct(
		private string $post_type
	) {
		$this->classes = array();
	}

	public function add_class( string ...$classes ): void
	{
		if ( $classes ) {
			$this->dirty = true;
			$this->classes = array_merge( $this->classes, $classes );
		}
	}

	public function classes(): array
	{
		if ( $this->dirty ) {
			$this->dirty = false;

			$classes = \apply_filters(
				"helsinki_{$this->post_type}_entry_classes",
				$this->classes
			);

			$this->classes = array_filter( array_unique( $classes ) );
		}

		return $this->classes;
	}
}
