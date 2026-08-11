<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Integrations\Askem;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Feedback_Buttons_Setup
{
	private bool $script_enabled = true;
	private string $html_before = '';
	private string $html_after = '';

	public function __construct(
		private string $script,
		private string $buttons_html = ''
	) {}

	public function script(): string
	{
		return $this->script;
	}

	public function enable_script( bool $enabled ): void
	{
		$this->script_enabled = $enabled;
	}

	public function append_html( string $html ): void
	{
		$this->html_before .= $html;
	}

	public function prepend_html( string $html ): void
	{
		$this->html_after .= $html;
	}

	public function buttons_html(): string
	{
		$html = $this->html_before
			. $this->buttons_html
			. $this->html_after;

		$html = \wp_kses( $html, $this->kses() );

		if ( $this->script_enabled ) {
			$html .= sprintf(
				'<script src="%s" type="text/javascript"></script>',
				\esc_url( $this->script )
			);
		}

		return $html;
	}

	public function kses(): array
	{
		return array(
			'div' => array(
				'id' => true,
				'class' => true,
				'data-*' => true,
			),
			'h2' => array(
				'id' => true,
				'class' => true,
			),
			'h3' => array(
				'id' => true,
				'class' => true,
			),
			'p' => array(
				'id' => true,
				'class' => true,
			),
			'span' => array(
				'id' => true,
				'class' => true,
				'aria-*' => true,
				'role' => true,
			),
			'a' => array(
				'id' => true,
				'class' => true,
				'href' => true,
				'target' => true,
			),
			'button' => array(
				'id' => true,
				'class' => true,
				'type' => true,
				'data-*' => true,
			),
		);
	}
}
