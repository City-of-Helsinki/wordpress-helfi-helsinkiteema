<span class="content__date date">
	<span class="screen-reader-text"><?php esc_html_e('Published', 'helsinki-universal'); ?>:</span>
	<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
		<?php echo get_the_date(); ?>
	</time>
</span>
