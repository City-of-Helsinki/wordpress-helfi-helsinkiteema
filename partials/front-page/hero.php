<section id="hero" class="<?php helsinki_hero_classes('front-page-section hero'); ?>">

	<?php

	  /**
		* Hook: helsinki_front_page_hero_before
		*
		*/
	  do_action('helsinki_front_page_hero_before', $args);

	?>

	<div class="<?php helsinki_hero_container_classes(); ?>">
		<?php

		  /**
			* Hook: helsinki_front_page_hero
			*
			*/
		  do_action('helsinki_front_page_hero', $args);

		?>
	</div>

	<?php

      /**
        * Hook: helsinki_front_page_hero_after
        *
        */
      do_action('helsinki_front_page_hero_after', $args);

    ?>

</section>
