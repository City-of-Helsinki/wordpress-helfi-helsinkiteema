<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<nav id="main-menu-nav" class="navigation__menu show-for-l" aria-labelledby="main-menu-nav-label">
	<span id="main-menu-nav-label" class="screen-reader-text">
		<?php echo esc_html_x( 'Main menu', 'Label - Nav - Main menu', 'helsinki-universal' ); ?>
	</span>
	<div class="hds-container hds-container--wide">
		<?php echo helsinki_menu('main_menu'); ?>
	</div>
	<button class="button-reset js-close hide-for-l" type="button">
		<span class="screen-reader-text"><?php esc_html_e('Close Menu', 'helsinki-universal'); ?></span>
		<?php helsinki_svg_icon('cross'); ?>
	</button>
</nav>
