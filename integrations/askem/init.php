<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Integrations\Askem;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_action( 'template_redirect', __NAMESPACE__ . '\\setup_feedback_buttons' );
function setup_feedback_buttons(): void {
	$layout = create_feedback_buttons_layout();

	if ( $layout->enabled() && get_api_key() ) {
		\add_action(
			'wp_enqueue_scripts',
			__NAMESPACE__ . '\\feedback_scripts'
		);

		\add_filter(
			'body_class',
			array( $layout, 'apply_body_class' ),
			10
		);

		\add_action(
			$layout->hook_name(),
			array( $layout, 'render' ),
			$layout->hook_priority()
		);
	}
}

function create_feedback_buttons_layout(): Feedback_Buttons_Layout {
	$layout = new Feedback_Buttons_Layout(
		(is_feedback_enabled() && is_feedback_context()),
		feedback_buttons_script_url()
	);

	if ( \is_singular( 'post' ) ) {
		$layout->display_after_content();
	}

	\do_action( 'helsinki_feedback_buttons_layout', $layout );

	return $layout;
}

function feedback_scripts(): void {
	$handle = 'helsinki-theme-askem';

	\wp_register_script( $handle, '' );
	\wp_enqueue_script( $handle );

	\wp_add_inline_script(
		$handle,
		sprintf(
			'const HelsinkiThemeAskem = %s;',
			json_encode( feedback_buttons_args( get_api_key() ) )
		),
		'before'
	);
}

function is_feedback_context(): bool {
	return \is_page() || \is_singular( 'post' );
}

function is_feedback_enabled(): bool {
	return \apply_filters( 'helsinki_feedback_enabled', false );
}

function feedback_buttons_script_url(): string {
	return helsinki_assets_url() . 'vendor/askem/init.js';
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
