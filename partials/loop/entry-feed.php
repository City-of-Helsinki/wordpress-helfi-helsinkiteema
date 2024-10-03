<li>
	<article class="entry entry--feed entry--post">

		<?php do_action( 'helsinki_entry_content_before', get_post(), 'feed', $args ); ?>

		<div>
			<?php do_action( 'helsinki_entry_content', get_post(), 'feed', $args ); ?>
		</div>

		<?php do_action( 'helsinki_entry_content_after', get_post(), 'feed', $args ); ?>

		<div class="entry__meta">

			<?php do_action( 'helsinki_entry_meta', get_post(), 'feed', $args ); ?>

		</div>
	</article>
</li>
