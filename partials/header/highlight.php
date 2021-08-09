<?php
if ( ! $args['link']['url'] && ! $args['link']['text'] ) {
	return;
}
?>
<div class="navigation__highlight show-for-l">
	<a href="<?php echo esc_url( $args['link']['url'] ); ?>">
		<?php echo esc_html( $args['link']['text'] ); ?>
	</a>
</div>
