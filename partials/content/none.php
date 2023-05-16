<div class="not-found">

	<?php if ( is_search() ) : ?>
		<h2 class="search-results-title view-subtitle">
			<?php printf(
					'%s "%s"',
					esc_html__('Results for keyword', 'helsinki-universal'),
					get_search_query()
				);
			?>
		</h2>
	<?php else : ?>
		<h2>
			<?php esc_html_e('Worse luck!', 'helsinki-universal'); ?>
		</h2>
	<?php endif; ?>

	<?php if ( is_search() ) : ?>
		<p><?php esc_html_e( 'No results found.', 'helsinki-universal' ); ?></p>
		<p><?php esc_html_e( 'Please try using another search term or phrase.', 'helsinki-universal' ); ?></p>
		<?php helsinki_search_links(); ?>
	<?php elseif ( is_author() ) : ?>
		<p><?php esc_html_e( 'This author has not published any posts yet.', 'helsinki-universal' ); ?></p>
	<?php else : ?>
		<p><?php esc_html_e( 'No posts have been published yet.', 'helsinki-universal' ); ?></p>
	<?php endif; ?>

</div>
