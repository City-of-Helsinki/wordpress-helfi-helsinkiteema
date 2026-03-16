<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Hook: helsinki_header_before
 *
 */
do_action( 'helsinki_header_before' );

?>

<header id="masthead" class="header" role="banner">

	<?php

		/**
		 * Hook: helsinki_masthead_top
		 *
		 */
		do_action( 'helsinki_masthead_top' );

	?>

	<div class="header__top">

		<?php

			/**
			 * Hook: helsinki_header_top
			 *
			 */
			do_action( 'helsinki_header_top' );

		?>

	</div>

	<div class="header__content">

		<?php

			/**
			* Hook: helsinki_header
			*
			*/
			do_action( 'helsinki_header' );

		?>

	</div>

	<div class="header__bottom">

		<?php

			/**
			 * Hook: helsinki_header_bottom
			 *
			 */
			do_action( 'helsinki_header_bottom' );

		?>

	</div>

	<?php

		/**
		 * Hook: helsinki_masthead_bottom
		 *
		 */
		do_action( 'helsinki_masthead_bottom' );

	?>

</header>

<?php

	/**
	 * Hook: helsinki_header_after
	 *
	 */
	do_action( 'helsinki_header_after' );

?>
