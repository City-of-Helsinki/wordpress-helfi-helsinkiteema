<li>
	<article class="entry entry--feed entry--post">
		<div>
			<h3 class="entry__title">
				<a href="<?php the_permalink(); ?>"><span><?php helsinki_entry_title(); ?></span></a>
			</h3>
		</div>
		<div class="entry__meta">
			<span class="screen-reader-text"><?php esc_html_e('Published:', 'hds-wp') ?></span>
			<time class="date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                <?php echo get_the_date(); ?>
			</time>
		</div>
	</article>
</li>
