<?php
get_header();

/**
  * Hook: helsinki_not_found_before
  *
  */
do_action('helsinki_not_found_before');

?>

<?php ob_start(); ?>

<div class="content has-light-gray-background-color">

	<?php

		/**
		  * Hook: helsinki_not_found_top
		  *
		  */
		do_action('helsinki_not_found_top');

	?>

	<div class="hds-container content__container">

		<?php

			/**
			  * Hook: helsinki_not_found_main_before
			  *
			  */
			do_action('helsinki_not_found_main_before');

		?>

		<div class="">

			<?php

				/**
				  * Hook: helsinki_not_found
				  *
				  */
				do_action('helsinki_not_found');

			?>

		</div>

		<?php

			/**
			  * Hook: helsinki_not_found_main_after
			  *
			  */
			do_action('helsinki_not_found_main_after');

		?>

	</div>

	<?php

		/**
		  * Hook: helsinki_not_found_bottom
		  *
		  */
		do_action('helsinki_not_found_bottom');

	?>

</div>

<?php 
      $error404 = ob_get_clean();
      echo apply_filters( 'helsinki_404_output', $error404);
?>

<?php

/**
  * Hook: helsinki_not_found_after
  *
  */
do_action('helsinki_not_found_after');

get_footer(); ?>
