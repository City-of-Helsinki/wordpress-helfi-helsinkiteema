<div id="site-logo" class="navigation__logo">
	<a class="<?php echo esc_attr( implode(' ', $args['classes']) ); ?>" href="<?php echo esc_url( $args['home_url'] ); ?>" rel="home">
		<?php
			printf(
				'%s<span>%s</span>',
				$args['custom_logo'] ?: $args['default_logo'],
				esc_html( $args['blog_name'] )
			);
		?>
	</a>
</div>
