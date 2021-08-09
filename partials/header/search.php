<div class="navigation__search">
	<button id="header-search-toggle" class="button-reset has-icon has-icon--above js-toggle js-toggle-no-scroll" aria-haspopup="true" aria-controls="header-search" aria-expanded="false" aria-label="<?php esc_attr_e('Search', 'helsinki-universal'); ?>" data-text-expanded="<?php esc_attr_e('Close', 'helsinki-universal'); ?>" data-text="<?php esc_attr_e('Search', 'helsinki-universal'); ?>" data-no-scroll-breakpoint="992" data-no-scroll-limit="down">
		<?php helsinki_svg_icon('search'); ?>
		<?php helsinki_svg_icon('cross'); ?>
		<span class="text"><?php echo esc_html_x('Search', 'verb', 'helsinki-universal'); ?></span>
	</button>
	<div id="header-search" aria-labelledby="header-search-toggle" role="region">
		<div class="hds-container">
			<h2 class="search-title"><?php echo esc_html_x('Search', 'verb', 'helsinki-universal'); ?></h2>
			<?php helsinki_header_searchform(); ?>
		</div>
	</div>
</div>
