<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Integrations\WPHelfiCookieConsent;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\Helsinki\Theme\Integrations\Cookies\Askem_Bid_Cookie;
use CityOfHelsinki\WordPress\Helsinki\Theme\Integrations\Cookies\Askem_Bid_Ts_Cookie;
use CityOfHelsinki\WordPress\Helsinki\Theme\Integrations\Cookies\Askem_Reaction_Cookie;
use CityOfHelsinki\WordPress\Helsinki\Theme\Integrations\Cookies\Helsinki_Localstorage_Notification;
use function CityOfHelsinki\WordPress\Helsinki\Theme\Integrations\Askem\feedback_buttons_script_url;

\add_filter(
	'wordpress_helfi_cookie_consent_known_cookies',
	__NAMESPACE__ . '\\provide_theme_cookies'
);
function provide_theme_cookies( array $cookies ): array {
	return array_merge( $cookies, array(
		Askem_Bid_Cookie::class,
		Askem_Bid_Ts_Cookie::class,
		Askem_Reaction_Cookie::class,
		Helsinki_Localstorage_Notification::class,
	) );
}

\add_filter(
	'wordpress_helfi_cookie_consent_script_placeholder_cookie_host',
	__NAMESPACE__ . '\\provide_script_placeholder_cookie_host',
	10, 2
);
function provide_script_placeholder_cookie_host( string $host, string $source ): string {
	return feedback_buttons_script_url() === $source ? 'Askem' : $host;
}
