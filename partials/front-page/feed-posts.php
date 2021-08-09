<section id="feed-posts" class="front-page-section feed-posts">

	<?php

	  /**
		* Hook: helsinki_front_page_feed-posts_before
		*
		*/
	  do_action('helsinki_front_page_feed-posts_before', $args);

	?>

	<div class="hds-container">
		<?php

		  /**
			* Hook: helsinki_front_page_feed-posts
			*
			*/
		  do_action('helsinki_front_page_feed-posts', $args);

		?>
	</div>

	<?php

	/**
	  * Hook: helsinki_front_page_feed-posts_after
	  *
	  */
	do_action('helsinki_front_page_feed-posts_after', $args);

	?>
</section>
