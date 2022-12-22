<li>
	<article class="entry entry--feed entry--post">
		<div>
			<h3 class="entry__title">
				<a href="<?php echo esc_url( $args['item']->get_permalink() ); ?>"><span><?php echo esc_html( $args['item']->get_title() ); ?></span></a>
				<span class="screen-reader-text"><?php esc_html_e( 'Link forwards to:', 'helsinki-universal' ); ?></span>
			</h3>
		</div>
		<div class="entry__meta">
			<span class="screen-reader-text"><?php esc_html_e('Published:', 'hds-wp') ?></span>
			<time class="date" datetime="<?php echo esc_attr( $args['item']->get_date('c') ); ?>">
				<?php echo esc_html( $args['item']->get_date( $args['date_format'] . ' ' . $args['time_format'] ) ); ?>
			</time>
		</div>
	</article>
</li>
