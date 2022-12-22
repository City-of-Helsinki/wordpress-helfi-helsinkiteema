<div class="entries l-up-2">
	<div>
		<ul class="posts">
			<?php
				foreach ($args['feed_posts'] as $feed_item) {
					get_template_part(
						'partials/front-page/feed-posts/list-item',
						null,
						array(
							'item' => $feed_item,
							'date_format' => $args['date_format'],
							'time_format' => $args['time_format'],
						)
					);
				}
			?>
		</ul>
	</div>
</div>
