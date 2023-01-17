<<?php isset($args['attributes']) ? print('div') : print('section') ?> 
	id="<?php isset($args['attributes']) ? print($args['attributes']['anchor']) : print('feed-posts') ?>" 
	class="front-page-section feed-posts<?php isset($args['attributes']['className']) ? print(' '.$args['attributes']['className']) : '' ?>">

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
</<?php isset($args['attributes']) ? print('div') : print('section') ?>>
