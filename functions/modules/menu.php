<?php

function helsinki_menu( string $location ) {
	$config = helsinki_menu_config($location);
	return $config ? wp_nav_menu($config) : '';
}

function helsinki_menu_config(string $location) {
	switch ( $location ) {
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
