<?php

function helsinki_content_article_has_call_to_action() {
	$meta = helsinki_content_article_call_to_action_data();
	$button_1_exists = $meta['button_1']['text'] && $meta['button_1']['url'];
	$button_2_exists = $meta['button_2']['text'] && $meta['button_2']['url'];
	return $button_1_exists || $button_2_exists;
}

function helsinki_content_article_call_to_action_data( int $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	return array(
		'button_1' => array(
			'text' => get_post_meta( $post_id, 'hero_cta_text', true ),
			'url' => get_post_meta( $post_id, 'hero_cta_url', true ),
		),
		'button_2' => array(
			'text' => get_post_meta( $post_id, 'hero_cta_2_text', true ),
			'url' => get_post_meta( $post_id, 'hero_cta_2_url', true ),
		),
	);
}

function helsinki_content_article_call_to_action() {
	get_template_part(
		'partials/content/parts/call-to-action',
		null,
		array(
			'cta' => helsinki_content_article_call_to_action_data(),
		)
	);
}
