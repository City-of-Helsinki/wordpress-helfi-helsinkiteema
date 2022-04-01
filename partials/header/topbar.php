<div id="topbar" class="topbar show-for-l">
	<div class="hds-container hds-container--wide flex-container flex-container--align-center">
		<div class="topbar__branding">
			<a href="<?php echo esc_html( $args['branding']['url'] ); ?>"><?php echo esc_html( $args['branding']['title'] ); ?></a>
		</div>
		<div class="topbar__link">
			<?php
				if ( $args['menu'] ) {
					echo $args['menu'];
				} else {
					printf(
						'<a href="%s">%s</a>',
						esc_url( $args['feedback']['url'] ),
						esc_html( $args['feedback']['title'] )
					);
				}
			?>
		</div>
	</div>
</div>
