<?php

class Artcloud_Menu_Walker extends Walker_Nav_Menu {

	public $submenu_id = 0;

	function start_lvl(&$output, $depth = 0, $args = array() ) {
		$output .= sprintf(
			"\n%s<ul class=\"menu menu--sub\" aria-labelledby=\"submenu-toggle-%s\">\n",
			str_repeat( "\t", $depth ),
			$this->submenu_id ?? 0
		);
	}

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = '';
		if ( $this->discard_item_spacing( $args ) && $depth ) {
			$indent = str_repeat( "\t", $depth );
		}

		$classes = array( 'menu__item' );

		if ( $item->current == 1 || $item->current_item_ancestor == true ) {
			$classes[] = 'menu__item--active';
		}

		if ( $args->walker->has_children ) {
			$classes[] = 'menu__item--parent has-toggle';
		}

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param WP_Post  $item  Menu item data object.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		/**
		 * Filters the CSS classes applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		// $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		// $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $class_names . '>';

		$atts = array(
			'title' => $item->attr_title ?? '',
			'target' => $item->target ?? '',
			'href' => $item->url ?? '',
			'aria-current' => $item->current ? 'page' : '',
			'rel' => '_blank' === $item->target && empty( $item->xfn ) ? 'noopener noreferrer' : $item->xfn,
		);

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title        Title attribute.
		 *     @type string $target       Target attribute.
		 *     @type string $rel          The rel attribute.
		 *     @type string $href         The href attribute.
		 *     @type string $aria_current The aria-current attribute.
		 * }
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
		    if ( ! empty( $value ) ) {
		        $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
		        $attributes .= ' ' . $attr . '="' . $value . '"';
		    }
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title The menu item's title.
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		$item_output = sprintf(
			'%s<a %s>%s%s%s</a>',
			$args->before,
			$attributes,
			$args->link_before,
			$title,
			$args->link_after
		);

		if ( $this->add_submenu_toggle( $args, $depth ) ) {
		  $this->submenu_id = $item->ID;
		  $item_output .= $this->submenu_toggle( $item->ID, $title );
		}

		$item_output .= $args->after;

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $item        Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

	}

	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= $this->discard_item_spacing( $args ) ? '</li>' : "</li>\n";
	}

	public function submenu_toggle( $item_id, $title ) {
		return sprintf(
			'<button id="%s" class="button-reset menu__toggle js-submenu-toggle" type="button" aria-haspopup="true" aria-expanded="false">
				<span class="screen-reader-text">%s</span>
				%s
			</button>',
			'submenu-toggle-' . $item->ID,
			sprintf(
				esc_html__( 'Toggle submenu for %s', 'helsinki-universal' ),
				$title
			),
			helsinki_get_svg_icon('angle-down')
		);
	}

	public function add_submenu_toggle( $args, $depth ) {
	  $show_toggle = $args->depth ? $args->depth > $depth + 1 : true;
	  return $args->walker->has_children && $show_toggle;
	}

	public function discard_item_spacing( $args ) {
	  return isset( $args->item_spacing ) && 'discard' === $args->item_spacing;
	}

}
