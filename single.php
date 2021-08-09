<?php
get_header();

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

get_footer();
