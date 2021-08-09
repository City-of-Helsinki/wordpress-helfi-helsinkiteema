<section class="footer__widgets hds-container">

	<?php

	  /**
		* Hook: helsinki_footer_widgets_before
		*
		*/
	  do_action('helsinki_footer_widgets_before');

	?>

	<div class="grid <?php echo apply_filters( 'helsinki_footer_widget_columns', 's-up-2 l-up-3 xl-up-4' ); ?>">
		<?php

		  /**
			* Hook: helsinki_footer_widgets
			*
			*/
		  do_action('helsinki_footer_widgets');

		?>
	</div>

	<?php

	  /**
		* Hook: helsinki_footer_widgets_after
		*
		*/
	  do_action('helsinki_footer_widgets_after');

	?>

</section>
