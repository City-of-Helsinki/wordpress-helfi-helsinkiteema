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

add_filter( 'render_block', 'helsinki_image_render', 10, 2 );
function helsinki_image_render( $block_content = '', $block = [] ) {
	$is_valid_image_block = ! empty( $block['blockName'] )
		&& ('core/image' === $block['blockName'])
		&& ! empty( $block['attrs']['id'] );

	if ( ! $is_valid_image_block ) {
		return $block_content;
	}

	$credit = helsinki_base_image_credit( $block['attrs']['id'] );
	if ( $credit ) {
		preg_match_all(
			'/(?<figcaption><figcaption[^\>]*>)(?<content>.*)(<\/figcaption>)/sU',
			$block_content,
			$matches
		);

		if ( ! empty( $matches['figcaption'][0] ) ) {
			$block_content = preg_replace(
				'/(?<figcaption><figcaption[^\>]*>)(?<content>.*)(<\/figcaption>)/sU',
				$matches['figcaption'][0] . $matches['content'][0] . ' ' . $credit . '</figcaption>',
				$block_content,
				1
			);
		} else {
			//if there is no figcaption, create one
			preg_match_all(
				'/(?<figure><figure[^\>]*>)(?<content>.*)(<\/figure>)/sU',
				$block_content,
				$matches
			);

			$block_content = preg_replace(
				'/(?<figure><figure[^\>]*>)(?<content>.*)(<\/figure>)/sU',
				$matches['figure'][0] . $matches['content'][0] . '<figcaption>' . $credit . '</figcaption></figure>',
				$block_content,
				1
			);
		}
	}

	return $block_content;
}
