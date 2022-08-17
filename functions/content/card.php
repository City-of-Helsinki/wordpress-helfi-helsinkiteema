<?php

add_filter( 'hds_wp_content_card_placeholder_icon', 'helsinki_content_card_placeholder_icon' );
function helsinki_content_card_placeholder_icon( string $name ) {
	return helsinki_entry_image_icon_name();
}

add_filter( 'hds_wp_content_cards_koros', 'helsinki_content_cards_koros' );
function helsinki_content_cards_koros( string $name ) {
	return apply_filters( 'helsinki_koros_type', $name );
}

add_filter( 'hds_wp_links_list_item_placeholder_icon', 'helsinki_links_list_item_placeholder_icon' );
function helsinki_links_list_item_placeholder_icon( string $name ) {
	return helsinki_entry_image_icon_name();
}