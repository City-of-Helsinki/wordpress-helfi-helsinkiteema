<div class="grid entries entries--grid l-up-3">
	<?php
		/**
		  * Hook: helsinki_entries_grid_top
		  *
		  */
		do_action('helsinki_entries_grid_top');

		while ( have_posts() ) {

		  the_post();

		  /**
			* Hook: helsinki_entries_grid
			*
			*/
		  do_action('helsinki_entries_grid');

		}

		/**
		  * Hook: helsinki_entries_grid_bottom
		  *
		  */
		do_action('helsinki_entries_grid_bottom');
	?>
</div>
