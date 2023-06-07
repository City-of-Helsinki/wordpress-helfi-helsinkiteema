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

		<?php if ( $args['is_search'] && !empty(get_the_excerpt()) ) : ?>
			<div class="entry__excerpt excerpt size-l">
				<?php the_excerpt(); ?>
			</div>
		<?php endif; ?>

		<div class="entry__meta meta">
			<?php if ( !empty(get_the_category_list(', ')) ) : ?>
				<span class="content__category categories">
					<span class="screen-reader-text"><?php esc_html_e('Categories'); ?>:</span>
					<?php the_category(', '); ?>
				</span>
			<?php endif; ?>
			<?php if ( get_post_type() === 'post' ) : ?>
				<time class="date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
					<?php echo get_the_date(); ?>
				</time>
			<?php endif; ?>

		</div>

	</div>

</div>
