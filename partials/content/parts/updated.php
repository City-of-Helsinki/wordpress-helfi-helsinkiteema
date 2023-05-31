<span class="content__date date">
	<span><?php esc_html_e('Updated', 'helsinki-universal'); ?>:</span>
	<time datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>">
		<?php echo get_the_modified_date('d.m.Y H:i'); ?>
	</time>
</span>
