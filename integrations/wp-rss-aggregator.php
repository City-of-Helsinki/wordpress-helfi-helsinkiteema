<?php

add_action( 'helsinki_wpra_feed_posts_list_top', 'helsinki_wpra_feed_sources' );
function helsinki_wpra_feed_sources( $args ) {
	$itemsCollection = $args[0] ?? null;

	if ( ! is_a( $itemsCollection, 'RebelCode\Wpra\Core\Entities\Collections\ImportedItemsCollection' ) ) {
		return;
	}

	$sources = array();
	foreach ( $itemsCollection as $item ) {
		$url = parse_url( $item['source_url'], PHP_URL_HOST );
		if ( isset( $sources[$url] ) ) {
			continue;
		}
		$sources[$url] = sprintf(
			_x( '%s', 'from RSS feed source', 'helsinki-universal' ),
			$url
		);
	}

	if ( ! $sources ) {
		return;
	}

	printf(
		'<p class="feed-source">%s</p>',
		sprintf(
			esc_html__( 'This feed is fetched from %s.', 'helsinki-universal' ),
			implode( ', ', $sources )
		)
	);

}
