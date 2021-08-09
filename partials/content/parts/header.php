<header class="<?php helsinki_content_article_header_class(); ?>">

	<?php

	  /**
		* Hook: helsinki_content_header_before
		*
		*/
	  do_action('helsinki_content_header_before');

	?>

	<div class="<?php helsinki_content_article_header_container_class(); ?>">
		<?php

		  /**
			* Hook: helsinki_content_header
			*
			*/
		  do_action('helsinki_content_header');

		?>
	</div>

	<?php

      /**
        * Hook: helsinki_content_header_after
        *
        */
      do_action('helsinki_content_header_after');

    ?>

</header>
