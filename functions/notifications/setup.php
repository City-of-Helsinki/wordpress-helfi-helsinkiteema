<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use CityOfHelsinki\WordPress\Helsinki\Theme\Functions\Notifications\Notification_Hooks;

add_action( 'template_redirect', 'helsinki_setup_notifications', 20 );
function helsinki_setup_notifications(): void {
	if ( is_singular() ) {
		$hooks = helsinki_create_notifications_hooks( substr( get_locale(), 0, 2 ) );

		foreach ( helsinki_notifications_config() as $data ) {
			$hooks->add_notification( $data );
		}

		if ( $hooks->should_display() ) {
			add_action( 'helsinki_main_top', array( $hooks, 'display' ), 20 );
			add_action( 'helsinki_notification_scripts', array( $hooks, 'scripts' ), 10 );
		}
	}
}

function helsinki_create_notifications_hooks( string $current_langugage ): Notification_Hooks {
	return new Notification_Hooks( $current_langugage );
}

function helsinki_notifications_config(): array {
	$out = array();

	$count = helsinki_customizer_notification_count();
	for ( $i = 1; $i <= $count; $i++ ) {
		$data = helsinki_theme_mod( 'helsinki_notification_notice_' . $i, '' );
		if ( $data ) {
			$out[] = $data;
		}
	}

	return $out;
}

function helsinki_notifications(): void {
	helsinki_deprecation_notice( __FUNCTION__, Notification_Hooks::class );
}

function helsinki_notification( array $notice, string $langugage = '' ): void {
	helsinki_deprecation_notice( __FUNCTION__, Notification_Hooks::class );
}

function helsinki_notification_translated_texts( array $notice ): array {
	return $notice;
}

function helsinki_notification_scripts(): void {
	helsinki_deprecation_notice( __FUNCTION__, Notification_Hooks::class );
}
