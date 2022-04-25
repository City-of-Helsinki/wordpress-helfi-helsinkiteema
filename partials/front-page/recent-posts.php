<<?php isset($args['attributes']) ? print('div') : print('section') ?> 
	id="<?php isset($args['attributes']) ? print($args['attributes']['anchor']) : print('recent-posts') ?>" 
	class="front-page-section posts<?php isset($args['attributes']['className']) ? print(' '.$args['attributes']['className']) : '' ?>"
>

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
</<?php isset($args['attributes']) ? print('div') : print('section') ?>>
