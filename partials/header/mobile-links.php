<div class="<?php helsinki_element_classes( 'mobile-links', $args['wrap_classes'] ); ?>">
	<?php
		if ( $args['menu'] ) {
			echo $args['menu'];
		}
	?>

	<?php if ( $args['display_branding'] || $args['display_feedback'] ) : ?>

		<ul class="menu menu--vertical">
			<?php if ( $args['display_branding'] ) : ?>
				<li class="menu__item">
					<a href="<?php echo esc_url( $args['branding']['url'] ); ?>">
						<?php echo esc_html( $args['branding']['title'] ); ?>
					</a>
				</li>
			<?php endif; ?>

			<?php if ( $args['display_feedback'] ) : ?>
				<li class="menu__item">
					<a href="<?php echo esc_url( $args['feedback']['url'] ); ?>">
						<?php echo esc_html( $args['feedback']['title'] ); ?>
					</a>
				</li>
			<?php endif; ?>
		</ul>

	<?php endif; ?>
</div>
