<div class="not-found grid m-up-2">

	<div class="grid__column">
		<h1 class="has-icon has-icon--before">
			<?php esc_html_e('404 - Sorry, the page you were looking for was not found', 'helsinki-universal'); ?>
		</h1>

		<p class="size-xl"><?php esc_html_e( 'Check that you have typed in the page address correctly. We may have deleted or moved the content.', 'helsinki-universal' ); ?></p>
		<p><a href="<?php echo get_home_url(); ?>"><?php esc_html_e('Go back to the frontpage', 'helsinki-universal'); echo helsinki_get_svg_icon('arrow-right', 'inline-icon'); ?></a></p>
		<p><a href="<?php echo helsinki_topbar_feedback(function_exists('pll_current_language') ? pll_current_language('slug') : substr( get_bloginfo('language'), 0, 2 ))['url']; ?>"><?php esc_html_e('Give feedback', 'helsinki-universal'); ?></a></p>
	</div>
	<div class="grid__column">
		<?php echo $args['img']; ?>
	</div>
</div>
