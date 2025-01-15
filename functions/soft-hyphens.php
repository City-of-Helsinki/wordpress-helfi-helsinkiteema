<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

add_action( 'template_redirect', 'helsinki_setup_soft_hyphens_handling' );
function helsinki_setup_soft_hyphens_handling(): void {
	$adapter = helsinki_create_soft_hyphens_hook_adapter(
		helsinki_create_soft_hyphens_handler()
	);

	add_filter( 'helsinki_content_output', array( $adapter, 'handle_content' ), 100, 1 );
	add_filter( 'helsinki_call_to_action_buttons', array( $adapter, 'handle_content' ), 100, 1 );
	add_filter( 'helsinki_sidebar_output', array( $adapter, 'handle_content' ), 100, 1 );
	add_filter( 'render_block', 'helsinki_links_parse_blocks', 100, 2 );
	add_filter( 'helsinki_header_output', array( $adapter, 'handle_content' ), 100, 1 );
	add_filter( 'helsinki_footer_output', array( $adapter, 'handle_content' ), 100, 1 );
	add_filter( 'helsinki_404_output', array( $adapter, 'handle_content' ), 100, 1 );
}

function helsinki_create_soft_hyphens_hook_adapter( Helsinki_Soft_Hyphens_Handler $handler ): Helsinki_Soft_Hyphens_Hooks_Adapter {
	return new Helsinki_Soft_Hyphens_Hooks_Adapter( $handler );
}

function helsinki_create_soft_hyphens_handler(): Helsinki_Soft_Hyphens_Handler {
	return new Helsinki_Soft_Hyphens_Handler();
}
