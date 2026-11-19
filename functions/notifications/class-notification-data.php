<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Notifications;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

final class Notification_Data
{
	public function __construct(
		public Notification_Type $type,
		public bool $enabled,
		public string $lang,
		public string $id,
		public string $title,
		public string $text,
		public string $link_text,
		public string $link_url,
		public string $aria_label,
		public string $close_text,
	) {}
}
