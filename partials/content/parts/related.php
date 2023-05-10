<aside title="<?php esc_html_e('Related content', 'helsinki-universal'); ?>" class="content__related related">
	<div class="hds-container">
		<h2><?php esc_html_e('You might be interested in', 'helsinki-universal'); ?></h2>
		<div class="feed-posts">
			<ul class="posts">
			<?php
				global $post;
				foreach ( $args['posts'] as $post ) {
					setup_postdata( $post );
					helsinki_feed_entry();
				}
		        wp_reset_postdata();
			?>
			<ul>
		</div>
	</div>
</aside>
