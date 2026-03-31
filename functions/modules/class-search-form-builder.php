<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Modules;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Search_Form_Builder
{
	private string $form_id;
	private string $title;
	private int $title_level;
	private array $title_classes;

	public function __construct()
	{
		$this->setup_builder();
	}

	private function setup_builder(): void
	{
		$this->form_id = '';
		$this->title_level = 2;
		$this->title_classes = array();
	}

	public function set_form_id( string $id ): self
	{
		$this->form_id = $id;

		return $this;
	}

	public function set_title( string $title ): self
	{
		$this->title = $title;

		return $this;
	}

	public function set_title_level( int $level ): self
	{
		$this->title_level = max( 1, min( 6, $level ) );

		return $this;
	}

	public function set_title_classes( string ...$classes ): self
	{
		$this->title_classes = array_merge( $this->title_classes, $classes );

		return $this;
	}

	public function render_form(): void
	{
		$html = $this->search_title_html() . $this->search_form_html();

		$this->setup_builder();

		echo $html;
	}

	private function search_form_html(): string
	{
		$attributes = array(
			'id' => $this->form_id(),
			'class' => 'search-form',
			'role' => 'search',
			'method' => 'get',
			'action' => esc_url( home_url( '/' ) ),
		);

		if ( $this->title ) {
			$attributes['aria-labelledby'] = $this->form_title_id();
		}

		return get_search_form( array(
			'echo' => false,
			'aria_label' => '',
			'id' => $this->form_id,
			'search_input_id' => $this->search_input_id(),
			'form_attributes' => $this->format_attributes( $attributes ),
		) );
	}

	private function search_title_html(): string
	{
		if ( $this->title ) {
			$this->set_title_classes( 'search-title' );

			return sprintf(
				'<h%1$d %2$s>%3$s</h%1$d>',
				$this->title_level,
				$this->format_attributes( array(
					'id' => $this->form_title_id(),
					'class' => implode( ' ', $this->title_classes ),
				) ),
				esc_html( $this->title )
			);
		}

		return '';
	}

	private function form_id(): string
	{
		return $this->format_id( 'search-form', $this->form_id );
	}

	private function form_title_id(): string
	{
		return $this->format_id( 'search-title', $this->form_id );
	}

	private function search_input_id(): string
	{
		return $this->format_id( 'search-input', $this->form_id );
	}

	private function format_id( string $base, string $name ): string
	{
		return $name ? sprintf( '%s-%s', $name, $base ) : $base;
	}

	private function format_attributes( array $attributes ): string
	{
		return implode( ' ', array_map(
			fn( $key, $value ) => sprintf( '%s="%s"', $key, esc_attr( $value ) ),
			array_keys( $attributes ),
			array_values( $attributes ),
		) );
	}
}
