<section role="group" aria-label="<?php echo esc_attr( $args['title'] ); ?>" class="content__tags tags">

	<h2><?php echo esc_html( $args['title'] ); ?></h2>

	<div class="tagcloud">
		<?php echo implode( '', $args['tags'] ); ?>
	</div>

</section>
