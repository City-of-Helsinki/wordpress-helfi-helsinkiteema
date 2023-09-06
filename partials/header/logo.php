<div id="site-logo" class="navigation__logo">
	<a class="<?php echo esc_attr( implode(' ', $args['classes']) ); ?>" href="<?php echo esc_url( $args['home_url'] ); ?>" rel="home">
		<?php
			if ( $args['custom_logo'] ) {
				echo $args['custom_logo'] . '<span>' . esc_html( $args['blog_name'] ) . '</span>';
			} else {
				echo $args['default_logo'] . '<span>' . esc_html( $args['blog_name'] ) . '</span>';
			}
		?>
	</a>
</div>
