<span class="content__category categories">
	<?php

		printf(
			'<span class="screen-reader-text">%s:</span>',
			esc_html( $args['title'] )
		);


		echo implode(
			sprintf(
				'<span class="separator">%s</span>',
				esc_html( $args['separator'] )
			),
			$args['categories']
		);

	?>
</span>
