<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Setup\Scheme;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Theme_Scheme
{
	protected string $current;
	protected string $default;
	protected array $options;

	public function __construct( array $options, string $default )
	{
		$this->options = $options;
		$this->default = $default;
		$this->current = $default;
	}

	public function set_current( string $scheme ): void
	{
		if ( $scheme ) {
			$this->validate_scheme( $scheme );
			$this->current = $scheme;
		}
	}

	public function current(): string
	{
		return $this->current;
	}

	public function default(): string
	{
		return \apply_filters( 'helsinki_default_scheme', $this->default );
	}

	private function validate_scheme( string $scheme ): void
	{
		if ( ! isset( $this->options[$scheme] ) ) {
			throw new \InvalidArgumentException( sprintf(
				_x( '%s is not a valid theme scheme.', 'Helsinki theme scheme validation exception', 'helsinki-universal' ),
				$scheme
			) );
		}
	}
}
