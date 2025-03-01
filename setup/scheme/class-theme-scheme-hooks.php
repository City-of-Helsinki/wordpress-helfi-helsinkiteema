<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Setup\Scheme;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Theme_Scheme_Hooks
{
	protected Theme_Scheme $scheme;
	protected Theme_Scheme_Styles $styles;

	public function __construct(
		Theme_Scheme $scheme,
		Theme_Scheme_Styles $styles
	) {
		$this->scheme = $scheme;
		$this->styles = $styles;
	}

	public function set_scheme( string $scheme ): void
	{
		$this->scheme->set_current( $scheme );
	}

	public function current_scheme(): string
	{
		return $this->scheme->current();
	}

	public function root_styles(): string
	{
		return $this->styles->root_styles( $this->scheme );
	}

	public function print_inline_styles(): void
	{
		printf( '<style>%s</style>', $this->root_styles() );
	}
}
