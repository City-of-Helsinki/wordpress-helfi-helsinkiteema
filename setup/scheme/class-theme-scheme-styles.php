<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Setup\Scheme;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Theme_Scheme_Styles
{
	protected array $colors;

	public function __construct( array $colors )
	{
		$this->colors = $colors;
	}

	public function root_styles( Theme_Scheme $scheme ): string
	{
		return sprintf( ':root {%s}', implode( ' ' ,
			$this->colors_to_css_properties( $this->setup_colors( $scheme ) )
		) );
	}

	private function colors_to_css_properties( array $colors ): array
	{
		$use_hex = $this->use_hex( $colors );

		$properties = array();
		foreach ( $colors as $key => $value ) {
			$properties[] = sprintf(
				'%s: %s;',
				\esc_attr($key),
				$use_hex ? \sanitize_hex_color( $value ) : 'var(' . \esc_attr($value) . ')'
			);
		}

		return $properties;
	}

	private function use_hex( array $colors ): bool
	{
		return \apply_filters(
			'helsinki_scheme_root_styles_use_hex',
			! empty( \sanitize_hex_color( $colors['--primary-color'] ) )
		);
	}

	private function setup_colors( Theme_Scheme $scheme ): array
	{
		$config = $this->color_config( $scheme );

		return \apply_filters(
			'helsinki_scheme_root_styles_colors',
			array(
				'--primary-color' => $config['primary']['color']
					?? '--color-' . $scheme->current(),
				'--primary-color-light' => $config['primary']['light']
					?? '--color-' . $scheme->current() . '-light',
				'--primary-color-medium' => $config['primary']['medium']
					?? '--color-' . $scheme->current() . '-medium-light',
				'--primary-color-dark' => $config['primary']['dark']
					?? '--color-' . $scheme->current() . '-dark',
				'--primary-content-color' => $config['primary']['content']
					?? '--color-' . $scheme->current() . '-content',
				'--primary-content-secondary-color' => $config['primary']['content-secondary']
					?? '--color-' . $scheme->current() . '-content-secondary',
				'--secondary-color' => $config['secondary']
					?? '',
				'--secondary-content-color' => $config['secondary-content']
					?? '',
				'--accent-color' => $config['accent']
					?? '',
			),
			$scheme->current(),
			$config
		);
	}

	private function color_config( Theme_Scheme $scheme ): array
	{
		$colors = \apply_filters( 'helsinki_colors', $this->colors );

		return $colors[$scheme->current()] ?? $colors[$scheme->default()];
	}
}
