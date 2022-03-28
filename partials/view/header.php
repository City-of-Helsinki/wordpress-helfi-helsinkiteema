<div class="view-header">

	<?php

	  /**
		* Hook: helsinki_view_header_before
		*
		*/
	  do_action('helsinki_view_header_before');

	?>

	<div class="hds-container">
		<?php

	      /**
	        * Hook: helsinki_view_header
	        *
	        */
	      do_action('helsinki_view_header');

	    ?>
	</div>

	<?php

      /**
        * Hook: helsinki_view_header_after
        *
        */
      do_action('helsinki_view_header_after');

    ?>

</div>
