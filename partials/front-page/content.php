<section id="post-content" class="front-page-section post-content">

	<?php

	  /**
		* Hook: helsinki_front_page_content_before
		*
		*/
	  do_action('helsinki_front_page_content_before', $args);

	?>

	<div class="hds-container">
		<?php

		  /**
			* Hook: helsinki_front_page_content
			*
			*/
		  do_action('helsinki_front_page_content', $args);

		?>
	</div>

	<?php

	/**
	  * Hook: helsinki_front_page_content_after
	  *
	  */
	do_action('helsinki_front_page_content_after', $args);

	?>
</section>
