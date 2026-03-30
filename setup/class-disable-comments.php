<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\Helsinki\Theme\Setup;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Disable_Comments
{
	public function init_common_hooks(): void
	{
		\add_action( 'init', array( $this, 'disable_comments_post_type_support' ) );
		\add_action( 'widgets_init', array( $this, 'disable_comment_widgets' ) );
		\add_action( 'template_redirect', array( $this, 'disable_comment_feed' ), 9 );

		\add_filter( 'wp_count_comments', array( $this, 'disable_comment_counts' ) );
		\add_filter( 'wp_headers', array( $this, 'disable_pingback_header' ) );
		\add_filter( 'xmlrpc_methods', array( $this, 'disable_xmlrpc_comments' ) );

		foreach ( $this->comment_settings() as $setting => $callback ) {
			\add_filter( 'pre_option_' . $setting, array( $this, $callback ) );
		}
	}

	public function init_admin_hooks(): void
	{
		\add_action( 'add_admin_bar_menus', array( $this, 'disable_admin_bar_comments_menu' ), 0 );
		\add_action( 'admin_init', array( $this, 'disable_admin_bar_comments_menu' ) );
		\add_action( 'admin_menu', array( $this, 'disable_comments_menu_page' ), PHP_INT_MAX );
		\add_action( 'admin_menu', array( $this, 'custom_comments_menu_page' ) );
		\add_action( 'admin_print_styles-index.php', array( $this, 'css_hide_comment_counts' ) );
		\add_action( 'admin_print_styles-profile.php', array( $this, 'css_hide_comment_counts' ) );
		\add_action( 'wp_dashboard_setup', array( $this, 'disable_dashboard_recent_comments' ) );
	}

	public function init_frontend_hooks(): void
	{
		\add_action( 'template_redirect', array( $this, 'disable_comment_template' ) );

		\add_filter( 'comments_array', '__return_empty_array', 20 );
		\add_filter( 'comments_open', '__return_false', 20 );
		\add_filter( 'pings_open', '__return_false', 20 );
		\add_filter( 'post_comments_feed_link', '__return_false' );
		\add_filter( 'comments_link_feed', '__return_false' );
		\add_filter( 'comment_link', '__return_false' );
		\add_filter( 'get_comments_number', '__return_false' );
		\add_filter( 'feed_links_show_comments_feed', '__return_false' );
	}

	public function disable_admin_bar_comments_menu(): void
	{
		\remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );

		if ( \is_multisite() ) {
			\add_action( 'admin_bar_menu', array( $this, 'remove_network_comment_links' ), 500 );
		}
	}

	public function remove_network_comment_links( $wp_admin_bar ): void
	{
		if ( \is_user_logged_in() ) {
			foreach ( (array) $wp_admin_bar->user->blogs as $blog ) {
				$wp_admin_bar->remove_menu( 'blog-' . $blog->userblog_id . '-c' );
			}
		}
	}

	public function disable_comment_counts(): \stdClass
	{
		return (object) array(
			'approved'       => 0,
			'moderated'      => 0,
			'spam'           => 0,
			'trash'          => 0,
			'post-trashed'   => 0,
			'total_comments' => 0,
			'all'            => 0,
		);
	}

	public function disable_comments_menu_page(): void
	{
		global $pagenow;

		if ( in_array( $pagenow, array( 'comment.php', 'edit-comments.php', 'options-discussion.php' ), true ) ) {
			$this->comments_closed_notice();
		}

		\remove_menu_page( 'edit-comments.php' );
		\remove_submenu_page( 'options-general.php', 'options-discussion.php' );
	}

	public function custom_comments_menu_page(): void
	{
		\add_submenu_page(
			'options-general.php',
			__( 'Discussion' ),
			__( 'Discussion' ),
			'manage_options',
			'helsinki-discussion.php',
			array( $this, 'render_custom_comments_menu_page' ),
			4
		);
	}

	public function render_custom_comments_menu_page(): void
	{
		printf(
			'<div class="wrap">
				<h1>%s</h1>
				<div class="notice notice-error">
					<h2>%s</h2>
					<p>%s</p>
				</div>
			</div>',
			\esc_html__( 'Discussion Settings' ),
			\esc_html__( 'Commenting disabled', 'helsinki-universal' ),
			\esc_html__( 'Commenting is disabled on Helsinkiteema sites.', 'helsinki-universal' )
		);
	}

	public function disable_dashboard_recent_comments(): void
	{
		\remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	}

	public function css_hide_comment_counts(): void
	{
		echo '<style>#dashboard_right_now .comment-count, #dashboard_right_now .comment-mod-count,#latest-comments,#welcome-panel .welcome-comments,.user-comment-shortcuts-wrap{display:none !important;}</style>';
	}

	public function disable_comments_post_type_support(): void
	{
		$types = array_keys( \get_post_types( array( 'public' => true ), 'objects' ) );

		foreach ( $types as $type ) {
			if ( \post_type_supports( $type, 'comments' ) ) {
				\remove_post_type_support( $type, 'comments' );
				\remove_post_type_support( $type, 'trackbacks' );
			}
		}
	}

	public function disable_comment_template(): void
	{
		if ( \is_singular() ) {
			\add_filter( 'comments_template', '__return_empty_string', 20 );

			\wp_deregister_script( 'comment-reply' );

			\remove_action( 'wp_head', 'feed_links_extra', 3 );
		}
	}

	public function disable_comment_widgets(): void
	{
		\unregister_widget( 'WP_Widget_Recent_Comments' );
		\add_filter( 'show_recent_comments_widget_style', '__return_false' );
	}

	public function disable_comment_feed(): void
	{
		if ( \is_comment_feed() ) {
			$this->comments_closed_notice();
		}
	}

	public function disable_pingback_header( array $headers ): array
	{
		unset( $headers['X-Pingback'] );
		return $headers;
	}

	public function disable_xmlrpc_comments( array $methods ): array
	{
		unset( $methods['wp.newComment'] );
		return $methods;
	}

	public function numeric_false(): int
	{
		return 0;
	}

	public function numeric_true(): int
	{
		return 1;
	}

	public function status_closed(): string
	{
		return 'closed';
	}

	private function comments_closed_notice(): void
	{
		\wp_die( \esc_html__( 'Comments are closed.' ), '', array( 'response' => 403 ) );
	}

	private function comment_settings(): array
	{
		return array(
			'require_name_email' => 'numeric_true',
			'comment_moderation' => 'numeric_true',
			'close_comments_for_old_posts' => 'numeric_true',
			'comment_previously_approved' => 'numeric_true',
			'comments_notify' => 'numeric_false',
			'moderation_notify' => 'numeric_false',
			'wp_notes_notify' => 'numeric_false',
			'show_avatars' => 'numeric_false',
			'default_pingback_flag' => 'numeric_false',
			'default_comment_status' => 'status_closed',
			'default_ping_status' => 'status_closed',
		);
	}
}
