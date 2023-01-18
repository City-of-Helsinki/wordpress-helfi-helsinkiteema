<?php
get_header();

ob_start(); 

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

$content = ob_get_clean();
echo apply_filters( 'helsinki_content_output', $content);

get_footer();
