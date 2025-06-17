<div class="grid__column">
	<article id="post-<?php the_ID(); ?>" class="<?php helsinki_entry_classes( 'grid entry--' . get_post_type() ); ?>">

		<?php do_action( 'helsinki_entry_content_before', get_post(), 'grid', $args ); ?>

		<div>
			<?php do_action( 'helsinki_entry_content', get_post(), 'grid', $args ); ?>

			<div class="entry__meta meta">

				<?php do_action( 'helsinki_entry_meta', get_post(), 'grid', $args ); ?>

			</div>

		</div>

		<?php do_action( 'helsinki_entry_content_after', get_post(), 'grid', $args ); ?>

	</article>
</div>
