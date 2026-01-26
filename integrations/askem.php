<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Integrations\Askem;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_action( 'template_redirect', __NAMESPACE__ . '\\setup_feedback_buttons' );
function setup_feedback_buttons(): void {
	if ( is_feedback_enabled() && is_feedback_context() ) {
		\add_filter( 'body_class', __NAMESPACE__ . '\\apply_body_class', 10 );

		$hook = feedback_buttons_hook_and_priority();

		\add_action( $hook['name'], __NAMESPACE__ . '\\provide_feedback_buttons', $hook['priority'] );
	}
}

function feedback_buttons_hook_and_priority(): array {
	if ( \is_singular( 'post' ) ) {
		return array(
			'name' => 'helsinki_content',
			'priority' => 30,
		);
	}

	return array(
		'name' => 'helsinki_content_body_after',
		'priority' => 21,
	);
}

function is_feedback_context(): bool {
	return \is_page() || \is_singular( 'post' );
}

function is_feedback_enabled(): bool {
	return \apply_filters( 'helsinki_feedback_enabled', false );
}

function apply_body_class( array $classes ): array {
	return \helsinki_add_body_class_has_n( $classes, 'rns' );
}

function provide_feedback_buttons(): void {
	$api_key = get_api_key();

	if ( $api_key ) {
		\get_template_part(
	        'partials/feedback/feedback',
	        null,
	        feedback_buttons_args( $api_key )
	    );
	}
}

function feedback_buttons_args( string $api_key ): array {
	return \apply_filters(
		'helsinki_feedback_buttons_args',
		array(
			'apiKey' => $api_key,
	        'title' => \get_the_title(),
	        'postId' => \get_the_ID(),
	        'category' => preg_replace( '/^https?:\/\//', '', \get_option('home') ),
	        'disableFonts' => true,
		)
	);
}

function get_api_key(): string {
	$keys = array(
        'fi' => 'gjhfvh3m4xcvnred',
        'sv' => 'mwft0afec1l7d6g1',
        'en' => '7zfblho0j7sm0url',
    );

	$lang = function_exists('pll_current_language')
		? \pll_current_language('slug')
		: substr( \get_bloginfo( 'language' ), 0, 2 );

	return \apply_filters(
		'helsinki_askem_api_key',
		$keys[$lang] ?? '',
		$lang,
		$keys
	);
}
