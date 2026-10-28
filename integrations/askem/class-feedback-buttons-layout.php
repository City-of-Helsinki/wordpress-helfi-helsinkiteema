<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Integrations\Askem;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Feedback_Buttons_Layout
{
	private string $hook;
	private string $layout_class;
	private int $priority;

	public function __construct(
		private bool $enabled,
		private string $script_url
	) {
		$this->display_after_body();
	}

	public function display_after_body(): void
	{
		$this->hook = 'helsinki_content_body_after';
		$this->priority = 21;
		$this->layout_class = 'rns-after-content-body';
	}

	public function display_after_content(): void
	{
		$this->hook = 'helsinki_content';
		$this->priority = 30;
		$this->layout_class = 'rns-after-content';
	}

	public function enable(): void
	{
		$this->enabled = true;
	}

	public function disable(): void
	{
		$this->enabled = false;
	}

	public function enabled(): bool
	{
		return $this->enabled;
	}

	public function hook_name(): string
	{
		return $this->hook;
	}

	public function hook_priority(): int
	{
		return $this->priority;
	}

	public function apply_body_class( array $classes ): array
	{
		return \helsinki_add_body_class_has_n(
			\helsinki_add_body_class_has_n( $classes, 'rns' ),
			$this->layout_class
		);
	}

	public function render(): void
	{
		$setup = new Feedback_Buttons_Setup(
			$this->script_url,
			'<div class="rns"></div>'
		);

		\do_action( 'helsinki_feedback_buttons_setup', $setup );

		printf(
			'<div class="rns-container">
				<div class="hds-container">%s</div>
			</div>',
			$setup->buttons_html()
		);
	}
}
