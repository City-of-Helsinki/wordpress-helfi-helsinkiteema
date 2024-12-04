<div id="post-<?php the_id(); ?>" class="<?php helsinki_entry_classes( get_post_type() . ' entry--list flex-container' ); ?>">

	<?php do_action( 'helsinki_entry_content_before', get_post(), '', $args ); ?>

	<div class="entry__content">

		<?php do_action( 'helsinki_entry_content', get_post(), '', $args ); ?>

		<div class="entry__meta meta">

			<?php do_action( 'helsinki_entry_meta', get_post(), '', $args ); ?>

		</div>

	</div>

	<?php do_action( 'helsinki_entry_content_after', get_post(), '', $args ); ?>

</div>
