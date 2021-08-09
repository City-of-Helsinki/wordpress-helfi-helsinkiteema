<?php
get_header();

/**
  * Hook: helsinki_not_found_before
  *
  */
do_action('helsinki_not_found_before');

?>

<div class="content">

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

		<div class="content__main">

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

/**
  * Hook: helsinki_not_found_after
  *
  */
do_action('helsinki_not_found_after');

get_footer(); ?>
