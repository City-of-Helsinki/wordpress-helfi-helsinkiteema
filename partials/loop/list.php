<div class="entries entries--list">
	<?php
		/**
		  * Hook: helsinki_entries_list_top
		  *
		  */
		do_action('helsinki_entries_list_top');

		while ( have_posts() ) {

		  the_post();

		  /**
			* Hook: helsinki_entries_list
			*
			*/
		  do_action('helsinki_entries_list');

		}

		/**
		  * Hook: helsinki_entries_list_bottom
		  *
		  */
		do_action('helsinki_entries_list_bottom');
	?>
</div>
