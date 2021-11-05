<?php
function helsinki_setup_theme()
{

    /**
     * I18n
     */
    load_theme_textdomain('helsinki-universal', get_template_directory() .'/languages');

    /**
     * Embed width
     */
    $GLOBALS['content_width'] = apply_filters('embed_content_width', 1000);

    /**
     * Theme support
     */
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
		add_theme_support( 'automatic-feed-links' );
    add_theme_support(
        'html5',
        [
	        'caption',
	        'comment-form',
	        'comment-list',
	        'gallery',
	        'search-form'
        ]
    );
    add_theme_support(
        'custom-logo',
        [
	        'flex-height' => true,
	        'flex-width'  => true,
	        'header-text' => [ 'site-title' ],
        ]
    );

	/**
	 * Post type support
	 */
	add_post_type_support( 'page', 'excerpt' );

	/**
	 * Block editor
	 */
	add_theme_support( 'align-wide' );
	// custom colors
	add_theme_support( 'disable-custom-font-sizes' );
	add_theme_support( 'disable-custom-colors' );
	add_theme_support( 'disable-custom-gradients' );
	remove_theme_support( 'core-block-patterns' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style-editor.css' );
	add_theme_support('responsive-embeds');
	add_theme_support( 'editor-color-palette', helsinki_scheme_editor_palette() );
	add_theme_support( 'editor-gradient-presets', array() );

	/**
	 * Widgets Block editor
	 */
	remove_theme_support( 'widgets-block-editor' );

  /**
   * Image sizes
   */
  set_post_thumbnail_size(400, 225, false);

  /**
   * Disable inline gallery styles
   */
  add_filter('use_default_gallery_style', '__return_false');

  /**
   * Menu locations
   */
  register_nav_menus(
      [
        'main_menu'      => esc_html_x('Main menu', 'Registered menu name', 'helsinki-universal'),
				'footer_menu'          => esc_html_x('Footer menu', 'Registered menu name', 'helsinki-universal'),
      ]
  );

  /**
   * Social Media Settings
   */
  add_theme_support('artcloud-site-core-social-media-profiles');


	/**
	 * 3rd Party Plugins
	 */
	add_theme_support( 'yoast-seo-breadcrumbs' );

	/**
	 * HDS
	 */
	add_theme_support(
		'hds-wp',
		array(
			'assets' => array(
				'scripts' => true,
				'styles' => true,
				'fonts' => true,
				'favicon' => true,
			),
			'topbar' => true,
			'widgets' => true,
			'blocks' => true,
			'cpt' => array(
				'faq' => true,
			),
		)
	);

}

function helsinki_disable_default_widgets()
{
	$disable = array(
		'WP_Widget_Calendar',
		'PLL_Widget_Calendar',
		'WP_Widget_Meta',
		'WP_Widget_Block'
	);
	array_walk( $disable, 'unregister_widget' );
}

function helsinki_register_sidebars()
{
	$sidebars = array(
		'post' => _x('Post', 'Post sidebar', 'helsinki-universal'),
		'page' => _x('Page', 'Page sidebar', 'helsinki-universal'),
		'footer' => _x('Footer', 'Footer sidebar', 'helsinki-universal'),
	);

	foreach ($sidebars as $key => $label) {
		$classes = array(
			'widget',
			'widget--%2$s',
			'widget--' . $key,
			'clearfix',
		);

		if ( 'footer' === $key ) {
			$classes[] = 'grid__column';
		}

		register_sidebar([
		    'id'            => 'sidebar-' . $key,
		    'name'          => $label,
		    'before_widget' => '<div id="%1$s" class="' . implode(' ', $classes) . '">',
		    'after_widget'  => '</div>',
		    'before_title'  => '<h3 class="widget__title">',
		    'after_title'   => '</h3>',
	    ]);
	}
}
