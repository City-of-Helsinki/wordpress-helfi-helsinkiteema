<div class="filters">
	<div class="dropdown">
		<span class="screen-reader-text">
			<?php esc_html_e('Show posts from a category', 'helsinki-universal'); ?>
		</span>
		<button id="category-filter" class="button-reset dropdown-trigger has-icon has-icon--after js-toggle" aria-haspopup="true" aria-controls="category-filter-menu" aria-expanded="false">
			<span class="current"><?php echo esc_html( $args['placeholder'] ); ?></span>
			<?php helsinki_svg_icon('arrow-down'); ?>
		</button>
		<div id="category-filter-menu" class="dropdown-content" aria-labelledby="category-filter" role="region">
			<?php
				foreach ( $args['categories'] as $category ) {
					printf(
						'<a href="%s">%s</a>',
						esc_url( add_query_arg( 'cat', $category->term_id, get_term_link( $category ) ) ),
						esc_html( $category->name )
					);
				}
			?>
		</div>
	</div>
</div>
