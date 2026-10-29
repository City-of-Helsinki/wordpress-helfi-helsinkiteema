<div class="grid__column">
	<article id="post-<?php the_ID(); ?>" class="<?php helsinki_entry_classes( $args['entry']->classes() ); ?>">

		<?php do_action( 'helsinki_entry_content_before', $args['entry']->post(), 'grid', $args ); ?>

		<div>
			<?php do_action( 'helsinki_entry_content', $args['entry']->post(), 'grid', $args ); ?>

			<div class="entry__meta meta">

				<?php do_action( 'helsinki_entry_meta', $args['entry']->post(), 'grid', $args ); ?>

			</div>

		</div>

		<?php do_action( 'helsinki_entry_content_after', $args['entry']->post(), 'grid', $args ); ?>

	</article>
</div>
