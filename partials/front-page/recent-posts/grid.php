<div class="grid entries m-up-2 l-up-4">
	<?php
		while ( $args['query']->have_posts() ) {
			$args['query']->the_post();
			helsinki_grid_entry($args);
		}
		wp_reset_postdata();
	?>
</div>
