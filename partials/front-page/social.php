<section id="social" class="front-page-section social">

	<?php

	  /**
		* Hook: helsinki_front_page_social_before
		*
		*/
	  do_action('helsinki_front_page_social_before', $args);

	?>

	<div class="hds-container">
		<?php

		  /**
			* Hook: helsinki_front_page_social
			*
			*/
		  do_action('helsinki_front_page_social', $args);

		?>
	</div>

	<?php

	/**
	  * Hook: helsinki_front_page_social_after
	  *
	  */
	do_action('helsinki_front_page_social_after', $args);

	?>
</section>
