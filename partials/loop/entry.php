<div id="post-<?php the_id(); ?>" class="<?php helsinki_entry_classes( get_post_type() . ' entry--list flex-container' ); ?>">

	<?php
		if ( has_post_thumbnail() ) {
			helsinki_entry_image();
		}
	?>

	<div class="entry__content">

		<h3 class="entry__title">
			<a href="<?php the_permalink(); ?>">
				<?php helsinki_entry_title(); ?>
			</a>
		</h3>

		<div class="entry__meta meta">
			<span class="content__category categories">
				<span class="screen-reader-text"><?php esc_html_e('Categories'); ?>:</span>
				<?php the_category(', '); ?>
			</span>
			<time class="date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
				<?php echo get_the_date(); ?>
			</time>
		</div>

	</div>

</div>
