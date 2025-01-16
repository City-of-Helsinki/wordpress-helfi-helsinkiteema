<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

add_action( 'template_redirect', 'helsinki_setup_soft_hyphens_handling' );
function helsinki_setup_soft_hyphens_handling(): void {
	add_filter( 'helsinki_content_output', 'helsinki_aria_hide_soft_hyphens', 100, 1 );
	add_filter( 'helsinki_call_to_action_buttons', 'helsinki_aria_hide_soft_hyphens', 100, 1 );
	add_filter( 'helsinki_sidebar_output', 'helsinki_aria_hide_soft_hyphens', 100, 1 );
	add_filter( 'helsinki_header_output', 'helsinki_aria_hide_soft_hyphens', 100, 1 );
	add_filter( 'helsinki_footer_output', 'helsinki_aria_hide_soft_hyphens', 100, 1 );
	add_filter( 'helsinki_404_output', 'helsinki_aria_hide_soft_hyphens', 100, 1 );

	add_filter( 'document_title', 'helsinki_remove_soft_hyphens', 9999, 1 );
	add_filter( 'wp_title', 'helsinki_remove_soft_hyphens', 9999, 1 );

	add_filter( 'wpseo_title', 'helsinki_remove_soft_hyphens', 9999, 1 );
	add_filter( 'wpseo_metadesc', 'helsinki_remove_soft_hyphens', 9999, 1 );
	add_filter( 'wpseo_opengraph_title', 'helsinki_remove_soft_hyphens', 9999, 1 );
	add_filter( 'wpseo_opengraph_desc', 'helsinki_remove_soft_hyphens', 9999, 1 );
	add_filter( 'wpseo_schema_company_name', 'helsinki_remove_soft_hyphens', 9999, 1 );
}

function helsinki_aria_hide_soft_hyphens( string $content ): string {
	return preg_replace(
		'/&shy;/',
		'<span aria-hidden="true">&shy;</span>',
		$content
		) ?: $content;
}

function helsinki_remove_soft_hyphens( string $content ): string {
	return preg_replace( '/&shy;/', '', $content ) ?: $content;
}
