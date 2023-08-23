<p class="posts-page">
	<span class="link-wrap">
		<?php 
			$link = '';
			if ($args['attributes']['category'] != 0) {
				$link = get_category_link($args['attributes']['category']);
			} else {
				$link = get_permalink($args['page_for_posts']);
			}
		?>
		<a class="has-icon has-icon--after hds-button" href="<?php echo esc_url($link); ?>">
			<?php
				esc_html_e('See all articles', 'helsinki-universal');
				helsinki_svg_icon('arrow-right');
			?>
		</a>
	</span>
</p>
