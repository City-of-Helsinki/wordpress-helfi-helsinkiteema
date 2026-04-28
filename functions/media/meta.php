<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

add_action( 'init', 'helsinki_setup_image_meta_provider' );
function helsinki_setup_image_meta_provider(): void {
	require_once plugin_dir_path( __FILE__ ) . 'class-helsinki-image-meta-provider.php';

	$provider = new Helsinki_Image_Meta_Provider();

	add_filter(
		'helsinki_image_credit_text',
		array( $provider, 'get_image_credit' ),
		10, 2
	);

	if ( is_admin() ) {
		add_filter(
			'attachment_fields_to_edit',
			array( $provider, 'attachment_edit_field' ),
			10, 2
		);

		add_filter(
			'attachment_fields_to_save',
			array( $provider, 'save_attachment_field' ),
			10, 2
		);
	}
}

function helsinki_base_image_credit( $post_id = null ): string {
	return apply_filters( 'helsinki_image_credit_text', '', (int) $post_id );
}
