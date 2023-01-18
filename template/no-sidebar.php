<?php
/**
  * Template Name: Basic page without sidebar
  */

get_header();

ob_start();

/**
* Hook: helsinki_content_before
*
*/
do_action("helsinki_content_before");

while ( have_posts() ) {

	the_post();

	/**
    * Hook: helsinki_content
    *
    */
  do_action("helsinki_content");

}

/**
* Hook: helsinki_content_after
*
*/
do_action("helsinki_content_after");

$content = ob_get_clean();
echo apply_filters( 'helsinki_content_output', $content);

get_footer();
