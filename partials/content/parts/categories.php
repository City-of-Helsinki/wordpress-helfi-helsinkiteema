<span class="content__category categories">
	<?php

		printf(
			'<span class="screen-reader-text">%s:</span>',
			esc_html( $args['title'] )
		);

		if ( $args['wrap_classes'] ) {
			printf(
				'<span class="%s">',
				esc_html( $args['wrap_classes'] )
			);
		}

		echo implode(
			$args['separator'] ? sprintf(
				'<span class="separator">%s</span>',
				esc_html( $args['separator'] )
			) : '',
			$args['categories']
		);

		if ( $args['wrap_classes'] ) {
			echo '</span>';
		}

	?>
</span>
