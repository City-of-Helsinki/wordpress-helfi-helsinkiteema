<figure class="content__thumbnail">
	<?php
		echo helsinki_image_with_wrap(
			$args['image'],
			isset( $args['fixed_size'] ) ? boolval($args['fixed_size']) : false 
		);

		if ( $args['caption'] || $args['credit'] ) {
			printf(
				'<figcaption>%s%s</figcaption>',
				$args['caption'] ? esc_html( $args['caption'] ) : '',
				$args['credit'] ? ($args['caption'] ? ' ' : '') . esc_html( $args['credit'] ) : '',
			);
		}
	?>
</figure>
