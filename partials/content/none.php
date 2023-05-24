<div class="not-found">

	<?php if ( is_search() ) : ?>
		
	<?php else : ?>
		<h2>
			<?php esc_html_e('Worse luck!', 'helsinki-universal'); ?>
		</h2>
	<?php endif; ?>

	<?php if ( is_search() ) : ?>
		<p><?php esc_html_e( 'No results found.', 'helsinki-universal' ); ?></p>
		<?php helsinki_search_links(); ?>
	<?php elseif ( is_author() ) : ?>
		<p><?php esc_html_e( 'This author has not published any posts yet.', 'helsinki-universal' ); ?></p>
	<?php else : ?>
		<p><?php esc_html_e( 'No posts have been published yet.', 'helsinki-universal' ); ?></p>
	<?php endif; ?>

</div>
