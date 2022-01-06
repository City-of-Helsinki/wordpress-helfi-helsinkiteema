<div class="<?php helsinki_hero_classes( 'hero' ); ?>">

	<?php

	  /**
		* Hook: helsinki_hero_before
		*
		*/
	  do_action( 'helsinki_hero_before', $args );

	?>

	<div class="hds-container hero__container">
		<?php

		  /**
			* Hook: helsinki_hero
			*
			*/
		  do_action( 'helsinki_hero', $args );

		?>
	</div>

	<?php

      /**
        * Hook: helsinki_hero_after
        *
        */
      do_action( 'helsinki_hero_after', $args );

    ?>

</div>
