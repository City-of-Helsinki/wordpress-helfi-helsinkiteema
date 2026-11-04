<div id="post-<?php the_id(); ?>" class="<?php helsinki_entry_classes( $args['entry']->classes() ); ?>">

	<?php do_action( 'helsinki_entry_content_before', $args['entry']->post(), '', $args ); ?>

	<div class="entry__content">

		<?php do_action( 'helsinki_entry_content', $args['entry']->post(), '', $args ); ?>

		<div class="entry__meta meta">

			<?php do_action( 'helsinki_entry_meta', $args['entry']->post(), '', $args ); ?>

		</div>

	</div>

	<?php do_action( 'helsinki_entry_content_after', $args['entry']->post(), '', $args ); ?>

</div>
