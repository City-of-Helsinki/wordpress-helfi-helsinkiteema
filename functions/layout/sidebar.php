<?php

function helsinki_sidebar_body_class($classes)
{
	return helsinki_add_body_class_has_n($classes, 'sidebar');
}

function helsinki_sidebar()
{
	get_sidebar();
}

function helsinki_sidebar_navigation()
{
	if (!helsinki_sidebar_compatible_page_template()) {
		return;
	}

	get_sidebar('navigation');
}

function helsinki_sidebar_widgets($widget_area, $post_id)
{
	if (is_active_sidebar($widget_area)) {
		dynamic_sidebar($widget_area);
	}
}

function helsinki_sidebar_post_meta()
{
	$sidebar_heading = get_post_meta(get_the_ID(), 'sidebar_heading', true);
	$sidebar_content = get_post_meta(get_the_ID(), 'sidebar_content', true);

	if ($sidebar_heading || $sidebar_content) {
		get_template_part('partials/sidebar/post-meta', null, array(
			'sidebar_heading' => $sidebar_heading,
			'sidebar_content' => $sidebar_content,
		));
	}
}

function helsinki_sidebar_compatible_page_template($post = null)
{
	if (!$post) {
		$post = get_post();
	}

	$template = get_page_template_slug($post);
	$sidebar_enabled = array_filter(array(
		(is_page() && apply_filters('helsinki_sidebar_page_enabled', false)),
		is_single(),
	));

	return apply_filters(
		'helsinki_sidebar_compatible_page_template',
		'template/with-sidebar.php' === $template || ('' === $template && $sidebar_enabled),
		$post
	);
}

function helsinki_sidebar_has_sidenavigation()
{
	$post = get_post();
	$sidebar_navigation = get_post_meta($post->ID, 'sidebar_navigation', true);

	if (!$sidebar_navigation) {
		return false;
	}

	if (!helsinki_sidebar_compatible_page_template()) {
		return true;
	}

	add_filter('body_class', function ($classes) {
		$classes[] = 'has-sidenavigation';
		return $classes;
	});

	return $sidebar_navigation;
}

function helsinki_sidebar_params($params)
{
	$params[0]['before_title'] = '<h2 class="widget__title">';
	$params[0]['after_title'] = '</h2>';

	return $params;
}
add_filter('dynamic_sidebar_params', 'helsinki_sidebar_params');

add_filter('wp_nav_menu_objects', 'helsinki_get_submenu', 10, 2);
function helsinki_get_submenu($items, $args)
{

	if (empty($args->context)) {
		return $items;
	}

	if ('sidebar' == $args->context) {

		$current_pages = array_filter($items, function ($item) {
			return !empty(array_intersect(['current-menu-parent', 'current-menu-ancestor', 'current-menu-item'], $item->classes));
		});
		$current_pages = array_values($current_pages);
		$parent_id = $current_pages[0]->ID;
	}

	$children = helsinki_submenu_get_children_ids($parent_id, $items);

	foreach ($items as $key => $item) {
		if ($item->ID != $parent_id && !in_array($item->ID, $children)) {
			unset($items[$key]);
		}
	}
	$items = array_values($items);

	return $items;
}

add_action('wp_update_nav_menu', 'helsinki_get_menu_items');
function helsinki_get_menu_items($nav_menu_selected_id)
{
	$menu_items = wp_get_nav_menu_items($nav_menu_selected_id);

	foreach ($menu_items as $key => $menu_item) {
		$submenu_items = $menu_items;

		if ($menu_item->menu_item_parent === '0') {
			$children = helsinki_submenu_get_children_ids($menu_item->ID, $menu_items);

			if ($children == null) {
				continue;
			}



			foreach ($menu_items as $key => $item) {
				if ($item->ID != $menu_item->ID && !in_array($item->ID, $children)) {
					unset($submenu_items[$key]);
				}
			}

			$submenu_items = array_values($submenu_items);

			if (get_post_meta($submenu_items[0]->object_id, 'sidebar_navigation', true) && get_post_meta($submenu_items[1]->object_id, 'sidebar_navigation', true) == false) {
				foreach ($submenu_items as $key => $item) {
					update_post_meta($item->object_id, 'sidebar_navigation', true);
				}
			} else if (get_post_meta($submenu_items[0]->object_id, 'sidebar_navigation', true) == false && get_post_meta($submenu_items[1]->object_id, 'sidebar_navigation', true) == true) {
				foreach ($submenu_items as $key => $item) {
					update_post_meta($item->object_id, 'sidebar_navigation', false);
				}
			}
		}
	}
}

function helsinki_submenu_get_children_ids($id, $items)
{

	$ids = wp_filter_object_list($items, array('menu_item_parent' => $id), 'and', 'ID');
	foreach ($ids as $id) {
		$ids = array_merge($ids, helsinki_submenu_get_children_ids($id, $items));
	}

	return $ids;
}
