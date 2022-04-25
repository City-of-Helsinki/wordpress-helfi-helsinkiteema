<<?php isset($args["attributes"]) ? print('div') : print('section id="recent-posts"') ?> class="front-page-section posts">

	<?php
	
	  /**
		* Hook: helsinki_front_page_recent_posts_before
		*
		*/
	  do_action('helsinki_front_page_recent_posts_before', $args);

	?>

	<div class="hds-container">
		<?php

		  /**
			* Hook: helsinki_front_page_recent_posts
			*
			*/
		  do_action('helsinki_front_page_recent_posts', $args);

		?>
	</div>

	<?php

	/**
	  * Hook: helsinki_front_page_recent_posts_after
	  *
	  */
	do_action('helsinki_front_page_recent_posts_after', $args);

	?>
</<?php isset($args["attributes"]) ? print("div") : print("section") ?>>
