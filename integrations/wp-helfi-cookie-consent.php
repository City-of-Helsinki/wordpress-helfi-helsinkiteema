<?php

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Integrations\WPHelfiCookieConsent;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\Helsinki\Theme\Integrations\Cookies\Askem_Bid_Cookie;
use CityOfHelsinki\WordPress\Helsinki\Theme\Integrations\Cookies\Askem_Bid_Ts_Cookie;
use CityOfHelsinki\WordPress\Helsinki\Theme\Integrations\Cookies\Askem_Reaction_Cookie;
use CityOfHelsinki\WordPress\Helsinki\Theme\Integrations\Cookies\Helsinki_Localstorage_Notification;

\add_filter( 'wordpress_helfi_cookie_consent_known_cookies', __NAMESPACE__ . '\\provide_theme_cookies' );
function provide_theme_cookies( array $cookies ): array {
	return array_merge( $cookies, array(
		Askem_Bid_Cookie::class,
		Askem_Bid_Ts_Cookie::class,
		Askem_Reaction_Cookie::class,
		Helsinki_Localstorage_Notification::class,
	) );
}
