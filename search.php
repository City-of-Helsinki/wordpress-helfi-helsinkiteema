<?php
get_header();

/**
  * Hook: helsinki_search_before
  *
  */
do_action('helsinki_search_before');

?>

<div class="content">

	<?php

		/**
		  * Hook: helsinki_search_top
		  *
		  */
		do_action('helsinki_search_top');

	?>

	<div class="hds-container content__container">

		<?php

			/**
			  * Hook: helsinki_search_main_before
			  *
			  */
			do_action('helsinki_search_main_before');

		?>

		<div class="content__main">

			<?php

				/**
				  * Hook: helsinki_search_posts_before
				  *
				  */
				do_action('helsinki_search_posts_before');

				if ( have_posts() ) {

					/**
					  * Hook: helsinki_search_posts
					  *
					  */
					do_action('helsinki_search_posts');

				} else {

					/**
					  * Hook: helsinki_search_no_posts
					  *
					  */
					do_action('helsinki_search_no_posts');

				}

				/**
				  * Hook: helsinki_search_posts_after
				  *
				  */
				do_action('helsinki_search_posts_after');

			?>

		</div>

		<?php

			/**
			  * Hook: helsinki_search_main_after
			  *
			  */
			do_action('helsinki_search_main_after');

		?>

	</div>

	<?php

		/**
		  * Hook: helsinki_search_bottom
		  *
		  */
		do_action('helsinki_search_bottom');

	?>

</div>

<?php

/**
  * Hook: helsinki_search_after
  *
  */
do_action('helsinki_search_after');

get_footer(); ?>
