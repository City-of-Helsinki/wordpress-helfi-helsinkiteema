<?php
get_header();


/**
  * Hook: helsinki_front_page_before
  *
  */
do_action('helsinki_front_page_before');

while ( have_posts() ) {
  the_post();
}
  
	/**
    * Hook: helsinki_front_page
    *
    */
  do_action('helsinki_front_page');


/**
  * Hook: helsinki_front_page_after
  *
  */
do_action('helsinki_front_page_after');

get_footer();
