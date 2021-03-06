<?php

function helsinki_menu( string $location ) {
	$config = helsinki_menu_config( $location );
	return $config ? wp_nav_menu( apply_filters( "helsinki_{$location}_args", $config ) ) : '';
}

function helsinki_menu_config(string $location) {
	switch ( $location ) {
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

		case 'main_menu':
			return array(
				'theme_location'    => $location,
				'container'         => 'false',
				'depth'             => 3,
				'menu_id'           => 'main-menu',
				'menu_class'        => 'menu menu--main',
				'echo'              => false,
				'fallback_cb'       => false,
				'link_before'		=> '<span>',
				'link_after'		=> '</span>',
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
				'depth'             => 3,
				'menu_id'           => 'mobile-main-menu',
				'menu_class'        => 'mobile-menu menu menu--main',
				'echo'              => false,
				'fallback_cb'       => false,
				'link_before'		=> '<span>',
				'link_after'		=> '</span>',
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
