<aside class="content__sidebar--navigation">
  <?php
  wp_nav_menu([
    'theme_location'  => 'main_menu',
    'container'       => 'nav',
    'container_class' => 'sidebar-navigation',
    'context' => 'sidebar',
    'walker' => new Helsinki_Sidebar_Walker(),
    'depth' => 5,
  ]);
  ?>
</aside>