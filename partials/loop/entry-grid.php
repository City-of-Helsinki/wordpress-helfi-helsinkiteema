<div class="grid__column">
	<article id="post-<?php the_ID(); ?>" class="<?php helsinki_entry_classes( 'grid entry--' . get_post_type() ); ?>">
		<a href="<?php the_permalink(); ?>">
			<?php helsinki_entry_image(); ?>
			<h2 class="entry__title"><?php helsinki_entry_title(); ?></h2>
			<div class="entry__meta meta">
				<time class="date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
					<?php echo get_the_date(); ?>
				</time>
			</div>
			<div class="entry__more">
				<?php helsinki_svg_icon('arrow-right'); ?>
			</div>
		</a>
	</article>
</div>
