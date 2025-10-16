<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Integrations\Cookies;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class Helsinki_Localstorage_Notification implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'Helsinkiteema';
	}

	public function name(): string
	{
		return 'helsinki_notification_*';
	}

	public function label(): string
	{
		return 'helsinki_notification';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Sivusto käyttää tätä tietuetta tietojen tallentamiseen siitä, mitä poikkeusilmoituksia on suljettu.',
			'sv' => 'Används av webbplatsen för att lagra information om ständga meddelanden.',
			'en' => 'Used by the website to store information about closed announcements.'
		);
	}

	public function retentionTranslations(): array
	{
		return array(
			'fi' => '-',
			'sv' => '-',
			'en' => '-'
		);
	}

	public function type(): string
	{
		return 'localstorage';
	}

	public function category(): string
	{
		return 'functional';
	}
}
