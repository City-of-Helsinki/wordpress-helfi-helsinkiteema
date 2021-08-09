<span class="content__author author">
	<span class="screen-reader-text"><?php esc_html_e('Author', 'helsinki-universal'); ?>:</span>
	<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a>
</span>
