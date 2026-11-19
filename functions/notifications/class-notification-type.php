<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Notifications;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

enum Notification_Type: string
{
	case INFO = 'info';
	case ERROR = 'error';
	case ALERT = 'alert';

	public function icon(): string
	{
		return match( $this ) {
			Notification_Type::INFO => 'info-circle-fill',
			Notification_Type::ERROR => 'error-fill',
			Notification_Type::ALERT => 'alert-circle-fill',
		};
	}
}
