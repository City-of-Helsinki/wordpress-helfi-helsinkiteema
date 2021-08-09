<p class="posts-page">
	<span class="link-wrap">
		<a class="has-icon has-icon--after" href="<?php echo esc_url(get_permalink($args['page_for_posts'])); ?>">
			<?php
				esc_html_e('All posts', 'helsinki-universal');
				helsinki_svg_icon('arrow-right');
			?>
		</a>
	</span>
</p>
