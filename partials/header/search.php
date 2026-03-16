<div class="nav-toggle nav-toggle--search">
	<button
		id="header-search-toggle"
		class="button-reset has-icon has-icon--above js-toggle js-toggle-no-scroll"
		aria-haspopup="true"
		aria-controls="header-search"
		aria-expanded="false"
		data-no-scroll-breakpoint="992"
		data-no-scroll-limit="down">
		<span class="js-toggle__open">
			<?php helsinki_svg_icon( 'search' ); ?>
		</span>
		<span class="js-toggle__close">
			<?php helsinki_svg_icon( 'cross' ); ?>
		</span>
		<span class="text">
			<?php echo esc_html_x( 'Search', 'search toggle', 'helsinki-universal' ); ?>
		</span>
	</button>
</div>
<div id="header-search" aria-labelledby="header-search-toggle" role="region" hidden>
	<div class="hds-container">
		<h2 class="search-title"><?php echo esc_html_x('Search the site', 'search title', 'helsinki-universal'); ?></h2>

		<?php do_action( 'helsinki_search_form', 'header' ); ?>
	</div>
</div>
