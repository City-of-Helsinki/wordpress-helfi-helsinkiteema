<aside title="<?php esc_html_e('Related content', 'helsinki-universal'); ?>" class="content__related related">
	<div class="hds-container">
		<h2><?php esc_html_e('Read also these', 'helsinki-universal'); ?></h2>
		<div class="grid entries s-up-2 l-up-<?php echo esc_attr( $args['per_page'] ); ?>">
			<?php
				global $post;
				foreach ( $args['posts'] as $post ) {
					setup_postdata( $post );
					helsinki_grid_entry();
				}
		        wp_reset_postdata();
			?>
		</div>
	</div>
</aside>
