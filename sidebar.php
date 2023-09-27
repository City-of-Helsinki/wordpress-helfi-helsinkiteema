<aside class="content__sidebar">
  <?php

  $post_type = get_post_type();
  $post_id = get_the_id();

  ob_start();

  /**
   * Hook: helsinki_sidebar
   *
   */
  do_action('helsinki_sidebar', "sidebar-{$post_type}", $post_id);

  /**
   * Hook: helsinki_{$post_type}_sidebar
   *
   */
  do_action("helsinki_{$post_type}_sidebar", $post_id);

  $content = ob_get_clean();
  echo apply_filters('helsinki_sidebar_output', $content);

  ?>
</aside>