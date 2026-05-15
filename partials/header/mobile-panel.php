<div class="nav-toggle nav-toggle--menu hide-for-l">
	<button
		id="mobile-panel-toggle"
		class="button-reset has-icon has-icon--above js-toggled"
		type="button"
		aria-expanded="false"
		aria-controls="mobile-panel"
		aria-haspopup="true"
		data-no-scroll-breakpoint="992"
		data-no-scroll-limit="down">
		<span class="open">
			<?php helsinki_svg_icon( 'menu-hamburger' ); ?>
		</span>
		<span class="close">
			<?php helsinki_svg_icon( 'cross' ); ?>
		</span>
		<span class="text">
			<?php echo esc_html_x( 'Menu', 'menu toggle', 'helsinki-universal' ); ?>
		</span>
	</button>
</div>
<div class="nav-toggle-dropdown nav-toggle-dropdown--menu hide-for-l">
	<nav id="mobile-panel" class="nav-toggle-dropdown__content" aria-labelledby="mobile-panel-toggle" aria-modal="true" role="dialog" hidden>

		<?php

		  /**
			* Hook: helsinki_header_mobile_panel
			*
			*/
		  do_action('helsinki_header_mobile_panel');

		?>

	</nav>
</div>
