<?php

function helsinki_menu(string $location)
{
	$config = helsinki_menu_config($location);
	return $config ? wp_nav_menu(apply_filters("helsinki_{$location}_args", $config)) : '';
}

function helsinki_header_primary_menu_items_style_is( string $style ): bool {
	$mods = get_theme_mod( 'helsinki_header_primary_menu' );

	return isset( $mods['menu-items'] ) && $mods['menu-items'] === $style;
}

function helsinki_menu_config(string $location)
{
	if ( helsinki_header_primary_menu_items_style_is( 'menu-depth-2-5' ) ) {
		$desktop_depth = 2;
		$mobile_depth = 5;
	} else {
		$desktop_depth = 3;
		$mobile_depth = 3;
	}

	switch ($location) {
		case 'topbar_menu':
			return array(
				'theme_location'    => $location,
				'container'         => 'false',
				'container_id'      => '',
				'depth'             => 1,
				'menu_id'           => 'topbar-menu',
				'menu_class'        => 'menu menu--topbar',
				'echo'              => false,
				'fallback_cb'       => false,
				'item_spacing'      => 'discard',
				'walker'            => new Artcloud_Menu_Walker(),
			);
			break;

		case 'mobile_topbar_menu':
			return array(
				'theme_location'    => 'topbar_menu',
				'container'         => 'false',
				'container_id'      => '',
				'depth'             => 1,
				'menu_id'           => 'mobile-topbar-menu',
				'menu_class'        => 'mobile-menu menu menu--topbar',
				'echo'              => false,
				'fallback_cb'       => false,
				'item_spacing'      => 'discard',
				'walker'            => new Artcloud_Menu_Walker(),
			);
			break;

		case 'main_menu':
			return array(
				'theme_location'    => $location,
				'container'         => 'false',
				'depth'             => $desktop_depth,
				'menu_id'           => 'main-menu',
				'menu_class'        => 'menu menu--main',
				'echo'              => false,
				'fallback_cb'       => false,
				'link_before'		=> '',
				'link_after'		=> '',
				'before'			=> '<div class="link-wrap">',
				'after'				=> '</div>',
				'item_spacing'      => 'discard',
				'walker'            => new Artcloud_Menu_Walker(),
			);
			break;

		case 'mobile_main_menu':
			return array(
				'theme_location'    => 'main_menu',
				'container'         => 'false',
				'depth'             => $mobile_depth,
				'menu_id'           => 'mobile-main-menu',
				'menu_class'        => 'mobile-menu menu menu--main',
				'echo'              => false,
				'fallback_cb'       => false,
				'link_before'		=> '',
				'link_after'		=> '',
				'before'			=> '<div class="link-wrap">',
				'after'				=> '</div>',
				'item_spacing'      => 'discard',
				'walker'            => new Artcloud_Menu_Walker(),
			);
			break;

		case 'footer_menu':
			return array(
				'theme_location'    => $location,
				'container'         => 'nav',
				'container_class'   => 'footer__navigation',
				'container_id'      => '',
				'depth'             => 1,
				'menu_id'           => 'footer-menu',
				'menu_class'        => 'menu menu--footer',
				'echo'              => false,
				'fallback_cb'       => false,
				'item_spacing'      => 'discard',
				'walker'            => new Artcloud_Menu_Walker(),
			);
			break;

		default:
			return array();
			break;
	}
}
