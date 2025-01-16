<button
	id="mobile-panel-toggle"
	class="button-reset has-icon has-icon--above hide-for-l js-toggle js-toggle-no-scroll"
	type="button"
	aria-expanded="false"
	aria-controls="mobile-panel"
	data-no-scroll-breakpoint="992"
	data-no-scroll-limit="down">
	<span class="js-toggle__open">
		<?php helsinki_svg_icon( 'menu-hamburger' ); ?>
		<span class="text" aria-hidden="true">
			<?php echo esc_html_x( 'Menu', 'Label', 'helsinki-universal' ); ?>
		</span>
		<span class="screen-reader-text">
			<?php echo esc_html_x( 'Open the navigation menu', 'Label - Toggle - Mobile menu', 'helsinki-universal' ); ?>
		</span>
	</span>
	<span class="js-toggle__close">
		<?php helsinki_svg_icon( 'cross' ); ?>
		<span class="text" aria-hidden="true">
			<?php echo esc_html_x( 'Close', 'verb', 'helsinki-universal' ); ?>
		</span>
		<span class="screen-reader-text">
			<?php echo esc_html_x( 'Close the navigation menu', 'Label - Toggle - Mobile menu', 'helsinki-universal' ); ?>
		</span>
	</span>
</button>
