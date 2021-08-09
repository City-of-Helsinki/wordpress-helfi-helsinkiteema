<!DOCTYPE html>
<html <?php language_attributes(); ?>>

  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>

    <?php

      wp_body_open();

      /**
        * Hook: helsinki_header_before
        *
        */
      do_action('helsinki_header_before');

    ?>

    <header id="masthead" class="<?php helsinki_header_classes(); ?>" role="banner">

      <?php

        /**
          * Hook: helsinki_header_top
          *
          */
        do_action('helsinki_header_top');

      ?>

      <div class="navigation__content hds-container--wide flex-container">

        <?php

          /**
            * Hook: helsinki_header
            *
            */
          do_action('helsinki_header');

        ?>

      </div>

      <?php

        /**
          * Hook: helsinki_header_bottom
          *
          */
        do_action('helsinki_header_bottom');

      ?>

    </header>

    <?php

      /**
        * Hook: helsinki_header_after
        *
        */
      do_action('helsinki_header_after');

    ?>

    <main id="main" role="main">

      <?php

        /**
          * Hook: helsinki_main_top
          *
          */
        do_action('helsinki_main_top');

      ?>
