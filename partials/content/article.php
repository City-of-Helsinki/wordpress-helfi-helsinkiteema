<?php
$post_type = get_post_type();

  /**
    * Hook: helsinki_content_article_before
    *
    */
  do_action('helsinki_content_article_before', $post_type);

?>

<article class="content">

	<?php

		/**
		  * Hook: helsinki_content_article_top
		  *
		  */
		do_action('helsinki_content_article_top', $post_type);

	?>

	<div class="<?php helsinki_content_article_container_class(); ?>">

		<?php

			/**
			  * Hook: helsinki_content_article_main_before
			  *
			  */
			do_action('helsinki_content_article_main_before', $post_type);

		?>

		<div class="content__main">

			<?php

				/**
				  * Hook: helsinki_content_article
				  *
				  */
				do_action('helsinki_content_article', $post_type);

			?>

		</div>

		<?php

			/**
			  * Hook: helsinki_content_article_main_after
			  *
			  */
			do_action('helsinki_content_article_main_after', $post_type);

		?>

	</div>

	<?php

		/**
		  * Hook: helsinki_content_article_bottom
		  *
		  */
		do_action('helsinki_content_article_bottom', $post_type);

	?>

</article>

<?php

  /**
    * Hook: helsinki_content_article_after
    *
    */
  do_action('helsinki_content_article_after', $post_type);

?>
