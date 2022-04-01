<h2 class="size-xl posts-count">
	<?php
		printf(
			'<span class="count">%d</span> %s',
			absint( $args['count'] ),
			esc_html_x('search results', 'posts count', 'helsinki-universal')
		);
	?>
</h2>
