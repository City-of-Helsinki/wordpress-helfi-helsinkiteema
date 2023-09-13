<?php
get_header();

ob_start();

if (get_option('page_for_posts') == get_the_ID()) {
  global $wp_query; 
  global $paged;
  $wp_query = new WP_Query(array( 'cat' => '', 'paged' => $paged));
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

$content = ob_get_clean();
echo apply_filters( 'helsinki_content_output', $content);

get_footer();
