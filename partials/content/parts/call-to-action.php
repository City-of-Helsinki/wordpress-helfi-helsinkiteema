<?php

$args['cta']['button_1']['text'] && $args['cta']['button_1']['url'];
$args['cta']['button_2']['text'] && $args['cta']['button_2']['url'];

$buttons = array();
foreach ( $args['cta'] as $key => $button ) {
	if ( ! $button['text'] || ! $button['url'] ) {
		continue;
	}
	$buttons[] = sprintf(
		'<a class="hds-button button" href="%s">%s</a>',
		esc_url( $button['url'] ),
		esc_html( $button['text'] )
	);
}

if ( $buttons ) {
	printf(
		'<div class="buttons">%s</div>',
		implode('', $buttons)
	);
}
