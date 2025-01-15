<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

add_action( 'template_redirect', 'helsinki_setup_soft_hyphens_handling' );
function helsinki_setup_soft_hyphens_handling(): void {
	$adapter = helsinki_create_soft_hyphens_hook_adapter(
		helsinki_create_soft_hyphens_handler()
	);

	add_filter( 'helsinki_content_output', array( $adapter, 'aria_hide_soft_hyphens' ), 100, 1 );
	add_filter( 'helsinki_call_to_action_buttons', array( $adapter, 'aria_hide_soft_hyphens' ), 100, 1 );
	add_filter( 'helsinki_sidebar_output', array( $adapter, 'aria_hide_soft_hyphens' ), 100, 1 );
	add_filter( 'helsinki_header_output', array( $adapter, 'aria_hide_soft_hyphens' ), 100, 1 );
	add_filter( 'helsinki_footer_output', array( $adapter, 'aria_hide_soft_hyphens' ), 100, 1 );
	add_filter( 'helsinki_404_output', array( $adapter, 'aria_hide_soft_hyphens' ), 100, 1 );

	add_filter( 'document_title', array( $adapter, 'remove_soft_hyphens' ), 9999, 1 );
	add_filter( 'wp_title', array( $adapter, 'remove_soft_hyphens' ), 9999, 1 );

	add_filter( 'wpseo_title', array( $adapter, 'remove_soft_hyphens' ), 9999, 1 );
	add_filter( 'wpseo_metadesc', array( $adapter, 'remove_soft_hyphens' ), 9999, 1 );
	add_filter( 'wpseo_opengraph_title', array( $adapter, 'remove_soft_hyphens' ), 9999, 1 );
	add_filter( 'wpseo_opengraph_desc', array( $adapter, 'remove_soft_hyphens' ), 9999, 1 );
	add_filter( 'wpseo_schema_company_name', array( $adapter, 'remove_soft_hyphens' ), 9999, 1 );
}

function helsinki_create_soft_hyphens_hook_adapter( Helsinki_Soft_Hyphens_Handler $handler ): Helsinki_Soft_Hyphens_Hooks_Adapter {
	return new Helsinki_Soft_Hyphens_Hooks_Adapter( $handler );
}

function helsinki_create_soft_hyphens_handler(): Helsinki_Soft_Hyphens_Handler {
	return new Helsinki_Soft_Hyphens_Handler();
}
