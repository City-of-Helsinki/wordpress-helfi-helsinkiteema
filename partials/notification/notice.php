<div id="<?php echo esc_attr( $args['id'] ); ?>" class="notification notification--<?php echo esc_attr( $args['type'] ); ?>" aria-label="<?php esc_html_e( 'Notification', 'helsinki-universal' )?>">

	<button class="button-reset close" type="button">
		<span class="screen-reader-text">
			<?php echo $args['title']; ?> - <?php esc_html_e( 'Close notification', 'helsinki-universal' ); ?>
		</span>
		<?php helsinki_svg_icon('cross'); ?>
	</button>

	<div class="notification__icon">
		<?php echo $args['icon']; ?>
	</div>

	<div class="notification__content">
		<?php echo $args['text']; ?>
	</div>

</div>
