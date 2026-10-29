<li>
	<article class="<?php helsinki_entry_classes( $args['entry']->classes() ); ?>">

		<?php do_action( 'helsinki_entry_content_before', $args['entry']->post(), 'feed', $args ); ?>

		<div>
			<?php do_action( 'helsinki_entry_content', $args['entry']->post(), 'feed', $args ); ?>
		</div>

		<?php do_action( 'helsinki_entry_content_after', $args['entry']->post(), 'feed', $args ); ?>

		<div class="entry__meta">

			<?php do_action( 'helsinki_entry_meta', $args['entry']->post(), 'feed', $args ); ?>

		</div>
	</article>
</li>
