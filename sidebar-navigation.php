<aside class="content__sidebar--navigation">
  <?php

  $theme_menu_depth = get_theme_mod('helsinki_header_primary_menu');

  if ($theme_menu_depth['menu-items'] === 'menu-depth-2-5') {
    $depth = 5;
  } else {
    $depth = 3;
  }

  wp_nav_menu([
    'theme_location'  => 'main_menu',
    'container'       => 'nav',
    'container_class' => 'sidebar-navigation',
    'context' => 'sidebar',
    'walker' => new Helsinki_Sidebar_Walker(),
    'depth' => $depth,
  ]);
  ?>
</aside>