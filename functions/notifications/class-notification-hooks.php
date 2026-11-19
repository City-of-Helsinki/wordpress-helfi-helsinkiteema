<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Notifications;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

final class Notification_Hooks
{
	private array $notifications;

	public function __construct(
		private string $current_langugage
	) {
		$this->notifications = array();
	}

	public function add_notification( array $source ): void
	{
		$data = $this->from_array( $source );

		if ( $this->should_add( $data ) ) {
			$this->notifications[] = new Notification_Renderer( $data );
		}
	}

	public function should_display(): bool
	{
		return ! empty( $this->notifications );
	}

	public function display(): void
	{
		\get_template_part(
			'partials/notification/container',
			null,
			array( 'notifications' => $this->notifications )
		);
	}

	public function scripts(): void
	{
		\get_template_part(
			'partials/notification/js/notifications.min',
			null,
			array()
		);
	}

	private function should_add( Notification_Data $data ): bool
	{
		$correct_lang = ( $this->current_langugage && $data->lang )
			? ( $this->current_langugage === $data->lang )
			: true;

		return $data->enabled && $correct_lang;
	}

	private function from_array( array $source ): Notification_Data
	{
		$data = new Notification_Data( ...$this->format_data( $source ) );

		\do_action( 'helsinki_notification_data', $data );

		return $data;
	}

	private function format_data( array $data ): ?array
	{
		$data = \shortcode_atts(
			array(
				'enabled' => false,
				'lang' => '',
				'type' => 'info',
				'title' => '',
				'text' => '',
				'link_text' => __( 'Read more', 'helsinki-universal' ),
				'link_url' => '',
			),
			$data
		);

		$data['type'] = $this->determine_type( $data['type'] );

		$data['id'] = md5(
			$data['type']->value
			. $data['lang']
			. $data['title']
			. $data['text']
		);

		$data['aria_label'] = __( 'Notification', 'helsinki-universal' );
		$data['close_text'] = implode( ' - ', array_filter( array(
			$data['title'],
			__( 'Close notification', 'helsinki-universal' )
		) ) );

		\do_action( 'hds_wp_use_icon', $data['type']->icon() );
		\do_action( 'hds_wp_use_icon', 'cross' );

		return $data;
	}

	private function determine_type( string $type ): Notification_Type
	{
		if ( 'warning' === $type ) {
			return Notification_Type::ERROR;
		}

		return Notification_Type::tryFrom( $type )
			?: Notification_Type::INFO;
	}
}
