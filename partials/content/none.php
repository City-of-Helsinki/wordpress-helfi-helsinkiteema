<div class="not-found">

	<h1 class="has-icon has-icon--before">
		<?php helsinki_svg_icon('face-neutral'); ?>
		<?php esc_html_e('Worse luck!', 'helsinki-universal'); ?>
	</h1>

	<?php if ( is_search() ) : ?>
		<p><?php esc_html_e( 'No posts matching your search could be found.', 'helsinki-universal' ); ?></p>
		<p><?php esc_html_e( 'Please try using another search term or phrase.', 'helsinki-universal' ); ?></p>
	<?php elseif ( is_author() ) : ?>
		<p><?php esc_html_e( 'This author has not published any posts yet.', 'helsinki-universal' ); ?></p>
	<?php else : ?>
		<p><?php esc_html_e( 'No posts have been published yet.', 'helsinki-universal' ); ?></p>
	<?php endif; ?>

</div>
