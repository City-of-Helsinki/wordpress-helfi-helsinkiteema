<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Notifications;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Content\Renderers\Content_Renderer;

final class Notification_Renderer implements Content_Renderer
{
	public function __construct(
		private Notification_Data $data
	) {}

	public function render(): string
	{
		return sprintf(
			'<div id="%1$s" class="hds-notification hds-notification--%2$s" aria-label="%3$s">
				<div class="hds-notification__content">
					<div class="hds-notification__label">
						%6$s%7$s
					</div>
					<div class="hds-notification__body">
						%8$s
					</div>
				</div>
				<button class="hds-notification__close-button" type="button">
					<span class="screen-reader-text">%4$s</span>
					%5$s
				</button>
			</div>',
			\esc_attr( $this->data->id ),
			\esc_attr( $this->data->type->value ),
			\esc_attr( $this->data->aria_label ),
			\esc_attr( $this->data->close_text ),
			\helsinki_get_svg_icon( 'cross' ),
			\helsinki_get_svg_icon( $this->data->type->icon() ),
			\esc_html( $this->data->title ),
			$this->content(),
		);
	}

	private function content(): string
	{
		$content = '';

		if ( $this->data->text ) {
			$content .= sprintf(
				'<p>%s</p>',
				\esc_html( $this->data->text )
			);
		}

		if ( $this->data->link_url && $this->data->link_text ) {
			$content .= sprintf(
				'<a href="%s">%s</a>',
				\esc_url( $this->data->link_url ),
				\esc_html( $this->data->link_text )
			);
		}

		return $content;
	}
}
