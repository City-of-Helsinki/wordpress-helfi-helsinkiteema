<?php

function helsinki_setup_templates()
{

	/**
	 * Body
	 */
	add_filter('body_class', 'helsinki_scheme_body_class', 10);
	if (helsinki_scheme_has_invert_color()) {
		add_filter('body_class', 'helsinki_scheme_invert_color_body_class', 10);
	}

	/**
	 * Site Header
	 */
	add_action('helsinki_header_top', 'helsinki_header_skip', 5);
	add_action('helsinki_header_top', 'helsinki_topbar', 10);
	add_filter('body_class', 'helsinki_topbar_body_class', 10);

	add_action('helsinki_header', 'helsinki_header_logo', 10);
	add_action('helsinki_header', 'helsinki_header_mobile_panel_toggle', 50);
	add_action('helsinki_header_bottom', 'helsinki_header_main_menu', 20);
	add_action('helsinki_header_bottom', 'helsinki_header_mobile_panel', 30);

	add_action('helsinki_header_mobile_panel', 'helsinki_header_mobile_menu', 20);
	add_action('helsinki_header_mobile_panel', 'helsinki_header_mobile_links', 30);

	if (apply_filters('helsinki_header_languages_enabled', false)) {
		add_action('helsinki_header', 'helsinki_header_languages', 20);
		add_action('helsinki_header_mobile_panel', 'helsinki_header_languages', 10);
	}

	if (apply_filters('helsinki_header_search_enabled', false)) {
		add_action('helsinki_header', 'helsinki_header_search', 40);
	}

	/**
	 * Site Hero
	 */
	add_filter('helsinki_header_koros_flipped', '__return_false');

	/**
	 * Breadcrumbs
	 */
	if (
		apply_filters('helsinki_breadcrumbs_enabled', false) &&
		(
			(helsinki_is_static_front_page() && !is_front_page()) || (!is_front_page() && !is_home())
		)
	) {
		add_action('helsinki_main_top', 'helsinki_content_breadcrumbs', 10);
	}

	/**
	 * Notifications
	 */
	if (is_singular()) {
		add_action('helsinki_main_top', 'helsinki_notifications', 20);
	}

	/**
	 * No posts
	 */
	add_action('helsinki_no_posts', 'helsinki_no_posts_notice', 30);

	/**
	 * Site content
	 */
	add_action('helsinki_content', 'helsinki_content_article', 20);

	/**
	 * Site sidebar
	 */
	if (
		!is_front_page() &&
		!is_home()
	) {

		if (helsinki_sidebar_compatible_page_template()) {
			add_action('helsinki_sidebar', 'helsinki_sidebar_post_meta', 10);
			add_action('helsinki_sidebar', 'helsinki_sidebar_widgets', 10, 2);
		}
	}


	/**
	 * Front Page
	 */
	if (is_front_page()) {

		if (helsinki_has_front_page_set()) {
			add_action('helsinki_front_page', 'helsinki_front_page_load_post', 10);

			/**
			 * Front page layout
			 */
			add_action('helsinki_front_page', 'helsinki_front_page_hero', 10);

			if (!helsinki_is_static_front_page()) {
				add_filter('body_class', 'helsinki_sidebar_body_class', 10);

				add_action('helsinki_loop_posts', 'helsinki_loop_count', 10);
				add_action('helsinki_loop_posts', 'helsinki_loop_list', 20);
				add_action('helsinki_loop_posts', 'helsinki_loop_pagination', 30);

				add_action('helsinki_entries_list', 'helsinki_loop_entry', 10);

				add_action('helsinki_loop_main_after', 'helsinki_loop_sidebar', 10);

				add_action('helsinki_loop_sidebar', 'helsinki_loop_sidebar_categories', 10);
				add_action('helsinki_loop_sidebar', 'helsinki_loop_sidebar_tags', 20);
				add_action('helsinki_front_page', 'helsinki_front_page_archives', 10);
			}

			add_action('helsinki_front_page', 'helsinki_front_page_available_sections', 20);

			/**
			 * Hero layout
			 */
			add_filter('body_class', 'helsinki_hero_body_class', 10);
			add_action('helsinki_front_page_hero', 'helsinki_hero_actions', 5);
			add_action('helsinki_front_page_hero', 'helsinki_hero', 10);

			/**
			 * Content layout
			 */
			add_action('helsinki_front_page_content', 'helsinki_front_page_content_title', 10);
			add_action('helsinki_front_page_content', 'helsinki_front_page_content_text', 20);

			add_action('helsinki_front_page', 'helsinki_front_page_unload_post', 10);
		} else {
			add_action('helsinki_front_page', 'helsinki_front_page_load_latest_posts_page', 10);

			add_filter('body_class', 'helsinki_sidebar_body_class', 10);

			add_action('helsinki_view_header_classes', 'helsinki_view_classes', 10);
			add_action('helsinki_view_header', 'helsinki_view_heading', 10);
			add_action('helsinki_view_header', 'helsinki_view_description', 20);
			add_action('helsinki_view_header_after', 'helsinki_view_hero', 20);

			add_action('helsinki_loop_top', 'helsinki_view_header', 10);


			add_action('helsinki_loop_posts', 'helsinki_loop_count', 10);
			add_action('helsinki_loop_posts', 'helsinki_loop_list', 20);
			add_action('helsinki_loop_posts', 'helsinki_loop_pagination', 30);

			add_action('helsinki_entries_list', 'helsinki_loop_entry', 10);

			add_action('helsinki_loop_main_after', 'helsinki_loop_sidebar', 10);

			add_action('helsinki_loop_sidebar', 'helsinki_loop_sidebar_categories', 10);
			add_action('helsinki_loop_sidebar', 'helsinki_loop_sidebar_tags', 20);
			add_action('helsinki_front_page', 'helsinki_front_page_archives', 10);

			add_action('helsinki_front_page', 'helsinki_front_page_unload_post', 10);
		}
	}

	/**
	 * Page
	 */
	else if (is_page()) {

		if (get_option('page_for_posts') == get_the_ID()) {
			remove_action('helsinki_main_top', 'helsinki_notifications', 20);
			add_filter('body_class', 'helsinki_sidebar_body_class', 10);

			add_filter('body_class', 'helsinki_hero_body_class', 10);
			add_action('helsinki_view_header_classes', 'helsinki_view_classes', 10);
			add_action('helsinki_view_header', 'helsinki_view_heading', 10);
			add_action('helsinki_view_header', 'helsinki_view_description', 20);
			add_action('helsinki_view_header_after', 'helsinki_view_hero', 20);

			add_action('helsinki_loop_top', 'helsinki_view_header', 10);

			add_action('helsinki_loop_posts', 'helsinki_loop_count', 10);
			add_action('helsinki_loop_posts', 'helsinki_loop_list', 20);
			add_action('helsinki_loop_posts', 'helsinki_loop_pagination', 30);

			add_action('helsinki_entries_list', 'helsinki_loop_entry', 10);

			add_action('helsinki_loop_main_after', 'helsinki_loop_sidebar', 10);

			add_action('helsinki_loop_sidebar', 'helsinki_loop_sidebar_categories', 10);
			add_action('helsinki_loop_sidebar', 'helsinki_loop_sidebar_tags', 20);
		} else {
			add_action('helsinki_content_article', 'helsinki_content_article_body', 20);

			if (apply_filters('helsinki_feedback_enabled', false)) {
				add_filter('body_class', 'helsinki_feedback_buttons_body_class', 10);
				add_action('helsinki_content_body_after', 'helsinki_feedback_buttons', 21);
			}

			if (helsinki_is_landing_page()) {
				add_filter('body_class', 'helsinki_hero_body_class', 10);
				add_action('helsinki_content_article_top', 'helsinki_hero_actions', 5);
				add_action('helsinki_content_article_top', 'helsinki_hero', 10);
			} else {

				if (helsinki_hero_is_disabled()) {
					add_action('helsinki_content_article', 'helsinki_content_article_title', 10);
				} else {
					add_filter('helsinki_content_article_header_name', 'helsinki_content_article_header_name_hero');
					add_action('helsinki_content_article_top', 'helsinki_content_article_header', 10);

					add_filter('body_class', 'helsinki_hero_body_class', 10);
					add_action('helsinki_content_header_hero', 'helsinki_hero', 10);

					add_filter('helsinki_hero_class_koros', '__return_true');
					add_action('helsinki_hero_after', 'helsinki_hero_koros', 10);

					add_action('helsinki_hero', 'helsinki_hero_content', 10);
					add_action('helsinki_hero_content', 'helsinki_hero_title', 10);
				}

				if (!is_page_template('template/no-sidebar.php')) {
					add_filter('body_class', 'helsinki_sidebar_body_class', 10);
				}

				if (apply_filters('helsinki_sidebar_page_enabled', false) && helsinki_sidebar_has_sidenavigation()) {
					add_action('helsinki_content_article_main_before', 'helsinki_sidebar_navigation', 30);
					add_action('helsinki_content_article_main_after', 'helsinki_sidebar', 30);
				} else if (apply_filters('helsinki_sidebar_page_enabled', false)) {
					add_action('helsinki_content_article_main_after', 'helsinki_sidebar', 30);
				}

				if (has_excerpt()) {
					if (helsinki_hero_is_disabled()) {
						add_action('helsinki_content_article', 'helsinki_content_article_excerpt', 11);
						if (!helsinki_has_featured_image() && !helsinki_post_table_of_contents_enabled()) {
							add_action('helsinki_content_article', 'helsinki_page_divider', 12);
						}
					} else {
						add_filter('helsinki_hero_class_excerpt', '__return_true');
						add_action('helsinki_hero_content', 'helsinki_hero_excerpt', 20);
					}
				}

				if (helsinki_content_article_has_call_to_action()) {
					add_filter('helsinki_hero_class_call_to_action', '__return_true');
					add_action('helsinki_hero_content', 'helsinki_hero_buttons', 30);
				}

				if (helsinki_post_table_of_contents_enabled()) {
					add_filter('body_class', 'helsinki_table_of_contents_body_class', 10);
					add_filter('render_block', 'helsinki_add_ids_to_headings', 10, 2);
					add_action('helsinki_content_article', 'helsinki_post_table_of_contents', 14);
				}

				if (has_post_thumbnail() && !helsinki_featured_image_is_hidden()) {
					add_filter('body_class', 'helsinki_featured_image_body_class', 10);
					add_action('helsinki_content_article', 'helsinki_content_article_thumbnail', 15);
				}
			}
		}
	}

	/**
	 * single
	 */
	else if (is_single()) {
		add_filter('body_class', 'helsinki_sidebar_body_class', 10);
		add_action('helsinki_content_article_main_after', 'helsinki_sidebar', 30);

		add_action('helsinki_content_article', 'helsinki_content_article_header', 10);
		add_action('helsinki_content_header', 'helsinki_content_article_title', 10);

		if (has_excerpt()) {
			add_action('helsinki_content_header', 'helsinki_content_article_excerpt', 20);
		}

		if (apply_filters('helsinki_blog_single_meta', false)) {
			add_action('helsinki_content_article', 'helsinki_content_article_meta', 15);

			if (apply_filters('helsinki_blog_single_categories', false)) {
				add_action('helsinki_content_article_meta', 'helsinki_content_article_categories', 10);
			}

			if (apply_filters('helsinki_blog_single_author', false)) {
				add_action('helsinki_content_article_meta', 'helsinki_content_article_author', 20);
			}

			add_action('helsinki_content_article_meta', 'helsinki_content_article_date', 30);

			if (apply_filters('helsinki_blog_single_updated', false)) {
				add_action('helsinki_content_article_meta', 'helsinki_content_article_updated', 40);
			}
		}

		if (has_post_thumbnail()) {
			add_filter('body_class', 'helsinki_featured_image_body_class', 10);
			add_action('helsinki_content_article', 'helsinki_content_article_thumbnail', 30);
		}

		add_action('helsinki_content_article', 'helsinki_content_article_body', 40);

		if (apply_filters('helsinki_blog_single_social_share', false)) {
			add_action('helsinki_content_article', 'helsinki_content_article_social_share', 50);
		}

		if (apply_filters('helsinki_blog_single_tags', false) && has_tag()) {
			add_action('helsinki_content_article', 'helsinki_content_article_tags', 60);
		}

		if (apply_filters('helsinki_blog_single_related', false)) {
			add_action('helsinki_content_article_bottom', 'helsinki_content_article_related', 20);
		}
	}

	/**
	 * Search
	 */
	else if (is_search()) {
		add_filter('body_class', 'helsinki_sidebar_body_class', 10);

		add_action('helsinki_view_header_classes', 'helsinki_view_classes', 10);
		add_action('helsinki_search_top', 'helsinki_view_header', 10);
		add_action('helsinki_search_top', 'helsinki_search_title', 20);

		add_action('helsinki_view_header', 'helsinki_search_form_title', 10);
		add_action('helsinki_view_header', 'helsinki_search_form', 20);

		add_action('helsinki_search_posts', 'helsinki_loop_count', 10);
		add_action('helsinki_search_posts', 'helsinki_loop_list', 20);
		add_action('helsinki_search_posts', 'helsinki_loop_pagination', 30);

		add_action('helsinki_search_no_posts', 'helsinki_no_posts_notice');

		add_action('helsinki_entries_list', 'helsinki_loop_entry', 10);

		add_action('helsinki_search_main_after', 'helsinki_search_sidebar', 10);
	}

	/**
	 * Not Found
	 */
	else if (is_404()) {
		add_filter('body_class', 'helsinki_sidebar_body_class', 10);
		add_action('helsinki_not_found', 'helsinki_not_found_notice', 30);
	}

	/**
	 * Archive
	 */
	else {
		add_filter('body_class', 'helsinki_sidebar_body_class', 10);

		add_filter('body_class', 'helsinki_hero_body_class', 10);
		add_action('helsinki_view_header_classes', 'helsinki_view_classes', 10);
		add_action('helsinki_view_header', 'helsinki_view_heading', 10);
		add_action('helsinki_view_header', 'helsinki_view_description', 20);
		add_action('helsinki_view_header_after', 'helsinki_view_hero', 20);

		add_action('helsinki_loop_top', 'helsinki_view_header', 10);

		add_action('helsinki_loop_posts', 'helsinki_loop_count', 10);
		add_action('helsinki_loop_posts', 'helsinki_loop_list', 20);
		add_action('helsinki_loop_posts', 'helsinki_loop_pagination', 30);

		add_action('helsinki_entries_list', 'helsinki_loop_entry', 10);

		add_action('helsinki_loop_main_after', 'helsinki_loop_sidebar', 10);

		add_action('helsinki_loop_sidebar', 'helsinki_loop_sidebar_categories', 10);
		add_action('helsinki_loop_sidebar', 'helsinki_loop_sidebar_tags', 20);
	}

	/**
	 * Site footer
	 */
	add_action('helsinki_footer', 'helsinki_footer_koros', 10);
	add_action('helsinki_footer', 'helsinki_footer_widgets', 20);
	add_action('helsinki_footer', 'helsinki_footer_bottom', 30);

	add_action('helsinki_footer_widgets', 'helsinki_footer_widget_area', 10);

	add_action('helsinki_footer_bottom', 'helsinki_footer_logo', 10);
	add_action('helsinki_footer_bottom', 'helsinki_footer_copyright', 20);
	add_action('helsinki_footer_bottom', 'helsinki_footer_menu', 30);
	add_action('helsinki_footer_bottom', 'helsinki_footer_back_top', 40);
}
