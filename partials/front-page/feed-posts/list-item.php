<li>
	<article class="<?php helsinki_entry_classes( 'feed entry--post'); ?>">
		<a href="<?php echo esc_url( $args['item']->get_permalink() ); ?>">
			<h3 class="entry__title"><?php echo esc_html( helsinki_trim_title( $args['item']->get_title() ) ); ?></h3>
		</a>
		<div class="entry__meta meta">
			<time class="date" datetime="<?php echo esc_attr( $args['item']->get_date('c') ); ?>">
				<?php echo esc_html( $args['item']->get_date( $args['date_format'] . ' ' . $args['time_format'] ) ); ?>
			</time>
		</div>
	</article>
</li>
