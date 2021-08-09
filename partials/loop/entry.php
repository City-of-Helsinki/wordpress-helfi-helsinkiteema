<article id="post-<?php the_id(); ?>" class="<?php helsinki_entry_classes( get_post_type() . ' entry--list flex-container' ); ?>">

	<?php
		if ( has_post_thumbnail() ) {
			helsinki_entry_image();
		}
	?>

	<div class="entry__content">

		<h2 class="entry__title">
			<a href="<?php the_permalink(); ?>">
				<?php helsinki_entry_title(); ?>
			</a>
		</h2>

		<div class="entry__excerpt excerpt size-l">
			<?php the_excerpt(); ?>
		</div>

		<div class="entry__meta meta">
			<time class="date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
				<?php echo get_the_date(); ?>
			</time>
		</div>

	</div>

</article>
