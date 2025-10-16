<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Integrations\Cookies;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class Askem_Reaction_Cookie implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'Askem';
	}

	public function name(): string
	{
		return 'rns_reaction_*';
	}

	public function label(): string
	{
		return 'rns_reaction';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Askem-reaktionappien toimintaan liittyvä tietue.',
			'sv' => 'En post relaterad till driften av reaktionsknappen Askem.',
			'en' => 'A record related to the operation of the Askem react buttons.'
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
		return 'statistics';
	}
}
