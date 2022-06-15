<?php
get_header();

if (get_option('page_for_posts') == get_the_ID()) {
  global $wp_query; 
  $wp_query = new WP_Query(array( 'cat' => ''));
	get_template_part(
		'partials/front-page/archives',
		null,
		array()
	);
  wp_reset_query();
}
else {
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
}

get_footer();
