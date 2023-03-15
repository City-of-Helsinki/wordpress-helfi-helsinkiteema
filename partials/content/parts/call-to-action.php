<?php

$args['cta']['button_1']['text'] && $args['cta']['button_1']['url'];
$args['cta']['button_2']['text'] && $args['cta']['button_2']['url'];

$buttons = array();
$first = true;
foreach ( $args['cta'] as $key => $button ) {
	if ( ! $button['text'] || ! $button['url'] ) {
		continue;
	}
	$buttons[] = sprintf(
		'<a class="hds-button %s button" href="%s">%s</a>',
		$first ? '' : 'hds-button--secondary',
		esc_url( $button['url'] ),
		esc_html( $button['text'] )
	);
	$first = false;
}

if ( $buttons ) {
	$output = sprintf(
		'<div class="buttons">%s</div>',
		implode('', $buttons)
	);
	echo apply_filters( 'helsinki_call_to_action_buttons', $output );
}
