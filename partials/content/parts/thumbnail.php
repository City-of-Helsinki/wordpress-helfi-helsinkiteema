<figure class="content__thumbnail">
	<?php
		echo helsinki_image_with_wrap(
			$args['image'],
			isset( $args['fixed_size'] ) ? boolval($args['fixed_size']) : false 
		);

		if ( $args['caption'] ?? '' ) {
			printf(
				'<figcaption>%s</figcaption>',
				esc_html( $args['caption'] )
			);
		}
	?>
</figure>
