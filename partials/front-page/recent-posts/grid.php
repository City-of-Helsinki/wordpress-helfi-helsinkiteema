<div class="grid entries m-up-2 l-up-3">
	<?php
		while ( $args['query']->have_posts() ) {
			$args['query']->the_post();
			helsinki_grid_entry();
		}
		wp_reset_postdata();
	?>
</div>
