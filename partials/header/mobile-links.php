<div class="mobile-links">
	<?php if ( $args['menu'] ) { ?>
		<?php echo $args['menu']; ?>
	<?php } ?>

	<ul class="menu menu--vertical">
		<li class="menu__item">
			<a href="<?php echo esc_url( $args['branding']['url'] ); ?>"><?php echo esc_html( $args['branding']['title'] ); ?></a>
		</li>
		<li class="menu__item">
			<a href="<?php echo esc_url( $args['feedback']['url'] ); ?>"><?php echo esc_html( $args['feedback']['title'] ); ?></a>
		</li>
	</ul>
</div>
