<?php
get_header();

ob_start();

/**
  * Hook: helsinki_content_before
  *
  */
do_action( 'helsinki_content_before' );

while ( have_posts() ) {

	the_post();

	/**
      * Hook: helsinki_content
      *
      */
    do_action( 'helsinki_content' );

}

/**
  * Hook: helsinki_content_after
  *
  */
do_action( 'helsinki_content_after' );

echo apply_filters( 'helsinki_content_output', ob_get_clean() );

get_footer();
