<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

		<div class="layout-wrap">

			<?php

				ob_start();

				/**
				 * Hook: helsinki_header_after
				 *
				 */
				do_action( 'helsinki_main_before' );

			?>

			<main id="main" role="main">

				<?php

					/**
					 * Hook: helsinki_main_top
					 *
					 */
					do_action( 'helsinki_main_top' );

					echo apply_filters( 'helsinki_header_output', ob_get_clean() );
				?>
