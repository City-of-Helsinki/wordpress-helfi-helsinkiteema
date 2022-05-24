<?php

/**
  * Hook: helsinki_loop_before
  *
  */
do_action('helsinki_loop_before');

?>

<div class="content">

	<?php

		/**
		  * Hook: helsinki_loop_top
		  *
		  */
		do_action('helsinki_loop_top');

	?>

	<div class="hds-container content__container">

		<?php

			/**
			  * Hook: helsinki_loop_main_before
			  *
			  */
			do_action('helsinki_loop_main_before');

		?>

		<div class="content__main">

			<?php

				/**
				  * Hook: helsinki_loop_posts_before
				  *
				  */
				do_action('helsinki_loop_posts_before');

				if ( have_posts() ) {

					/**
					  * Hook: helsinki_loop_posts
					  *
					  */
					do_action('helsinki_loop_posts');

				} else {

					/**
					  * Hook: helsinki_loop_no_posts
					  *
					  */
					do_action('helsinki_loop_no_posts');

				}

				/**
				  * Hook: helsinki_loop_posts_after
				  *
				  */
				do_action('helsinki_loop_posts_after');

			?>

		</div>

		<?php

			/**
			  * Hook: helsinki_loop_main_after
			  *
			  */
			do_action('helsinki_loop_main_after');

		?>

	</div>

	<?php

		/**
		  * Hook: helsinki_loop_bottom
		  *
		  */
		do_action('helsinki_loop_bottom');

	?>

</div>

<?php

/**
  * Hook: helsinki_loop_after
  *
  */
do_action('helsinki_loop_after');
