<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Integrations\Askem;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_action( 'template_redirect', __NAMESPACE__ . '\\setup_feedback_buttons' );
function setup_feedback_buttons(): void {
	$enabled = is_feedback_enabled()
		&& is_feedback_context()
		&& get_api_key();

	if ( $enabled ) {
		\add_filter( 'body_class', __NAMESPACE__ . '\\apply_body_class', 10 );
		\add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\feedback_scripts' );

		$hook = feedback_buttons_hook_and_priority();

		\add_action( $hook['name'], __NAMESPACE__ . '\\provide_feedback_buttons', $hook['priority'] );
	}
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

function feedback_buttons_script_url(): string {
	$script_url = \apply_filters(
		'helsinki_feedback_buttons_script_url',
		helsinki_assets_url() . 'vendor/askem/init.js'
	);

	return \wp_sanitize_redirect( $script_url ) ?: '';
}

function feedback_buttons_html(): string {
	return \wp_kses(
		\apply_filters(
			'helsinki_feedback_buttons_html',
			'<div class="rns"></div>'
		),
		array(
			'div' => array(
				'id' => true,
				'class' => true,
				'data-*' => true,
			),
			'h2' => array(
				'id' => true,
				'class' => true,
			),
			'h3' => array(
				'id' => true,
				'class' => true,
			),
			'p' => array(
				'id' => true,
				'class' => true,
			),
			'span' => array(
				'id' => true,
				'class' => true,
				'aria-*' => true,
				'role' => true,
			),
			'a' => array(
				'id' => true,
				'class' => true,
				'href' => true,
				'target' => true,
			),
			'button' => array(
				'id' => true,
				'class' => true,
				'type' => true,
				'data-*' => true,
			),
		)
	);
}

function provide_feedback_buttons(): void {
	$script_url = feedback_buttons_script_url();
	$buttons = feedback_buttons_html();

	if ( \wp_validate_redirect( $script_url ) ) {
		$buttons .= sprintf(
			'<script src="%s" type="text/javascript"></script>',
			\esc_url( $script_url )
		);
	}

	printf(
		'<div class="rns-container">
			<div class="hds-container">%s</div>
		</div>',
		$buttons
	);
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
